<?php

namespace OmsVN\Grafana;

/**
 * Class LogsController
 * @package OPNsense\AcmeClient
 */
class LogsController extends \OPNsense\Base\IndexController
{
    public function indexAction()
    {
        // choose template
        $this->view->pick('OmsVN/Grafana/logs');
    }
}
