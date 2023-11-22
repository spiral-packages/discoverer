<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Spiral\Boot\BootloadManagerInterface;
use Spiral\Discoverer\RegistryInterface;

/**
 * @psalm-import-type TClass from BootloadManagerInterface
 */
interface BootloaderRegistryInterface extends RegistryInterface
{
    /**
     * @return TClass[]|array<TClass, array<string, mixed>>
     */
    public function getBootloaders(): array;

    /**
     * @return TClass[]
     */
    public function getIgnoredBootloaders(): array;
}
