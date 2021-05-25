<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Detail_Registration;


/**
 * @property BigInteger id
 * @property date date
 * @property integer day_hours
 * @property json observations
 */

class Skill extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.attendances';

    protected static $instance;

    protected $fillable = [
        'date',
        'day_hour',
        'observation'
    ];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    // Instance
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Relationships
    public function detailRegistration()
    {
        return $this->hasMany(Detail_Registration::class);
    }

   
    //acesors
    public function getFullDateAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['date']}";
    }

    public function getFullDayHourAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['day_hour']}";
    }


    public function getFullObservationAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['observation']}";
    }



    //mutatos
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = strtoupper($value);
    }

    public function setDayHourAttribute($value)
    {
        $this->attributes['day_hour'] = strtoupper($value);
    }

    public function setObservationAttribute($value)
    {
        $this->attributes['observation'] = strtoupper($value);
    }

    //Scopers
    public function scopeDate($query, $date)
    {
        if ($date) {
            return $query->where('date', 'ILIKE', "%$date%");
        }
    }

    public function scopeDayHour($query, $day_hour)
    {
        if ($day_hour) {
            return $query->where('day_hour', 'ILIKE', "%$day_hour%");
        }
    }

    {
        public function scopeObservation($query, $observation)
        if ($observation) {
            return $query->where('observation', 'ILIKE', "%$observation%");
        }
    }

}
