<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Psr\Container\ContainerInterface;
use Spiral\Boot\BootloadManagerInterface;

/**
 * @psalm-import-type TClass from BootloadManagerInterface
 */
final class ArrayRegistry implements BootloaderRegistryInterface
{
    /**
     * @param array<TClass, array<non-empty-string, mixed>> $bootloaders
     * @param TClass[] $ignorableBootloaders
     */
    public function __construct(
        private readonly array $bootloaders,
        private readonly array $ignorableBootloaders = []
    ) {
    }

    public function init(ContainerInterface $container): void
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
