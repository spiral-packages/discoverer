<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover\Tests\Bootloader;

use Spiral\Discoverer\Bootloader\ComposerRegistry;
use Spiral\Discoverer\Tests\TestCase;

final class ComposerRegistryTest extends TestCase
{
    private ComposerRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registry = new ComposerRegistry();
        $this->registry->init($this->getContainer());
    }

    public function testGetsBootloaders(): void
    {
        $this->assertSame([
            'Spiral\Scheduler\Bootloader\SchedulerBootloader',
            'Spiral\EventBus\Bootloader\EventBusBootloader',
            'Spiral\Notifications\Bootloader\NotificationsBootloader',
            'Spiral\PackageA\Bootloader\PackageABootloader',
            'Spiral\PackageB\Bootloader\PackageBBootloader',
        ], $this->registry->getBootloaders());
    }

    public function testGetIgnorableBootloaders(): void
    {
        $this->assertSame([
            'Spiral\EventBus\Bootloader\EventBusBootloader',
            'Spiral\PackageB\Bootloader\PackageBBootloader',
        ], $this->registry->getIgnoredBootloaders());
    }
}
