<?php

declare(strict_types=1);

namespace Spiral\BootloadersDiscover\Registry;

use Spiral\Boot\DirectoriesInterface;
use Spiral\BootloadersDiscover\RegistryInterface;
use Spiral\Core\Container;
use Spiral\Files\FilesInterface;

final class ComposerRegistry implements RegistryInterface
{
    private FilesInterface $files;
    private string $rootDir;
    private string $vendorDir;
    private array $packages = [];

    public function init(Container $container): void
    {
        $this->files = $container->get(FilesInterface::class);
        $dirs = $container->get(DirectoriesInterface::class);

        $this->rootDir = $dirs->get('root');
        $this->vendorDir = $this->rootDir.'/vendor';

        if ($this->files->exists($path = $this->vendorDir.'/composer/installed.json')) {
            $installed = \json_decode($this->files->read($path), true);
            $packages = $installed['packages'] ?? $installed;

            foreach ($packages as $package) {
                if (! isset($package['extra']['spiral'])) {
                    continue;
                }

                $packageName = $this->formatPackageName($package['name']);
                $this->packages[$packageName] = \array_merge([
                    'bootloaders' => [],
                    'dont-discover' => [],
                ], (array)$package['extra']['spiral']);
            }
        }
    }

    public function getBootloaders(): array
    {
        $bootloaders = [];

        foreach ($this->packages as $extra) {
            $bootloaders = array_merge($bootloaders, (array)$extra['bootloaders']);
        }

        return \array_unique($bootloaders);
    }

    public function getIgnorableBootloaders(): array
    {
        if (! $this->files->isFile($composerPath = $this->rootDir.'/composer.json')) {
            return [];
        }

        $data = \json_decode(
            file_get_contents($composerPath),
            true
        );

        $ignore = (array)($data['extra']['spiral']['dont-discover'] ?? []);

        foreach ($this->packages as $extra) {
            $ignore = array_merge($ignore, (array)$extra['dont-discover']);
        }

        $bootloaders = [];

        foreach ($ignore as $packageName) {
            if (isset($this->packages[$packageName])) {
                $bootloaders = \array_merge($bootloaders, $this->packages[$packageName]['bootloaders']);
            }
        }

        return \array_unique($bootloaders);
    }

    private function formatPackageName(string $name): string
    {
        return str_replace($this->vendorDir.'/', '', $name);
    }
}
