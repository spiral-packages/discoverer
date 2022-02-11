<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Config;

use Spiral\Core\InjectableConfig;

final class DiscovererConfig extends InjectableConfig
{
    public const CONFIG = 'discoverer';
    protected $config = [
        'bootloaders' => [],
        'ignoredBootloaders' => [],
    ];

    public function getBootloaders(): array
    {
        return (array)($this->config['bootloaders'] ?? []);
    }

    public function getIgnoredBootloaders(): array
    {
        return (array)($this->config['ignoredBootloaders'] ?? []);
    }
}
