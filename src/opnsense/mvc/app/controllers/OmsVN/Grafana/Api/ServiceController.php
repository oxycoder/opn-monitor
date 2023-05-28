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

    // /**
    //  * reconfigure grafana
    //  */
    public function reloadAction()
    {
        $status = "failed";
        if ($this->request->isPost()) {
            $backend = new Backend();
            $bckresult = trim($backend->configdRun('template reload OmsVN/Grafana'));
            if ($bckresult == "OK") {
                $status = "ok";
            }
            $this->restartAction();
        }
        return array("status" => $status);
    }
}
