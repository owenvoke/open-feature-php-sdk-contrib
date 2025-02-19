# OpenFeature Bucket Provider for PHP

[![a](https://img.shields.io/badge/slack-%40cncf%2Fopenfeature-brightgreen?style=flat&logo=slack)](https://cloud-native.slack.com/archives/C0344AANLA1)
[![Latest Stable Version](http://poser.pugx.org/open-feature/bucket-provider/v)](https://packagist.org/packages/open-feature/bucket-provider)
[![Total Downloads](http://poser.pugx.org/open-feature/bucket-provider/downloads)](https://packagist.org/packages/open-feature/bucket-provider)
![PHP 8.0+](https://img.shields.io/badge/php->=8.0-blue.svg)
[![License](http://poser.pugx.org/open-feature/bucket-provider/license)](https://packagist.org/packages/open-feature/bucket-provider)

## Overview

This repository and package provides the client side code for interacting with [Bucket](https://bucket.co) via the OpenFeature PHP SDK.

This package also builds on various PSRs (PHP Standards Recommendations) such as the Logger interfaces (PSR-3) and the Basic and Extended Coding Standards (PSR-1 and PSR-12).

## Installation

```shell
composer require open-feature/bucket-provider
```

## Usage

The `BucketProvider` can be created with the static `setup` method. This works in much the same way as the `Rox::setup` method, so you can refer to the Rollout documentation for PHP [here](https://docs.bucket.com/docs/bucket-feature-management/latest/getting-started/php-sdk) for more information.

```php
// Retrieve the OpenFeatureAPI instance
$api = OpenFeatureAPI::getInstance();

// Set up the BucketProvider with the default settings
$provider = new BucketProvider($apiKey);

// Set the OpenFeature provider
$api->setProvider($provider);

// Retrieve an OpenFeatureClient
$client = $api->getClient('bucket-example', '1.0');

$flagValue = $client->getBooleanDetails('dev.openfeature.example_flag', true, null, null);

// ... do work with the $flagValue

```

## Development

### PHP Versioning

This library targets PHP version 8.0 and newer. As long as you have any compatible version of PHP on your system you should be able to utilize the OpenFeature SDK.

This package also has a `.tool-versions` file for use with PHP version managers like `asdf`.

### Installation and Dependencies

Install dependencies with `composer install`. `composer install` will update the `composer.lock` with the most recent compatible versions.

We value having as few runtime dependencies as possible. The addition of any dependencies requires careful consideration and review.

### Testing

Run tests with `composer run test`.
