<?php

declare(strict_types=1);

namespace Spiral\Discoverer\Tests;

use Psr\Container\ContainerInterface;
use Spiral\Discoverer\Discoverer;
use Spiral\Discoverer\DiscovererRegistryInterface;
use Spiral\Discoverer\Exception\DiscovererRegistryException;

final class DiscovererTest extends TestCase
{
    public function testDiscoverExistsDiscoverer(): void
    {
        $discoverer = new Discoverer(
            $this->getContainer(),
            new class implements DiscovererRegistryInterface {

                public static function getName(): string
                {
                    return 'test';
                }

                public function discover(): array
                {
                    return [
                        'foo',
                        'bar',
                    ];
                }

                public function init(ContainerInterface $container): void
                {

                }
            }
        );

        $this->assertSame([
            'foo',
            'bar'
        ], $discoverer->discover('test'));
    }

    public function testNonExistDiscovererShouldThrowAnException()
    {
        $this->expectException(DiscovererRegistryException::class);
        $this->expectErrorMessage('Registry with name [test] does not exist.');

        $discoverer = new Discoverer($this->getContainer());
        $discoverer->discover('test');
    }
}
