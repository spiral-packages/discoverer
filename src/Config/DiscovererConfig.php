<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Config;

use Spiral\Boot\BootloadManagerInterface;
use Spiral\Core\InjectableConfig;
use Spiral\Discoverer\Bootloader\BootloaderRegistryInterface;
use Spiral\Discoverer\Bootloader as BootloaderRegistry;
use Spiral\Discoverer\Tokenizer as TokenizerRegistry;
use Spiral\Discoverer\Tokenizer\DirectoryRegistryInterface;

/**
 * @psalm-import-type TClass from BootloadManagerInterface
 * @property array{
 *     bootloaders: array<TClass>|array<TClass, array<string, mixed>>,
 *     ignoredBootloaders: array<TClass>,
 *     registries: array{
 *         bootloaders: array<class-string<BootloaderRegistryInterface>>,
 *         directories: array<class-string<DirectoryRegistryInterface>>
 *     }
 * } $config
 */
final class DiscovererConfig extends InjectableConfig
{
    public const CONFIG = 'discoverer';

    protected array $config = [
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
    ];

    /**
     * @return array<TClass>|array<TClass, array<string, mixed>>
     */
    public function getBootloaders(): array
    {
        return (array)$this->config['bootloaders'];
    }

    /**
     * @return array<TClass>
     */
    public function getIgnoredBootloaders(): array
    {
        return (array)$this->config['ignoredBootloaders'];
    }

    /**
     * @return array<class-string<BootloaderRegistryInterface>>
     */
    public function getBootloaderRegistries(): array
    {
        return $this->config['registries']['bootloaders'] ?? [];
    }

    /**
     * @return array<class-string<DirectoryRegistryInterface>>
     */
    public function getDirectoryRegistries(): array
    {
        return $this->config['registries']['directories'] ?? [];
    }
}
