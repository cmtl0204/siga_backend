<?php

use App\Http\Controllers\App\FileController;
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
use App\Http\Controllers\Uic\EventController;
use App\Http\Controllers\Uic\EventPlanningController;
use App\Http\Controllers\Uic\InformationStudentController;
use App\Http\Controllers\Uic\ModalityController;
use App\Http\Controllers\Uic\PlanningController;
use App\Http\Controllers\Uic\TutorController;
use App\Http\Controllers\Uic\ProjectController;
use App\Http\Controllers\Uic\ProjectPlanController;
use App\Http\Controllers\Uic\RequirementController;
use App\Http\Controllers\Uic\MeshStudentRequirementController;

$middlewares = ['auth:api'];

Route::middleware($middlewares)
    ->group(function () {
        Route::apiResources([
            'modalities' => ModalityController::class,
            'enrollments' => EnrollmentController::class,
            'plannings' => PlanningController::class,
            'tutors' => TutorController::class,
            'requirements' => RequirementController::class,
            'mesh-student-requirements' => MeshStudentRequirementController::class,
            'projects' => ProjectController::class,
            'project-plans' => ProjectPlanController::class

        ]);
        Route::prefix('modality')->group(function () {
            Route::get('show-modalities/{modalityId}', [ModalityController::class, 'showModalities']);
            Route::put('delete', [ModalityController::class, 'delete']);
        });
        Route::prefix('enrollment')->group(function () {
            Route::put('delete', [EnrollmentController::class, 'delete']);
        });
        Route::prefix('planning')->group(function () {
            Route::put('delete', [PlanningController::class, 'delete']);
        });

        Route::prefix('tutor')->group(function () {
            Route::put('delete', [TutorController::class, 'delete']);
        });
        Route::prefix('requirement')->group(function () {
            Route::put('delete', [RequirementController::class, 'delete']);
            Route::prefix('file')->group(function () {
                Route::post('', [RequirementController::class, 'uploadFile']);
                Route::put('delete', [RequirementController::class, 'deleteFile']);
                Route::get('', [RequirementController::class, 'indexFile']);
                Route::put('update/{file}', [RequirementController::class, 'updateFile']);
                Route::get('{file}', [RequirementController::class, 'showFile']);
            });
        });
        Route::prefix('mesh-student-requirement')->group(function () {
            Route::put('delete', [MeshStudentRequirementController::class, 'delete']);
        });
        Route::prefix('project')->group(function () {
            Route::put('delete', [ProjectController::class, 'delete']);
        });
        Route::prefix('project-plan')->group(function () {
            Route::put('delete', [ProjectPlanController::class, 'delete']);
            Route::prefix('file')->group(function () {
                Route::post('', [ProjectPlanController::class, 'uploadFile']);
                Route::put('delete', [ProjectPlanController::class, 'deleteFile']);
                Route::get('', [ProjectPlanController::class, 'indexFile']);
                Route::put('update/{file}', [ProjectPlanController::class, 'updateFile']);
                Route::get('{file}', [ProjectPlanController::class, 'showFile']);
            });
        });
    });

//without middleware
Route::prefix('/')->group(function () {
    Route::apiResources([
        'modalities' => ModalityController::class,
        'enrollments' => EnrollmentController::class,
        'plannings' => PlanningController::class,
        'event-plannings' => EventPlanningController::class,
        'tutors' => TutorController::class,
        'requirements' => RequirementController::class,
        'mesh-student-requirements' => MeshStudentRequirementController::class,
        'projects' => ProjectController::class,
        'project-plans' => ProjectPlanController::class,
        'events' => EventController::class,
        'information-students' => InformationStudentController::class

    ]);
    Route::prefix('modality')->group(function () {
        Route::get('show-modalities/{modalityId}', [ModalityController::class, 'showModalities']);
        Route::put('delete', [ModalityController::class, 'delete']);
    });
    Route::prefix('enrollment')->group(function () {
        Route::put('delete', [EnrollmentController::class, 'delete']);
    });
    Route::prefix('planning')->group(function () {
        Route::put('delete', [PlanningController::class, 'delete']);
    });
    Route::prefix('event-planning')->group(function () {
        Route::put('delete', [EventPlanningController::class, 'delete']);
        Route::prefix('file')->group(function () {
            Route::post('', [EventPlanningController::class, 'uploadFile']);
            Route::put('delete', [EventPlanningController::class, 'deleteFile']);
            Route::get('', [EventPlanningController::class, 'indexFile']);
            Route::put('update/{file}', [EventPlanningController::class, 'updateFile']);
            Route::get('{file}', [EventPlanningController::class, 'showFile']);
        });
    });
    Route::prefix('event')->group(function () {
        Route::put('delete', [EventController::class, 'delete']);
    });
    Route::prefix('tutor')->group(function () {
        Route::put('delete', [TutorController::class, 'delete']);
    });
    Route::prefix('requirement')->group(function () {
        Route::put('delete', [RequirementController::class, 'delete']);
        Route::prefix('file')->group(function () {
            Route::post('', [RequirementController::class, 'uploadFile']);
            Route::put('delete', [RequirementController::class, 'deleteFile']);
            Route::get('', [RequirementController::class, 'indexFile']);
            Route::put('update/{file}', [RequirementController::class, 'updateFile']);
            Route::get('{file}', [RequirementController::class, 'showFile']);
        });
    });
    Route::prefix('mesh-student-requirement')->group(function () {
        Route::put('delete', [MeshStudentRequirementController::class, 'delete']);
    });
    Route::prefix('project')->group(function () {
        Route::put('delete', [ProjectController::class, 'delete']);
    });
    Route::prefix('project-plan')->group(function () {
        Route::put('delete', [ProjectPlanController::class, 'delete']);
        Route::prefix('file')->group(function () {
            Route::post('', [ProjectPlanController::class, 'uploadFile']);
            Route::put('delete', [ProjectPlanController::class, 'deleteFile']);
            Route::get('', [ProjectPlanController::class, 'indexFile']);
            Route::put('update/{file}', [ProjectPlanController::class, 'updateFile']);
            Route::get('{file}', [ProjectPlanController::class, 'showFile']);
        });
    });
    Route::prefix('information-student')->group(function () {
        Route::put('delete', [InformationStudentController::class, 'delete']);
    });
});
