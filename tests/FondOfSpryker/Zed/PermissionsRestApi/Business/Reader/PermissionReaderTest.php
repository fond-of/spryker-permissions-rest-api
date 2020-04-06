<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Business\Reader;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepositoryInterface;
use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionReaderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\PermissionsRestApi\Business\Reader\PermissionReader
     */
    protected $permissionReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepositoryInterface
     */
    protected $permissionsRestApiRepositoryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionTransfer
     */
    protected $permissionTransferMock;

    /**
     * @var string
     */
    protected $key;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->permissionsRestApiRepositoryInterfaceMock = $this->getMockBuilder(PermissionsRestApiRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->key = 'key';

        $this->permissionReader = new PermissionReader(
            $this->permissionsRestApiRepositoryInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKey(): void
    {
        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('requireKey')
            ->willReturnSelf();

        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($this->key);

        $this->permissionsRestApiRepositoryInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->willReturn($this->permissionTransferMock);

        $this->assertInstanceOf(
            PermissionResponseTransfer::class,
            $this->permissionReader->findPermissionByKey(
                $this->permissionTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKeyNotSuccessful(): void
    {
        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('requireKey')
            ->willReturnSelf();

        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($this->key);

        $this->permissionsRestApiRepositoryInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->willReturn(null);

        $this->assertInstanceOf(
            PermissionResponseTransfer::class,
            $this->permissionReader->findPermissionByKey(
                $this->permissionTransferMock
            )
        );
    }
}
