<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions;

use Generated\Shared\Transfer\PermissionTransfer;
use Generated\Shared\Transfer\RestPermissionsResponseAttributesTransfer;

class PermissionMapper implements PermissionMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\RestPermissionsResponseAttributesTransfer
     */
    public function mapRestPermissionsResponseAttributesTransfer(
        PermissionTransfer $permissionTransfer
    ): RestPermissionsResponseAttributesTransfer {
        return (new RestPermissionsResponseAttributesTransfer())->fromArray($permissionTransfer->toArray(), true);
    }
}
