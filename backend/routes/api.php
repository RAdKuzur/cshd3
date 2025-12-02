<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StuffController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/check', [AuthController::class, 'check'])->name('check');
Route::get('/profile/{username}', [UserController::class, 'profile'])->name('profile');

Route::get('/stuff', [StuffController::class, 'stuff'])->name('stuff');

Route::get('/things/info-type', [ThingController::class, 'infoType'])->name('things.info-type');

Route::get('/things/simple-electronics', [ThingController::class, 'simpleElectronics'])->name('things.simple-electronics');
Route::get('/things/electronics', [ThingController::class, 'electronics'])->name('things.electronics');

Route::post('/things/create', [ThingController::class, 'create'])->name('things.create');
