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
use App\Http\Controllers\Cecy\CourseController;
use App\Http\Controllers\Cecy\PlanificationController;
use App\Models\Cecy\Planification;

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
        
        //Courses
        Route::prefix('course')->group(function () {
            Route::get('all', [CourseController::class, 'index']);
            Route::post('store', [CourseController::class, 'storeCourse']);
            Route::put('approval/{course}', [CourseController::class, 'approvalCourse']);
            Route::get('responsables', [CourseController::class, 'getResponsables']);
            Route::put('tutor-assignment/{planification}', [CourseController::class, 'tutorAssignment']);   
            Route::get('{courseId}', [CourseController::class, 'getCourse']);
                       
        });

        Route::prefix('planification')->group(function () {
            Route::get('all', [PlanificationController::class, 'getPlanifiations']);       
            Route::post('createPlanification', [PlanificationController::class, 'createPlanification']);
            Route::put('{planification}', [PlanificationController::class, 'updatePlanification']);
          
                       
        });
        

   


    });
