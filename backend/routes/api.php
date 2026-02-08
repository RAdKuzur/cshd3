<?php

use App\Http\Controllers\AdminAuditoriumController;
use App\Http\Controllers\AdminBranchController;
use App\Http\Controllers\AdminPositionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuditoriumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LicenceController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\NetworkThingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TechWorkController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\TransferActController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAvailabilityMiddleware;
use App\Http\Middleware\CheckPermissionMiddleware;
use App\Http\Middleware\LicenceMiddleware;
use App\Http\Middleware\PrometheusMiddleware;
use App\Http\Middleware\TechWorkMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/metrics', [MetricsController::class, 'metrics'])->name('metrics');

Route::middleware([PrometheusMiddleware::class])->group(function () {

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/block', [AuthController::class, 'block'])->name('block');
    Route::post('/unblock', [AuthController::class, 'unblock'])->name('unblock');
    Route::middleware([CheckPermissionMiddleware::class])->group(function () {

        Route::get('/tech-works', [TechWorkController::class, 'all'])->name('tech-works.all');
        Route::post('/tech-works', [TechWorkController::class, 'create'])->name('tech-works.create');
        Route::post('/tech-works/{id}/cancel', [TechWorkController::class, 'cancel'])->name('tech-works.cancel');

        Route::middleware([TechWorkMiddleware::class])->group(function () {
            Route::post('/licence', [LicenceController::class, 'create'])->name('licence.create');
            Route::get('/profile/{username}', [UserController::class, 'profile'])->name('profile');

            Route::get('/notifications/{username}', [NotificationController::class, 'getUserNotifications'])->name('notifications.get-user-notifications');
            Route::post('/notifications/{username}', [NotificationController::class, 'readAllUserNotifications'])->name('notifications.read-all-user-notifications');
            Route::post('/notifications/{notificationId}/read', [NotificationController::class, 'readUserNotification'])->name('notifications.read-user-notification');
            Route::delete('/notifications/{notificationId}', [NotificationController::class, 'delete'])->name('notifications.delete');
            Route::delete('/notifications/{username}', [NotificationController::class, 'deleteAllUserNotifications'])->name('notifications.delete-all-user-notifications');

            Route::middleware([LicenceMiddleware::class])->group(function () {
                //    Route::middleware([CheckAvailabilityMiddleware::class])->group(function () {
                //        //routes...
                //    });
                Route::get('/info/thing-types', [InfoController::class, 'types'])->name('info.types');
                Route::get('/info/balance', [InfoController::class, 'balance'])->name('info.balance');
                Route::get('/info/departments', [InfoController::class, 'departments'])->name('info.departments');
                Route::get('/info/branches', [InfoController::class, 'branches'])->name('info.branches');
                Route::get('/info/transfer-acts/types', [InfoController::class, 'transferActTypes'])->name('info.transfer-acts.types');
                Route::get('/info/roles', [InfoController::class, 'roles'])->name('info.roles');

                Route::get('/auditoriums', [AuditoriumController::class, 'all'])->name('auditorium.all');
                Route::get('/things/simple-things', [ThingController::class, 'simpleThings'])->name('things.simple-things');

                Route::post('/things/composite', [ThingController::class, 'compositeCreate'])->name('things.composite-create');
                Route::get('/things', [ThingController::class, 'all'])->name('things.all');
                Route::get('/things/person/{id}', [ThingController::class, 'personThings'])->name('things.person');
                Route::get('/things/free', [ThingController::class, 'getFreeThings'])->name('things.free');

                Route::get('/stuff', [PeopleController::class, 'stuff'])->name('stuff');

                Route::get('/things/filter-arm', [ThingController::class, 'filterArm'])->name('things.filter-arm');
                Route::get('/things/electronics', [ThingController::class, 'electronics'])->name('things.electronics');
                Route::get('/things/furniture', [ThingController::class, 'furniture'])->name('things.furniture');
                Route::get('/things/{id}', [ThingController::class, 'getOne'])->name('things.get-one');
                Route::post('/things', [ThingController::class, 'create'])->name('things.create');
                Route::put('/things/{id}', [ThingController::class, 'update'])->name('things.update');
                Route::delete('/things/{id}', [ThingController::class, 'delete'])->name('things.delete');

                Route::get('/auditoriums/map', [AuditoriumController::class, 'map'])->name('auditorium.map');

                Route::get('/admin/positions', [AdminPositionController::class, 'all'])->name('admin.positions.all');
                Route::post('/admin/positions', [AdminPositionController::class, 'create'])->name('admin.positions.create');
                Route::put('/admin/positions/{id}', [AdminPositionController::class, 'update'])->name('admin.positions.update');
                Route::delete('/admin/positions/{id}', [AdminPositionController::class, 'delete'])->name('admin.positions.delete');

                Route::get('/admin/auditoriums', [AdminAuditoriumController::class, 'all'])->name('admin.auditoriums.all');
                Route::post('/admin/auditoriums', [AdminAuditoriumController::class, 'create'])->name('admin.auditoriums.create');
                Route::put('/admin/auditoriums/{id}', [AdminAuditoriumController::class, 'update'])->name('admin.auditoriums.update');
                Route::delete('/admin/auditoriums/{id}', [AdminAuditoriumController::class, 'delete'])->name('admin.auditoriums.delete');

                Route::get('/admin/branches', [AdminBranchController::class, 'all'])->name('admin.branches.all');
                Route::post('/admin/branches', [AdminBranchController::class, 'create'])->name('admin.branches.create');
                Route::put('/admin/branches/{id}', [AdminBranchController::class, 'update'])->name('admin.branches.update');
                Route::delete('/admin/branches/{id}', [AdminBranchController::class, 'delete'])->name('admin.branches.delete');

                Route::get('/admin/users', [AdminUserController::class, 'all'])->name('admin.users.all');
                Route::get('/admin/users/{id}', [AdminUserController::class, 'getOne'])->name('admin.users.get-one');
                Route::post('/admin/users', [AdminUserController::class, 'create'])->name('admin.users.create');
                Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
                Route::delete('/admin/users/{id}', [AdminUserController::class, 'delete'])->name('admin.users.delete');

                Route::get('/reports/auditoriums/{id}', [ReportController::class, 'auditorium'])->name('reports.auditorium');
                Route::get('/reports/auditoriums', [ReportController::class, 'auditoriums'])->name('reports.auditoriums');
                Route::get('/reports/things', [ReportController::class, 'things'])->name('reports.things');
                Route::get('/reports/workstations', [ReportController::class, 'workstations'])->name('reports.workstations');
                Route::get('/reports/general', [ReportController::class, 'general'])->name('reports.general');
                Route::get('/reports/form-extended/{year}', [ReportController::class, 'formExtended'])->name('reports.form-extended');
                Route::get('/reports/form/{year}', [ReportController::class, 'form'])->name('reports.form');

                Route::get('/transfer-acts', [TransferActController::class, 'all'])->name('transfer-acts.all');
                Route::get('/transfer-acts/{id}', [TransferActController::class, 'getOne'])->name('transfer-acts.get-one');
                Route::post('/transfer-acts', [TransferActController::class, 'create'])->name('transfer-acts.create');
                Route::put('/transfer-acts/{id}', [TransferActController::class, 'update'])->name('transfer-acts.update');
                Route::delete('/transfer-acts/{id}', [TransferActController::class, 'delete'])->name('transfer-acts.delete');
                Route::get('/transfer-acts/things/{id}', [ThingController::class, 'transferActThings'])->name('things.transfer-act-things');
                Route::post('/transfer-acts/confirm', [TransferActController::class, 'confirm'])->name('transfer-acts.confirm');
                Route::post('/transfer-acts/cancel-confirm', [TransferActController::class, 'cancelConfirm'])->name('transfer-acts.cancel-confirm');

                Route::get('/people', [PeopleController::class, 'all'])->name('people.all');

                Route::get('/files', [FileController::class, 'all'])->name('files.all');
                Route::get('/files/{id}', [FileController::class, 'getOne'])->name('files.get-one');
                Route::get('/files/download/{id}', [FileController::class, 'download'])->name('files.download');
                Route::post('/files', [FileController::class, 'upload'])->name('files.upload');
                Route::delete('/files/{id}', [FileController::class, 'delete'])->name('files.delete');


                Route::get('/network-things', [NetworkThingController::class, 'all'])->name('network-things.all');
                Route::get('/network-things/{id}', [NetworkThingController::class, 'getOne'])->name('network-things.get-one');
                Route::post('/network-things', [NetworkThingController::class, 'create'])->name('network-things.create');
                Route::put('/network-things/{id}', [NetworkThingController::class, 'update'])->name('network-things.update');
                Route::delete('/network-things/{id}', [NetworkThingController::class, 'delete'])->name('network-things.delete');
                Route::get('/telephones', [NetworkThingController::class, 'telephones'])->name('network-things.telephones');

                Route::post('/search', [SearchController::class, 'search'])->name('search');
            });
        });
    });
});


