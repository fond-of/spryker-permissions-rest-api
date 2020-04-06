<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Persistence;

use FondOfSpryker\Zed\PermissionsRestApi\Persistence\Mapper\PermissionMapper;
use FondOfSpryker\Zed\PermissionsRestApi\Persistence\Mapper\PermissionMapperInterface;
use Orm\Zed\Permission\Persistence\SpyPermissionQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Glue\PermissionsRestApi\PermissionsRestApiConfig getConfig()
 * @method \FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepositoryInterface getRepository()
 */
class PermissionsRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Permission\Persistence\SpyPermissionQuery
     */
    public function createPermissionQuery(): SpyPermissionQuery
    {
        return new SpyPermissionQuery();
    }

    /**
     * @return \FondOfSpryker\Zed\PermissionsRestApi\Persistence\Mapper\PermissionMapperInterface
     */
    public function createPermissionMapper(): PermissionMapperInterface
    {
        return new PermissionMapper();
    }
}
