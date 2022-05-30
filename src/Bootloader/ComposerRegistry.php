<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Bootloader;

use Spiral\Discoverer\Traits\WithComposerPackages;

final class ComposerRegistry implements BootloaderRegistryInterface
{
    use WithComposerPackages;

    public function getBootloaders(): array
    {
        $bootloaders = [];

        foreach ($this->getComposer()->getPackages() as $extra) {
            $bootloaders = \array_merge(
                $bootloaders,
                (array)($extra['bootloaders'] ?? [])
            );
        }

        return \array_unique($bootloaders);
    }

    public function getIgnoredBootloaders(): array
    {
        $ignore = $this->getComposer()->getComposerExtra('dont-discover', []);

        foreach ($this->getComposer()->getPackages() as $extra) {
            $ignore = \array_merge(
                $ignore,
                (array)($extra['dont-discover'] ?? [])
            );
        }

        $bootloaders = [];

        foreach ($ignore as $packageName) {
            if ($package = $this->getComposer()->getPackageExtra($packageName)) {
                $bootloaders = \array_merge(
                    $bootloaders,
                    (array)($package['bootloaders'] ?? [])
                );
            }
        }

        return \array_unique($bootloaders);
    }
}
