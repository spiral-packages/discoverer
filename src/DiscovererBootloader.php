<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

use Psr\Container\ContainerInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Discoverer\Tokenizer\DirectoriesDiscoverer;
use Spiral\Tokenizer\Bootloader\TokenizerBootloader;

final class DiscovererBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        TokenizerBootloader::class,
    ];

    /**
     * @throws Exception\DiscovererRegistryException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function init(
        ContainerInterface $container,
        TokenizerBootloader $tokenizerBootloader
    ): void {
        if (!$container->has(DiscovererInterface::class)) {
            return;
        }

        $discoverer = $container->get(DiscovererInterface::class);
        \assert($discoverer instanceof DiscovererInterface);

        if ($discoverer->has(DirectoriesDiscoverer::getName())) {
            foreach ($discoverer->discover(DirectoriesDiscoverer::getName()) as $directory) {
                $tokenizerBootloader->addDirectory($directory);
            }
        };
    }
}
