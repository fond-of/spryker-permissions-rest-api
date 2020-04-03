<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client;

use FondOfSpryker\Client\CustomerB2b\CustomerB2bClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;

class PermissionsRestApiToCustomerB2bClientBridge implements PermissionsRestApiToCustomerB2bClientInterface
{
    /**
     * @var \Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerB2bClient;

    /**
     * @param \FondOfSpryker\Client\CustomerB2b\CustomerB2bClientInterface $customerB2bClient
     */
    public function __construct(CustomerB2bClientInterface $customerB2bClient)
    {
        $this->customerB2bClient = $customerB2bClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function findCustomerById(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        return $this->customerB2bClient->findCustomerById($customerTransfer);
    }
}
