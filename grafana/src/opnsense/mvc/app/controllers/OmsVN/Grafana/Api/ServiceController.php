<?php

namespace OmsVN\Grafana\Api;

use OPNsense\Base\ApiControllerBase;
use OPNsense\Core\Backend;

/**
 * Class ServiceController
 * @package OPNsense\Cron
 */
class ServiceController extends ApiControllerBase
{
    /**
     * reconfigure grafana
     */
    public function reloadAction()
    {
        $status = "failed";
        if ($this->request->isPost()) {
            $backend = new Backend();
            $bckresult = trim($backend->configdRun('template reload OmsVN/Grafana'));
            if ($bckresult == "OK") {
                $status = "ok";
            }
        }
        return array("status" => $status);
    }
}
