<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App\CatalogueController;
use App\Http\Controllers\App\ImageController;
use App\Http\Controllers\App\TeacherController;
use App\Http\Controllers\App\InstitutionController;
use App\Http\Controllers\App\FileController;
use App\Http\Controllers\App\LocationController;
use App\Http\Controllers\App\EmailController;
use App\Http\Controllers\App\SubjectController;


Route::apiResource('catalogues', CatalogueController::class);
Route::apiResource('locations', LocationController::class)->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);
Route::get('countries', [LocationController::class, 'getCountries'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);

//prueba ruta de subject
Route::apiResource('subjects', SubjectController::class);





Route::group(['prefix' => 'image'], function () {
    Route::get('download', [ImageController::class, 'download']);
});

Route::group(['prefix' => 'file'], function () {
    Route::get('download', [FileController::class, 'download']);
});

Route::group(['prefix' => 'teachers'], function () {
    Route::post('upload_image', [TeacherController::class, 'uploadImage']);
});

Route::group(['prefix' => 'institutions'], function () {
    Route::post('assign_institution', [InstitutionController::class, 'assignInstitution']);
    Route::post('remove_institution', [InstitutionController::class, 'removeInstitution']);
});

Route::group(['prefix' => 'emails'], function () {
    Route::post('send', [EmailController::class, 'send']);
});

Route::get('test', function () {
    return 'hola mundo';
});

