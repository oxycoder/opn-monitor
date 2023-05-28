<?php

function promtail_services()
{
    global $config;

    $services = array();

    if (isset($config['OmsVN']['promtail']['general']['enabled']) && $config['OmsVN']['promtail']['general']['enabled'] == 1) {
        $services[] = array(
            'description' => gettext('promtail service'),
            'configd' => array(
                'restart' => array('promtail restart'),
                'start' => array('promtail start'),
                'stop' => array('promtail stop'),
                'status' => array('promtail status'),
            ),
            'name' => 'promtail',
            'pidfile' => '/var/run/promtail/promtail.pid'
        );
    }

    return $services;
}
