<?php

namespace FondOfSpryker\Glue\PermissionsRestApi\Controller;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \FondOfSpryker\Glue\PermissionsRestApi\PermissionsRestApiFactory getFactory()
 */
class PermissionsResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        if ($restRequest->getResource()->getId()) {
            return $this->getFactory()
                ->createPermissionReader()
                ->findPermissionByKey($restRequest);
        }

        return $this->getFactory()
            ->createPermissionReader()
            ->findAllPermissions($restRequest);
    }
}
