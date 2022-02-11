<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

use Spiral\Discoverer\Exception\DiscovererRegistryException;

interface DiscovererInterface
{
    public function has(string $name): bool;

    /**
     * @throws DiscovererRegistryException
     */
    public function discover(string $name): array;
}
