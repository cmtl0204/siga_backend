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
use App\Http\Controllers\Uic\EnrollmentController;
use App\Http\Controllers\Uic\ModalityController;

$middlewares = ['auth:api'];

Route::middleware($middlewares)
    ->group(function () {
        Route::apiResources([
            'modalities' => ModalityController::class,
            'enrollments' => EnrollmentController::class
        ]);
});

    
Route::prefix('/')->group(function () {
        Route::apiResources([
            'modalities'=>ModalityController::class,
            'enrollments' => EnrollmentController::class
        ]);
        Route::prefix('modality')->group(function(){
            Route::get('show-modalities/{modalityId}',[ModalityController::class,'showModalities']);
        });
        // Route::prefix('auth')->group(function () {
        //     Route::get('validate-attempts/{username}', [AuthController::class, 'validateAttempts']);
        //     Route::post('password-forgot', [AuthController::class, 'passwordForgot']);
            
        // });
    });
    