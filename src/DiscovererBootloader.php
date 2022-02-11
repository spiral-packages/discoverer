<?php

declare(strict_types=1);

namespace Spiral\Discoverer;

use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Core\Container;
use Spiral\Discoverer\Tokenizer\DirectoriesDiscoverer;
use Spiral\Tokenizer\Bootloader\TokenizerBootloader;

final class DiscovererBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        TokenizerBootloader::class,
    ];

    public function boot(
        Container $container,
        TokenizerBootloader $tokenizerBootloader
    ) {
        if ($container->has(DiscovererInterface::class)) {
            $discoverer = $container->get(DiscovererInterface::class);
            if ($discoverer->has(DirectoriesDiscoverer::getName())) {
                foreach ($discoverer->discover(DirectoriesDiscoverer::getName()) as $directory) {
                    $tokenizerBootloader->addDirectory($directory);
                }
            };
        }
    }
}
