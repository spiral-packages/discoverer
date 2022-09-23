<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Psr\Container\ContainerInterface;
use Spiral\Boot\Bootloader\BootloaderInterface;
use Spiral\Boot\BootloadManagerInterface;
use Spiral\Discoverer\DiscovererRegistryInterface;

/**
 * @psalm-import-type TClass from BootloadManagerInterface
 */
class BootloadersDiscoverer implements DiscovererRegistryInterface
{
    /** @var BootloaderRegistryInterface[] */
    private array $registries;

    public function __construct(BootloaderRegistryInterface ...$registry)
    {
        $this->registries = $registry;
    }

    public static function getName(): string
    {
        return 'bootloaders';
    }

    /**
     * @return array<class-string<BootloaderInterface>, array>
     */
    public function discover(): array
    {
        $bootloaders = [];
        $ignorableBootloaders = $this->getIgnoredBootloaders();

        foreach ($this->registries as $registry) {
            if (! $registry instanceof BootloaderRegistryInterface) {
                continue;
            }

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
     * @return TClass[]
     */
    private function getIgnoredBootloaders(): array
    {
        $ignorableBootloaders = [];
        foreach ($this->registries as $registry) {
            if (! $registry instanceof BootloaderRegistryInterface) {
                continue;
            }

            $ignorableBootloaders = \array_merge(
                $ignorableBootloaders,
                $registry->getIgnoredBootloaders()
            );
        }

        return \array_unique($ignorableBootloaders);
    }

    public function init(ContainerInterface $container): void
    {
        foreach ($this->registries as $registry) {
            $registry->init($container);
        }
    }
}
