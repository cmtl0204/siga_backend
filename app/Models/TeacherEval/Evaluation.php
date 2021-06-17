<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

//Models
use App\Models\TeacherEval\EvaluationType;
use App\Models\TeacherEval\Teacher;
use App\Models\TeacherEval\SchoolPeriod;
use App\Models\TeacherEval\Status;

/**
 * @property BigInteger id
 * @property string description
 */

class Evaluation extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher-eval.skills';

    protected $fillable = [
        'result',
        'percentage',
    ];

//Instance

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }


    // Relationships
    public function evaluationType()
    {
        return $this->belongsTo(EvaluationType::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schoolPeriod()
    {
        return $this->morphMany(SchoolPeriod::class, 'school_periodable');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
