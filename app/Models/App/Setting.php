<?php

namespace App\Models\App;

use App\Traits\StateActive;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use StateActive;


    protected $connection = 'pgsql-app';
    protected $table = 'app.settings';

    protected $fillable = [];
}
