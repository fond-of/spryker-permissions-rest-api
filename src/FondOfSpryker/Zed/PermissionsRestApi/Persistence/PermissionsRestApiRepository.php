<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Persistence;

use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiPersistenceFactory getFactory()
 */
class PermissionsRestApiRepository extends AbstractRepository implements PermissionsRestApiRepositoryInterface
{
    /**
     * @param string $permissionKey
     *
     * @return \Generated\Shared\Transfer\PermissionTransfer|null
     */
    public function findPermissionByKey(string $permissionKey): ?PermissionTransfer
    {
        $permissionEntity = $this->getFactory()
            ->createPermissionQuery()
            ->filterByKey($permissionKey)
            ->findOne();

        if (!$permissionEntity) {
            return null;
        }

        return $this->getFactory()
            ->createPermissionMapper()
            ->mapEntityToPermissionTransfer($permissionEntity, new PermissionTransfer());
    }
}
