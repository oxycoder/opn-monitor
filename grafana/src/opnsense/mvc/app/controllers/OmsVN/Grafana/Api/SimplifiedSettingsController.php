<?php

namespace OmsVN\Grafana\Api;

use OPNsense\Base\ApiMutableModelControllerBase;

/**
 * a simplified settings controller for our grafana app, uses our ApiMutableModelControllerBase type
 * @package OmsVN\Grafana
 */
class SimplifiedSettingsController extends ApiMutableModelControllerBase
{
    protected static $internalModelName = 'grafana';
    protected static $internalModelClass = 'OmsVN\Grafana\Grafana';
}
