<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Libraries\Graylog;

class GraylogController extends Controller
{
    public function index()
    {
        $graylog = new Graylog();
        $clusters = $graylog->getClusters();
        return view('pages.graylog', compact('clusters'));
    }
}
