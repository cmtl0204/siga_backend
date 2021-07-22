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

use App\Http\Controllers\Cecy\RegistrationController;
use App\Http\Controllers\Cecy\PlanificationInstructorController;

use App\Http\Controllers\Cecy\DetailRegistrationController;

//$middlewares = ['auth:api', 'check-institution', 'check-role', 'check-status', 'check-attempts', 'check-permissions'];
$middlewares = ['auth:api'];

// With Middleware
Route::middleware($middlewares)
    ->prefix('/')
    ->group(function () {
        // ApiResources
        Route::apiResources([
            'user-admins' => UserAdministrationController::class,
            'users' => UserController::class,
            'permissions' => PermissionController::class,
            'routes' => RouteController::class,
            'shortcuts' => ShortcutController::class,
            'roles' => RoleController::class,
            'systems' => SystemController::class,
        ]);

        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('roles', [AuthController::class, 'getRoles'])->withoutMiddleware(['check-permissions']);
            Route::get('permissions', [AuthController::class, 'getPermissions']);
            Route::put('change-password', [AuthController::class, 'changePassword']);
            Route::post('transactional-code', [AuthController::class, 'generateTransactionalCode']);
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('logout-all', [AuthController::class, 'logoutAll']);
            Route::post('permissions', [AuthController::class, 'getPermissions']);
            Route::get('reset-attempts', [AuthController::class, 'resetAttempts']);
        });

        // User
        Route::prefix('user')->group(function () {
            Route::get('{username}', [UserController::class, 'show']);
            Route::post('filters', [UserController::class, 'index']);
            Route::post('avatars', [UserController::class, 'uploadAvatar']);
            Route::get('export', [UserController::class, 'export']);
        });

        // Role
        Route::prefix('roles')->group(function () {
            Route::post('users', [RoleController::class, 'getUsers']);
            Route::post('permissions', [RoleController::class, 'getPermissions']);
            Route::post('assign-role', [RoleController::class, 'assignRole']);
            Route::post('remove-role', [RoleController::class, 'removeRole']);
        });
    });

    Route::apiResource('detailRegistrations', DetailRegistrationController::class);
    Route::put('detailRegistration/delete', [DetailRegistrationController::class, 'delete']);
    Route::get('excel/detailRegistration', [DetailRegistrationController::class, 'excel']);


// Without Middleware
Route::prefix('/')
    ->group(function () {
        // Auth
        Route::prefix('auth')->group(function () {
            Route::get('validate-attempts/{username}', [AuthController::class, 'validateAttempts']);
            Route::post('password-forgot', [AuthController::class, 'passwordForgot']);
            Route::post('reset-password', [AuthController::class, 'resetPassword']);
            Route::post('user-locked', [AuthController::class, 'userLocked']);
            Route::post('unlock-user', [AuthController::class, 'unlockUser']);
        });

    });


    Route::apiResource('topics', TopicController::class);
    Route::put ('topic/delete', [TopicController::class, 'delete']);
    Route::apiResource('planificationInstructors', PlanificationInstructorController::class);

    Route::apiResource('registrations', RegistrationController::class);
Route::apiResource('planificationInstructors', PlanificationInstructorController::class);
Route::get('excel/registration-export', [RegistrationController::class, 'exportTest']);
Route::get('pdf/registration-participant', [RegistrationController::class, 'exportRegisterParticipant']);
Route::get('pdf/mensual-programation', [RegistrationController::class, 'exportProgramationMensual']);
Route::get('pdf/register-potografic', [RegistrationController::class, 'exportRegisterPothografic']);

Route::get('excel/needCourse-export', [RegistrationController::class, 'exportNeedCourse']);
Route::get('excel/register-potografic-export', [RegistrationController::class, 'exportExeclRegisterPothografic']);
Route::get('excel/programation-mensual-export', [RegistrationController::class, 'exportExeclProgramationMensual']);
Route::get('excel/registration-participant-export', [RegistrationController::class, 'exportExeclRegisterParticipant']);

Route::put('registration/delete', [RegistrationController::class, 'delete']);
        Route::put('planificationInstructor/delete', [PlanificationInstructorController::class, 'delete']);
    
    // Route::prefix('registration')
    //     ->group(function () {
           // Route::put('topic/delete', [TopicController::class, 'delete']);
           // Route::put('planificationInstructor/delete', [PlanificationInstructorController::class, 'delete']);
        //     });
        // });
