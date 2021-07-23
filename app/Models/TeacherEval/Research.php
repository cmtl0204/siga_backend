<?php

namespace App\Models\TeacherEval;

// Laravel
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application

use App\Models\App\Status;
use App\Models\App\Teacher;
use App\Models\App\SchoolPeriod;
use phpseclib3\Math\BigInteger;
use App\Models\TeacherEval\DetailEvaluation;
use App\Models\TeacherEval\EvaluationType;




/**
 * @property BigInteger id
 * @property double result
 * @property double percentage

 */

class Research extends Model implements Auditable
{
    use HasFactory;
    use Auditing;


    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.researchs';

    protected static $instance;


    protected $fillable = [
        'inv_auto_eval',
        'inv_pares',
        'inv_coodinador',
        'total'
    ];

    protected $casts = [
        'inv_auto_eval' => 'double',
        'inv_pares' => 'double',
        'inv_coodinador' => 'double',
        'total' => 'double'
    ];



    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }



    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }



  /*  public function detailEvaluationable()
    {
        return $this->morphTo();
    }*/


    public function scopeResult($query, $result)
    {
        if ($result) {
            return $query->where('result', 'ILIKE', "$result");
        }
    }


    public function scopePercentage($query, $percentage)
    {
        if ($percentage) {
            return $query->orWhere('result', 'ILIKE', "$percentage");
        }
    }

}
