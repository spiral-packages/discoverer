<?php

namespace Spiral\BootloadersDiscover;

use Spiral\Core\Container;

final class Discoverer
{
    /** @var RegistryInterface[] */
    private array $registries;

    public function __construct(RegistryInterface ...$registries)
    {
        $this->registries = $registries;
    }

    /**
     * @return array<class-string, array<non-empty-string, mixed>>
     */
    public function discover(Container $container): array
    {
        $this->initRegistries($container);

        $bootloaders = [];
        $ignorableBootloaders = $this->getIgnorableBootloaders();

        foreach ($this->registries as $registry) {
            $registryBootloaders = $registry->getBootloaders();

            foreach ($registryBootloaders as $class => $options) {
                if (\is_string($options)) {
                    $class = $options;
                    $options = [];
                }

                if (isset($bootloaders[$class]) || \in_array($class, $ignorableBootloaders)) {
                    continue;
                }

                $bootloaders[$class] = $options;
            }
        }

        return $bootloaders;
    }

    /**
     * @return array<class-string>
     */
    protected function getIgnorableBootloaders(): array
    {
        /** @var array<class-string> $ignorableBootloaders */
        $ignorableBootloaders = [];
        foreach ($this->registries as $registry) {
            $ignorableBootloaders = \array_merge(
                $ignorableBootloaders,
                $registry->getIgnorableBootloaders()
            );
        }

        return \array_unique($ignorableBootloaders);
    }

    protected function initRegistries(Container $container): void
    {
        foreach ($this->registries as $registry) {
            $registry->init($container);
        }
    }
}
