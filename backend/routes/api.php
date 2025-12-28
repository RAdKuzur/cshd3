<?php

use App\Http\Controllers\AdminAuditoriumController;
use App\Http\Controllers\AdminPositionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuditoriumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ElectronicsController;
use App\Http\Controllers\FileController;
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
Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');


Route::middleware([CheckPermissionMiddleware::class])->group(function () {

    Route::get('/info/thing-types', [InfoController::class, 'types'])->name('info.types');
    Route::get('/info/balance', [InfoController::class, 'balance'])->name('info.balance');
    Route::get('/info/departments', [InfoController::class, 'departments'])->name('info.departments');
    Route::get('/info/branches', [InfoController::class, 'branches'])->name('info.branches');
    Route::get('/info/transfer-acts/types', [InfoController::class, 'transferActTypes'])->name('info.branches');
    Route::get('/info/roles', [InfoController::class, 'roles'])->name('info.roles');

    Route::get('/auditoriums', [AuditoriumController::class, 'all'])->name('auditorium.all');
    Route::get('/things/simple-electronics', [ElectronicsController::class, 'simpleElectronics'])->name('things.simple-electronics');

    Route::post('/things/composite', [ThingController::class, 'compositeCreate'])->name('things.composite-create');
    Route::get('/things', [ThingController::class, 'all'])->name('things.all');
    Route::get('/things/person/{id}', [ThingController::class, 'personThings'])->name('things.person');
    Route::get('/things/free', [ThingController::class, 'getFreeThings'])->name('things.free'); //

    Route::get('/profile/{username}', [UserController::class, 'profile'])->name('profile');

    Route::get('/stuff', [PeopleController::class, 'stuff'])->name('stuff');

    Route::get('/things/electronics', [ElectronicsController::class, 'electronics'])->name('things.electronics');
    Route::get('/things/{id}', [ThingController::class, 'getOne'])->name('things.get-one');
    Route::post('/things', [ThingController::class, 'create'])->name('things.create');
    Route::put('/things/{id}', [ThingController::class, 'update'])->name('things.update');
    Route::delete('/things/{id}', [ThingController::class, 'delete'])->name('things.delete');

    Route::get('/auditoriums/map', [AuditoriumController::class, 'map'])->name('auditorium.map');

    Route::get('/admin/positions' , [AdminPositionController::class, 'all'])->name('admin.positions.all');
    Route::post('/admin/positions' , [AdminPositionController::class, 'create'])->name('admin.positions.create');
    Route::put('/admin/positions/{id}' , [AdminPositionController::class, 'update'])->name('admin.positions.update');
    Route::delete('/admin/positions/{id}' , [AdminPositionController::class, 'delete'])->name('admin.positions.delete');

    Route::get('/admin/auditoriums' , [AdminAuditoriumController::class, 'all'])->name('admin.positions.all');
    Route::post('/admin/auditoriums' , [AdminAuditoriumController::class, 'create'])->name('admin.positions.create');
    Route::put('/admin/auditoriums/{id}' , [AdminAuditoriumController::class, 'update'])->name('admin.positions.update');
    Route::delete('/admin/auditoriums/{id}' , [AdminAuditoriumController::class, 'delete'])->name('admin.positions.delete');

    Route::get('/admin/users' , [AdminUserController::class, 'all'])->name('admin.users.all');
    Route::get('/admin/users/{id}' , [AdminUserController::class, 'getOne'])->name('admin.users.get-one');
    Route::post('/admin/users' , [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::put('/admin/users/{id}' , [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}' , [AdminUserController::class, 'delete'])->name('admin.users.delete');

    Route::get('/reports/auditoriums/{id}', [ReportController::class, 'auditorium'])->name('reports.auditorium');
    Route::get('/reports/auditoriums', [ReportController::class, 'auditoriums'])->name('reports.auditoriums');
    Route::get('/reports/things', [ReportController::class, 'things'])->name('reports.positions');
    Route::get('/reports/workstations', [ReportController::class, 'workstations'])->name('reports.workstations');

    Route::get('/transfer-acts', [TransferActController::class, 'all'])->name('transfer-acts.all');
    Route::get('/transfer-acts/{id}', [TransferActController::class, 'getOne'])->name('transfer-acts.get-one');
    Route::post('/transfer-acts', [TransferActController::class, 'create'])->name('transfer-acts.create');
    Route::put('/transfer-acts/{id}', [TransferActController::class, 'update'])->name('transfer-acts.update');
    Route::delete('/transfer-acts/{id}', [TransferActController::class, 'delete'])->name('transfer-acts.delete');
    Route::get('/transfer-acts/things/{id}', [ThingController::class, 'transferActThings'])->name('things.transferActThings');

    Route::get('/people', [PeopleController::class, 'all'])->name('people.all');
});

Route::get('/files', [FileController::class, 'all'])->name('files.all');
Route::get('/files/{id}', [FileController::class, 'getOne'])->name('files.get-one');
Route::get('/files/download/{id}', [FileController::class, 'download'])->name('files.download');
Route::post('/files', [FileController::class, 'upload'])->name('files.upload');
Route::delete('/files/{id}', [FileController::class, 'delete'])->name('files.delete');

Route::post('/test' , [TestController::class, 'test'])->name('test');
Route::post('/tests' , [TestController::class, 'tests'])->name('tests');
