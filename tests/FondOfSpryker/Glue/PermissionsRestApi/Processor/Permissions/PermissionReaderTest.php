<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiClientInterface;
use FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCompanyUserClientInterface;
use FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCustomerB2bClientInterface;
use FondOfSpryker\Glue\PermissionsRestApi\PermissionsRestApiConfig;
use FondOfSpryker\Glue\PermissionsRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionResponseTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Generated\Shared\Transfer\RestPermissionsResponseAttributesTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PermissionReaderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionReader
     */
    protected $permissionReader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCustomerB2bClientInterface
     */
    protected $permissionsRestApiToCustomerB2bClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCompanyUserClientInterface
     */
    protected $permissionsRestApiToCompanyUserClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiClientInterface
     */
    protected $permissionsRestApiClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionMapperInterface
     */
    protected $permissionMapperInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\PermissionsRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiErrorInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected $restResourceInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionResponseTransfer
     */
    protected $permissionResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestUserTransfer
     */
    protected $restUserTransferMock;

    /**
     * @var int
     */
    protected $surrogateIdentifier;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    protected $permissionCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PermissionTransfer
     */
    protected $permissionTransferMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\PermissionTransfer[]
     */
    protected $permissions;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    protected $companyUserCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\CompanyUserTransfer[]
     */
    protected $companyUsers;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyRoleTransfer
     */
    protected $companyRoleTransferMock;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\CompanyRoleTransfer[]
     */
    protected $roles;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestPermissionsResponseAttributesTransfer
     */
    protected $restPermissionsResponseAttributesTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->restResourceBuilderInterfaceMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiToCustomerB2bClientInterfaceMock = $this->getMockBuilder(PermissionsRestApiToCustomerB2bClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiToCompanyUserClientInterfaceMock = $this->getMockBuilder(PermissionsRestApiToCompanyUserClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionsRestApiClientInterfaceMock = $this->getMockBuilder(PermissionsRestApiClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionMapperInterfaceMock = $this->getMockBuilder(PermissionMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restApiErrorInterfaceMock = $this->getMockBuilder(RestApiErrorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestInterfaceMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseInterfaceMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceInterfaceMock = $this->getMockBuilder(RestResourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionResponseTransferMock = $this->getMockBuilder(PermissionResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restUserTransferMock = $this->getMockBuilder(RestUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->surrogateIdentifier = 1;

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionCollectionTransferMock = $this->getMockBuilder(PermissionCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionTransferMock = $this->getMockBuilder(PermissionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissions = new ArrayObject([
            $this->permissionTransferMock,
        ]);

        $this->key = 'key';

        $this->companyUserCollectionTransferMock = $this->getMockBuilder(CompanyUserCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUsers = new ArrayObject([
           $this->companyUserTransferMock,
        ]);

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->roles = new ArrayObject([
            $this->companyRoleTransferMock,
        ]);

        $this->restPermissionsResponseAttributesTransferMock = $this->getMockBuilder(RestPermissionsResponseAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionReader = new PermissionReader(
            $this->restResourceBuilderInterfaceMock,
            $this->permissionsRestApiToCustomerB2bClientInterfaceMock,
            $this->permissionsRestApiToCompanyUserClientInterfaceMock,
            $this->permissionsRestApiClientInterfaceMock,
            $this->permissionMapperInterfaceMock,
            $this->restApiErrorInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKey(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->key);

        $this->permissionsRestApiClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->willReturn($this->permissionResponseTransferMock);

        $this->permissionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->surrogateIdentifier);

        $this->permissionsRestApiToCustomerB2bClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturnOnConsecutiveCalls('otherKey', $this->key);

        $this->permissionsRestApiToCompanyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUsersByCustomerReference')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUsers);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($this->roles);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getPermissionCollection')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->permissionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getPermission')
            ->willReturn($this->permissionTransferMock);

        $this->permissionMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestPermissionsResponseAttributesTransfer')
            ->willReturn($this->restPermissionsResponseAttributesTransferMock);

        $this->restPermissionsResponseAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($this->key);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                PermissionsRestApiConfig::RESOURCE_PERMISSION,
                $this->key,
                $this->restPermissionsResponseAttributesTransferMock
            )
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findPermissionByKey(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKeyPermissionKeyMissing(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn(null);

        $this->restApiErrorInterfaceMock->expects($this->atLeastOnce())
            ->method('addPermissionKeyMissingError')
            ->with($this->restResponseInterfaceMock)
            ->willReturn($this->restResponseInterfaceMock);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findPermissionByKey(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKeyPermissionNotFound(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->key);

        $this->permissionsRestApiClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->willReturn($this->permissionResponseTransferMock);

        $this->permissionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(false);

        $this->restApiErrorInterfaceMock->expects($this->atLeastOnce())
            ->method('addPermissionNotFound')
            ->with($this->restResponseInterfaceMock)
            ->willReturn($this->restResponseInterfaceMock);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findPermissionByKey(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKeyPermissionNoPermission(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->key);

        $this->permissionsRestApiClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->willReturn($this->permissionResponseTransferMock);

        $this->permissionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->surrogateIdentifier);

        $this->permissionsRestApiToCustomerB2bClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn('otherKey');

        $this->permissionsRestApiToCompanyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUsersByCustomerReference')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUsers);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($this->roles);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getPermissionCollection')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->restApiErrorInterfaceMock->expects($this->atLeastOnce())
            ->method('addPermissionNoPermission')
            ->with($this->restResponseInterfaceMock)
            ->willReturn($this->restResponseInterfaceMock);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findPermissionByKey(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKeyByCustomer(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->key);

        $this->permissionsRestApiClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->willReturn($this->permissionResponseTransferMock);

        $this->permissionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->surrogateIdentifier);

        $this->permissionsRestApiToCustomerB2bClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($this->key);

        $this->permissionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getPermission')
            ->willReturn($this->permissionTransferMock);

        $this->permissionMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestPermissionsResponseAttributesTransfer')
            ->willReturn($this->restPermissionsResponseAttributesTransferMock);

        $this->restPermissionsResponseAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($this->key);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                PermissionsRestApiConfig::RESOURCE_PERMISSION,
                $this->key,
                $this->restPermissionsResponseAttributesTransferMock
            )
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findPermissionByKey(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindPermissionByKeyCompanyRoleNull(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getResource')
            ->willReturn($this->restResourceInterfaceMock);

        $this->restResourceInterfaceMock->expects($this->atLeastOnce())
            ->method('getId')
            ->willReturn($this->key);

        $this->permissionsRestApiClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findPermissionByKey')
            ->willReturn($this->permissionResponseTransferMock);

        $this->permissionResponseTransferMock->expects($this->atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->surrogateIdentifier);

        $this->permissionsRestApiToCustomerB2bClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->permissionTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturnOnConsecutiveCalls('otherKey', $this->key);

        $this->permissionsRestApiToCompanyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUsersByCustomerReference')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUsers);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn(null);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findPermissionByKey(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindAllPermissions(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->surrogateIdentifier);

        $this->permissionsRestApiToCustomerB2bClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->permissionMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestPermissionsResponseAttributesTransfer')
            ->with($this->permissionTransferMock)
            ->willReturn($this->restPermissionsResponseAttributesTransferMock);

        $this->restPermissionsResponseAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($this->key);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                PermissionsRestApiConfig::RESOURCE_PERMISSION,
                $this->key,
                $this->restPermissionsResponseAttributesTransferMock
            )->willReturn($this->restResourceInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        $this->permissionsRestApiToCompanyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUsersByCustomerReference')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUsers);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($this->roles);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getPermissionCollection')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('fromArray')
            ->willReturnSelf();

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findAllPermissions(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindAllPermissionsCompanyRoleCollectionNull(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->surrogateIdentifier);

        $this->permissionsRestApiToCustomerB2bClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->permissionMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestPermissionsResponseAttributesTransfer')
            ->with($this->permissionTransferMock)
            ->willReturn($this->restPermissionsResponseAttributesTransferMock);

        $this->restPermissionsResponseAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($this->key);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                PermissionsRestApiConfig::RESOURCE_PERMISSION,
                $this->key,
                $this->restPermissionsResponseAttributesTransferMock
            )->willReturn($this->restResourceInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        $this->permissionsRestApiToCompanyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUsersByCustomerReference')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUsers);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn(null);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findAllPermissions(
                $this->restRequestInterfaceMock
            )
        );
    }

    /**
     * @return void
     */
    public function testFindAllPermissionsPermissionCollectionNull(): void
    {
        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResponse')
            ->willReturn($this->restResponseInterfaceMock);

        $this->restRequestInterfaceMock->expects($this->atLeastOnce())
            ->method('getRestUser')
            ->willReturn($this->restUserTransferMock);

        $this->restUserTransferMock->expects($this->atLeastOnce())
            ->method('getSurrogateIdentifier')
            ->willReturn($this->surrogateIdentifier);

        $this->permissionsRestApiToCustomerB2bClientInterfaceMock->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissionCollectionTransferMock);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->permissionMapperInterfaceMock->expects($this->atLeastOnce())
            ->method('mapRestPermissionsResponseAttributesTransfer')
            ->with($this->permissionTransferMock)
            ->willReturn($this->restPermissionsResponseAttributesTransferMock);

        $this->restPermissionsResponseAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getKey')
            ->willReturn($this->key);

        $this->restResourceBuilderInterfaceMock->expects($this->atLeastOnce())
            ->method('createRestResource')
            ->with(
                PermissionsRestApiConfig::RESOURCE_PERMISSION,
                $this->key,
                $this->restPermissionsResponseAttributesTransferMock
            )->willReturn($this->restResourceInterfaceMock);

        $this->restResponseInterfaceMock->expects($this->atLeastOnce())
            ->method('addResource')
            ->with($this->restResourceInterfaceMock)
            ->willReturnSelf();

        $this->permissionsRestApiToCompanyUserClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUsersByCustomerReference')
            ->with($this->customerTransferMock)
            ->willReturn($this->companyUserCollectionTransferMock);

        $this->companyUserCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUsers')
            ->willReturn($this->companyUsers);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($this->roles);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getPermissionCollection')
            ->willReturn(null);

        $this->permissionCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getPermissions')
            ->willReturn($this->permissions);

        $this->assertInstanceOf(
            RestResponseInterface::class,
            $this->permissionReader->findAllPermissions(
                $this->restRequestInterfaceMock
            )
        );
    }
}
