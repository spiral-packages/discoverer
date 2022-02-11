<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tests\Bootloader;

use Spiral\Discoverer\Bootloader\ArrayRegistry;
use Spiral\Discoverer\Tests\TestCase;

final class ArrayRegistryTest extends TestCase
{
    public function testGetsBootloaders(): void
    {
        $registry = new ArrayRegistry($bootloaders = [
            'BootloaderA',
            'BootloaderB',
        ]);

        $this->assertSame($bootloaders, $registry->getBootloaders());
    }

    public function testGetsIgnorableBootloaders(): void
    {
        $registry = new ArrayRegistry([], $bootloaders = [
            'BootloaderA',
            'BootloaderB',
        ]);

        $this->assertSame($bootloaders, $registry->getIgnoredBootloaders());
    }
}
