<?php

namespace OmsVN\Grafana\Api;

use OPNsense\Base\ApiMutableServiceControllerBase;
use OmsVN\Grafana\Grafana;
use OPNsense\Core\Config;

/**
 * Class SettingsController Handles settings related API actions for the grafana module
 * @package OmsVN\Grafana
 */
class SettingsController extends ApiMutableServiceControllerBase
{
    protected static $internalServiceClass = '\OmsVN\Grafana\Grafana';
    protected static $internalServiceTemplate = 'OmsVN/Grafana';
    protected static $internalServiceEnabled = 'general.enabled';
    protected static $internalServiceName = 'grafana';

    protected function reconfigureForceRestart()
    {
        return 0;
    }

    /**
     * retrieve grafana general settings
     * @return array general settings
     * @throws \OPNsense\Base\ModelException
     * @throws \ReflectionException
     */
    public function getAction()
    {
        // define list of configurable settings
        $result = array();
        if ($this->request->isGet()) {
            $mdlGrafana = new Grafana();
            $result['grafana'] = $mdlGrafana->getNodes();
        }
        return $result;
    }

    /**
     * update grafana settings
     * @return array status
     * @throws \OPNsense\Base\ModelException
     * @throws \ReflectionException
     */
    public function setAction()
    {
        $result = array("result" => "failed");
        if ($this->request->isPost()) {
            // load model and update with provided data
            $mdlGrafana = new Grafana();
            $mdlGrafana->setNodes($this->request->getPost("grafana"));

            // perform validation
            $valMsgs = $mdlGrafana->performValidation();
            foreach ($valMsgs as $field => $msg) {
                if (!array_key_exists("validations", $result)) {
                    $result["validations"] = array();
                }
                $result["validations"]["grafana." . $msg->getField()] = $msg->getMessage();
            }

            // serialize model to config and save
            if ($valMsgs->count() == 0) {
                $mdlGrafana->serializeToConfig();
                Config::getInstance()->save();
                $result["result"] = "saved";
            }
        }
        return $result;
    }
}
