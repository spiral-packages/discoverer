<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tokenizer;

use Spiral\Discoverer\RegistryInterface;

interface DirectoryRegistryInterface extends RegistryInterface
{
    public function getDirectories(): array;
}
