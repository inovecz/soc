<?php

namespace App\Http\Controllers;

class SettingController extends Controller
{
    public ?string $logo = null;

    public function index()
    {
        return view('pages.settings.index', ['logo' => $this->logo]);
    }
}
