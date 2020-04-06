<?php

namespace FondOfSpryker\Client\PermissionsRestApi;

use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiFactory getFactory()
 */
class PermissionsRestApiClient extends AbstractClient implements PermissionsRestApiClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * {@internal will work if Key field is provided.}
     *
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKey(PermissionTransfer $permissionTransfer): PermissionResponseTransfer
    {
        return $this->getFactory()
            ->createZedPermissionsRestApiStub()
            ->findPermissionByKey($permissionTransfer);
    }
}
