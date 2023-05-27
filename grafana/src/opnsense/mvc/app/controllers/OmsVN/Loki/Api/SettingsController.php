<?php

namespace OmsVN\Loki\Api;

use OPNsense\Base\ApiMutableModelControllerBase;
/**
 * Class SettingsController Handles settings related API actions for the loki module
 * @package OmsVN\Loki
 */
class SettingsController extends ApiMutableModelControllerBase
{
    protected static $internalModelName = 'loki';
    protected static $internalModelClass = '\OmsVN\Loki\Loki';
}
