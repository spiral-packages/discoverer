<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tokenizer;

use Spiral\Discoverer\RegistryInterface;

interface DirectoryRegistryInterface extends RegistryInterface
{
    /**
     * @return non-empty-string[]
     */
    public function getDirectories(): array;
}
