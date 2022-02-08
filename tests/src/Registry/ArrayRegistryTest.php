<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover\Tests\Registry;

use Spiral\BootloadersDiscover\Registry\ArrayRegistry;
use Spiral\BootloadersDiscover\Tests\TestCase;

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

        $this->assertSame($bootloaders, $registry->getIgnorableBootloaders());
    }
}
