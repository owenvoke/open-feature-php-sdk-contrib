<?php

declare(strict_types=1);

namespace OpenFeature\Providers\Split\Test\unit;

use OpenFeature\Providers\Bucket\BucketProvider;
use OpenFeature\Providers\Bucket\Test\TestCase;
use OpenFeature\interfaces\provider\Provider;

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

    public function testCanBeInstantiated(): void
    {
        // Given
        $instance = $this->instance;

        // Then
        $this->assertNotNull($instance);
        $this->assertInstanceOf(BucketProvider::class, $instance);
        $this->assertInstanceOf(Provider::class, $instance);
        $this->assertEquals('BucketProvider', $instance->getMetadata()->getName());
    }
}
