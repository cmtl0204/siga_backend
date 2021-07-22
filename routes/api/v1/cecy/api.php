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
use App\Http\Controllers\Cecy\AttendanceController;
use App\Http\Controllers\Cecy\CourseController;
use App\Http\Controllers\Cecy\InstructorController;
use App\Http\Controllers\Cecy\PrerequisiteController;
use App\Models\Cecy\Prerequisite;

use App\Http\Controllers\Cecy\RegistrationController;
use App\Http\Controllers\Cecy\PlanificationInstructorController;
use App\Http\Controllers\Cecy\DetailRegistrationController;

use App\Http\Controllers\Cecy\TopicController;
use App\Models\Cecy\DetailRegistration;

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
    Route::apiResource('attendances', AttendanceController::class);
Route::put ('attendance/delete', [AttendanceController::class, 'delete']);



    Route ::apiResource ('/prerequisites',PrerequisiteController::class);
    Route ::apiResource ('/courses',CourseController::class);
    Route ::apiResource ('/instructors',InstructorController::class);
    
    
    Route::prefix('prerequisite')->group(function () { 
        Route::put('delete', [DetailRegistrationController::class, 'delete']);
        Route::prefix('file')->group(function () {
            Route::post('', [DetailRegistrationController::class, 'uploadFile']);
            Route::put('delete', [DetailRegistrationController::class, 'deleteFile']);
            Route::get('', [DetailRegistrationController::class, 'indexFile']);
            Route::put('update/{file}', [DetailRegistrationController::class, 'updateFile']);
            Route::get('{file}', [DetailRegistrationController::class, 'showFile']);                
            });
    });
    
    Route::prefix('detailRegistration')->group(function () { 
    Route::put('delete', [DetailRegistrationController::class, 'delete']);
    Route::put('record-grades/{detailRegistration}', [DetailRegistrationController::class, 'recordGrades']);
    Route::prefix('file')->group(function () {
        Route::post('', [DetailRegistrationController::class, 'uploadFile']);
        Route::put('delete', [DetailRegistrationController::class, 'deleteFile']);
        Route::get('', [DetailRegistrationController::class, 'indexFile']);
        Route::put('update/{file}', [DetailRegistrationController::class, 'updateFile']);
        Route::get('{file}', [DetailRegistrationController::class, 'showFile']);                
        });
});


    
    Route::put('instructor/delete', [InstructorController::class, 'delete']);

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



Route::apiResource('registrations', RegistrationController::class);
Route::apiResource('planificationInstructors', PlanificationInstructorController::class);
Route::get('excel/registration-export', [RegistrationController::class, 'exportTest']);


// Route::prefix('registration')
//     ->group(function () {
        Route::put('registration/delete', [RegistrationController::class, 'delete']);
        Route::put('planificationInstructor/delete', [PlanificationInstructorController::class, 'delete']);
    //     });
    // });

    Route::apiResource('topics', TopicController::class);
    Route::put ('topic/delete', [TopicController::class, 'delete']);
    Route::apiResource('planificationInstructors', PlanificationInstructorController::class);
    
    // Route::prefix('registration')
    //     ->group(function () {
           // Route::put('topic/delete', [TopicController::class, 'delete']);
           // Route::put('planificationInstructor/delete', [PlanificationInstructorController::class, 'delete']);
        //     });
        // });
