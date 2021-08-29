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
use App\Http\Controllers\TeacherEval\EvaluationTypeController;
use App\Http\Controllers\TeacherEval\AnswerController;
use App\Http\Controllers\TeacherEval\AnswerQuestionController;
use App\Http\Controllers\TeacherEval\QuestionController;
use App\Http\Controllers\TeacherEval\ExtraCreditController;
use App\Http\Controllers\TeacherEval\ResearchController;
use App\Http\Controllers\TeacherEval\DetailEvaluation\DetailEvaluationController;
use App\Http\Controllers\TeacherEval\Evaluation\EvaluationController;
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
        //'evaluation'=> DetailEvaluationController::class,
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


     // rutas tabla answer
     Route::prefix('answer')->group(function () {
        Route::get('index', [AnswerController::class, 'index']);
        Route::get('show/{answer}', [AnswerController::class, 'show']);
        Route::post('store', [AnswerController::class, 'store']);
        Route::put('update/{answer}',  [AnswerController::class, 'update']);
        Route::put('delete',  [AnswerController::class, 'delete']);
    });
  // rutas tabla QUESTION
    Route::prefix('question')->group(function () {
        Route::post('store', [QuestionController::class, 'store']);
        Route::put('put/{question}', [QuestionController::class, 'update']);
        Route::get('index', [QuestionController::class, 'index']);
        Route::get('show/{question}', [QuestionController::class, 'show']);
        Route::put('delete', [QuestionController::class, 'delete']);
    });

    Route::prefix('evaluation-detail')->group(function () {
        Route::get('all', [DetailEvaluationController::class, 'index']);
        Route::get('get', [DetailEvaluationController::class, 'getall']);
        Route::get('show/{detail}', [DetailEvaluationController::class, 'show']);
        Route::post('create',  [DetailEvaluationController::class, 'store']);
        Route::put('update/{detail}',  [DetailEvaluationController::class, 'update']);
        Route::put('delete',  [DetailEvaluationController::class, 'delete']);
        //Route::delete('destroy/{detail}',  [DetailEvaluationController::class, 'destroy']);
    });


    Route::prefix('evaluation')->group(function () {
        Route::get('all', [EvaluationController::class, 'index']);
        //Route::get('allEva', [EvaluationController::class, 'getAllEvaluations']);
        Route::get('gestion/{id}', [EvaluationController::class, 'getGestionAcademicaById']);
        Route::get('show/{evaluation}', [EvaluationController::class, 'show']);
        Route::post('create',  [EvaluationController::class, 'store']);
        Route::post('create/{id}',  [EvaluationController::class, 'saveTeacher']);
        Route::put('update/{detail}',  [EvaluationController::class, 'update']);
        Route::put('delete',  [EvaluationController::class, 'delete']);
        //Route::delete('destroy/{detail}',  [EvaluationController::class, 'destroy']);
        //pruebas
        Route::post('profe', [EvaluationController::class, 'profe']);
        Route::post('school', [EvaluationController::class, 'school']);
        Route::get('getall', [EvaluationController::class, 'getall']);
        Route::get('getet', [EvaluationController::class, 'getEt']);
        Route::get('teachers', [EvaluationController::class, 'getTeachers']);
        Route::put('deleteT',  [EvaluationController::class, 'deletet']);
        Route::get('result',  [EvaluationController::class, 'getResult']);
    });

       // rutas tabla answer
       Route::prefix('answer')->group(function () {
        Route::get('index', [AnswerController::class, 'index']);
        Route::get('show/{answer}', [AnswerController::class, 'show']);
        Route::post('store', [AnswerController::class, 'store']);
        Route::put('update/{answer}',  [AnswerController::class, 'update']);
        Route::put('delete',  [AnswerController::class, 'delete']);
    });


    Route::prefix('credit')->group(function () {
        Route::get('getAll', [ExtraCreditController::class, 'getAll']);
        Route::get('credit', [ExtraCreditController::class, 'getExtraCredit']);
        Route::get('show/{id}', [ExtraCreditController::class, 'show']);
        Route::post('store/{id}', [ExtraCreditController::class, 'store']);
        Route::put('update/{id}',  [ExtraCreditController::class, 'update']);
        Route::delete('delete/{id}',  [ExtraCreditController::class, 'delete']);


    });


    Route::prefix('investigacion')->group(function () {
        Route::get('getAll', [ResearchController::class, 'getAll']);
        Route::get('research', [ResearchController::class, 'getInvestigacion']);
        Route::get('show/{id}', [ResearchController::class, 'show']);
        Route::post('store/{id}', [ResearchController::class, 'store']);
        Route::put('update/{id}',  [ResearchController::class, 'update']);
        Route::delete('delete/{id}',  [ResearchController::class, 'delete']);


    });

    Route::prefix('evaluation-type')->group(function () {
        Route::get('index', [EvaluationTypeController::class, 'index']);
        Route::post('store', [EvaluationTypeController::class, 'store']);
        Route::get('show/{id}', [EvaluationTypeController::class, 'show']);
        Route::put('update/{evaluationType}', [EvaluationTypeController::class, 'update']);
        Route::put('delete', [EvaluationTypeController::class, 'delete']);
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

});
