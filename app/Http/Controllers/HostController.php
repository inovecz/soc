<?php

namespace App\Http\Controllers;

use App\Libraries\Zabbix;

class HostController extends Controller
{
    public function __construct(protected Zabbix $zabbix = new Zabbix()) { }

    public function index()
    {
        $hosts = $this->zabbix->getHosts();
        foreach ($hosts as $index => $host) {
            $hosts[$index]['problems'] = $this->zabbix->getProblemsCount($host['hostid']);
        }
        return view('pages.hosts.index', compact('hosts'));
    }

    public function detail(string $hostId)
    {
        $host = $this->zabbix->getHost($hostId)[0];
        $problems = $this->zabbix->getProblems($hostId);
        return view('pages.hosts.detail', compact('host', 'problems'));
    }
}
