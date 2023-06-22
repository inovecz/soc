<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Libraries\Graylog;

class LogsAndReportsController extends Controller
{
    public function index()
    {
        $graylog = new Graylog();
        $clusters = $graylog->getClusters();
        return view('pages.logsAndReports.index', compact('clusters'));
    }
}
