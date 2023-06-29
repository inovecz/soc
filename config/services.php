<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'zabbix' => [
        'host' => env('ZABBIX_HOST', 'localhost'),
        'username' => env('ZABBIX_USERNAME', 'Admin'),
        'password' => env('ZABBIX_PASSWORD', 'zabbix'),
    ],

    'graylog' => [
        'host' => env('GRAYLOG_HOST', 'localhost').'/api/',
        'username' => env('GRAYLOG_USERNAME', 'Admin'),
        'password' => env('GRAYLOG_PASSWORD', 'graylog'),
    ],

    'open_vas' => [
        'host' => env('OPENVAS_PROTOCOL', 'https://').env('OPENVAS_IP', 'localhost').':'.env('OPENVAS_PORT', '9390').'/api/',
        'ip' => env('OPENVAS_IP', 'localhost'),
        'username' => env('OPENVAS_USERNAME', 'Admin'),
        'password' => env('OPENVAS_PASSWORD', 'openvas'),
    ],

    'grafana' => [
        'host' => env('GRAFANA_HOST', 'localhost').'/api/',
        'host_no_api' => env('GRAFANA_HOST', 'localhost'),
        'username' => env('GRAFANA_USERNAME', 'Admin'),
        'password' => env('GRAFANA_PASSWORD', 'grafana'),
    ],
];
