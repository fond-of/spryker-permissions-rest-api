<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Persistence\Mapper;

use Generated\Shared\Transfer\PermissionTransfer;
use Orm\Zed\Permission\Persistence\SpyPermission;

class PermissionMapper implements PermissionMapperInterface
{
    /**
     * @param \Orm\Zed\Permission\Persistence\SpyPermission $spyPermission
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionTransfer
     */
    public function mapEntityToPermissionTransfer(
        SpyPermission $spyPermission,
        PermissionTransfer $permissionTransfer
    ): PermissionTransfer {
        return $permissionTransfer->fromArray($spyPermission->toArray(), true);
    }
}
