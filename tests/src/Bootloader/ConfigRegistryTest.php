<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tests\Bootloader;

use Spiral\Discoverer\Config\DiscovererConfig;
use Spiral\Discoverer\Bootloader\ConfigRegistry;
use Spiral\Discoverer\Tests\TestCase;

final class ConfigRegistryTest extends TestCase
{
    private ConfigRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getContainer()->bindSingleton(DiscovererConfig::class, new DiscovererConfig([
            'bootloaders' => [
                'BootloaderA',
                'BootloaderB',
            ],
            'ignoredBootloaders' => [
                'BootloaderC',
                'BootloaderC',
            ],
        ]));

        $this->registry = new ConfigRegistry();
        $this->registry->init($this->getContainer());
    }

    public function testGetsBootloaders(): void
    {
        $this->assertSame([
            'BootloaderA',
            'BootloaderB',
        ], $this->registry->getBootloaders());
    }

    public function testGetsIgnoredBootloaders(): void
    {
        $this->assertSame([
            'BootloaderC',
            'BootloaderC',
        ], $this->registry->getIgnoredBootloaders());
    }
}
