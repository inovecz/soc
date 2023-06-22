<?php

namespace App\Http\Livewire\People;

use Livewire\Component;
use App\Libraries\Zabbix;

class IndexTable extends Component
{
    public array $users;
    public array $settings;

    public function mount()
    {
        $zabbix = new Zabbix();
        $users = $zabbix->getUsers();
        $roles = $zabbix->getRoles();
        $rolesMap = [];
        foreach ($roles as $role) {
            $rolesMap[$role['roleid']] = $role;
        }
        foreach ($users as $index => $user) {
            $users[$index]['role'] = $rolesMap[$user['roleid']] ?? null;
        }
        $this->users = $users;
        $this->settings = $zabbix->getSettings();
    }

    public function render()
    {
        return view('livewire.people.index-table');
    }
}
