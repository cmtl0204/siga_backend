<?php

use App\Exports\UsersExport;
use App\Http\Controllers\Authentication\AuthController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('login')->group(function () {
    Route::get('{driver}', [AuthController::class, 'redirectToProvider']);
    Route::get('{driver}/callback', [AuthController::class, 'handleProviderCallback']);
});

Route::get('export', function () {
    return Excel::download(new UsersExport, 'users.pdf');
});

Route::get('generate-password/{password}', function ($password) {
    return \Illuminate\Support\Facades\Hash::make($password);
});


