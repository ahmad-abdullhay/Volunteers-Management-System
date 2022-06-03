<?php

use App\Http\Controllers\Dashboard\MetricQueryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\JoinRequestController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\MetricController;
use App\Http\Controllers\Dashboard\PostController;


use App\Http\Controllers\MediaController;

use App\Http\Controllers\Dashboard\Badge\BadgeController;
use App\Http\Controllers\Dashboard\Badge\BadgeCRUDController;

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\UserCrudController;
use App\Http\Controllers\Dashboard\Admin\AdminCrudController;

use App\Http\Controllers\Dashboard\Message\MailCategoryController;
use App\Http\Controllers\Dashboard\Message\MailController;
use App\Http\Controllers\Dashboard\Message\MailCategoryRoleController;


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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('mail-categories/get-user-by-category-id/{category_id}', [MailCategoryController::class,'getUserFromRoleInCategory']);

});

Route::group(['prefix' => 'mobile'], function () {
    require_once base_path('routes/mobile.php');


});

Route::prefix('dashboard')->group(function () {

    //Admin Login Route.
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum', 'type.admin']], function(){


        Route::get('mail/unread-count/{category_id}', [MailController::class,"AdminMessageUnread"]);

        Route::get('me', [AuthController::class, 'me']);

        // Start Roles && Permissions.

        Route::get('permissions', [RoleController::class, 'permissions']);
        Route::resource('roles', RoleController::class);

        //End Roles && Permissions.
        Route::get('posts/accept/{id}',[PostController ::class,'acceptPost']);

        Route::resource('posts',PostController ::class);


        Route::patch('join-requests/change-status/{id}', [JoinRequestController::class, 'changeRequestStatus']);

        Route::resource('join-requests', JoinRequestController::class);
        Route::resource('events', EventController::class);

        Route::apiResource('notifications', NotificationCrudController::class);

        //StartMetric Routes.

        Route::apiResource('metrics', MetricController::class);

        //Categories Routes.
        Route::apiResource('categories', CategoryController::class);

        //End Metric Routes.

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


        Route::get('event/end/{event}', [EventController::class, 'eventEnd']);




        Route::patch('activate-volunteer/{user}', [UserController::class, 'activateVolunteer']);


        Route::resource('badge', BadgeCRUDController::class);
        Route::post('badge/add-to-user', [BadgeController::class,'addBadgeUser']);

        Route::resource('mail-categories', MailCategoryController::class);


        Route::resource('mail', MailController::class);
        Route::get('mail/get-by-category/{category_id}', [MailController::class,"getByAdminIdWithCategoryId"]);


        Route::resource('mail-categories-role', MailCategoryRoleController::class);

        Route::apiResource('users', UserCrudController::class);
        Route::apiResource('admins', AdminCrudController::class);

        Route::get("search-by-name/{key}",[UserController::class,"searchByName"]);

        Route::get("admin/mail-category",[AdminCrudController::class,"getMailCategories"]);



    });

});

// Start -- Media Apis --.

//Upload Single or Multiple Media files.
Route::post('/upload-media', [MediaController::class, 'uploadMedia']);

//Delete Media File.
Route::delete('/delete-media/{id}', [MediaController::class, 'deleteMedia']);

// End -- Media Apis --.






