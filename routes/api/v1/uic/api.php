<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Authentication\UserController;
use App\Http\Controllers\Authentication\RoleController;
use App\Http\Controllers\Authentication\PermissionController;
use App\Http\Controllers\Authentication\RouteController;
use App\Http\Controllers\Authentication\ShortcutController;
use App\Http\Controllers\Authentication\SystemController;
use App\Http\Controllers\Authentication\UserAdministrationController;
use App\Http\Controllers\Uic\PlanningController;
use App\Http\Controllers\Uic\TutorController;

$middlewares = ['auth:api'];

// With Middleware
Route::middleware($middlewares)
    ->group(function () {
        // ApiResources
        Route::apiResources([
            'plannings' => PlanningController::class,
            'tutors' => TutorController::class

        ]);

    });


// Without Middleware
Route::prefix('/')
    ->group(function () {

        Route::apiResources([
            'plannings' => PlanningController::class,
            'tutors' => TutorController::class
        ]);

        Route::prefix('planning')->group(function(){
            Route::put('delete',[PlanningController::class,'delete']);
        });

        Route::prefix('tutor')->group(function(){
            Route::put('delete',[TutorController::class,'delete']);
        });


        /* Auth
        Route::prefix('auth')->group(function () {
            Route::get('validate-attempts/{username}', [AuthController::class, 'validateAttempts']);
            Route::post('password-forgot', [AuthController::class, 'passwordForgot']);

        });*/
    });
