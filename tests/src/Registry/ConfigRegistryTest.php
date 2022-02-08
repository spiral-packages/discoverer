<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover\Tests\Registry;

use Spiral\BootloadersDiscover\Config\BootloadersConfig;
use Spiral\BootloadersDiscover\Registry\ConfigRegistry;
use Spiral\BootloadersDiscover\Tests\TestCase;

final class ConfigRegistryTest extends TestCase
{
    private ConfigRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->getContainer()->bindSingleton(BootloadersConfig::class, new BootloadersConfig([
            'bootloaders' => [
                'BootloaderA',
                'BootloaderB',
            ],
            'ignorableBootloaders' => [
                'BootloaderC',
                'BootloaderC',
            ],
        ]));

        $this->registry = new ConfigRegistry();
        $this->registry->init($this->getContainer());
    }

    public function testGetsBootloaders(): void
    {
        $registry = new ConfigRegistry();

        $this->assertSame([
            'BootloaderA',
            'BootloaderB',
        ], $this->registry->getBootloaders());
    }

    public function testGetsIgnorableBootloaders(): void
    {
        $registry = new ConfigRegistry();

        $this->assertSame([
            'BootloaderC',
            'BootloaderC',
        ], $this->registry->getIgnorableBootloaders());
    }
}
