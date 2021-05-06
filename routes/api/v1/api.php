<?php

use \App\Http\Requests\Authentication\Auth\CreateClientRequest;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Artisan;

Route::get('init', function (CreateClientRequest $request) {
    if (env('APP_ENV') != 'local') {
        return 'El sistema se encuentra en producción.';
    }

    DB::select('drop schema if exists public cascade;');
    DB::select('drop schema if exists authentication cascade;');
    DB::select('drop schema if exists app cascade;');
    DB::select('drop schema if exists registration cascade;');

    DB::select('create schema authentication;');
    DB::select('create schema app;');
    DB::select('create schema registration;');

    Artisan::call('migrate --seed');
    Artisan::call('passport:client', [
        '--password' => true,
        '--name' => $request->input('client_name'),
        '--quiet' => true,
    ]);

    $clientSecret = DB::select("select secret from oauth_clients where name='" . $request->input('client_name') . "'");

    return response()->json([
        'msg' => [
            'Los esquemas fueron creados correctamente.',
            'Las migraciones fueron creadas correctamente',
            'Cliente para la aplicación creado correctamente',
        ],
        'client' => $clientSecret[0]->secret
    ]);
});
