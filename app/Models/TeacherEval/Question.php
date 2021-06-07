<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\File;
use App\Models\App\Image;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string code
 * @property integer order
 * @property string name
 * @property string description
 */

class Question extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.questions';

    protected $fillable = [
        'code',
        'order',
        'name',
        'description',

    ];

    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
    ];
    protected $cascadeDeletes = ['files','evaluationTypes','images','status','type'];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Relationships

    public function evaluationTypes()
    {
        return $this->belongsTo(EvaluationType::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    // Accessors para concatenar dos o mas atributos eje. name+lastName= newCamp FULLNAME
    public function getFullQuestionAttribute()
    {
        return "{$this->attributes['code']}.{$this->attributes['name']}..{$this->attributes['description']}";
    }

    public function getlName_DescriptionAttribute()
    {
        return "{$this->attributes['name']}.{$this->attributes['description']}";
    }

    // Mutators cambiar el formato de entrada de texto minusculas mayusculas
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
    }

    // Scopes para hacer consultas al modelo
    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->where('code', 'ILIKE', "%$code%");
        }
    }

    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orwhere('description', 'ILIKE', "%$description%");
        }
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->orwhere('name', 'ILIKE', "%$name%");
        }
    }


}
