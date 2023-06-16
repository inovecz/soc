<?php

namespace App\Http\Controllers;

use App\Libraries\Zabbix;

class AlertController extends Controller
{
    public function __construct(protected Zabbix $zabbix = new Zabbix()) { }

    public function index()
    {
        $alerts = $this->zabbix->getAlerts();
        return view('pages.alerts.index', compact('alerts'));
    }
}
