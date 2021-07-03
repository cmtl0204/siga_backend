<?php

namespace App\Models\Uic;

use App\Models\Uic\Planning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Dyrynda\Database\Support\CascadeSoftDeletes;
/**
 * @property BigInteger id
 * @property string name
 * @property string description
 */
class Event extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use CascadeSoftDeletes;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.events';
    //hacer despues
    protected $with = [];

    protected $fillable = [
        'name',
        'description'
    ];

    protected $cascadeDeletes = ['EventPlannings'];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

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
