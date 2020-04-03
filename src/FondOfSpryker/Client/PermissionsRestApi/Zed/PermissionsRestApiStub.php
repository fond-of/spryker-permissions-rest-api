<?php

namespace FondOfSpryker\Client\PermissionsRestApi\Zed;

use FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionsRestApiStub implements PermissionsRestApiStubInterface
{
    /**
     * @var \FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(PermissionsRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKey(PermissionTransfer $permissionTransfer): PermissionResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\PermissionResponseTransfer $permissionResponseTransfer */
        $permissionResponseTransfer = $this->zedRequestClient->call('/permissions-rest-api/gateway/find-permission-by-key', $permissionTransfer);

        return $permissionResponseTransfer;
    }
}
