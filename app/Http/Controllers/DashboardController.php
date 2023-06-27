<?php

namespace App\Http\Controllers;

use App\Libraries\Grafana;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(string $dashboardUid)
    {
        $dashboard = (new Grafana())->getDashboard($dashboardUid);
        $panels = (new Grafana())->getPanels($dashboardUid);
        $panelMembers = [];
        foreach ($panels as $panel) {
            $panelMembers[] = [
                'id' => $panel['id'],
                'name' => $panel['title'] ?? Str::uuid(),
                'title' => $panel['title'] ?? __('Untitled'),
                'url' => config('services.grafana.host_no_api').':3000/d-solo/'.$dashboard['uid'].'/'.$dashboard['slug'].'?orgId=1&refresh=30s&panelId='.$panel['id'],
                'size' => 1,
            ];
        }
        return view('pages.dashboards.index', compact('dashboard', 'panels', 'panelMembers', 'dashboardUid'));
    }

    public function manage()
    {
        $dashboards = (new Grafana())->getDashboards();
        return view('pages.dashboards.manage', compact('dashboards'));
    }
}
