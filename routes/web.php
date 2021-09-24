<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Models\Portfolio\Pea;
use Illuminate\Support\Facades\Route;

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


Route::get('test/{id}', function ($id) {
    $pea = Pea::first();
    $pdf = PDF::loadView('reports.portfolio.pea', ['pea'=>$pea]);
    return $pdf->download('pea.pdf');
});
