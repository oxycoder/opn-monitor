<?php

namespace OmsVN\Grafana\Api;

use OPNsense\Base\ApiMutableModelControllerBase;

/**
 * Class SettingsController Handles settings related API actions for the grafana module
 * @package OmsVN\Grafana
 */
class SettingsController extends ApiMutableModelControllerBase
{
    protected static $internalModelName = 'grafana';
    protected static $internalModelClass = '\OmsVN\Grafana\Grafana';
}
