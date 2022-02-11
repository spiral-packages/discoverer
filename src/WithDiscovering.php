<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

use Spiral\Discoverer\Bootloader\BootloadersDiscoverer;

trait WithDiscovering
{
    private ?Discoverer $discoverer = null;

    public function discover(DiscovererRegistryInterface ...$registry): void
    {
        $this->discoverer = new Discoverer($this->container, ...$registry);

        $this->container->bindSingleton(
            DiscovererInterface::class,
            $this->discoverer
        );
    }

    protected function defineBootloaders(): array
    {
        if (! $this->discoverer) {
            return parent::defineBootloaders();
        }

        return $this->discoverer->discover(BootloadersDiscoverer::getName());
    }
}
