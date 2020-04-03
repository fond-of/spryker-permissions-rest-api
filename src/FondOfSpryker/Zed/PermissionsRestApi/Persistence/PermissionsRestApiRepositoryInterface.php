<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Persistence;

use Generated\Shared\Transfer\PermissionTransfer;

interface PermissionsRestApiRepositoryInterface
{
    /**
     * @param string $permissionKey
     *
     * @return \Generated\Shared\Transfer\PermissionTransfer|null
     */
    public function findPermissionByKey(string $permissionKey): ?PermissionTransfer;
}
