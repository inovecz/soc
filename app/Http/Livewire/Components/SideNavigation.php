<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Livewire\Redirector;
use App\Libraries\Grafana;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class SideNavigation extends Component
{
    public array $menuItems = [];
    public bool $isExpanded;

    protected $listeners = ['menu-settings-updated' => 'buildMenuItems'];

    public function mount()
    {
        $this->buildMenuItems();
    }

    public function render()
    {
        return view('livewire.components.side-navigation', ['menuItems' => $this->menuItems]);
    }

    public function routeTo(string $route, array $params = []): RedirectResponse|Redirector
    {
        return redirect()->route($route, $params);
    }

    public function buildMenuItems(): void
    {
        $this->menuItems = [];
        $this->menuItems[] = [];
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.dashboards', 1) === 1) {
            $dashboardsSubmenu = [];
            try {
                $dashboards = (new Grafana())->getDashboards();
                foreach ($dashboards as $dashboard) {
                    $dashboardsSubmenu[] = [
                        'label' => $dashboard['title'],
                        'route' => 'dashboards.index',
                        'params' => ['dashboardUid' => $dashboard['uid']],
                        'active' => Str::of(request()?->route()?->getName())->startsWith('dashboards.index') && request()?->route()?->parameter('dashboardUid') === (string) $dashboard['uid'],
                    ];
                }
            } catch (ServiceUnavailableHttpException $e) {
                $dashboardsSubmenu[] = [
                    'label' => 'Grafana disconnected',
                ];
            }

            $this->menuItems[] = [
                'label' => __('Dashboards'),
                'icon' => 'mdi-view-grid',
                'route' => null,
                'active' => Str::of(request()?->route()?->getName())->startsWith('dashboards'),
                'submenu' => [
                    ...$dashboardsSubmenu,
                    ['label' => __('Manage'), 'route' => 'dashboards.manage', 'active' => Str::of(request()?->route()?->getName())->startsWith('dashboards.manage')],
                ],
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.alerts', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Alerts'),
                'icon' => 'mdi-bell',
                'route' => 'alerts.index',
                'active' => request()?->route()?->getName() === 'alerts.index',
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.threat_analysis_centre', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Threat Analysis Centre'),
                'icon' => 'mdi-bug',
                'route' => '',
                'active' => Str::of(request()?->route()?->getName())->startsWith('openvas'),
                'submenu' => [
                    ['label' => __('OpenVAS'), 'route' => 'openvas.index', 'active' => Str::of(request()?->route()?->getName())->startsWith('openvas.index')],
                ],
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.logs_n_reports', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Logs & Reports'),
                'icon' => 'mdi-poll',
                'route' => 'graylog.index',
                'active' => request()?->route()?->getName() === 'graylog.index',
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.people', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('People'),
                'icon' => 'mdi-account-group',
                'route' => 'users.index',
                'active' => request()?->route()?->getName() === 'users.index',
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.devices', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Devices'),
                'icon' => 'mdi-cellphone-link',
                'route' => 'hosts.index',
                'active' => request()?->route()?->getName() === 'hosts.index',
            ];
        }
        $this->menuItems[] = [
            'label' => __('Global Setting'),
            'icon' => 'mdi-cogs',
            'route' => 'settings.index',
            'active' => request()?->route()?->getName() === 'settings.index',
        ];
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.account_health_check', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Account Health Check'),
                'icon' => 'mdi-shield-plus',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
            ];
        }
        $this->menuItems[] = [];
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.admin_button', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Admin button'),
                'icon' => 'mdi-shield-crown',
                'role_id' => 3,
                'route' => '',
                'active' => request()?->route()?->getName() === '',
                'submenu' => [],
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.actions', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Actions'),
                'icon' => 'mdi-toggle-switch',
                'route' => '',
                'active' => request()?->route()?->getName() === '',
                'submenu' => [],
            ];
        }
    }
}
