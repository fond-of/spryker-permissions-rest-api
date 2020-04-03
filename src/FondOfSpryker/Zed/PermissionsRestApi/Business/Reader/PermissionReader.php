<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Business\Reader;

use FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepositoryInterface;
use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

class PermissionReader implements PermissionReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepositoryInterface
     */
    protected $permissionsRestApiRepository;

    /**
     * @param \FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepositoryInterface $permissionsRestApiRepository
     */
    public function __construct(
        PermissionsRestApiRepositoryInterface $permissionsRestApiRepository
    ) {
        $this->permissionsRestApiRepository = $permissionsRestApiRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionResponseTransfer
     */
    public function findPermissionByKey(PermissionTransfer $permissionTransfer): PermissionResponseTransfer
    {
        $permissionTransfer->requireKey();

        $permissionTransfer = $this->permissionsRestApiRepository->findPermissionByKey(
            $permissionTransfer->getKey()
        );

        $permissionResponseTransfer = new PermissionResponseTransfer();

        if (!$permissionTransfer) {
            return $permissionResponseTransfer->setIsSuccessful(false);
        }

        return $permissionResponseTransfer
            ->setIsSuccessful(true)
            ->setPermission($permissionTransfer);
    }
}
