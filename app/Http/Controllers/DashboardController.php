<?php

namespace App\Http\Controllers;

use App\Libraries\Grafana;

class DashboardController extends Controller
{
    public function index(string $dashboardUid)
    {
        $panels = (new Grafana())->getPanels($dashboardUid);
        return view('dashboard', compact('panels'));
    }
}
