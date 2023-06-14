<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Livewire\Redirector;
use App\Libraries\Grafana;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class SideNavigation extends Component
{
    public array $menuItems = [];
    public bool $isExpanded;

    public function mount()
    {
        $dashboards = (new Grafana())->getDashboards();

        $dashboardsSubmenu = [];
        foreach ($dashboards as $dashboard) {
            $dashboardsSubmenu[] = [
                'label' => $dashboard['title'],
                'route' => 'dashboards.index',
                'params' => ['dashboardUid' => $dashboard['uid']],
                'active' => Str::of(request()?->route()?->getName())->startsWith('dashboards.index') && request()?->route()?->parameter('dashboardUid') === (string) $dashboard['uid'],
            ];
        }
        $this->menuItems = [
            [],
            [
                'label' => __('Dashboards'),
                'icon' => 'mdi-view-dashboard',
                'route' => null,
                'active' => Str::of(request()?->route()?->getName())->startsWith('dashboards'),
                'submenu' => [
                    ...$dashboardsSubmenu,
                    ['label' => __('Manage'), 'route' => 'dashboards.manage', 'active' => Str::of(request()?->route()?->getName())->startsWith('dashboards.manage')],
                ],
            ], [
                'label' => __('Alerts'),
                'icon' => 'mdi-alert',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
            ], [
                'label' => __('Threat Analysis Centre'),
                'icon' => 'mdi-bug',
                'route' => '',
                'active' => Str::of(request()?->route()?->getName())->startsWith('openvas'),
                'submenu' => [
                    ['label' => __('OpenVAS'), 'route' => 'openvas.index', 'active' => Str::of(request()?->route()?->getName())->startsWith('openvas.index')],
                ],
            ], [
                'label' => __('Logs & Reports'),
                'icon' => 'mdi-poll',
                'route' => 'graylog.index',
                'active' => request()?->route()?->getName() === 'graylog.index',
            ], [
                'label' => __('People'),
                'icon' => 'mdi-account-multiple',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
            ], [
                'label' => __('Devices'),
                'icon' => 'mdi-cellphone-link',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
            ], [
                'label' => __('Global Setting'),
                'icon' => 'mdi-cogs',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
            ], [
                'label' => __('Account Health Check'),
                'icon' => 'mdi-shield-plus',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
            ],
            [],
            [
                'label' => __('Endpoint'),
                'icon' => 'mdi-transit-connection-variant',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
                'submenu' => [],
            ], [
                'label' => __('Server'),
                'icon' => 'mdi-server-network',
                'route' => 'zabbix.index',
                'active' => request()?->route()?->getName() === 'zabbix.index',
                'submenu' => [],
            ], [
                'label' => __('Firewall Management'),
                'icon' => 'mdi-folder-account',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
                'submenu' => [],
            ], [
                'label' => __('Switches'),
                'icon' => 'mdi-toggle-switch',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
                'submenu' => [],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.components.side-navigation', ['menuItems' => $this->menuItems]);
    }

    public function routeTo(string $route, array $params = []): RedirectResponse|Redirector
    {
        return redirect()->route($route, $params);
    }
}
