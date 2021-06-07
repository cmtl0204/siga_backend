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
 */

class SelfResult extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.self_results';

    protected $fillable = [
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
   /*
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }



   */

    // Accessors para concatenar dos o mas atributos eje. name+lastName= newCamp FULLNAME
    /*public function getFullQuestionAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['description']}";
    }*/

    // Mutators cambiar el formato de entrada de texto minusculas mayusculas
    /*public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
    }*/

    // Scopes para hacer consultas al modelo
   /* public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->where('description', 'ILIKE', "%$description%");
        }
    }*/
}
