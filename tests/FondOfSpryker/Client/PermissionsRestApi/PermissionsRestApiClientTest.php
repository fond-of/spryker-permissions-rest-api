<?php

namespace FondOfSpryker\Client\PermissionsRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\PermissionsRestApi\Zed\PermissionsRestApiStubInterface;
use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionsRestApiClientTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiClient
     */
    protected $permissionsRestApiClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionTransfer
     */
    protected $permissionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiFactory
     */
    protected $permissionsRestApiFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\PermissionsRestApi\Zed\PermissionsRestApiStubInterface
     */
    protected $permissionsRestApiStubInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionResponseTransfer
     */
    protected $permissionResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiFactoryMock = $this->getMockBuilder(PermissionsRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiStubInterfaceMock = $this->getMockBuilder(PermissionsRestApiStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionResponseTransferMock = $this->getMockBuilder(PermissionResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiClient = new PermissionsRestApiClient();
        $this->permissionsRestApiClient->setFactory($this->permissionsRestApiFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindPermissionByKey(): void
    {
        $this->permissionsRestApiFactoryMock->expects($this->atLeastOnce())
            ->method('createZedPermissionsRestApiStub')
            ->willReturn($this->permissionsRestApiStubInterfaceMock);

        $this->permissionsRestApiStubInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->with($this->permissionTransferMock)
            ->willReturn($this->permissionResponseTransferMock);

        $this->assertInstanceOf(
            PermissionResponseTransfer::class,
            $this->permissionsRestApiClient->findPermissionByKey(
                $this->permissionTransferMock
            )
        );
    }
}
