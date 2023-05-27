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

    // /**
    //  * reconfigure loki
    //  */
    public function reloadAction()
    {
        $status = "failed";
        if ($this->request->isPost()) {
            $backend = new Backend();
            $bckresult = trim($backend->configdRun('template reload OmsVN/Loki'));
            if ($bckresult == "OK") {
                $status = "ok";
            }
            $this->restartAction();
        }
        return array("status" => $status);
    }
}
