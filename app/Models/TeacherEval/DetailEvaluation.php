<?php

namespace App\Models\TeacherEval;

// Laravel
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use App\Models\Authentication\System;



class DetailEvaluation extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.detail_evaluations';

    protected static $instance;


    protected $fillable = [
    'detail_evaluationable',
    'result',
    ];

    protected $casts = [
        'result' = 'array'
    ];


    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }



    /*public function system()
    {
        return $this->belongsTo(System::class);
    }*/

}
