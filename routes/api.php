<?php

use App\Http\Controllers\Dashboard\MetricQueryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\JoinRequestController;
use App\Http\Controllers\Dashboard\EventController as EventCrudController;
use App\Http\Controllers\Dashboard\Event\EventController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\Metric\MetricCrudController;
use App\Http\Controllers\Dashboard\Metric\MetricController;
use App\Http\Controllers\Dashboard\PostController;


use App\Http\Controllers\MediaController;

use App\Http\Controllers\Dashboard\Badge\BadgeController;
use App\Http\Controllers\Dashboard\Badge\BadgeCRUDController;

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\UserCrudController;
use App\Http\Controllers\Dashboard\Admin\AdminCrudController;

use App\Http\Controllers\Dashboard\Notification\NotificationCrudController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->post('dashboard/user', function (Request $request) {
//
//});


Route::group(['prefix' => 'mobile'], function () {
    require_once base_path('routes/mobile.php');


});


Route::prefix('dashboard')->group(function () {

    //Admin Login Route.
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum', 'type.admin']], function(){

        Route::get('me', [AuthController::class, 'me']);

        // Start Roles && Permissions.

        Route::get('permissions', [RoleController::class, 'permissions']);
        Route::resource('roles', RoleController::class);

        //End Roles && Permissions.
        Route::get('posts/accept/{id}',[PostController ::class,'acceptPost']);

        Route::resource('posts',PostController ::class);


        Route::patch('join-requests/change-status/{id}', [JoinRequestController::class, 'changeRequestStatus']);

        Route::resource('join-requests', JoinRequestController::class);


        Route::get('events/remove-user', [EventController::class, 'removeUserFromEvent']);
        Route::get('events/change-user-role', [EventController::class, 'changeUserRoleStatus']);
        Route::resource('events', EventCrudController::class);



        Route::apiResource('notifications', NotificationCrudController::class);

        //StartMetric Routes.

        Route::apiResource('metrics', MetricCrudController::class);

        Route::get('metric/metrics-event-user', [MetricController::class, 'getEventUserMetricValues']);

        //End Metric Routes.

        //Categories Routes.
        Route::apiResource('categories', CategoryController::class);



        Route::apiResource('metricQuery', \App\Http\Controllers\Dashboard\MetricQueryController::class);
        // ahmad

        Route::apiResource('metricConfiguration', \App\Http\Controllers\Dashboard\EventMetricConfigurationController::class);


        Route::apiResource('pointRule', \App\Http\Controllers\Dashboard\PointRuleController::class);
        Route::post('newPointRule', [\App\Http\Controllers\Dashboard\PointRuleController::class, 'newPointRule']);

        Route::post('newBadge', [BadgeController::class, 'newBadge']);
        Route::get('getMetricsOperations', [MetricQueryController::class, 'getMetricsOperations']);

        //
        Route::get('getAllPointRules', [\App\Http\Controllers\Dashboard\PointRuleController::class, 'getAll']);
        Route::get('getAllBadges', [BadgeController::class, 'getAll']);


        Route::get('event/end/{event}', [EventCrudController::class, 'eventEnd']);




        Route::patch('activate-volunteer/{user}', [UserController::class, 'activateVolunteer']);


        Route::resource('badge', BadgeCRUDController::class);
        Route::post('badge/add-to-user', [BadgeController::class,'addBadgeUser']);

        Route::apiResource('users', UserCrudController::class);
        Route::apiResource('admins', AdminCrudController::class);


    });

});

// Start -- Media Apis --.

//Upload Single or Multiple Media files.
Route::post('/upload-media', [MediaController::class, 'uploadMedia']);

//Delete Media File.
Route::delete('/delete-media/{id}', [MediaController::class, 'deleteMedia']);

// End -- Media Apis --.






