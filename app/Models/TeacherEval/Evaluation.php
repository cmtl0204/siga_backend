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

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.evaluations';

    protected static $instance;


    protected $fillable = [
    'result',
    'percentage'
    ];

    /*protected $casts = [
        'name' => 'array',
        'percentage' => 'array'
    ];*/



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

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function schoolPeriod()
    {
        return $this->belongsTo(SchoolPeriod::class);
    }

    public function evaluationType()
    {
        return $this->belongsTo(EvaluationType::class);
    }

  /*  public function detailEvaluationable()
    {
        return $this->morphTo();
    }*/

    public function detailEvaluation()
    {
        return $this->morphMany(DetailEvaluation::class, 'detail_evaluationable');
    }

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
