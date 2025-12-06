<?php

use App\Http\Controllers\AuditoriumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElectronicsController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\StuffController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//Route::get('/check', [AuthController::class, 'check'])->name('check');

Route::get('/info/thing-types', [InfoController::class, 'types'])->name('info.types');
Route::get('/info/balance', [InfoController::class, 'balance'])->name('info.balance');
Route::get('/auditoriums/index', [AuditoriumController::class, 'index'])->name('auditorium.index');
Route::get('/things/simple-electronics', [ElectronicsController::class, 'simpleElectronics'])->name('things.simple-electronics');

Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/profile/{username}', [UserController::class, 'profile'])->name('profile');

    Route::get('/stuff', [StuffController::class, 'stuff'])->name('stuff');


    Route::get('/things/electronics', [ElectronicsController::class, 'electronics'])->name('things.electronics');
    Route::get('/things/view/{id}', [ThingController::class, 'view'])->name('things.view');
    Route::get('/things/edit/{id}', [ThingController::class, 'edit'])->name('things.edit');
    Route::post('/things/create', [ThingController::class, 'create'])->name('things.create');
    Route::put('/things/update/{id}', [ThingController::class, 'update'])->name('things.update');
    Route::delete('/things/delete/{id}', [ThingController::class, 'delete'])->name('things.delete');

    Route::get('/auditoriums/map', [AuditoriumController::class, 'map'])->name('auditorium.map');
});
