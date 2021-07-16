<?php

namespace App\Models\Uic;

use App\Models\App\Catalogue;
use App\Models\Uic\Planning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

// Application
use Dyrynda\Database\Support\CascadeSoftDeletes;

use Carbon\Carbon;

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
    use SoftDeletes;
    protected $connection = 'pgsql-uic';
    protected $table = 'uic.events';
    //hacer despues
    protected $with = ['planning', 'name'];

    protected $fillable = [
        'start_date',
        'end_date'
    ];

    protected $cascadeDeletes = [];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }
    public function name()
    {
        return $this->belongsTo(Catalogue::class);
    }

    //scope

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name_id', 'ILIKE', "%$name%");
        }
    }

    public function scopePlanning($query, $planning)
    {
        if ($planning) {
            return $query->orWhere('planning_id', 'ILIKE', "%$planning%");
        }
    }

    public function scopeDate($query)
    {

        $date = Carbon::now();
        $date = $date->toDateString();

        return $query->whereDate('end_date', '>=', "%$date%");
    }
}