<?php

namespace FondOfSpryker\Glue\PermissionsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class PermissionsRestApiConfig extends AbstractBundleConfig
{
    public const RESOURCE_PERMISSION = 'permissions';
    public const ACTION_PERMISSIONS_GET = 'get';
    public const CONTROLLER_PERMISSIONS = 'permissions-resource';

    public const RESPONSE_CODE_EXTERNAL_REFERENCE_MISSING = '800';
    public const RESPONSE_CODE_NOT_FOUND = '801';
    public const RESPONSE_CODE_NO_PERMISSION = '802';

    public const RESPONSE_DETAILS_EXTERNAL_REFERENCE_MISSING = 'External reference is missing.';
    public const RESPONSE_DETAILS_NOT_FOUND = 'Permission not found.';
    public const RESPONSE_DETAILS_NO_PERMISSION = 'No permission to read Permission.';
}
