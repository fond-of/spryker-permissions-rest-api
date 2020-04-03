<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Business;

use FondOfSpryker\Zed\PermissionsRestApi\Business\Reader\PermissionReader;
use FondOfSpryker\Zed\PermissionsRestApi\Business\Reader\PermissionReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepositoryInterface getRepository()
 */
class PermissionsRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\PermissionsRestApi\Business\Reader\PermissionReaderInterface
     */
    public function createPermissionReader(): PermissionReaderInterface
    {
        return new PermissionReader(
            $this->getRepository()
        );
    }
}
