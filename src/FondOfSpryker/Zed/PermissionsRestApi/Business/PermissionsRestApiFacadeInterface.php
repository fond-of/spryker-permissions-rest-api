<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Business;

use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

interface PermissionsRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKey(PermissionTransfer $permissionTransfer): PermissionResponseTransfer;
}
