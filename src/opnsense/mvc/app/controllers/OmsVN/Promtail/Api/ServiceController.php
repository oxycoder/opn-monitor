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

    // /**
    //  * reconfigure promtail
    //  */
    public function reloadAction()
    {
        $status = "failed";
        if ($this->request->isPost()) {
            $backend = new Backend();
            $bckresult = trim($backend->configdRun('template reload OmsVN/Promtail'));
            if ($bckresult == "OK") {
                $status = "ok";
            }
            $this->restartAction();
        }
        return array("status" => $status);
    }
}
