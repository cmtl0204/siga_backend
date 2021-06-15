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
use phpseclib3\Math\BigInteger;
use App\Models\TeacherEval\DetailEvaluation;

/**
 * @property BigInteger id
 * @property double name
 * @property double description

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

    protected $casts = [
        'result' => 'array',
        'percentage' => 'array'
    ];

    protected $hidden = ['detail_evaluationable_type'];

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

    public function detailEvaluation()
    {
        return $this->morphMany(DetailEvaluation::class, 'detail_evaluationable');
    }



}
