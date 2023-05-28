<?php

namespace OmsVN\Loki;

/**
 * Class IndexController
 * @package OmsVN\Loki
 */
class IndexController extends \OPNsense\Base\IndexController
{
    public function indexAction()
    {
        // pick the template to serve to our users.
        $this->view->pick('OmsVN/Loki/index');
        // fetch form data "general" in
        $this->view->generalForm = $this->getForm("general");
    }
}
