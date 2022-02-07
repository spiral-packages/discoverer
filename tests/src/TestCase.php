<?php

namespace Spiral\BootloadersDiscover\Tests;

class TestCase extends \Spiral\Testing\TestCase
{
    public function rootDirectory(): string
    {
        return __DIR__.'/../';
    }

    public function defineBootloaders(): array
    {
        return [
            \Spiral\Boot\Bootloader\ConfigurationBootloader::class,
            \Spiral\BootloadersDiscover\BootloadersDiscoverBootloader::class,
            // ...
        ];
    }
}
