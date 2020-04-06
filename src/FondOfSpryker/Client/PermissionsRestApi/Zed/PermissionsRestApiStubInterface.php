<?php

namespace FondOfSpryker\Client\PermissionsRestApi\Zed;

use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

interface PermissionsRestApiStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKey(PermissionTransfer $permissionTransfer): PermissionResponseTransfer;
}
