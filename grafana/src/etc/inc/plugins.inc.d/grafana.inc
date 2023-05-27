<?php

function grafana_services()
{
    global $config;

    $services = array();

    if (isset($config['OmsVN']['grafana']['general']['enabled']) && $config['OmsVN']['grafana']['general']['enabled'] == 1) {
        $services[] = array(
            'description' => gettext('grafana service'),
            'configd' => array(
                'restart' => array('grafana restart'),
                'start' => array('grafana start'),
                'stop' => array('grafana stop'),
                'status' => array('grafana status'),
            ),
            'name' => 'grafana',
            'pidfile' => '/var/run/grafana/grafana.pid'
        );
    }

    return $services;
}
