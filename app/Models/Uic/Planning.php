<?php

namespace App\Models\Uic;

// Laravel

use App\Models\App\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;




/**
 * @property BigInteger id
 * @property String name
 * @property Integer number
 * @property String description
 */

class Planning extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.plannings';

    protected $fillable = [
        'name',
        'number',
        'description'
    ];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected $with = [];
    protected $cascadeDeletes = ['enrollments', 'eventPlannings'];

    /*Relatioship*/
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function eventPlannings()
    {
        return $this->hasMany(EventPlanning::class);
    }
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'ILIKE', "%$name%");
        }
    }
    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description', 'ILIKE', "%$description%");
        }
    }
}
