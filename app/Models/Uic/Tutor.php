<?php

namespace App\Models\Uic;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Type;
use App\Models\App\Teacher;

//use App\Models\Uic\Project;



/**
 * @property BigInteger id
 * @property json observations
 */

class Tutor extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.tutors';

    protected $fillable = [

     'observation'];
     

     protected $casts = [
        'observations' => 'array',
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

   /*Relatioship*/
    // public function project()
    // {
    //     return $this->belongsTo(Project::class);
    // }

    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class);
    // }

    // public function type()
    // {
    //     return $this->belongsTo(Type::class);
    // }
}
