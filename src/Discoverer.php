<?php

namespace Spiral\Discoverer;

use Spiral\Core\Container;
use Spiral\Discoverer\Exception\DiscovererRegistryException;

final class Discoverer implements DiscovererInterface
{
    /** @var DiscovererRegistryInterface[] */
    private array $registries;

    public function __construct(
        private Container $container,
        DiscovererRegistryInterface ...$registries
    ) {
        foreach ($registries as $registry) {
            $this->registries[$registry::getName()] = $registry;
            $registry->init($container);
        }
    }

    public function discover(string $name): array
    {
        if ($this->has($name)) {
            return $this->registries[$name]->discover();
        }

        throw new DiscovererRegistryException(\sprintf('Registry with name [%s] does not exist.', $name));
    }

    public function has(string $name): bool
    {
        return isset($this->registries[$name]);
    }
}
