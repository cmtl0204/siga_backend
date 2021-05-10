<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Authentication\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function store(){
        Client::create([
            'user_id'=>1,
            'name'=>'asd',
            'secret'=>'asdasdsa',
            'provider'=>'users',
            'redirect'=>'asdasd',
            'personal_access_client'=>true,
            'password_client'=>false,
            'revoked'=>false
        ]);
    }
}
