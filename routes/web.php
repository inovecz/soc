<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\ZabbixController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OpenVasController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountHealthController;
use App\Http\Controllers\LogsAndReportsController;
use App\Http\Controllers\ThreatAnalysisController;

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
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('dashboards.manage');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboards/manage', [DashboardController::class, 'manage'])->name('dashboards.manage');
    Route::get('/dashboards/{dashboardUid}', [DashboardController::class, 'index'])->name('dashboards.index');
    Route::get('/zabbix', [ZabbixController::class, 'index'])->name('zabbix.index');
    Route::get('/logs-n-reports', [LogsAndReportsController::class, 'index'])->name('logs-n-reports.index');
    Route::get('/openvas', [OpenVasController::class, 'index'])->name('openvas.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/hosts', [HostController::class, 'index'])->name('hosts.index');
    Route::get('/hosts/{hostId}', [HostController::class, 'detail'])->name('hosts.detail');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/threat-analysis-centre', [ThreatAnalysisController::class, 'index'])->name('threat-analysis-centre.index');
    Route::get('/account-health-check', [AccountHealthController::class, 'index'])->name('account-health-check.index');
    Route::get('/actions', [ActionController::class, 'index'])->name('actions.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
