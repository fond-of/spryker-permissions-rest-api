<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\PermissionsRestApi\Business\Reader\PermissionReaderInterface;
use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionsRestApiFacadeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\PermissionsRestApi\Business\PermissionsRestApiFacade
     */
    protected $permissionsRestApiFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionTransfer
     */
    protected $permissionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\PermissionsRestApi\Business\PermissionsRestApiBusinessFactory
     */
    protected $permissionsRestApiBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\PermissionsRestApi\Business\Reader\PermissionReaderInterface
     */
    protected $permissionReaderInterfaceMock;

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

        $this->permissionsRestApiBusinessFactoryMock = $this->getMockBuilder(PermissionsRestApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionReaderInterfaceMock = $this->getMockBuilder(PermissionReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionResponseTransferMock = $this->getMockBuilder(PermissionResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiFacade = new PermissionsRestApiFacade();
        $this->permissionsRestApiFacade->setFactory($this->permissionsRestApiBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindPermissionByKey(): void
    {
        $this->permissionsRestApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createPermissionReader')
            ->willReturn($this->permissionReaderInterfaceMock);

        $this->permissionReaderInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->with($this->permissionTransferMock)
            ->willReturn($this->permissionResponseTransferMock);

        $this->assertInstanceOf(
            PermissionResponseTransfer::class,
            $this->permissionsRestApiFacade->findPermissionByKey(
                $this->permissionTransferMock
            )
        );
    }
}
