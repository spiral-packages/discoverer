<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tests\Tokenizer;

use Spiral\Discoverer\Tests\TestCase;
use Spiral\Discoverer\Tokenizer\DirectoriesDiscoverer;
use Spiral\Discoverer\Tokenizer\DirectoryRegistryInterface;

final class DirectoriesDiscovererTest extends TestCase
{
    public function testGetsName()
    {
        $this->assertSame(
            'directories',
            DirectoriesDiscoverer::getName()
        );
    }

    public function testDiscover(): void
    {
        $discover = new DirectoriesDiscoverer(
            $registry2 = $this->mockContainer(DirectoryRegistryInterface::class),
            $registry3 = $this->mockContainer(DirectoryRegistryInterface::class),
        );

        $registry2->shouldReceive('init')->once()->with($this->getContainer());
        $registry3->shouldReceive('init')->once()->with($this->getContainer());

        $discover->init($this->getContainer());

        $registry3->shouldReceive('getDirectories')->once()->andReturn([
            'src/foo',
            'src/bar',
        ]);

        $registry2->shouldReceive('getDirectories')->once()->andReturn([
            'src/foo',
            'src/baz',
            null,
            '',
        ]);

        $this->assertSame([
            'src/foo',
            'src/baz',
            'src/bar',
        ], $discover->discover());
    }
}
