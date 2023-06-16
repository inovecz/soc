<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class MenuSettings extends Component
{
    public array $settings;

    public function mount()
    {
        $this->settings = [
            'dashboards' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.dashboards', 1),
            'alerts' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.alerts', 1),
            'threat_analysis_centre' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.threat_analysis_centre', 1),
            'logs_n_reports' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.logs_reports', 1),
            'people' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.people', 1),
            'devices' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.devices', 1),
            'account_health_check' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.account_health_check', 1),
            'admin_button' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.admin_button', 1),
            'actions' => (int) \Setting::get('user_menu.'.auth()->user()->id.'.actions', 1),
        ];
    }

    public function render()
    {
        return view('livewire.settings.menu-settings');
    }

    public function updatingSettings($value, $key): void
    {
        \Setting::set('user_menu.'.auth()->user()->id.'.'.$key, $value === true ? 1 : 0);
        $this->emit('menu-settings-updated');
    }
}
