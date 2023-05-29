<?php

namespace OmsVN\Promtail\Api;

use OPNsense\Base\ApiMutableServiceControllerBase;
use OPNsense\Core\Backend;

/**
 * Class ServiceController
 * @package OmsVN\Promtail
 */
class ServiceController extends ApiMutableServiceControllerBase
{
    protected static $internalServiceClass = '\OmsVN\Promtail\Promtail';
    protected static $internalServiceEnabled = 'general.enabled';
    protected static $internalServiceTemplate = 'OmsVN/Promtail';
    protected static $internalServiceName = 'promtail';

    /**
     * reconfigure force restart check, return zero for soft-reload
     */
    public function reconfigureForceRestart() {
        // do not restart service on reconfigure
        return 0;
    }
}
