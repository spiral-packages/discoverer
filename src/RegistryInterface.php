<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

use Spiral\Core\Container;

interface RegistryInterface
{
    public function init(Container $container): void;
}
