<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controller\Authentication\AuthController;
use App\Http\Controller\Authentication\UserController;
use App\Http\Controller\Authentication\RoleController;
use App\Http\Controller\Authentication\PermissionController;
use App\Http\Controller\Authentication\RouteController;
use App\Http\Controller\Authentication\ShortcutController;
use App\Http\Controller\Authentication\SystemController;
use App\Http\Controller\Authentication\UserAdministrationController;
//use App\Http\Controllers\Uic\EnrollmentController;
//use App\Http\Controllers\Uic\ModalityController;

use App\Http\Controller\Uic\ProjectController;
use App\Http\Controller\Uic\ProjectPlanController;
use App\Http\Controller\Uic\RequirementController;
use App\Http\Controllers\Uic\MergeStudentRequirementController;

$middlewares = ['auth:api'];

Route::middleware($middlewares)
    ->group(function () {
        Route::apiResources([
            //'modalities' => ModalityController::class,
            //'enrollments' => EnrollmentController::class,
            'requirements'=> RequirementController::class,
            'merge-student-requirements'=> MergeStudentRequirementController::class,
            'projects'=> ProjectController::class,
            'project-plans'=> ProjectPlanController::class
        ]);

        Route::prefix('requirement')->group(function(){
            Route::put('delete',[RequirementController::class,'delete']);
        });
        Route::prefix('merge-student-requirement')->group(function(){
            Route::put('delete',[MergeStudentRequirementController::class,'delete']);
        });
        Route::prefix('project')->group(function(){
            Route::put('delete',[ProjectController::class,'delete']);
        });
        Route::prefix('project-plan')->group(function(){
            Route::put('delete',[ProjectPlanController::class,'delete']);
        });
});

    
Route::prefix('/')->group(function () {
        Route::apiResources([
            //'modalities'=>ModalityController::class,
            //'enrollments' => EnrollmentController::class
            'requirements'=> RequirementController::class,
            'merge-student-requirements'=> MergeStudentRequirementController::class,
            'projects'=> ProjectController::class,
            'project-plans'=> ProjectPlanController::class
        ]);
        //Route::prefix('modality')->group(function(){
        //    Route::get('show-modalities/{modalityId}',[ModalityController::class,'showModalities']);
        //    Route::put('delete',[ModalityController::class,'delete']);
        //});
        //Route::prefix('enrollment')->group(function(){
        //    Route::put('delete',[EnrollmentController::class,'delete']);
        //});
        Route::prefix('requirement')->group(function(){
            Route::put('delete',[RequirementController::class,'delete']);
        });
        Route::prefix('merge-student-requirement')->group(function(){
            Route::put('delete',[MergeStudentRequirementController::class,'delete']);
        });
        Route::prefix('project')->group(function(){
            Route::put('delete',[ProjectController::class,'delete']);
        });
        Route::prefix('project-plan')->group(function(){
            Route::put('delete',[ProjectPlanController::class,'delete']);
        });
        // Route::prefix('auth')->group(function () {
        //     Route::get('validate-attempts/{username}', [AuthController::class, 'validateAttempts']);
        //     Route::post('password-forgot', [AuthController::class, 'passwordForgot']);
            
        // });
    });
    