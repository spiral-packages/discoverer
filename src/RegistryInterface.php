<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

use Psr\Container\ContainerInterface;

interface RegistryInterface
{
    public function init(ContainerInterface $container): void;
}
