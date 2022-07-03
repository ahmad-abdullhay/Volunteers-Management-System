<?php

use App\Http\Controllers\Dashboard\LeaderboardController;
use App\Http\Controllers\Dashboard\LevelController;
use App\Http\Controllers\Dashboard\MetricQueryController;
use App\Http\Controllers\Dashboard\QuestionnaireController;
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



//Route::get('/validate-token', function ($request) {
//    dd($request->bearerToken());
//    return ['data' => 'Token is valid'];
//});


Route::prefix('dashboard')->group(function () {

    //Admin Login Route.
    Route::post('/login', [AuthController::class, 'login']);


    Route::group(['middleware' => ['auth:sanctum', 'type.admin']], function(){



        Route::get('mail/unread-count/{category_id}', [MailController::class,"AdminMessageUnread"]);

        Route::get("check-token",[AdminCrudController::class,"CheckToken"]);




        Route::get('me', [AuthController::class, 'me']);

        // Start Roles && Permissions.

        Route::get('permissions', [RoleController::class, 'permissions']);
        Route::resource('roles', RoleController::class);

        //End Roles && Permissions.
        Route::get('posts/accept/{id}',[PostController ::class,'acceptPost']);

        Route::resource('posts',PostController ::class);



        Route::patch('join-requests/change-status/{id}', [JoinRequestController::class, 'changeRequestStatus']);

        Route::resource('join-requests', JoinRequestController::class);

        Route::patch('event/changeStatus/{event}', [EventController::class, 'changeEventStatus']);

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

        Route::get('metric/get-event-metrics/{event}', [\App\Http\Controllers\Mobile\MetricController::class, 'getEventMetrics']);

        Route::get('metric/metrics-event-user', [MetricController::class, 'getEventUserMetricValues']);
        //
        Route::get('getAllPointRules', [\App\Http\Controllers\Dashboard\PointRuleController::class, 'getAll']);
        Route::get('getAllBadges', [BadgeController::class, 'getAll']);
        Route::get('userBadges', [BadgeController::class, 'index']);
        Route::get('badgeUsers/{badge}', [BadgeController::class, 'usersEarnedBadge']);
        Route::apiResource('metricConfiguration', \App\Http\Controllers\Dashboard\EventMetricConfigurationController::class);

        Route::get('event/end/{event}', [EventCrudController::class, 'eventEnd']);

        Route::resource('levels', LevelController::class);
        Route::get('levelVolunteer/{level}', [LevelController::class, 'levelsVolunteer']);

        Route::get('test', [RoleController::class, 'test']);


        Route::patch('activate-volunteer/{user}', [UserController::class, 'activateVolunteer']);


        Route::resource('badge', BadgeCRUDController::class);
        Route::post('badge/add-to-user', [BadgeController::class,'addBadgeUser']);

        Route::resource('mail-categories', MailCategoryController::class);


     //   Route::resource('mail', MailController::class);
        Route::get('mail/get-by-category/{category_id}', [MailController::class,"getByAdminIdWithCategoryId"]);


        Route::resource('mail-categories-role', MailCategoryRoleController::class);

        Route::apiResource('users', UserCrudController::class);
        Route::apiResource('admins', AdminCrudController::class);

        Route::get("search-by-name/{key}",[UserController::class,"searchByName"]);

        Route::get("admin/mail-category",[AdminCrudController::class,"getMailCategories"]);

        Route::post('newLeaderboardTable', [LeaderboardController::class, 'newTable']);
        Route::get('leaderboardsVolunteers', [LeaderboardController::class, 'tableVolunteers']);

        Route::apiResource('leaderboard', LeaderboardController::class);

        Route::get('questionnaire', [QuestionnaireController::class, 'getAll']);
    });

});

// Start -- Media Apis --.

//Upload Single or Multiple Media files.
Route::post('/upload-media', [MediaController::class, 'uploadMedia']);

//Delete Media File.
Route::delete('/delete-media/{id}', [MediaController::class, 'deleteMedia']);

// End -- Media Apis --.






