<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rutas placeholder para el sidebar
Route::prefix('tenants')->name('tenants.')->group(function () {
    Route::get('/', fn() => view('dashboard'))->name('index');
    Route::get('/create', fn() => view('dashboard'))->name('create');
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', fn() => view('dashboard'))->name('index');
    Route::get('/create', fn() => view('dashboard'))->name('create');
});

Route::get('/analytics', fn() => view('dashboard'))->name('analytics.index');
Route::get('/settings', fn() => view('dashboard'))->name('settings.index');
Route::get('/profile', fn() => view('dashboard'))->name('profile');

// Rutas de autenticación placeholder
Route::post('/logout', function () {
    return redirect()->route('dashboard');
})->name('logout');
