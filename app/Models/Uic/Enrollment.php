<?php

namespace App\Models\Uic;

use App\Models\App\Status;
use App\Models\Uic\Modality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

/**
 * @property BigInteger id
 * @property string date
 * @property string code
 * @property json observations
 */

class Enrollment extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;
    
    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.enrollments';
    protected $with = ['modality','status']; //belongs to ,'shoolPeriod'

    protected $fillable = [
        'id',
        'date',
        'code'
    ];
    // protected $cascadeDeletes = ['projects'];

    protected $casts = [
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];


    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    //relationships
    public function modality() {
        return $this->belongsTo(Modality::class);
    }
// no hay el modelo
    // public function shoolPeriod() {
    //     return $this->belongsTo(SchoolPeriod::class);
    // }
//  no hay ese modelo
    // public function meshStudent(){
    //     return $this->belongsTo(MeshStudent::class);
    // }
    // public function projects(){
    //     return $this->hasMany(Project::class);
    // }
    public function status() {
        return $this->belongsTo(Status::class);
    }
    public function scopeDate($query, $date)
    {
        if ($date) {
            return $query->where('date', 'ILIKE', "%$date%");
        }
    }
    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->orWhere('code', 'ILIKE', "%$code%");
        }
    }
}