<?php

namespace App\Models\TeacherEval;

// Laravel
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use App\Models\App\Teacher;
use App\Models\App\SchoolPeriod;
use phpseclib3\Math\BigInteger;
use App\Models\TeacherEval\DetailEvaluation;
use App\Models\TeacherEval\EvaluationType;

use Dyrynda\Database\Support\CascadeSoftDeletes;


/**
 * @property BigInteger id
 * @property double result
 * @property double percentage

 */

class Evaluation extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    protected static $instance;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.evaluation_types';

    protected $fillable = [
        'name',
        'code',
        'percentage',
        'global_percentage'
    ];
    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
    ];

    public static function getInstance($id){
        if(is_null(static::$instance)){
            static::$instance = new static;
        }
        static::$instance -> id = $id;
        return static::$instance;
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


    public function schoolPeriod()
    {
        return $this->belongsTo(SchoolPeriod::class);
    }

    public function evaluationType()
    {
        return $this->belongsTo(EvaluationType::class);
    }

    //relantioships
    public function parent(){
        return $this->belongsTo(EvaluationType::class, 'parent_id');
    }
    public function children(){
        return $this->hasMany(EvaluationType::class, 'parent_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


        // Scopes
        public function scopeName($query, $name)
        {
            if ($name) {
                return $query->where('name', 'ILIKE', "%$name%");
            }
        }

        protected $cascadeDeletes = ['parent', 'status'];
}
