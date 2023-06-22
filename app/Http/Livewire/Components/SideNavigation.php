<?php

namespace App\Http\Livewire\Components;

use Storage;
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
    public ?string $logo = null;

    protected $listeners = ['menu-settings-updated' => 'buildMenuItems'];

    public function mount()
    {
        $this->buildMenuItems();
    }

    public function render()
    {
        return view('livewire.components.side-navigation', ['menuItems' => $this->menuItems, 'logo' => $this->logo]);
    }

    public function routeTo(string $route, array $params = []): RedirectResponse|Redirector
    {
        return redirect()->route($route, $params);
    }

    public function buildMenuItems(): void
    {
        $logoPath = \Setting::get('logo.'.auth()->user()->id);
        if ($logoPath) {
            $logo = Storage::get($logoPath, null);
            $extension = pathinfo($logoPath, PATHINFO_EXTENSION);
            $base64Logo = base64_encode($logo);
            $this->logo = 'data:image/'.$extension.';base64,'.$base64Logo;
        } else {
            $this->logo = null;
        }

        $this->menuItems = [];
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
                'active' => request()?->pageIs('dashboards/*'),
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
                'active' => request()?->pageIs('alerts'),
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.threat_analysis_centre', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Threat Analysis Centre'),
                'icon' => 'mdi-bug',
                'route' => 'threat-analysis-centre.index',
                'active' => request()?->pageIs('threat-analysis-centre'),
                'submenu' => [
                    ['label' => __('OpenVAS'), 'route' => 'openvas.index', 'active' => Str::of(request()?->route()?->getName())->startsWith('openvas.index')],
                ],
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.logs_n_reports', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Logs & Reports'),
                'icon' => 'mdi-poll',
                'route' => 'logs-n-reports.index',
                'active' => request()?->pageIs('logs-n-reports'),
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.people', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('People'),
                'icon' => 'mdi-account-group',
                'route' => 'users.index',
                'active' => request()?->pageIs('users'),
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.devices', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Devices'),
                'icon' => 'mdi-cellphone-link',
                'route' => 'hosts.index',
                'active' => request()?->pageIs('hosts'),
            ];
        }
        $this->menuItems[] = [
            'label' => __('Global Setting'),
            'icon' => 'mdi-cogs',
            'route' => 'settings.index',
            'active' => request()?->pageIs('settings'),
        ];
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.account_health_check', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Account Health Check'),
                'icon' => 'mdi-shield-plus',
                'route' => 'account-health-check.index',
                'active' => request()?->pageIs('account-health-check'),
            ];
        }
        $this->menuItems[] = [];
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.admin_button', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Admin button'),
                'icon' => 'mdi-shield-crown',
                'role_id' => 3,
                'route' => '',
                'active' => request()?->pageIs('admin-button'),
                'submenu' => [],
            ];
        }
        if ((int) \Setting::get('user_menu.'.auth()->user()->id.'.actions', 1) === 1) {
            $this->menuItems[] = [
                'label' => __('Actions'),
                'icon' => 'mdi-toggle-switch',
                'route' => 'actions.index',
                'active' => request()?->pageIs('actions'),
                'submenu' => [],
            ];
        }
    }
}
