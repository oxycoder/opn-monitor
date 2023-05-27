<?php

function loki_services()
{
    global $config;

    $services = array();

    if (isset($config['OmsVN']['loki']['general']['enabled']) && $config['OmsVN']['loki']['general']['enabled'] == 1) {
        $services[] = array(
            'description' => gettext('loki service'),
            'configd' => array(
                'restart' => array('loki restart'),
                'start' => array('loki start'),
                'stop' => array('loki stop'),
                'status' => array('loki status'),
            ),
            'name' => 'loki',
            'pidfile' => '/var/run/loki/loki.pid'
        );
    }

    return $services;
}
