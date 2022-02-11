<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tests;

use Mockery as m;
use Spiral\Core\Container;
use Spiral\Discoverer\DiscovererInterface;
use Spiral\Discoverer\Tokenizer\DirectoriesDiscoverer;

final class DiscovererBootloaderWithDiscovererTest extends TestCase
{
    private \Mockery\MockInterface $discoverer;

    protected function setUp(): void
    {
        $this->discoverer = m::mock(DiscovererInterface::class);
        $this->beforeBooting(function (Container $container) {
            $container->bindSingleton(DiscovererInterface::class, $this->discoverer);
        });

        $this->discoverer->shouldReceive('has')->with(DirectoriesDiscoverer::getName())->andReturnTrue();
        $this->discoverer->shouldReceive('discover')->with(DirectoriesDiscoverer::getName())->andReturn([
            'src/foo',
            'src/bar',
        ]);

        parent::setUp();
    }

    public function testTokenizerDirectoriesShouldBeDiscovered()
    {
        $dirs = $this->getConfig('tokenizer')['directories'];

        $this->assertContains('src/foo', $dirs);
        $this->assertContains('src/bar', $dirs);
    }
}
