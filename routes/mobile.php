<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\AuthController;
use App\Http\Controllers\Mobile\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/sign-up', [AuthController::class, 'signUp']);

Route::group(['middleware' => ['auth:sanctum', 'type.user']], function (){

    Route::get('/test', function (){
        dd(auth()->user());
    });

    Route::post('/join-event', [UserController::class, 'joinEvent']);
    
    Route::post('/change-join-event-status', [UserController::class, 'ChangeVolunteerJoinEventStatus']);

});
