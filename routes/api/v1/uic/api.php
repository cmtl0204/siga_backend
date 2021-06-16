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

use App\Http\Controllers\Uic\MergeStudentRequirementController;
use App\Http\Controllers\Uic\ProjectController;
use App\Http\Controllers\Uic\ProjectPlanController;
use App\Http\Controllers\Uic\RequirementController;

$middlewares = ['auth:api'];

Route::middleware($middlewares)
    ->group(function () {
        Route::apiResources([
            'modalities' => ModalityController::class,
            'enrollments' => EnrollmentController::class,
            'Requirements'=> RequirementController::class,
            'MergeStudentRequirements'=> MergeStudentRequirementController::class,
            'Projects'=> ProjectController::class,
            'ProjectPlans'=> ProjectPlanController::class
        ]);
});

    
Route::prefix('/')->group(function () {
        Route::apiResources([
            'modalities'=>ModalityController::class,
            'enrollments' => EnrollmentController::class
        ]);
        Route::prefix('modality')->group(function(){
            Route::get('show-modalities/{modalityId}',[ModalityController::class,'showModalities']);
            Route::put('delete',[ModalityController::class,'delete']);
        });
        Route::prefix('enrollment')->group(function(){
            Route::put('delete',[EnrollmentController::class,'delete']);
        });
        Route::prefix('requirement')->group(function(){
            Route::put('delete',[RequirementController::class,'delete']);
        });
        Route::prefix('mergeStudentRequirement')->group(function(){
            Route::put('delete',[MergeStudentRequirementController::class,'delete']);
        });
        Route::prefix('project')->group(function(){
            Route::put('delete',[ProjectController::class,'delete']);
        });
        Route::prefix('projectPlan')->group(function(){
            Route::put('delete',[ProjectPlanController::class,'delete']);
        });
        // Route::prefix('auth')->group(function () {
        //     Route::get('validate-attempts/{username}', [AuthController::class, 'validateAttempts']);
        //     Route::post('password-forgot', [AuthController::class, 'passwordForgot']);
            
        // });
    });
    