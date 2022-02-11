<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tokenizer;

use Spiral\Discoverer\Traits\WithComposerPackages;

final class ComposerRegistry implements DirectoryRegistryInterface
{
    use WithComposerPackages;

    public function getDirectories(): array
    {
        $dirs = [];

        foreach ($this->getComposer()->getPackages() as $package => $extra) {
            $dirs = \array_merge(
                $dirs,
                \array_map(function (string $dir) use ($package, $extra) {
                    return $this->getComposer()->getPackagePath($package).'/'.ltrim($dir, '\/');
                }, $extra['directories'] ?? [])
            );
        }

        foreach ($this->getComposer()->getComposerExtra('directories', []) as $package => $packageDirs) {
            if (\is_int($package) || $package === 'self') {
                $packagePath = rtrim($this->getComposer()->getRootDir(), '\/');
            } else if (! $packagePath = $this->getComposer()->getPackagePath($package)) {
                continue;
            }

            foreach ((array)$packageDirs as $dir) {
                $dirs[] = $packagePath.'/'.ltrim($dir, '\/');
            }
        }

        return $dirs;
    }
}
