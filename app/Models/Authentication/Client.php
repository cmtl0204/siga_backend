<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\Client as PassportClient;
use OwenIt\Auditing\Contracts\Auditable;

// Traits State
use App\Traits\StateActive;


class Client extends PassportClient implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActive;


    public function username()
    {
        return 'username';
    }
}
