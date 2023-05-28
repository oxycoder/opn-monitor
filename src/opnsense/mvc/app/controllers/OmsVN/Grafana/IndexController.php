<?php

namespace OmsVN\Grafana;

/**
 * Class IndexController
 * @package OmsVN\Grafana
 */
class IndexController extends \OPNsense\Base\IndexController
{
    public function indexAction()
    {
        // pick the template to serve to our users.
        $this->view->pick('OmsVN/Grafana/index');
        // fetch form data "general" in
        $this->view->generalForm = $this->getForm("general");
    }
}
