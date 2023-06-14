<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZabbixController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GraylogController;
use App\Http\Controllers\OpenVasController;
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
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
