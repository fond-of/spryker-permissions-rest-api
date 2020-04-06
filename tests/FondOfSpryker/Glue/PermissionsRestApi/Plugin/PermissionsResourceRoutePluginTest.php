<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Plugin;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\PermissionsRestApi\PermissionsRestApiConfig;
use Generated\Shared\Transfer\RestPermissionsResponseAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;

class PermissionsResourceRoutePluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PermissionsRestApi\Plugin\PermissionsResourceRoutePlugin
     */
    protected $permissionsResourceRoutePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    protected $resourceRouteCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->resourceRouteCollectionInterfaceMock = $this->getMockBuilder(ResourceRouteCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsResourceRoutePlugin = new PermissionsResourceRoutePlugin();
    }

    /**
     * @return void
     */
    public function testConfigure(): void
    {
        $this->resourceRouteCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addGet')
            ->with(PermissionsRestApiConfig::ACTION_PERMISSIONS_GET, true)
            ->willReturn($this->resourceRouteCollectionInterfaceMock);

        $this->assertInstanceOf(
            ResourceRouteCollectionInterface::class,
            $this->permissionsResourceRoutePlugin->configure(
                $this->resourceRouteCollectionInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testGetResourceType(): void
    {
        $this->assertSame(
            $this->permissionsResourceRoutePlugin->getResourceType(),
            PermissionsRestApiConfig::RESOURCE_PERMISSION
        );
    }

    /**
     * @return void
     */
    public function testGetController(): void
    {
        $this->assertSame(
            PermissionsRestApiConfig::CONTROLLER_PERMISSIONS,
            $this->permissionsResourceRoutePlugin->getController()
        );
    }

    /**
     * @return void
     */
    public function testGetResourceAttributesClassName(): void
    {
        $this->assertSame(
            RestPermissionsResponseAttributesTransfer::class,
            $this->permissionsResourceRoutePlugin->getResourceAttributesClassName()
        );
    }
}
