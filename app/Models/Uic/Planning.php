<?php

namespace App\Models\Uic;

// Laravel
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
 * @property String event
 * @property Date start_date
 * @property Date end_date
 * @property String description
 */

class Planning extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;


    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.plannings';

     protected $fillable = [

     'id',
     'name',
     'number',
     'event',
     'start_date',
     'end_date',
     'description'];

    protected $casts = [
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

    /*Relatioship*/
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'ILIKE', "%$name%");
        }
    }
    public function scopeEvent($query, $event)
    {
        if ($event) {
            return $query->orWhere('event', 'ILIKE', "%$event%");
        }
    }
    public function scopeStartDate($query, $startDate)
    {
        if ($startDate) {
            return $query->orWhere('start_date', 'ILIKE', "%$startDate%");
        }
    }
    public function scopeEndDate($query, $endDate)
    {
        if ($endDate) {
            return $query->orWhere('end_date', 'ILIKE', "%$endDate%");
        }
    }
    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description', 'ILIKE', "%$description%");
        }
    }
}
