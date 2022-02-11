<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Spiral\Discoverer\RegistryInterface;

interface BootloaderRegistryInterface extends RegistryInterface
{
    /**
     * @return array<class-string>|array<class-string, array<non-empty-string, mixed>>
     */
    public function getBootloaders(): array;

    /**
     * @return array<class-string>
     */
    public function getIgnoredBootloaders(): array;
}
