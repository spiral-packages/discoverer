<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover\Tests;

use Spiral\BootloadersDiscover\Discoverer;
use Spiral\BootloadersDiscover\RegistryInterface;

final class DiscovererTest extends TestCase
{
    public function testDiscover(): void
    {
        $discover = new Discoverer(
            $registry1 = $this->mockContainer(RegistryInterface::class),
            $registry2 = $this->mockContainer(RegistryInterface::class),
        );

        $registry1->shouldReceive('init')->once()->with($this->getContainer());
        $registry2->shouldReceive('init')->once()->with($this->getContainer());

        $registry1->shouldReceive('getIgnorableBootloaders')->once()->andReturn([
            'BootloaderC',
        ]);

        $registry2->shouldReceive('getIgnorableBootloaders')->once()->andReturn([
            'BootloaderA',
        ]);

        $registry1->shouldReceive('getBootloaders')->once()->andReturn([
            'BootloaderA',
            'BootloaderB',
        ]);

        $registry2->shouldReceive('getBootloaders')->once()->andReturn([
            'BootloaderC',
            'BootloaderD',
        ]);

        $this->assertSame([
            'BootloaderB' => [],
            'BootloaderD' => [],
        ], $discover->discover($this->getContainer()));
    }
}
