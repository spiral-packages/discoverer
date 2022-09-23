<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Psr\Container\ContainerInterface;
use Spiral\Discoverer\Config\DiscovererConfig;

final class ConfigRegistry implements BootloaderRegistryInterface
{
    private ?DiscovererConfig $config = null;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function init(ContainerInterface $container): void
    {
        $this->config = $container->get(DiscovererConfig::class);
        \assert($this->config instanceof DiscovererConfig);
    }

    public function getBootloaders(): array
    {
        return $this->config !== null ? $this->config->getBootloaders() : [];
    }

    public function getIgnoredBootloaders(): array
    {
        return $this->config !== null ? $this->config->getIgnoredBootloaders() : [];
    }
}
