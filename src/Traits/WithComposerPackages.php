<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Traits;

use Spiral\Boot\DirectoriesInterface;
use Spiral\Core\Container;
use Spiral\Discoverer\Composer;
use Spiral\Files\FilesInterface;

trait WithComposerPackages
{
    private Composer $composer;

    public function init(Container $container): void
    {
        $dirs = $container->get(DirectoriesInterface::class);

        $this->composer = new Composer(
            $container->get(FilesInterface::class),
            $dirs->get('root')
        );
    }

    public function getComposer(): Composer
    {
        return $this->composer;
    }
}
