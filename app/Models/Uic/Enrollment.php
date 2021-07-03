<?php

namespace App\Models\Uic;

use App\Models\App\MeshStudent;
use App\Models\App\SchoolPeriod;
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
    use CascadeSoftDeletes;
    use SoftDeletes;
    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.enrollments';
    //hacer despues
    protected $with = []; //belongs to ,'shoolPeriod'

    protected $fillable = [
        'date',
        'code'
    ];
    protected $cascadeDeletes = ['projects'];

    protected $casts = [
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    //relationships
    public function modality()
    {
        return $this->belongsTo(Modality::class);
    }
    // no hay el modelo
    public function shoolPeriod()
    {
        return $this->belongsTo(SchoolPeriod::class);
    }
    //  no hay ese modelo
    public function meshStudent()
    {
        return $this->belongsTo(MeshStudent::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }
    public function status()
    {
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
