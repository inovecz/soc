<?php

namespace App\Http\Controllers;

use App\Libraries\Zabbix;

class UserController extends Controller
{
    public function __construct(protected Zabbix $zabbix = new Zabbix()) { }

    public function index()
    {
        return view('pages.people.index');
    }
}
