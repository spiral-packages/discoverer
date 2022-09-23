<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

interface DiscovererRegistryInterface extends RegistryInterface
{
    public static function getName(): string;

    public function discover(): array;
}
