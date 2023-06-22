<?php

namespace App\Http\Controllers;

use App\Libraries\Zabbix;

class ActionController extends Controller
{
    public function __construct(protected Zabbix $zabbix = new Zabbix()) { }

    public function index()
    {
        $scripts = $this->zabbix->getScripts();
        return view('pages.actions.index', compact('scripts'));
    }
}
