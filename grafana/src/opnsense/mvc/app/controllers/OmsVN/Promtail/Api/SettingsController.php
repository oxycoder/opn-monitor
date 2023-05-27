<?php

namespace OmsVN\Promtail\Api;

use OPNsense\Base\ApiMutableModelControllerBase;

/**
 * Class SettingsController Handles settings related API actions for the promtail module
 * @package OmsVN\Promtail
 */
class SettingsController extends ApiMutableModelControllerBase
{
    protected static $internalModelName = 'promtail';
    protected static $internalModelClass = '\OmsVN\Promtail\Promtail';
}
