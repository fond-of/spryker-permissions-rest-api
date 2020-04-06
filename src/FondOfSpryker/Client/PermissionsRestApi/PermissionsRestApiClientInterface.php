<?php

namespace FondOfSpryker\Client\PermissionsRestApi;

use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

interface PermissionsRestApiClientInterface
{
    /**
     * Specification:
     * - Finds a permission by key.
     * - Makes zed request.
     * - Requires key field to be set in PermissionTransfer taken as parameter.
     *
     * @api
     *
     * {@internal will work if Key field is provided.}
     *
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKey(PermissionTransfer $permissionTransfer): PermissionResponseTransfer;
}
