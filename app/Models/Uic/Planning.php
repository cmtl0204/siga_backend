<?php

namespace App\Models\Uic;

// Laravel

use App\Models\App\Career;
use App\Models\App\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

use Carbon\Carbon;




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
    use CascadeSoftDeletes;
    protected $connection = 'pgsql-uic';
    protected $table = 'uic.plannings';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected $with = ['career', 'events'];
    protected $appends = ['career_planning'];
    protected $cascadeDeletes = ['enrollments', 'events'];

    /*Relatioship*/
    public function career()
    {
        return $this->belongsTo(Career::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
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
    public function scopeDate($query)
    {

        $date = Carbon::now();
        $date = $date->toDateString();

        return $query->whereDate('end_date', '>=', "%$date%");
    }
    // Accessors
    public function getCareerPlanningAttribute()
    {
        return "{$this->career['short_name']} - {$this->attributes['name']}";
    }
}
