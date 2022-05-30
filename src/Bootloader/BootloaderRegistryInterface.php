<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Spiral\Boot\Bootloader\BootloaderInterface;
use Spiral\Discoverer\RegistryInterface;

interface BootloaderRegistryInterface extends RegistryInterface
{
    /**
     * @return array<class-string<BootloaderInterface>>|array<class-string<BootloaderInterface>, array<non-empty-string, mixed>>
     */
    public function getBootloaders(): array;

    /**
     * @return array<class-string<BootloaderInterface>>
     */
    public function getIgnoredBootloaders(): array;
}
