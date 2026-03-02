<?php

use App\Http\Controllers\AdminAuditoriumController;
use App\Http\Controllers\AdminBranchController;
use App\Http\Controllers\AdminPositionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuditoriumController;
use App\Http\Controllers\AuditoriumResponsibilityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HistoryResourceController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LicenceController;
use App\Http\Controllers\MetricsController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\ModelResourceController;
use App\Http\Controllers\NetworkThingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PeoplePositionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TechWorkController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ThingAuditoriumController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\TransferActController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAvailabilityMiddleware;
use App\Http\Middleware\CheckPermissionMiddleware;
use App\Http\Middleware\CheckSignedUrlMiddleware;
use App\Http\Middleware\IdentifyUsernameMiddleware;
use App\Http\Middleware\LicenceMiddleware;
use App\Http\Middleware\PrometheusMiddleware;
use App\Http\Middleware\TechWorkMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/metrics', [MetricsController::class, 'metrics'])->name('metrics');
Route::get('/test', [TestController::class, 'test'])->name('test');
Route::get('/tests', [TestController::class, 'tests'])->name('tests');

Route::get('/test-ip', function() {
    return [
        'ip_method' => request()->ip(),
        'server_remote_addr' => request()->server('REMOTE_ADDR'),
        'header_x_forwarded_for' => request()->header('X-Forwarded-For'),
        'header_x_real_ip' => request()->header('X-Real-IP'),
        'all_ips' => request()->getClientIps(),
    ];
});

