<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Business\Reader;

use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

interface PermissionReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKey(PermissionTransfer $permissionTransfer): PermissionResponseTransfer;
}
