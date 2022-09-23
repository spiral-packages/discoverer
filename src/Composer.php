<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

use Spiral\Files\FilesInterface;

final class Composer
{
    private string $vendorDir;
    private array $packages = [];
    private array $packageDirs = [];
    private array $composerExtra = [];

    public function __construct(
        FilesInterface $files,
        private readonly string $rootDir,
        string $extraKey = 'spiral'
    ) {
        $this->vendorDir = \rtrim($rootDir, '\/').'/vendor';

        if ($files->exists($path = $this->vendorDir.'/composer/installed.json')) {
            $installed = \json_decode($files->read($path), true);
            $packages = $installed['packages'] ?? $installed;

            foreach ($packages as $package) {
                $packageName = $this->formatPackageName($package['name']);
                $this->packageDirs[$packageName] = $this->vendorDir.'/composer/'.$package['install-path'];

                if (! isset($package['extra'][$extraKey])) {
                    continue;
                }

                $this->packages[$packageName] = (array)$package['extra'][$extraKey];
            }
        }

        if ($files->isFile($composerPath = $this->rootDir.'/composer.json')) {
            $data = \json_decode(
                \file_get_contents($composerPath),
                true
            );

            $this->composerExtra = (array)($data['extra'][$extraKey] ?? []);
        }
    }

    public function getComposerExtra(string $key, mixed $default = null): mixed
    {
        return $this->composerExtra[$key] ?? $default;
    }

    public function getPackagePath(string $package): ?string
    {
        return $this->packageDirs[$package] ?? null;
    }

    public function packageHasExtra(string $package, string $key): bool
    {
        return isset($this->packages[$package][$key]);
    }

    public function getPackageExtra(string $package, array $default = null): ?array
    {
        if (! isset($this->packages[$package])) {
            return $default;
        }

        return (array)$this->packages[$package];
    }

    private function formatPackageName(string $name): string
    {
        return \str_replace($this->vendorDir.'/', '', $name);
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    public function getRootDir(): string
    {
        return $this->rootDir;
    }
}
