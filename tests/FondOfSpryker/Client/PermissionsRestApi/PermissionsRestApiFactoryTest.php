<?php

namespace FondOfSpryker\Client\PermissionsRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface;
use FondOfSpryker\Client\PermissionsRestApi\Zed\PermissionsRestApiStubInterface;
use Spryker\Client\Kernel\Container;

class PermissionsRestApiFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiFactory
     */
    protected $permissionsRestApiFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface
     */
    protected $permissionsRestApiToZedRequestClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiToZedRequestClientInterfaceMock = $this->getMockBuilder(PermissionsRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiFactory = new PermissionsRestApiFactory();
        $this->permissionsRestApiFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedPermissionsRestApiStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(PermissionsRestApiDependencyProvider::CLIENT_ZED_REQUEST)
            ->willReturn($this->permissionsRestApiToZedRequestClientInterfaceMock);

        $this->assertInstanceOf(
            PermissionsRestApiStubInterface::class,
            $this->permissionsRestApiFactory->createZedPermissionsRestApiStub()
        );
    }
}
