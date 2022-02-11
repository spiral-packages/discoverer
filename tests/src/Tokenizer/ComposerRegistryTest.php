<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tests\Tokenizer;

use Spiral\Discoverer\Tests\TestCase;
use Spiral\Discoverer\Tokenizer\ComposerRegistry;

final class ComposerRegistryTest extends TestCase
{
    private ComposerRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registry = new ComposerRegistry();
        $this->registry->init($this->getContainer());
    }

    public function testGetsBootloaders(): void
    {
        $rootDir = $this->getDirectoryByAlias('root');

        $this->assertSame([
            $rootDir.'vendor/composer/../foo/scheduler/src/foo',
            $rootDir.'src/Listener',
            $rootDir.'vendor/composer/../foo/notifications/src/foo',
            $rootDir.'vendor/composer/../foo/notifications/src/bar',
            $rootDir.'vendor/composer/../foo/event-bus/src/bar',
        ], $this->registry->getDirectories());
    }
}
