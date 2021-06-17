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
use App\Models\TeacherEval\Evaluation;
use App\Models\Authentication\System;
use phpseclib3\Math\BigInteger;

use Dyrynda\Database\Support\CascadeSoftDeletes;



/**
 * @property BigInteger id
 * @property double result


 */


class DetailEvaluation extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.detail_evaluations';

    protected static $instance;


    protected $fillable = [
    'result',
    'evaluation_id'
    ];

    /*protected $casts = [
        'result' => 'array'
    ];*/

    protected $hidden = [
    'detail_evaluationable_type',
    'detail_evaluationable_id'
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }


    public function detailEvaluationable()
    {
        return $this->morphTo();
    }


    /*public function evaluation()
    {
        return $this->morphMany(Evaluation::class, 'detailEvaluationable');
    }*/

    public function scopeResult($query, $result)
    {
        if ($result) {
            return $query->where('result', 'ILIKE', "$result");
        }
    }

}
