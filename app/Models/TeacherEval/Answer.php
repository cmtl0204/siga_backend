<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\File;
use App\Models\App\Image;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string description
 */

class Answer extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.answer';

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

    // Relationships
    public function answerQuestion()
    {
        return $this->belongsTo(Answer::class);
    }

    public function answerQuestion()
    {
        return $this->belongsTo(Question::class);
    }

    public function Question()
    {
        return $this->belongsTo(Answer::class);
    }

    /* Accessors
    public function getFullDescriptionAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['description']}";
    }*/

    // Mutators
    public function setDescriptionAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    // Scopes
    public function scopeDescription($query, $code)
    {
        if ($code) {
            return $query->where('code', 'ILIKE', "%$code%");
        }
    }
}
