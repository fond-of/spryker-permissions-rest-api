<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Business;

use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\PermissionsRestApi\Business\PermissionsRestApiBusinessFactory getFactory()
 * @method \FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepositoryInterface getRepository()
 */
class PermissionsRestApiFacade extends AbstractFacade implements PermissionsRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKey(PermissionTransfer $permissionTransfer): PermissionResponseTransfer
    {
        return $this->getFactory()
            ->createPermissionReader()
            ->findPermissionByKey($permissionTransfer);
    }
}
