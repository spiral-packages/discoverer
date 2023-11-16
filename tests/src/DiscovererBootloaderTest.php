<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tests;

final class DiscovererBootloaderTest extends TestCase
{
    public function testTokenizerDirectoriesShouldBeDiscovered(): void
    {
        $dirs = $this->getConfig('tokenizer')['directories'];

        $rootDir = $this->getDirectoryByAlias('root');

        $this->assertContains($rootDir.'vendor/composer/../foo/notifications/src/foo', $dirs);
        $this->assertContains($rootDir.'vendor/composer/../foo/notifications/src/bar', $dirs);
    }
}
