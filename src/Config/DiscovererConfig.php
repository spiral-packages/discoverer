<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Config;

use Spiral\Boot\Bootloader\BootloaderInterface;
use Spiral\Core\InjectableConfig;

final class DiscovererConfig extends InjectableConfig
{
    public const CONFIG = 'discoverer';
    protected array $config = [
        'bootloaders' => [],
        'ignoredBootloaders' => [],
    ];

    /**
     * @return array<class-string<BootloaderInterface>>|array<class-string<BootloaderInterface>, array<non-empty-string, mixed>>
     */
    public function getBootloaders(): array
    {
        return (array)($this->config['bootloaders'] ?? []);
    }

    /**
     * @return array<class-string<BootloaderInterface>>
     */
    public function getIgnoredBootloaders(): array
    {
        return (array)($this->config['ignoredBootloaders'] ?? []);
    }
}
