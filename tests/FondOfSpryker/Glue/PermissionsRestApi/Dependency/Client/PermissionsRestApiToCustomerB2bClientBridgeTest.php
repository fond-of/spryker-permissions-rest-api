<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CustomerB2b\CustomerB2bClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class PermissionsRestApiToCustomerB2bClientBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCustomerB2bClientBridge
     */
    protected $permissionsRestApiToCustomerB2bClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CustomerB2b\CustomerB2bClientInterface
     */
    protected $customerB2bClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerB2bClientInterfaceMock = $this->getMockBuilder(CustomerB2bClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiToCustomerB2bClientBridge = new PermissionsRestApiToCustomerB2bClientBridge(
            $this->customerB2bClientInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testFindCustomerById(): void
    {
        $this->customerB2bClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->assertInstanceOf(
            CustomerTransfer::class,
            $this->permissionsRestApiToCustomerB2bClientBridge->findCustomerById(
                $this->customerTransferMock
            )
        );
    }
}
