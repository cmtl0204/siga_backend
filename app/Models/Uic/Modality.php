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
        'parent_id',
        'name',
        'description'
    ];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];
    protected $cascadeDeletes = ['modalities','enrollment'];

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

    //relationships orden alfabetico
    public function career()
    {
        return $this->belongsTo(Career::class);
    }
    public function modalities()
    {
        return $this->hasMany('App\Models\Uic\Modality','parent_id');
    }
    public function modality()
    {
        return $this->belongsTo('App\Models\Uic\Modality','parent_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
   
    //accesors - crea un nuevo campo personalizado en la consulta 
    // public function getNameDescriptionAttribute() {
    //     return "{$this->attributes['name']} {$this->attributes['description']}";
    // }

    //mutators - trabajan directamente con los campos de la tabla transforma el registro a mayuscula 
    // public function setDescriptionAttribute ($value) {
    //     $this->attributes['description'] = strtoupper($value);
    // }

    //scopes añadir una clausula sencilla a mi consulta para no ponerlo desde el controller
    // public function scopeDescription ($query, $description) {
    //     if($description) {
    //         return $query->where('description','ILIKE','%$description%');
    //     }
    // }
}
