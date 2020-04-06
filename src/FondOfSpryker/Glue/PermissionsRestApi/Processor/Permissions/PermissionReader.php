<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions;

use FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiClientInterface;
use FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCompanyUserClientInterface;
use FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCustomerB2bClientInterface;
use FondOfSpryker\Glue\PermissionsRestApi\PermissionsRestApiConfig;
use FondOfSpryker\Glue\PermissionsRestApi\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Generated\Shared\Transfer\RestUserTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class PermissionReader implements PermissionReaderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionMapper
     */
    protected $permissionMapper;

    /**
     * @var \Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerB2bClient;

    /**
     * @var \Spryker\Client\CompanyUser\CompanyUserClientInterface
     */
    protected $companyUserClient;

    /**
     * @var \FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiClientInterface
     */
    protected $permissionsRestApiClient;

    /**
     * @var \FondOfSpryker\Glue\PermissionsRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $restApiError;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCustomerB2bClientInterface $customerB2bClient
     * @param \FondOfSpryker\Glue\PermissionsRestApi\Dependency\Client\PermissionsRestApiToCompanyUserClientInterface $companyUserClient
     * @param \FondOfSpryker\Client\PermissionsRestApi\PermissionsRestApiClientInterface $permissionsRestApiClient
     * @param \FondOfSpryker\Glue\PermissionsRestApi\Processor\Permissions\PermissionMapperInterface $permissionMapper
     * @param \FondOfSpryker\Glue\PermissionsRestApi\Processor\Validation\RestApiErrorInterface $restApiError
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        PermissionsRestApiToCustomerB2bClientInterface $customerB2bClient,
        PermissionsRestApiToCompanyUserClientInterface $companyUserClient,
        PermissionsRestApiClientInterface $permissionsRestApiClient,
        PermissionMapperInterface $permissionMapper,
        RestApiErrorInterface $restApiError
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->permissionMapper = $permissionMapper;
        $this->companyUserClient = $companyUserClient;
        $this->permissionsRestApiClient = $permissionsRestApiClient;
        $this->customerB2bClient = $customerB2bClient;
        $this->restApiError = $restApiError;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function findPermissionByKey(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        if (!$restRequest->getResource()->getId()) {
            return $this->restApiError->addPermissionKeyMissingError($restResponse);
        }

        $permissionTransfer = (new PermissionTransfer())
            ->setKey($restRequest->getResource()->getId());

        $permissionResponseTransfer = $this->permissionsRestApiClient
            ->findPermissionByKey($permissionTransfer);

        if (!$permissionResponseTransfer->getIsSuccessful()) {
            return $this->restApiError->addPermissionNotFound($restResponse);
        }

        if (!$this->isPermissionAssignedToRestUser($restRequest->getRestUser(), $restRequest->getResource()->getId())) {
            return $this->restApiError->addPermissionNoPermission($restResponse);
        }

        $this->addPermissionTransferToResponse(
            $permissionResponseTransfer->getPermission(),
            $restResponse
        );

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\RestUserTransfer $restUserTransfer
     * @param string $key
     *
     * @return bool
     */
    protected function isPermissionAssignedToRestUser(
        RestUserTransfer $restUserTransfer,
        string $key
    ): bool {
        $customerTransfer = $this->findCustomerByRestUser($restUserTransfer);

        $permissionCollectionTransfer = $customerTransfer->getPermissions();

        if ($permissionCollectionTransfer &&
            $this->containsPermissionCollectionPermissionKey($permissionCollectionTransfer, $key)) {
            return true;
        }

        $companyUserCollectionTransfer = $this->companyUserClient->getActiveCompanyUsersByCustomerReference($customerTransfer);

        foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUserTransfer) {
            $companyRoleCollectionTransfer = $companyUserTransfer->getCompanyRoleCollection();

            if ($this->isPermissionAssignedToCompanyRoleCollection($companyRoleCollectionTransfer, $key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|null $companyRoleCollectionTransfer
     * @param string $key
     *
     * @return bool
     */
    protected function isPermissionAssignedToCompanyRoleCollection(
        ?CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
        string $key
    ): bool {
        if (!$companyRoleCollectionTransfer) {
            return false;
        }

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            if ($this->containsPermissionCollectionPermissionKey($companyRoleTransfer->getPermissionCollection(), $key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $permissionCollectionTransfer
     * @param string $key
     *
     * @return bool
     */
    protected function containsPermissionCollectionPermissionKey(
        PermissionCollectionTransfer $permissionCollectionTransfer,
        string $key
    ): bool {
        foreach ($permissionCollectionTransfer->getPermissions() as $permissionTransfer) {
            if ($permissionTransfer->getKey() === $key) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\RestUserTransfer $restUserTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function findCustomerByRestUser(RestUserTransfer $restUserTransfer): CustomerTransfer
    {
        $customerTransfer = (new CustomerTransfer())
            ->setIdCustomer($restUserTransfer->getSurrogateIdentifier());

        return $this->customerB2bClient->findCustomerById($customerTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function findAllPermissions(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        $customerTransfer = $this->findCustomerByRestUser($restRequest->getRestUser());

        $permissionCollectionTransfer = $customerTransfer->getPermissions();

        if ($permissionCollectionTransfer) {
            $this->addPermissionCollectionToResponse($permissionCollectionTransfer, $restResponse);
        }

        $companyUserCollectionTransfer = $this->companyUserClient->getActiveCompanyUsersByCustomerReference($customerTransfer);

        foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUserTransfer) {
            $permissionCollectionTransfer = $this->getPermissionCollectionByCompanyUser($companyUserTransfer);

            $this->addPermissionCollectionToResponse($permissionCollectionTransfer, $restResponse);
        }

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    protected function getPermissionCollectionByCompanyUser(
        CompanyUserTransfer $companyUserTransfer
    ): PermissionCollectionTransfer {
        $permissionCollectionTransfer = new PermissionCollectionTransfer();

        $companyRoleCollectionTransfer = $companyUserTransfer->getCompanyRoleCollection();

        if (!$companyRoleCollectionTransfer) {
            return $permissionCollectionTransfer;
        }

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            if (!$companyRoleTransfer->getPermissionCollection()) {
                continue;
            }

            $permissionCollectionTransfer = $companyRoleTransfer->getPermissionCollection();

            $permissionCollectionTransfer->fromArray($permissionCollectionTransfer->toArray(), true);
        }

        return $permissionCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $permissionCollectionTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPermissionCollectionToResponse(
        PermissionCollectionTransfer $permissionCollectionTransfer,
        RestResponseInterface $restResponse
    ): RestResponseInterface {
        foreach ($permissionCollectionTransfer->getPermissions() as $permissionTransfer) {
            $this->addPermissionTransferToResponse(
                $permissionTransfer,
                $restResponse
            );
        }

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $permissionTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function addPermissionTransferToResponse(
        PermissionTransfer $permissionTransfer,
        RestResponseInterface $restResponse
    ): RestResponseInterface {
        $restPermissionsResponseAttributesTransfer = $this->permissionMapper
            ->mapRestPermissionsResponseAttributesTransfer($permissionTransfer);

        $restResource = $this->restResourceBuilder->createRestResource(
            PermissionsRestApiConfig::RESOURCE_PERMISSION,
            $restPermissionsResponseAttributesTransfer->getKey(),
            $restPermissionsResponseAttributesTransfer
        );

        return $restResponse->addResource($restResource);
    }
}
