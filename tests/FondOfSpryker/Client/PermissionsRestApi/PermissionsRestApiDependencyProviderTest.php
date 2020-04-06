<?php

namespace FondOfSpryker\Client\PermissionsRestApi;

use Codeception\Test\Unit;
use Spryker\Client\Kernel\Container;

class PermissionsRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiDependencyProvider
     */
    protected $permissionsRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiDependencyProvider = new PermissionsRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->permissionsRestApiDependencyProvider->provideServiceLayerDependencies(
                $this->containerMock
            )
        );
    }
}
