<?php

use App\Http\Controllers\Mobile\EventUserRatingController;
use App\Models\EventUserRating;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\AuthController;
use App\Http\Controllers\Mobile\UserController;
use App\Http\Controllers\Mobile\MetricController;
use App\Http\Controllers\Mobile\EventController;
use App\Http\Controllers\Dashboard\Message\MailController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\Badge\BadgeController;
use App\Http\Controllers\Mobile\NotificationController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/sign-up', [AuthController::class, 'signUp']);

Route::group(['middleware' => ['auth:sanctum', 'type.user']], function (){

    Route::get('mail/unread-count/{category_id}', [MailController::class,"UserMessageUnread"]);


    Route::get('me', [AuthController::class, 'me']);

    Route::get('/test', function (){
        dd(auth()->user());
    });
    Route::group(['prefix' => 'posts'], function () {
        Route::get('read-one/{id}',[PostController::class,'readOne']);
        Route::get('read-all',[PostController::class,'readAll']);
    });

    Route::get("user/mail-category",[UserController::class,"getMailCategories"]);

    Route::resource('mail', MailController::class);

    Route::get('mail/get-by-category/{category_id}', [MailController::class,"getByUserIdWithCategoryId"]);



    Route::post('/join-event', [UserController::class, 'joinEvent']);

    Route::post('/change-join-event-status', [UserController::class, 'ChangeVolunteerJoinEventStatus']);

    //Start Metric Routes.
    Route::post('metric/insert-value', [MetricController::class, 'insertMetricForUser']);

    Route::get('metric/get-event-metrics/{event}', [MetricController::class, 'getEventMetrics']);
    Route::get('metric/metrics-event-user', [MetricController::class, 'getEventUserMetricValues']);

    Route::get('metric/insertable-metrics-event-user', [MetricController::class, 'getEventUserInsertableMetrics']);

    //End Metric Routes.
    Route::get('event/getEventEndReport/{event}', [EventController::class, 'getEventEndReport']);

    //Start Event Routes.
    //Get only pending users that want to join the event.
    Route::get('event/users/pending/{event}', [EventController::class, 'getEventsRequests']);

    //Get Accepted users.
    Route::get('event/users/{event}  ', [EventController::class, 'getEventUsers']);

    Route::get('events', [EventController::class, 'index']);

    Route::post('rateEvent', [EventUserRatingController::class,'rateEvent']);



//    Route::get('badges/{user_id}', [BadgeController::class, 'index']);

    //End Event Routes.
    Route::get('badges', [BadgeController::class, 'index']);


    // -- Start Notifications --

    Route::get('notifications', [NotificationController::class, 'index']);

    Route::put('notifications', [NotificationController::class, 'readNotifications']);

    Route::delete('notifications/{id}', [NotificationController::class, 'deleteNotification']);


    // -- End Notifications --
});
