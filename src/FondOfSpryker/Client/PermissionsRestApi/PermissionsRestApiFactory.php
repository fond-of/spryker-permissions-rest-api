<?php

namespace FondOfSpryker\Client\PermissionsRestApi;

use FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface;
use FondOfSpryker\Client\PermissionsRestApi\Zed\PermissionsRestApiStub;
use FondOfSpryker\Client\PermissionsRestApi\Zed\PermissionsRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class PermissionsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Client\PermissionsRestApi\Zed\PermissionsRestApiStubInterface
     */
    public function createZedPermissionsRestApiStub(): PermissionsRestApiStubInterface
    {
        return new PermissionsRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfSpryker\Client\PermissionsRestApi\Dependency\Client\PermissionsRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): PermissionsRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(PermissionsRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
