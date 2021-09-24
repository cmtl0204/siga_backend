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


use App\Http\Controllers\Portfolio\PeaController;
use App\Http\Controllers\Portfolio\UnitController;
use App\Http\Controllers\Portfolio\ContentController;
use App\Http\Controllers\Portfolio\DidacticResourceController;
use App\Http\Controllers\Portfolio\MethodologicalStrategyController;
use App\Http\Controllers\Portfolio\RelationLearningResultController;
use App\Http\Controllers\Portfolio\LearningResultController;

//$middlewares = ['auth:api', 'check-institution', 'check-role', 'check-status', 'check-attempts', 'check-permissions'];
// $middlewares = ['auth:api', 'verified', 'check-role', 'check-institution', 'check-status', 'check-attempts', 'check-permissions'];
$middlewares = [];

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

        // portfolio
        //Route::apiResource('peas', PeaController::class);

        Route::prefix('pea')->group(function () {
            Route::get('teachers/subjects', [PeaController::class, 'getSubjects']);

        });



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
        // portfolio

        Route::put('pea/{pea}', [PeaController::class, 'update']);

        Route::get('export/{pea}', [PeaController::class, 'generatePea']);


        //Route::put('learning-result/{learningResult}', [LearningResultController, 'update']);

        Route::apiResources([
            'peas' => PeaController::class,
            'units' => UnitController::class,
            'contents' => ContentController::class,
            'didactic-resources' => DidacticResourceController::class,
            'methodological-strategies' => MethodologicalStrategyController ::class,
            'relation-learning-results' => RelationLearningResultController ::class,
            'learning-results' => LearningResultController ::class,
            'unit' => UnitController::class,
        ]);



        Route::put('unit/{unit}' , [UnitController::class, 'update']);
        Route::put('content/{content}' , [ContentController::class, 'update']);
        Route::put('didactic-resource/{didacticResource}' , [DidacticResourceController::class, 'update']);
        Route::put('methodological-strategy/{methodologicalStrategy}' , [MethodologicalStrategyController::class, 'update']);
        Route::put('relation-learning-result/{relationLearningResult}' , [RelationLearningResultController::class, 'update']);

        Route::prefix('learning-results')->group(function () {
            Route::delete('delete/{id}', [LearningResultController::class, 'delete']);
            Route::get('parents', [LearningResultController::class, 'getParentLearningResults']);
            Route::get('headers', [LearningResultController::class, 'show']);

            //Route::post('create' , [LearningResultController::class, 'createLearning']);

        });

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
