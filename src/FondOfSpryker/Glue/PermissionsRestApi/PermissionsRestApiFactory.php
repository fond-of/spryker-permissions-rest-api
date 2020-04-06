<?php

namespace FondOfSpryker\Glue\PermissionsRestApi;

use FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCompanyUserClientInterface;
use FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCustomerB2bClientInterface;
use FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionMapper;
use FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionMapperInterface;
use FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionReader;
use FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionReaderInterface;
use FondOfSpryker\Glue\PermissionsRestApi\Processor\Validation\RestApiError;
use FondOfSpryker\Glue\PermissionsRestApi\Processor\Validation\RestApiErrorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiClientInterface getClient()
 */
class PermissionsRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionReaderInterface
     */
    public function createPermissionReader(): PermissionReaderInterface
    {
        return new PermissionReader(
            $this->getResourceBuilder(),
            $this->getCustomerB2bClient(),
            $this->getCompanyUserClient(),
            $this->getClient(),
            $this->createPermissionMapper(),
            $this->createRestApiError()
        );
    }

    /**
     * @return \FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionMapperInterface
     */
    protected function createPermissionMapper(): PermissionMapperInterface
    {
        return new PermissionMapper();
    }

    /**
     * @return \FondOfSpryker\Glue\PermissionsRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return \FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCustomerB2bClientInterface
     */
    protected function getCustomerB2bClient(): PermissionsRestApiToCustomerB2bClientInterface
    {
        return $this->getProvidedDependency(PermissionsRestApiDependencyProvider::CLIENT_CUSTOMER_B2B);
    }

    /**
     * @return \FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCompanyUserClientInterface
     */
    protected function getCompanyUserClient(): PermissionsRestApiToCompanyUserClientInterface
    {
        return $this->getProvidedDependency(PermissionsRestApiDependencyProvider::CLIENT_COMPANY_USER);
    }
}
