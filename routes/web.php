<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\ZabbixController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraylogController;
use App\Http\Controllers\OpenVasController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboards/{dashboardUid}', [DashboardController::class, 'index'])->whereUuid('dashboardUid')->name('dashboards.index');
    Route::get('/zabbix', [ZabbixController::class, 'index'])->name('zabbix.index');
    Route::get('/graylog', [GraylogController::class, 'index'])->name('graylog.index');
    Route::get('/openvas', [OpenVasController::class, 'index'])->name('openvas.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/hosts', [HostController::class, 'index'])->name('hosts.index');
    Route::get('/hosts/{hostId}', [HostController::class, 'detail'])->name('hosts.detail');
    Route::get('/people', [PeopleController::class, 'index'])->name('people.index');
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
