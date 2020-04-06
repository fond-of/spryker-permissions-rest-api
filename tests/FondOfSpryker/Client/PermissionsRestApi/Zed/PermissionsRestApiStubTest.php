<?php

namespace FondOfSpryker\Client\PermissionsRestApi\Zed;

use Codeception\Test\Unit;
use FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionsRestApiStubTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\PermissionsRestApi\Zed\PermissionsRestApiStub
     */
    protected $permissionsRestApiStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface
     */
    protected $permissionsRestApiToZedRequestClientInterface;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionTransfer
     */
    protected $permissionTransferMock;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionResponseTransfer
     */
    protected $permissionResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->permissionsRestApiToZedRequestClientInterface = $this->getMockBuilder(PermissionsRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = '/permissions-rest-api/gateway/find-permission-by-key';

        $this->permissionResponseTransferMock = $this->getMockBuilder(PermissionResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiStub = new PermissionsRestApiStub(
            $this->permissionsRestApiToZedRequestClientInterface
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKey(): void
    {
        $this->permissionsRestApiToZedRequestClientInterface->expects($this->atLeastOnce())
            ->method('call')
            ->with($this->url, $this->permissionTransferMock)
            ->willReturn($this->permissionResponseTransferMock);

        $this->assertInstanceOf(
            PermissionResponseTransfer::class,
            $this->permissionsRestApiStub->findPermissionByKey(
                $this->permissionTransferMock
            )
        );
    }
}
