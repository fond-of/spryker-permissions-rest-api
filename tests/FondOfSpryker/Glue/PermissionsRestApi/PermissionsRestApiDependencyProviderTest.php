<?php

namespace FondOfSpryker\Glue\PermissionsRestApi;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\Container;

class PermissionsRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PermissionsRestApi\PermissionsRestApiDependencyProvider
     */
    protected $permissionsRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
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
    public function testProvideDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->permissionsRestApiDependencyProvider->provideDependencies(
                $this->containerMock
            )
        );
    }
}