Route::middleware([PrometheusMiddleware::class])->group(function () {

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/block', [AuthController::class, 'block'])->name('block');
    Route::post('/unblock', [AuthController::class, 'unblock'])->name('unblock');

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');

    Route::middleware([CheckSignedUrlMiddleware::class])->group(function () {
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    });

    Route::middleware([CheckPermissionMiddleware::class])->group(function () {

        Route::get('/tech-works', [TechWorkController::class, 'all'])->name('tech-works.all');
        Route::post('/tech-works', [TechWorkController::class, 'create'])->name('tech-works.create');
        Route::post('/tech-works/{id}/cancel', [TechWorkController::class, 'cancel'])->name('tech-works.cancel');

        Route::middleware([TechWorkMiddleware::class])->group(function () {
            Route::post('/licence', [LicenceController::class, 'create'])->name('licences.create');
            Route::get('/profile/{username}', [UserController::class, 'profile'])->name('profile')->middleware(IdentifyUsernameMiddleware::class);

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
                Route::get('/info/resource-types', [InfoController::class, 'resourceTypes'])->name('info.resource-types');

                Route::get('/auditoriums', [AuditoriumController::class, 'all'])->name('auditoriums.all');
                Route::get('/things/simple-things', [ThingController::class, 'simpleThings'])->name('things.simple-things');

                Route::post('/things-composite', [ThingController::class, 'compositeCreate'])->name('things.composite-create');
                Route::get('/things', [ThingController::class, 'all'])->name('things.all');
                Route::get('/things/{id}/person', [ThingController::class, 'personThings'])->name('things.person');
                Route::get('/things/free', [ThingController::class, 'getFreeThings'])->name('things.free');

                Route::get('/staff', [PeopleController::class, 'staff'])->name('staff');

                Route::get('/things/filter-arm', [ThingController::class, 'filterArm'])->name('things.filter-arm');
                Route::get('/things/electronics', [ThingController::class, 'electronics'])->name('things.electronics');
                Route::get('/things/furniture', [ThingController::class, 'furniture'])->name('things.furniture');
                Route::get('/things/{id}', [ThingController::class, 'getOne'])->name('things.get-one');
                Route::post('/things', [ThingController::class, 'create'])->name('things.create');
                Route::put('/things/{id}', [ThingController::class, 'update'])->name('things.update');
                Route::delete('/things/{id}', [ThingController::class, 'delete'])->name('things.delete');

                Route::get('/auditoriums/map', [AuditoriumController::class, 'map'])->name('auditoriums.map');

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
                Route::get('/reports/resources', [ReportController::class, 'resources'])->name('reports.resources');
                Route::get('/reports/network-audit', [ReportController::class, 'networkAudit'])->name('reports.network-audit');

                Route::get('/transfer-acts', [TransferActController::class, 'all'])->name('transfer-acts.all');
                Route::get('/transfer-acts/{id}', [TransferActController::class, 'getOne'])->name('transfer-acts.get-one');
                Route::post('/transfer-acts', [TransferActController::class, 'create'])->name('transfer-acts.create');
                Route::put('/transfer-acts/{id}', [TransferActController::class, 'update'])->name('transfer-acts.update');
                Route::delete('/transfer-acts/{id}', [TransferActController::class, 'delete'])->name('transfer-acts.delete');
                Route::get('/transfer-acts/{id}/things', [ThingController::class, 'transferActThings'])->name('things.transfer-act-things');
                Route::post('/transfer-acts/confirm', [TransferActController::class, 'confirm'])->name('transfer-acts.confirm');
                Route::post('/transfer-acts/cancel-confirm', [TransferActController::class, 'cancelConfirm'])->name('transfer-acts.cancel-confirm');

                Route::get('/people', [PeopleController::class, 'all'])->name('people.all');

                Route::get('/files', [FileController::class, 'all'])->name('files.all');
                Route::get('/files/{id}', [FileController::class, 'getOne'])->name('files.get-one');
                Route::post('/files', [FileController::class, 'upload'])->name('files.upload');
                Route::delete('/files/{id}', [FileController::class, 'delete'])->name('files.delete');
                Route::get('/files/{tableName}/row/{rowId}', [FileController::class, 'getFiles'])->name('files.get-files');


                Route::get('/network-things', [NetworkThingController::class, 'all'])->name('network-things.all');
                Route::get('/network-things/{id}', [NetworkThingController::class, 'getOne'])->name('network-things.get-one');
                Route::post('/network-things', [NetworkThingController::class, 'create'])->name('network-things.create');
                Route::put('/network-things/{id}', [NetworkThingController::class, 'update'])->name('network-things.update');
                Route::delete('/network-things/{id}', [NetworkThingController::class, 'delete'])->name('network-things.delete');
                Route::get('/telephones', [NetworkThingController::class, 'telephones'])->name('network-things.telephones');

                Route::post('/search', [SearchController::class, 'search'])->name('search');

                Route::get('/companies', [CompanyController::class, 'all'])->name('companies.all');
                Route::get('/companies/{id}', [CompanyController::class, 'getOne'])->name('companies.get-one');
                Route::post('/companies', [CompanyController::class, 'create'])->name('companies.create');
                Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
                Route::delete('/companies/{id}', [CompanyController::class, 'delete'])->name('companies.delete');

                Route::get('/models', [ModelController::class, 'all'])->name('models.all');
                Route::get('/models/{id}', [ModelController::class, 'getOne'])->name('models.get-one');
                Route::post('/models', [ModelController::class, 'create'])->name('models.create');
                Route::put('/models/{id}', [ModelController::class, 'update'])->name('models.update');
                Route::delete('/models/{id}', [ModelController::class, 'delete'])->name('models.delete');

                Route::get('/devices', [DeviceController::class, 'all'])->name('devices.all');
                Route::get('/devices/{id}', [DeviceController::class, 'getOne'])->name('devices.get-one');
                Route::post('/devices', [DeviceController::class, 'create'])->name('devices.create');
                Route::put('/devices/{id}', [DeviceController::class, 'update'])->name('devices.update');
                Route::delete('/devices/{id}', [DeviceController::class, 'delete'])->name('devices.delete');

                Route::get('/resources', [ResourceController::class, 'all'])->name('resources.all');
                Route::get('/resources/{id}', [ResourceController::class, 'getOne'])->name('resources.get-one');
                Route::post('/resources', [ResourceController::class, 'create'])->name('resources.create');
                Route::put('/resources/{id}', [ResourceController::class, 'update'])->name('resources.update');
                Route::delete('/resources/{id}', [ResourceController::class, 'delete'])->name('resources.delete');

                Route::get('/history/resources', [HistoryResourceController::class, 'all'])->name('history-resources.all');
                Route::get('/history/resources/{id}', [HistoryResourceController::class, 'getOne'])->name('history-resources.get-one');
                Route::post('/history/resources', [HistoryResourceController::class, 'create'])->name('history-resources.create');
                Route::put('/history/resources/{id}', [HistoryResourceController::class, 'update'])->name('history-resources.update');
                Route::delete('/history/resources/{id}', [HistoryResourceController::class, 'delete'])->name('history-resources.delete');

                Route::get('/history/thing-auditoriums', [ThingAuditoriumController::class, 'all'])->name('history-thing-auditoriums.all');
                Route::get('/history/thing-auditoriums/{id}', [ThingAuditoriumController::class, 'getOne'])->name('history-thing-auditoriums.get-one');
                Route::post('/history/thing-auditoriums', [ThingAuditoriumController::class, 'create'])->name('history-thing-auditoriums.create');
                Route::put('/history/thing-auditoriums/{id}', [ThingAuditoriumController::class, 'update'])->name('history-thing-auditoriums.update');
                Route::delete('/history/thing-auditoriums/{id}', [ThingAuditoriumController::class, 'delete'])->name('history-thing-auditoriums.delete');

                Route::get('/history/people-positions', [PeoplePositionController::class, 'all'])->name('history-people-positions.all');
                Route::get('/history/people-positions/{id}', [PeoplePositionController::class, 'getOne'])->name('history-people-positions.get-one');
                Route::post('/history/people-positions', [PeoplePositionController::class, 'create'])->name('history-people-positions.create');
                Route::put('/history/people-positions/{id}', [PeoplePositionController::class, 'update'])->name('history-people-positions.update');
                Route::delete('/history/people-positions/{id}', [PeoplePositionController::class, 'delete'])->name('history-people-positions.delete');

                Route::get('/history/auditorium-responsibilities', [AuditoriumResponsibilityController::class, 'all'])->name('history-auditorium-responsibilities.all');
                Route::get('/history/auditorium-responsibilities/{id}', [AuditoriumResponsibilityController::class, 'getOne'])->name('history-auditorium-responsibilities.get-one');
                Route::post('/history/auditorium-responsibilities', [AuditoriumResponsibilityController::class, 'create'])->name('history-auditorium-responsibilities.create');
                Route::put('/history/auditorium-responsibilities/{id}', [AuditoriumResponsibilityController::class, 'update'])->name('history-auditorium-responsibilities.update');
                Route::delete('/history/auditorium-responsibilities/{id}', [AuditoriumResponsibilityController::class, 'delete'])->name('history-auditorium-responsibilities.delete');

                Route::get('/model-resources', [ModelResourceController::class, 'all'])->name('model-resources.all');
                Route::get('/model-resources/{id}', [ModelResourceController::class, 'getOne'])->name('model-resources.get-one');
                Route::post('/model-resources', [ModelResourceController::class, 'create'])->name('model-resources.create');
                Route::put('/model-resources/{id}', [ModelResourceController::class, 'update'])->name('model-resources.update');
                Route::delete('/model-resources/{id}', [ModelResourceController::class, 'delete'])->name('model-resources.delete');

                Route::get('/tokens', [TokenController::class, 'all'])->name('tokens.all');
                Route::get('/tokens/{username}/all', [TokenController::class, 'allUsername'])->name('tokens.username-all')->middleware(IdentifyUsernameMiddleware::class);;
                Route::put('/tokens/{id}/revoke', [TokenController::class, 'revoke'])->name('tokens.revoke');
                Route::delete('/tokens/{id}', [TokenController::class, 'delete'])->name('tokens.delete');

                Route::get('/inventory/{username}', [ThingController::class, 'inventory'])->name('things.inventory')->middleware(IdentifyUsernameMiddleware::class);;
            });
        });
    });
});


