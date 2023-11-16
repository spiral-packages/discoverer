<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Boot\Bootloader\BootloaderRegistryInterface;
use Spiral\Config\ConfiguratorInterface;
use Spiral\Discoverer\Bootloader as BootloaderRegistry;
use Spiral\Discoverer\Config\DiscovererConfig;
use Spiral\Discoverer\Tokenizer as TokenizerRegistry;
use Spiral\Tokenizer\Bootloader\TokenizerBootloader;

final class DiscovererBootloader extends Bootloader
{
    public function __construct(
        private readonly ConfiguratorInterface $config,
    ) {
    }

    public function defineSingletons(): array
    {
        return [
            DiscovererInterface::class => [self::class, 'initDiscoverer'],
        ];
    }

    public function init(ContainerInterface $container, TokenizerBootloader $tokenizerBootloader): void
    {
        $this->initDefaultConfig();
        $this->registerDirectories($container, $tokenizerBootloader);
        $this->registerBootloaders($container);
    }

    private function initDefaultConfig(): void
    {
        $this->config->setDefaults(DiscovererConfig::CONFIG, [
            'bootloaders' => [],
            'ignoredBootloaders' => [],
            'registries' => [
                'bootloaders' => [
                    BootloaderRegistry\ComposerRegistry::class,
                    BootloaderRegistry\ConfigRegistry::class,
                ],
                'directories' => [
                    TokenizerRegistry\ComposerRegistry::class,
                ],
            ],
        ]);
    }

    /**
     * @throws Exception\DiscovererRegistryException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function registerDirectories(ContainerInterface $container, TokenizerBootloader $tokenizerBootloader): void
    {
        $discoverer = $container->get(DiscovererInterface::class);

        if ($discoverer->has(TokenizerRegistry\DirectoriesDiscoverer::getName())) {
            foreach ($discoverer->discover(TokenizerRegistry\DirectoriesDiscoverer::getName()) as $directory) {
                $tokenizerBootloader->addDirectory($directory);
            }
        }
    }

    private function registerBootloaders(ContainerInterface $container): void
    {
        $discoverer = $container->get(DiscovererInterface::class);
        $bootloadersRegistry = $container->get(BootloaderRegistryInterface::class);

        if ($discoverer->has(BootloaderRegistry\BootloadersDiscoverer::getName())) {
            $bootloaders = $discoverer->discover(BootloaderRegistry\BootloadersDiscoverer::getName());
            foreach ($bootloaders as $bootloader => $options) {
                $bootloadersRegistry->register([$bootloader => $options]);
            }
        }
    }

    private function initDiscoverer(DiscovererConfig $config, ContainerInterface $container): DiscovererInterface
    {
        $bootloaders = [];
        foreach ($config->getBootloaderRegistries() as $registry) {
            $registry = $container->get($registry);
            \assert($registry instanceof BootloaderRegistry\BootloaderRegistryInterface);
            $bootloaders[] = $registry;
        }

        $directories = [];
        foreach ($config->getDirectoryRegistries() as $registry) {
            $registry = $container->get($registry);
            \assert($registry instanceof TokenizerRegistry\DirectoryRegistryInterface);
            $directories[] = $registry;
        }

        return new Discoverer(
            $container,
            new BootloaderRegistry\BootloadersDiscoverer(...$bootloaders),
            new TokenizerRegistry\DirectoriesDiscoverer(...$directories),
        );
    }
}
