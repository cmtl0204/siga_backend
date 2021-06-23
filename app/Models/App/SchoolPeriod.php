<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;


class SchoolPeriod extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-app';
    protected $table = 'app.school_periods';

    protected static $instance;

    protected $fillable = [
        'code', 'name'
    ];
    protected $casts = [
        'start_date' => 'date:Y-m-d h:m:s',
        'end_date' => 'date:Y-m-d h:m:s',
        'ordinary_start_date' => 'date:Y-m-d h:m:s',
        'ordinary_end_date' => 'date:Y-m-d h:m:s',
        'extraordinary_start_date' => 'date:Y-m-d h:m:s',
        'extraordinary_end_date' => 'date:Y-m-d h:m:s',
        'especial_start_date' => 'date:Y-m-d h:m:s',
        'especial_end_date' => 'date:Y-m-d h:m:s',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }
   

}
