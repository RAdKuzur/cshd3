<?php

use App\Http\Controllers\AdminAuditoriumController;
use App\Http\Controllers\AdminPositionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuditoriumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElectronicsController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\TransferActController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CheckPermissionMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//Route::get('/check', [AuthController::class, 'check'])->name('check');

Route::get('/info/thing-types', [InfoController::class, 'types'])->name('info.types');
Route::get('/info/balance', [InfoController::class, 'balance'])->name('info.balance');
Route::get('/info/departments', [InfoController::class, 'departments'])->name('info.departments');
Route::get('/info/branches', [InfoController::class, 'branches'])->name('info.branches');
Route::get('/info/transfer-acts/types', [InfoController::class, 'transferActTypes'])->name('info.branches');

Route::get('/auditoriums/index', [AuditoriumController::class, 'index'])->name('auditorium.index');
Route::get('/things/simple-electronics', [ElectronicsController::class, 'simpleElectronics'])->name('things.simple-electronics');

Route::post('/things/composite-store', [ThingController::class, 'compositeStore'])->name('things.composite-store');
Route::get('/things/index', [ThingController::class, 'index'])->name('things.index');
Route::get('/things/person/{id}', [ThingController::class, 'personThings'])->name('things.person');
Route::get('/things/free', [ThingController::class, 'free'])->name('things.free');
Route::middleware([CheckPermissionMiddleware::class])->group(function () {
    Route::get('/profile/{username}', [UserController::class, 'profile'])->name('profile');

    Route::get('/stuff', [PeopleController::class, 'stuff'])->name('stuff');


    Route::get('/things/electronics', [ElectronicsController::class, 'electronics'])->name('things.electronics');
    Route::get('/things/view/{id}', [ThingController::class, 'view'])->name('things.view');
    Route::get('/things/edit/{id}', [ThingController::class, 'edit'])->name('things.edit');
    Route::post('/things/store', [ThingController::class, 'store'])->name('things.store');
    Route::put('/things/update/{id}', [ThingController::class, 'update'])->name('things.update');
    Route::delete('/things/delete/{id}', [ThingController::class, 'delete'])->name('things.delete');

    Route::get('/auditoriums/map', [AuditoriumController::class, 'map'])->name('auditorium.map');


    Route::get('/admin/positions/index' , [AdminPositionController::class, 'index'])->name('admin.positions.index');
    Route::post('/admin/positions/store' , [AdminPositionController::class, 'store'])->name('admin.positions.store');
    Route::put('/admin/positions/update/{id}' , [AdminPositionController::class, 'update'])->name('admin.positions.update');
    Route::delete('/admin/positions/delete/{id}' , [AdminPositionController::class, 'delete'])->name('admin.positions.delete');

    Route::get('/admin/auditoriums/index' , [AdminAuditoriumController::class, 'index'])->name('admin.positions.index');
    Route::post('/admin/auditoriums/store' , [AdminAuditoriumController::class, 'store'])->name('admin.positions.store');
    Route::put('/admin/auditoriums/update/{id}' , [AdminAuditoriumController::class, 'update'])->name('admin.positions.update');
    Route::delete('/admin/auditoriums/delete/{id}' , [AdminAuditoriumController::class, 'delete'])->name('admin.positions.delete');

    Route::get('/admin/users/index' , [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/view/{id}' , [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::post('/admin/users/store' , [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/update/{id}' , [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/delete/{id}' , [AdminUserController::class, 'delete'])->name('admin.users.delete');

});;
Route::get('/reports/auditorium/{id}', [ReportController::class, 'auditorium'])->name('reports.auditorium');
Route::get('/reports/auditoriums', [ReportController::class, 'auditoriums'])->name('reports.auditoriums');
Route::get('/reports/things', [ReportController::class, 'things'])->name('reports.positions');
Route::get('/reports/workstations', [ReportController::class, 'workstations'])->name('reports.workstations');

Route::get('/things/transfer-acts/index', [TransferActController::class, 'index'])->name('transfer-acts.index');
Route::get('/things/transfer-acts/view/{id}', [TransferActController::class, 'view'])->name('transfer-acts.view');
Route::get('/things/transfer-acts/edit/{id}', [TransferActController::class, 'edit'])->name('transfer-acts.edit');
Route::post('/things/transfer-acts/store', [TransferActController::class, 'store'])->name('transfer-acts.store');
Route::put('/things/transfer-acts/update/{id}', [TransferActController::class, 'update'])->name('transfer-acts.update');
Route::delete('/things/transfer-acts/delete/{id}', [TransferActController::class, 'delete'])->name('transfer-acts.delete');
Route::get('/things/transfer-acts/things/{id}', [ThingController::class, 'transferActThings'])->name('things.transferActThings');
Route::get('/people/index', [PeopleController::class, 'index'])->name('people.index');

Route::post('/test' , [TestController::class, 'test'])->name('test');
Route::post('/tests' , [TestController::class, 'tests'])->name('tests');
