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

//$middlewares = ['auth:api', 'check-institution', 'check-role', 'check-status', 'check-attempts', 'check-permissions'];
$middlewares = ['auth:api'];

// With Middleware
Route::middleware($middlewares)
    ->prefix('/')
    ->group(function () {
        // ApiResources Solo Crud metodos get post put delete
        // Route::apiResources([
        //     // 'registrations'=> RegistrationController::class, crea los 5 metodos crud en un controller
            

        // ]);

        //ruta separado con "detail-registration" Rutas que no necesiten crud o que sean extras a un crud
        // Route::prefix('registration')->group(function () {
        //     Route::get('register', [RegistrationController::class, 'register']);
        //     Route::post('xyz', [RegistrationController::class, 'xyz']);
            

        // });


    });

// Without Middleware
Route::prefix('/')
    ->group(function () {
        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('validate-attempts/{username}', [AuthController::class, 'validateAttempts']);
            Route::post('password-forgot', [AuthController::class, 'passwordForgot']);

        });
    });
