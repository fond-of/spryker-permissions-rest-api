<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Communication\Controller;

use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \FondOfSpryker\Zed\PermissionsRestApi\Business\PermissionsRestApiFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKeyAction(
        PermissionTransfer $permissionTransfer
    ): PermissionResponseTransfer {
        return $this->getFacade()
            ->findPermissionByKey($permissionTransfer);
    }
}
