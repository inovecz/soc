<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Libraries\Zabbix;

class OpenVasController extends Controller
{
    public function index()
    {
        $zabbix = new Zabbix();
        $hosts = $zabbix->getHosts();
        $hostsData = $zabbix->getHostsData($hosts);
        return view('pages.zabbix', compact('hosts', 'hostsData'));
    }
}
