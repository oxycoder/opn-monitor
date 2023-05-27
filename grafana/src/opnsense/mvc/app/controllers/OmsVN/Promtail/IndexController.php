<?php

namespace OmsVN\Promtail;

/**
 * Class IndexController
 * @package OmsVN\Promtail
 */
class IndexController extends \OPNsense\Base\IndexController
{
    public function indexAction()
    {
        // pick the template to serve to our users.
        $this->view->pick('OmsVN/Promtail/index');
        // fetch form data "general" in
        $this->view->generalForm = $this->getForm("general");
    }
}
