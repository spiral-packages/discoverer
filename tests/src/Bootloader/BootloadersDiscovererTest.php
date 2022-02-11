<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tests\Bootloader;

use Spiral\Discoverer\Bootloader\BootloaderRegistryInterface;
use Spiral\Discoverer\Bootloader\BootloadersDiscoverer;
use Spiral\Discoverer\Tests\TestCase;

final class BootloadersDiscovererTest extends TestCase
{
    public function testGetsName()
    {
        return $this->assertSame(
            'bootloaders',
            BootloadersDiscoverer::getName()
        );
    }

    public function testDiscover(): void
    {
        $discover = new BootloadersDiscoverer(
            $registry2 = $this->mockContainer(BootloaderRegistryInterface::class),
            $registry3 = $this->mockContainer(BootloaderRegistryInterface::class),
        );

        $registry2->shouldReceive('init')->once()->with($this->getContainer());
        $registry3->shouldReceive('init')->once()->with($this->getContainer());

        $registry3->shouldReceive('getIgnoredBootloaders')->once()->andReturn([
            'BootloaderC',
        ]);

        $registry2->shouldReceive('getIgnoredBootloaders')->once()->andReturn([
            'BootloaderA',
        ]);

        $registry3->shouldReceive('getBootloaders')->once()->andReturn([
            'BootloaderA',
            'BootloaderB',
        ]);

        $registry2->shouldReceive('getBootloaders')->once()->andReturn([
            'BootloaderC',
            'BootloaderD',
        ]);

        $discover->init($this->getContainer());

        $this->assertSame([
            'BootloaderD' => [],
            'BootloaderB' => [],
        ], $discover->discover());
    }
}
