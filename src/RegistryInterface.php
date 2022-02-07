<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover;

use Spiral\Core\Container;

interface RegistryInterface
{
    public function init(Container $container): void;

    /**
     * @return array<class-string>|array<class-string, array<non-empty-string, mixed>>
     */
    public function getBootloaders(): array;

    /**
     * @return array<class-string>
     */
    public function getIgnorableBootloaders(): array;
}
