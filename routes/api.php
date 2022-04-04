<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\JoinRequestController;

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

Route::middleware('auth:sanctum')->post('dashboard/user', function (Request $request) {

});




Route::prefix('dashboard')->group(function () {

    //Admin Login Route.
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function(){

        // Start Roles && Permissions.

        Route::get('permissions', [RoleController::class, 'permissions']);
        Route::resource('roles', RoleController::class);

        //End Roles && Permissions.

        Route::resource('join-requests', JoinRequestController::class);
    });

});






