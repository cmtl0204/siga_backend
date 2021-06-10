<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

class SchoolPeriod extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;


    protected $connection = 'pgsql-app';
    protected $table = 'app.schoolPeriods';

    protected $fillable = [];
}
