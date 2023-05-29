<?php

namespace OmsVN\Grafana\Api;

use OPNsense\Base\ApiMutableServiceControllerBase;
use OPNsense\Core\Backend;

/**
 * Class ServiceController
 * @package OmsVN\Grafana
 */
class ServiceController extends ApiMutableServiceControllerBase
{
    protected static $internalServiceClass = '\OmsVN\Grafana\Grafana';
    protected static $internalServiceEnabled = 'general.enabled';
    protected static $internalServiceTemplate = 'OmsVN/Grafana';
    protected static $internalServiceName = 'grafana';

    /**
     * reconfigure force restart check, return zero for soft-reload
     */
    public function reconfigureForceRestart() {
        // do not restart service on reconfigure
        return 0;
    }
}
