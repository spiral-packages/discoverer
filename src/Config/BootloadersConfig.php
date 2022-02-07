<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover\Config;

use Spiral\Core\InjectableConfig;

final class BootloadersConfig extends InjectableConfig
{
    public const CONFIG = 'bootloaders';
    protected $config = [
        'bootloaders' => [],
        'ignorableBootloaders' => [],
    ];

    public function getBootloaders(): array
    {
        return (array)($this->config['bootloaders'] ?? []);
    }

    public function getIgnorableBootloaders(): array
    {
        return (array)($this->config['ignorableBootloaders'] ?? []);
    }
}
