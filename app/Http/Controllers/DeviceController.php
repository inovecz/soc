<?php

namespace App\Http\Controllers;

use App\Libraries\Zabbix;

class DeviceController extends Controller
{
    public function __construct(protected Zabbix $zabbix = new Zabbix()) { }

    public function index()
    {
        return view('pages.hosts.index');
    }

    public function detail(string $hostId)
    {
        $host = $this->zabbix->getHost($hostId)[0];
        $problems = $this->zabbix->getProblems($hostId);
        $items = $this->zabbix->getItems($hostId);
        $collectItems = collect($items);

        $host['ip'] = $host['interfaces'][0]['ip'] ?? null;
        $host['port'] = $host['interfaces'][0]['port'] ?? null;
        $host['os'] = $collectItems->firstWhere('key_', 'system.sw.os')['lastvalue'] ?? null;
        $host['arch'] = $collectItems->firstWhere('key_', 'system.sw.arch')['lastvalue'] ?? null;
        $host['cpu'] = $collectItems->firstWhere('key_', 'system.cpu.util')['lastvalue'] ?? null;
        $host['mem'] = $collectItems->filter(fn($item) => str_starts_with($item['key_'], 'vm.memory.util'))->first()['lastvalue'] ?? null;

        return view('pages.hosts.detail', compact('host', 'problems', 'items'));
    }

    public function discoveryIndex()
    {
        return view('pages.hosts.discovery');
    }
}
