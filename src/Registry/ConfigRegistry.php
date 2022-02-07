<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover\Registry;

use Spiral\BootloadersDiscover\Config\BootloadersConfig;
use Spiral\BootloadersDiscover\RegistryInterface;
use Spiral\Core\Container;

final class ConfigRegistry implements RegistryInterface
{
    private BootloadersConfig $config;

    public function init(Container $container): void
    {
        $this->config = $container->get(BootloadersConfig::class);
    }

    public function getBootloaders(): array
    {
        return $this->config->getBootloaders();
    }

    public function getIgnorableBootloaders(): array
    {
        return $this->config->getIgnorableBootloaders();
    }
}
