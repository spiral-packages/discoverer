<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Spiral\Core\Container;
use Spiral\Discoverer\Config\DiscovererConfig;

final class ConfigRegistry implements BootloaderRegistryInterface
{
    private DiscovererConfig $config;

    public function init(Container $container): void
    {
        $this->config = $container->get(DiscovererConfig::class);
    }

    public function getBootloaders(): array
    {
        return $this->config->getBootloaders();
    }

    public function getIgnoredBootloaders(): array
    {
        return $this->config->getIgnoredBootloaders();
    }
}
