<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PermissionTransfer;
use Generated\Shared\Transfer\RestPermissionsResponseAttributesTransfer;

class PermissionMapperTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionMapper
     */
    protected $permissionMapper;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionTransfer
     */
    protected $permissionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionMapper = new PermissionMapper();
    }

    /**
     * @return void
     */
    public function testMapRestPermissionsResponseAttributesTransfer(): void
    {
        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->assertInstanceOf(
            RestPermissionsResponseAttributesTransfer::class,
            $this->permissionMapper->mapRestPermissionsResponseAttributesTransfer(
                $this->permissionTransferMock
            )
        );
    }
}
