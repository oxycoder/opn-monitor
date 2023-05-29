<?php

namespace OmsVN\Loki\Api;

use OPNsense\Base\ApiMutableServiceControllerBase;
use OPNsense\Core\Backend;

/**
 * Class ServiceController
 * @package OmsVN\Loki
 */
class ServiceController extends ApiMutableServiceControllerBase
{
    protected static $internalServiceClass = '\OmsVN\Loki\Loki';
    protected static $internalServiceEnabled = 'general.enabled';
    protected static $internalServiceTemplate = 'OmsVN/Loki';
    protected static $internalServiceName = 'loki';

    /**
     * reconfigure force restart check, return zero for soft-reload
     */
    public function reconfigureForceRestart() {
        // do not restart service on reconfigure
        return 0;
    }
}
