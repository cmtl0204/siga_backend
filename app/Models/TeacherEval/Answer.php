<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use App\Models\App\AnswerQuestion;

/**
 * @property BigInteger id
 * @property string name
 */

class Answer extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.answers';

    protected $fillable = [
        'code',
        'order',
        'name',
        'value'
    ];

    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function question()
    {
        return $this->belongsTo(Answer::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
   
    public function answerQuestion()
    {
        return $this->belongsTo(AnswerQuestion::class);
    }
    
      // Mutators
      public function setNameAttribute($value)
      {
          $this->attributes['name'] = strtoupper($value);
      }
  
      public function setCodeAttribute($value)
      {
          $this->attributes['code'] = strtoupper($value);
      }


    // Scopes

    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->where('code', 'ILIKE', "%$code%");
        }
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->orwhere('name', 'ILIKE', "%$name%");
        }
    }
    
}

