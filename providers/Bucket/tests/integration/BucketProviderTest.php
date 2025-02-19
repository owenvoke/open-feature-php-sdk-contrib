<?php

declare(strict_types=1);

namespace OpenFeature\Providers\Bucket\Test\integration;

use OpenFeature\Providers\Bucket\BucketProvider;
use OpenFeature\Providers\Bucket\Test\TestCase;
use OpenFeature\interfaces\provider\ErrorCode;
use OpenFeature\interfaces\provider\Provider;
use OpenFeature\interfaces\provider\ResolutionError;

class BucketProviderTest extends TestCase
{
    private const API_KEY = '012345678901234567890123';
    private Provider $instance;

    protected function setUp(): void
    {
        $apiKey = self::API_KEY;

        $instance = new BucketProvider($apiKey);

        $this->instance = $instance;
    }

    public function testCanResolveBool(): void
    {
        // Given
        $flagName = 'dev.openfeature.bool_flag';
        $defaultValue = false;
        $expectedValue = true;

        // When
        $details = $this->instance->resolveBooleanValue($flagName, $defaultValue);
        $value = $details->getValue();

        // Then
        $this->assertNotEquals($value, $defaultValue);
        $this->assertEquals($value, $expectedValue);
    }

    public function testCannotResolveInt(): void
    {
        // Given
        $flagName = 'dev.openfeature.int_flag';
        $defaultValue = 0;

        // When
        $details = $this->instance->resolveIntegerValue($flagName, $defaultValue);
        $value = $details->getValue();
        $error = $details->getError();

        // Then
        $this->assertEquals($value, $defaultValue);
        $this->assertInstanceOf(ResolutionError::class, $error);
        $this->assertEquals($error->getResolutionErrorCode(), ErrorCode::GENERAL());
    }

    public function testCannotResolveFloat(): void
    {
        // Given
        $flagName = 'dev.openfeature.float_flag';
        $defaultValue = 0.0;

        // When
        $details = $this->instance->resolveFloatValue($flagName, $defaultValue);
        $value = $details->getValue();
        $error = $details->getError();

        // Then
        $this->assertEquals($value, $defaultValue);
        $this->assertInstanceOf(ResolutionError::class, $error);
        $this->assertEquals($error->getResolutionErrorCode(), ErrorCode::GENERAL());
    }

    public function testCannotResolveString(): void
    {
        // Given
        $flagName = 'dev.openfeature.string_flag';
        $defaultValue = 'default';

        // When
        $details = $this->instance->resolveStringValue($flagName, $defaultValue);
        $value = $details->getValue();
        $error = $details->getError();

        // Then
        $this->assertEquals($value, $defaultValue);
        $this->assertInstanceOf(ResolutionError::class, $error);
        $this->assertEquals($error->getResolutionErrorCode(), ErrorCode::GENERAL());
    }

    public function testCannotResolveObject(): void
    {
        // Given
        $flagName = 'dev.openfeature.object_flag';
        $defaultValue = [];

        // When
        $details = $this->instance->resolveObjectValue($flagName, $defaultValue);
        $value = $details->getValue();
        $error = $details->getError();

        // Then
        $this->assertEquals($value, $defaultValue);
        $this->assertInstanceOf(ResolutionError::class, $error);
        $this->assertEquals($error->getResolutionErrorCode(), ErrorCode::GENERAL());
    }
}
