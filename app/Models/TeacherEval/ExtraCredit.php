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

class ExtraCredit extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.extra_credits';

    protected static $instance;


    protected $fillable = [
        'diploma_yavirac',
        'title_fourth_level',
        'OCS_member',
        'governing_processes',
        'process_nouns',
        'support_processes'
    ];

    protected $casts = [
        'diploma_yavirac' => 'double',
        'title_fourth_level' => 'double',
        'OCS_member' => 'double',
        'governing_processes' => 'double',
        'process_nouns' => 'double',
        'support_processes' => 'double'
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
