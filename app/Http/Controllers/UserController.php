<?php

namespace App\Http\Controllers;

use App\Libraries\Zabbix;

class UserController extends Controller
{
    public function __construct(protected Zabbix $zabbix = new Zabbix()) { }

    public function index()
    {
        $users = $this->zabbix->getUsers();
        $roles = $this->zabbix->getRoles();
        $rolesMap = [];
        foreach ($roles as $role) {
            $rolesMap[$role['roleid']] = $role;
        }
        foreach ($users as $index => $user) {
            $users[$index]['role'] = $rolesMap[$user['roleid']] ?? null;
        }
        $settings = $this->zabbix->getSettings();
        return view('pages.people.index', compact('users', 'settings'));
    }
}
