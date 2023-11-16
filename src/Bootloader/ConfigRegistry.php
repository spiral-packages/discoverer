<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Psr\Container\ContainerInterface;
use Spiral\Boot\BootloadManagerInterface;
use Spiral\Discoverer\Config\DiscovererConfig;

/**
 * @psalm-import-type TClass from BootloadManagerInterface
 */
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

    /**
     * @return TClass[]|array<TClass, array<string, mixed>>
     */
    public function getBootloaders(): array
    {
        return $this->config !== null ? $this->config->getBootloaders() : [];
    }

    public function getIgnoredBootloaders(): array
    {
        return $this->config !== null ? $this->config->getIgnoredBootloaders() : [];
    }
}
