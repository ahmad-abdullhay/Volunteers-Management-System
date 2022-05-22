<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\AuthController;
use App\Http\Controllers\Mobile\UserController;
use App\Http\Controllers\Mobile\MetricController;
use App\Http\Controllers\Mobile\EventController;
use App\Http\Controllers\Dashboard\Badge\BadgeController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/sign-up', [AuthController::class, 'signUp']);

Route::group(['middleware' => ['auth:sanctum', 'type.user']], function (){

    Route::get('me', [AuthController::class, 'me']);

    Route::get('/test', function (){
        dd(auth()->user());
    });

    Route::post('/join-event', [UserController::class, 'joinEvent']);

    Route::post('/change-join-event-status', [UserController::class, 'ChangeVolunteerJoinEventStatus']);

    //Start Metric Routes.
    Route::post('metric/insert-value', [MetricController::class, 'insertMetricForUser']);

    //End Metric Routes.

    //Start Event Routes.
    //Get only pending users that want to join the event.
    Route::get('event/users/pending/{event}', [EventController::class, 'getEventsRequests']);

    //Get Accepted users.
    Route::get('event/users/{event}  ', [EventController::class, 'getEventUsers']);

    Route::get('events', [EventController::class, 'index']);




//    Route::get('badges/{user_id}', [BadgeController::class, 'index']);

    //End Event Routes.
    Route::get('badges', [BadgeController::class, 'index']);



});
