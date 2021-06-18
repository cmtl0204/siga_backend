<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TeacherEval\Evaluation;

class SchoolPeriod extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-app';
    protected $table = 'app.school_periods';

    protected $fillable = [
      'name',
      'start_date'
    ];


    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
    ];
    // Instance
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public static function evaluation()
    {
        return $this->hasMany(Evaluation::class);
    }

    // Mutators
   /* public function setMainStreetAttribute($value)
    {
        $this->attributes['main_street'] = strtoupper($value);
    }

    public function setSecondaryStreetAttribute($value)
    {
        $this->attributes['secondary_street'] = strtoupper($value);
    }

    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = strtoupper($value);
    }

    public function setPostCodeAttribute($value)
    {
        $this->attributes['post_code'] = strtoupper($value);
    }*/

}
