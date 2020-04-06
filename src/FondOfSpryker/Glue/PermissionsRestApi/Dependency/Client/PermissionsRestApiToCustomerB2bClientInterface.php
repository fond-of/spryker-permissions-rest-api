<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client;

use Generated\Shared\Transfer\CustomerTransfer;

interface PermissionsRestApiToCustomerB2bClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function findCustomerById(CustomerTransfer $customerTransfer): CustomerTransfer;
}
