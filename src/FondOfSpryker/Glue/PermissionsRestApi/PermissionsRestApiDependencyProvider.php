<?php

namespace FondOfSpryker\Glue\PermissionsRestApi;

use FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCompanyUserClientBridge;
use FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCustomerB2bClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class PermissionsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CUSTOMER_B2B = 'CLIENT_CUSTOMER_B2B';
    public const CLIENT_COMPANY_USER = 'CLIENT_COMPANY_USER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addCustomerB2bClient($container);
        $container = $this->addCompanyUserClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCustomerB2bClient(Container $container): Container
    {
        $container[static::CLIENT_CUSTOMER_B2B] = static function (Container $container) {
            return new PermissionsRestApiToCustomerB2bClientBridge($container->getLocator()->customerB2b()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addCompanyUserClient(Container $container): Container
    {
        $container[static::CLIENT_COMPANY_USER] = static function (Container $container) {
            return new PermissionsRestApiToCompanyUserClientBridge($container->getLocator()->companyUser()->client());
        };

        return $container;
    }
}
