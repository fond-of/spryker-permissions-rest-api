<?php

namespace FondOfSpryker\Zed\PermissionsRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\PermissionsRestApi\Business\Reader\PermissionReaderInterface;
use FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepository;

class PermissionsRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\PermissionsRestApi\Business\PermissionsRestApiBusinessFactory
     */
    protected $permissionsRestApiBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\PermissionsRestApi\Persistence\PermissionsRestApiRepository
     */
    protected $permissionsRestApiRepositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->permissionsRestApiRepositoryMock = $this->getMockBuilder(PermissionsRestApiRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiBusinessFactory = new PermissionsRestApiBusinessFactory();
        $this->permissionsRestApiBusinessFactory->setRepository($this->permissionsRestApiRepositoryMock);
    }

    /**
     * @return void
     */
    public function testCreatePermissionReader(): void
    {
        $this->assertInstanceOf(
            PermissionReaderInterface::class,
            $this->permissionsRestApiBusinessFactory->createPermissionReader()
        );
    }
}
