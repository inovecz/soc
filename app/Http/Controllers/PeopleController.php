<?php

namespace App\Http\Controllers;

use App\Libraries\Zabbix;

class PeopleController extends Controller
{
    public function __construct(protected Zabbix $zabbix = new Zabbix()) { }

    public function index()
    {
        $users = $this->zabbix->getUsers();
        return view('pages.people.index', compact('users'));
    }
}
