<?php

declare(strict_types=1);

namespace OpenFeature\Providers\Bucket;

use DateTime;
use OpenFeature\implementation\provider\AbstractProvider;
use OpenFeature\implementation\provider\ResolutionDetailsBuilder;
use OpenFeature\implementation\provider\ResolutionDetailsFactory;
use OpenFeature\implementation\provider\ResolutionError;
use OpenFeature\interfaces\flags\EvaluationContext;
use OpenFeature\interfaces\provider\ErrorCode;
use OpenFeature\interfaces\provider\Provider;
use OpenFeature\interfaces\provider\ResolutionDetails;
use OpenFeature\interfaces\provider\ThrowableWithResolutionError;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

class BucketProvider extends AbstractProvider implements Provider
{
    protected static string $NAME = 'BucketProvider';

    /** @param array<string, mixed> $options */
    public function __construct(?string $apiKey = null, array $options = []) // @phpstan-ignore-line
    {
    }

    public function setLogger(LoggerInterface $logger): void
    {
        // no-op
    }

    public function getLogger(): LoggerInterface
    {
        // no-op
        return new NullLogger();
    }

    public function resolveBooleanValue(
        string $flagKey,
        bool $defaultValue,
        ?EvaluationContext $context = null,
    ): ResolutionDetails {
        try {
            // Get flag value

            return ResolutionDetailsFactory::fromSuccess($defaultValue);
        } catch (Throwable $err) {
            $detailsBuilder = new ResolutionDetailsBuilder();

            $detailsBuilder->withValue($defaultValue);

            if ($err instanceof ThrowableWithResolutionError) {
                $detailsBuilder->withError($err->getResolutionError());
            } else {
                $detailsBuilder->withError(
                    new ResolutionError(ErrorCode::GENERAL(), $err->getMessage()),
                );
            }

            return $detailsBuilder->build();
        }
    }

    public function resolveStringValue(
        string $flagKey,
        string $defaultValue,
        ?EvaluationContext $context = null,
    ): ResolutionDetails {
        return $this->invalidFlagTypeBuilder('string', $defaultValue);
    }

    public function resolveIntegerValue(
        string $flagKey,
        int $defaultValue,
        ?EvaluationContext $context = null,
    ): ResolutionDetails {
        return $this->invalidFlagTypeBuilder('integer', $defaultValue);
    }

    public function resolveFloatValue(
        string $flagKey,
        float $defaultValue,
        ?EvaluationContext $context = null,
    ): ResolutionDetails {
        return $this->invalidFlagTypeBuilder('float', $defaultValue);
    }

    /** @param array<array-key, mixed> $defaultValue */
    public function resolveObjectValue(
        string $flagKey,
        array $defaultValue,
        ?EvaluationContext $context = null,
    ): ResolutionDetails {
        return $this->invalidFlagTypeBuilder('object', $defaultValue);
    }

    /** @param array<array-key, mixed>|bool|DateTime|float|int|string|null $defaultValue */
    private function invalidFlagTypeBuilder(string $type, mixed $defaultValue): ResolutionDetails
    {
        $detailsBuilder = new ResolutionDetailsBuilder();

        $detailsBuilder->withValue($defaultValue);

        $detailsBuilder->withError(new ResolutionError(ErrorCode::GENERAL(), "Bucket doesn't support {$type} flags"));

        return $detailsBuilder->build();
    }
}
