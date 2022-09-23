<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Traits;

use Psr\Container\ContainerInterface;
use Spiral\Boot\DirectoriesInterface;
use Spiral\Discoverer\Composer;
use Spiral\Files\FilesInterface;

trait WithComposerPackages
{
    private Composer $composer;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function init(ContainerInterface $container): void
    {
        $dirs = $container->get(DirectoriesInterface::class);
        $files = $container->get(FilesInterface::class);
        \assert($files instanceof FilesInterface);

        $this->composer = new Composer($files, $dirs->get('root'));
    }

    public function getComposer(): Composer
    {
        return $this->composer;
    }
}
