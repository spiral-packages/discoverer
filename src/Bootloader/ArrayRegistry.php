<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Spiral\Boot\Bootloader\BootloaderInterface;
use Spiral\Core\Container;

final class ArrayRegistry implements BootloaderRegistryInterface
{
    /**
     * @param array<class-string<BootloaderInterface>, array<non-empty-string, mixed>> $bootloaders
     * @param array<class-string<BootloaderInterface>> $ignorableBootloaders
     */
    public function __construct(
        private array $bootloaders,
        private array $ignorableBootloaders = []
    ) {
    }

    public function init(Container $container): void
    {
    }

    public function getBootloaders(): array
    {
        return $this->bootloaders;
    }

    public function getIgnoredBootloaders(): array
    {
        return $this->ignorableBootloaders;
    }
}
