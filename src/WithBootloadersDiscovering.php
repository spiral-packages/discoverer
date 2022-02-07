<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover;

trait WithBootloadersDiscovering
{
    private ?Discoverer $discoverer = null;

    public function discoverBootloadersFrom(RegistryInterface ...$registry): void
    {
        $this->discoverer = new Discoverer(...$registry);
    }

    protected function defineBootloaders(): array
    {
        if (! $this->discoverer) {
            return parent::defineBootloaders();
        }

        return $this->discoverer->discover($this->container);
    }
}
