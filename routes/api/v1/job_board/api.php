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
        Route::group(['prefix' => 'opportunities'], function () {
            Route::get('public-offers', [WebOfferController::class, 'getPublicOffers'])->withoutMiddleware('auth:api');
            Route::get('private-offers', [WebOfferController::class, 'getOffers']);
            Route::get('apply-offer', [WebOfferController::class, 'applyOffer']);
            Route::post('index', [WebOfferController::class, 'index']);
        });

        // index show store update destroy (crud)
        Route::apiResources([
            'catalogues' => SkillController::class,
            'categories' => CategoryController::class,
            'offers' => OfferController::class,
            'skills' => SkillController::class,
            'academic-formations' => AcademicFormationController::class,
            'courses' => CourseController::class,
            'catalogues' => LanguageController::class,
            'languages' => LanguageController::class,
            'experiences' => ExperienceController::class,
            'references' => ReferenceController::class,
            'companies' => CompanyController::class,
            'professionals' => ProfessionalController::class,
        ]);

        Route::prefix('skill')->group(function () {
            Route::get('test', [SkillController::class, 'test']);
            Route::put('delete', [SkillController::class, 'delete']);
            Route::post('image', [SkillController::class, 'uploadImages']);
            Route::post('image/{image}', [SkillController::class, 'updateImage']);
            Route::delete('image/{image}', [SkillController::class, 'deleteImage']);
            Route::get('image', [SkillController::class, 'indexImage']);
            Route::get('image/{image}', [SkillController::class, 'showImage']);

            Route::prefix('file')->group(function () {
                Route::post('', [SkillController::class, 'uploadFiles']);
                Route::delete('{image}', [SkillController::class, 'deleteFile']);
                Route::get('', [SkillController::class, 'indexFile']);
                Route::get('{file}', [SkillController::class, 'showFile']);
            });

        });

        Route::prefix('company')->group(function () {
            Route::get('{id}', [CompanyController::class, 'show']);
            Route::get('{id}', [CompanyController::class, 'getProfesional']);
            Route::get('detach/{id}', [CompanyController::class, 'detachProfessional']);
            Route::put('{id}', [CompanyController::class, 'update']);
            Route::post('register', [CompanyController::class, 'register']);

        });

        Route::prefix('professional')->group(function () {
            Route::get('{id}', [ProfessionalController::class, 'getOffers']);
                Route::get('{id}', [ProfessionalController::class, 'getCompanies']);
              //   Route::get('test', function () {
                //  return 'test';
      //      });
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
            Route::get('test', [CourseController::class, 'test']);
            Route::put('delete', [CourseController::class, 'delete']);
            /*ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';*/
                Route::prefix('file')->group(function () {
                    Route::post('', [CourseController::class, 'uploadFiles']);
                    Route::delete('{image}', [CourseController::class, 'deleteFile']);
                    Route::get('', [CourseController::class, 'indexFile']);
                    Route::get('{file}', [CourseController::class, 'showFile']);
                 });
            });
        });

        Route::prefix('language')->group(function () {
            Route::get('test', [LanguageController::class, 'test']);
            Route::put('delete', [LanguageController::class, 'delete']);
            // ruta para hcer pruebas
        //Route::get('test', function () {
      //          return 'test';
      Route::prefix('file')->group(function () {
        Route::post('', [LanguageController::class, 'uploadFiles']);
        Route::delete('{image}', [LanguageController::class, 'deleteFile']);
        Route::get('', [LanguageController::class, 'indexFile']);
        Route::get('{file}', [LanguageController::class, 'showFile']);
     });
            });
     

        Route::prefix('experience')->group(function () {
            Route::get('test', [ExperienceController::class, 'test']);
            Route::put('delete', [ExperienceController::class, 'delete']);
            /* ruta para hcer pruebas
            Route::get('test', function () {
                return 'test';*/
                Route::prefix('file')->group(function () {
                    Route::post('', [ExperienceController::class, 'uploadFiles']);
                    Route::delete('{image}', [ExperienceController::class, 'deleteFile']);
                    Route::get('', [ExperienceController::class, 'indexFile']);
                    Route::get('{file}', [ExperienceController::class, 'showFile']);
                 });
                
            });
        

        Route::prefix('reference')->group(function () {
            Route::get('test', [ReferenceController::class, 'test']);
            Route::put('delete', [ReferenceController::class, 'delete']);
        
            // ruta para hcer pruebas
          //  Route::get('test', function () {
            //    return 'test';
            Route::prefix('file')->group(function () {
                Route::post('', [ReferenceController::class, 'uploadFiles']);
                Route::delete('{image}', [ReferenceController::class, 'deleteFile']);
                Route::get('', [ReferenceController::class, 'indexFile']);
                Route::get('{file}', [ReferenceController::class, 'showFile']);
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
            Route::post('professionals', [WebProfessionalController::class, 'getProfessionals']);
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


