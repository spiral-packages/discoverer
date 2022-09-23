<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tokenizer;

use Psr\Container\ContainerInterface;
use Spiral\Discoverer\DiscovererRegistryInterface;

final class DirectoriesDiscoverer implements DiscovererRegistryInterface
{
    /** @var DirectoryRegistryInterface[] */
    private array $registries;

    public function __construct(DirectoryRegistryInterface ...$registry)
    {
        $this->registries = $registry;
    }

    public static function getName(): string
    {
        return 'directories';
    }

    /**
     * @return non-empty-string[]
     */
    public function discover(): array
    {
        $dirs = [];

        foreach ($this->registries as $registry) {
            $dirs = \array_merge($dirs, $registry->getDirectories());
        }

        return \array_values(\array_unique(\array_filter($dirs)));
    }

    public function init(ContainerInterface $container): void
    {
        foreach ($this->registries as $registry) {
            $registry->init($container);
        }
    }
}
