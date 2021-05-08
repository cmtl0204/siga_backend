<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobBoard\CompanyController;
use App\Http\Controllers\JobBoard\ProfessionalController;
use App\Http\Controllers\JobBoard\OfferController;
use App\Http\Controllers\JobBoard\CategoryController;
use App\Http\Controllers\JobBoard\SkillController;
use App\Http\Controllers\JobBoard\AcademicFormationController;
use App\Http\Controllers\JobBoard\CourseController;
use App\Http\Controllers\JobBoard\LanguageController;
use App\Http\Controllers\JobBoard\ExperienceController;
use App\Http\Controllers\JobBoard\ReferenceController;
use App\Http\Controllers\JobBoard\WebProfessionalController;
use App\Http\Controllers\JobBoard\WebOfferController;


//$middlewares = ['auth:api', 'check-institution', 'check-role', 'check-status', 'check-attempts', 'check-permissions'];
$middlewares = ['auth:api'];

// With Middleware
Route::middleware($middlewares)
    ->group(function () {
        Route::apiResources([
            'catalogues' => SkillController::class,
            'categories' => CategoryController::class,
            'offers' => OfferController::class,
            'skills' => SkillController::class,
            'academic-formations' => AcademicFormationController::class,
            'courses' => CourseController::class,
            'languages' => LanguageController::class,
            'experiences' => ExperienceController::class,
            'references' => ReferenceController::class,
            'companies' => CompanyController::class,
            'professionals' => ProfessionalController::class,
        ]);

        Route::prefix('skill')->group(function () {
            Route::get('test', [SkillController::class, 'test']);
            Route::post('image', [SkillController::class, 'uploadImages']);
            Route::post('image/{image}', [SkillController::class, 'updateImage']);
            Route::delete('image/{image}', [SkillController::class, 'deleteImage']);
            Route::get('image', [SkillController::class, 'indexImage']);
            Route::get('image/{image}', [SkillController::class, 'showImage']);
            Route::post('file', [SkillController::class, 'uploadFiles']);
            Route::post('file/{image}', [SkillController::class, 'updateFile']);
            Route::delete('file/{image}', [SkillController::class, 'deleteFile']);
            Route::get('file', [SkillController::class, 'indexFile']);
            Route::get('file/{file}', [SkillController::class, 'showFile']);
        });

        Route::prefix('company')->group( function () {
            Route::get('{id}', [CompanyController::class, 'show']);
            Route::put('{id}', [CompanyController::class, 'update']);
            Route::post('register', [CompanyController::class, 'register']);
        });

        Route::prefix('professional')->group(function () {
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('offer')->group(function () {
            Route::get('test', function () {
                return 'test';
            });
            Route::get('proffesionals/{offer}', [OfferController::class, 'getProfessionals']);
            Route::put('end-offer/{offer}', [OfferController::class, 'changeStatus']);
        });

        Route::prefix('academic-formation')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('course')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('language')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('experience')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('reference')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('web-professional')->group(function () {

        });
    });

// Without Middleware
Route::prefix('/')
    ->group(function () {
        // ruta para hcer pruebas
        Route::prefix('test')->group(function () {
            // ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';
            });
        });

        Route::prefix('web-professional')->group(function () {
            Route::get('total', [WebProfessionalController::class, 'total']);
            Route::get('professionals', [WebProfessionalController::class, 'getProfessionals']);
            Route::get('filter-categories', [WebProfessionalController::class, 'filterCategories']);
            Route::get('apply-professional', [WebProfessionalController::class, 'applyProfessional']);
        });

        Route::prefix('web-offer')->group(function () {
            Route::get('total', [WebOfferController::class, 'total']);
            Route::get('offers', [WebOfferController::class, 'getOffers']);
            Route::get('filter-categories', [WebOfferController::class, 'filterCategories']);
            Route::get('apply-offer', [WebOfferController::class, 'applyOffer']);
        });
    });

