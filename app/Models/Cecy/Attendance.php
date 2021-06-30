<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\App\Cecy\DetailRegistration;


/**
 * @property BigInteger id
 * @property String description
 */

class Attendance extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.attendances';

    protected static $instance;

    protected $fillable = [
        'date',
        'day_hours',
        'observations'

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
    return $this->belongsTo(etailRegistration::class);
}



//acesors
//public function getFullDescriptionAttribute()
// {
//    return "{$this->attributes['id']}.{$this->attributes['description']}";
//}


//mutatos
//public function setDescriptionAttribute($value)
//{
//    $this->attributes['description'] = strtoupper($value);
//}

//Scopers
// public function scopeDescription($query, $description)
//{
 //   if ($description) {
 //       return $query->where('description', 'ILIKE', "%$description%");
 //   }
//}

}
