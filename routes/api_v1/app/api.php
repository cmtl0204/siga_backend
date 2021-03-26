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
use App\Http\Controllers\App\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResource('catalogues', CatalogueController::class);
Route::apiResource('locations', LocationController::class)->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);
Route::get('countries', [LocationController::class, 'getCountries'])->withoutMiddleware(['auth:api', 'check-institution', 'check-role', 'check-attempts', 'check-status', 'check-permissions']);

Route::group(['prefix' => 'images'], function () {
    Route::get('avatars', [ImageController::class, 'getAvatar']);
    Route::post('avatars', [ImageController::class, 'createAvatar']);
});

Route::group(['prefix' => 'teachers'], function () {
    Route::post('upload_image', [TeacherController::class, 'uploadImage']);
});

Route::group(['prefix' => 'institutions'], function () {
    Route::post('assign_institution', [InstitutionController::class, 'assignInstitution']);
    Route::post('remove_institution', [InstitutionController::class, 'removeInstitution']);
});

Route::post('upload', [FileController::class, 'upload']);

Route::group(['prefix' => 'emails'], function () {
    Route::post('send', [EmailController::class, 'send']);
});

Route::group(['prefix' => 'chats'], function () {
    Route::post('send_all', [ChatController::class, 'sendAll']);
    Route::post('send_direct', [ChatController::class, 'sendDirect']);
});

Route::get('test', function () {
    return 'hola mundo';
});
