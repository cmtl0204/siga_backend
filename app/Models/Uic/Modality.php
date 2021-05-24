<?php

namespace App\Models\Uic;

use App\Models\App\Career;
use App\Models\App\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

/**
 * @property BigInteger id
 * @property string name
 * @property string description
 */

class Modality extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.modalities';
    protected $with = ['career','status','modality'];

    protected $fillable = [
        'name',
        'description',
        'names'
    ];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];
    protected $cascadeDeletes = ['modalities'];

    //campos extras funciona con accesor
    //protected $appends = ['name_description'];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    //relationships
    public function career()
    {
        return $this->belongsTo(Career::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function modality()
    {
        return $this->belongsTo('App\Models\Uic\Modality','parent_id');
    }
    public function modalities()
    {
        return $this->hasMany('App\Models\Uic\Modality','parent_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
   
    //accesor - crea campo personalizado, es necesario el array attributes['nombreAtributo']
    public function getNameDescriptionAttribute(){
        return "{$this->attributes['name']}: {$this->attributes['description']}";
    }

    //mutators - muta el registro de la tabla, es necesario llamar el método en el controller 
    public function setDescriptionAttribute($value) {
        $this->attributes['description'] = strtoupper($value);
    }
}
