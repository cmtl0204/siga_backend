<?php

use App\Http\Controllers\Authentication\ModuleController;
use App\Models\Authentication\Permission;
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
$middlewares = ['auth:api', 'verified', 'check-role', 'check-institution', 'check-status', 'check-attempts', 'check-permissions'];
//$middlewares = ['auth:api'];

// With Middleware
Route::middleware($middlewares)
    ->prefix('/')
    ->group(function () {
        // ApiResources
        Route::apiResource('user-admins', UserAdministrationController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('permissions', PermissionController::class);
        Route::apiResource('routes', RouteController::class);
        Route::apiResource('shortcuts', ShortcutController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('systems', SystemController::class)->except('show');

        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('roles', [AuthController::class, 'getRoles'])
                ->withoutMiddleware(['check-institution', 'check-role', 'check-permissions']);
            Route::get('permissions', [AuthController::class, 'getPermissions'])
                ->withoutMiddleware(['check-institution', 'check-permissions']);
            Route::put('change-password', [AuthController::class, 'changePassword'])
                ->withoutMiddleware(['check-institution', 'check-role', 'check-permissions']);
            Route::post('transactional-code', [AuthController::class, 'generateTransactionalCode']);
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('logout-all', [AuthController::class, 'logoutAll']);
            Route::get('reset-attempts', [AuthController::class, 'resetAttempts'])
                ->withoutMiddleware(['check-institution', 'check-role', 'check-permissions']);
            Route::post('test', function (\Illuminate\Http\Request $request) {
                return $request->user()->markEmailAsVerified();

            })->withoutMiddleware('verified');
        });

        // User
        Route::prefix('user')->group(function () {
            Route::get('{username}', [UserController::class, 'show'])
                ->withoutMiddleware(['check-institution', 'check-role', 'check-permissions']);
            Route::post('filters', [UserController::class, 'index']);
            Route::post('avatars', [UserController::class, 'uploadAvatar']);
            Route::get('export', [UserController::class, 'export']);
        });

        // Role
        Route::prefix('role')->group(function () {
            Route::post('users', [RoleController::class, 'getUsers']);
            Route::post('permissions', [RoleController::class, 'getPermissions']);
            Route::post('assign-role', [RoleController::class, 'assignRole']);
            Route::post('remove-role', [RoleController::class, 'removeRole']);
        });

        // Module
        Route::prefix('module')->group(function () {
            Route::get('menus', [ModuleController::class, 'getMenus']);
        });
    });

// Without Middleware
Route::prefix('/')
    ->group(function () {
        // ApiResources
        Route::apiResource('systems', SystemController::class)->only(['show']);

        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('incorrect-password/{username}', [AuthController::class, 'incorrectPassword']);
            Route::post('password-forgot', [AuthController::class, 'passwordForgot']);
            Route::post('reset-password', [AuthController::class, 'resetPassword']);
            Route::post('user-locked', [AuthController::class, 'userLocked']);
            Route::post('unlock-user', [AuthController::class, 'unlockUser']);
            Route::post('email-verified', [AuthController::class, 'emailVerified']);
            Route::get('verify-email/{user}', [AuthController::class, 'verifyEmail']);
            Route::post('register-socialite-user', [AuthController::class, 'registerSocialiteUser']);
            Route::post('test-out', function (\Illuminate\Http\Request $request) {
                $request->user()->sendEmailVerificationNotification();
            });
        });
    });
