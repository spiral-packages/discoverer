<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Config;

use Spiral\Boot\Bootloader\BootloaderInterface;
use Spiral\Boot\BootloadManagerInterface;
use Spiral\Core\InjectableConfig;

/**
 * @psalm-import-type TClass from BootloadManagerInterface
 */
final class DiscovererConfig extends InjectableConfig
{
    public const CONFIG = 'discoverer';
    protected array $config = [
        'bootloaders' => [],
        'ignoredBootloaders' => [],
    ];

    /**
     * @return TClass[]|array<TClass, array<non-empty-string, mixed>>
     */
    public function getBootloaders(): array
    {
        return (array)$this->config['bootloaders'];
    }

    /**
     * @return TClass[]
     */
    public function getIgnoredBootloaders(): array
    {
        return (array)$this->config['ignoredBootloaders'];
    }
}
