<?php

namespace Spiral\Discoverer\Tests;

use Spiral\Discoverer\DiscovererBootloader;

abstract class TestCase extends \Spiral\Testing\TestCase
{
    public function rootDirectory(): string
    {
        return __DIR__.'/../';
    }

    public function defineBootloaders(): array
    {
        return [
            \Spiral\Boot\Bootloader\CoreBootloader::class,
            DiscovererBootloader::class,
        ];
    }
}
