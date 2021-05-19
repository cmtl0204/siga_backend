<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use App\Models\App\File;
use App\Models\App\Image;
use App\Models\App\Catalogue;


/**
 * @property BigInteger id
 * @property date date
 * @property string number
 */

class Skill extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.skills';

    protected $fillable = [
        'date',
        'number',
    ];

    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
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
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // Accessors
    public function getFullDateAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['date']}";
    }

    public function getFullNumberAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['number']}";
    }

    // Mutators
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = strtoupper($value);
    }

    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = strtoupper($value);
    }

    // Scopes
    public function scopeDate($query, $date)
    {
        if ($date) {
            return $query->where('date', 'ILIKE', "%$date%");
        }
    }

    public function scopeNumber($query, $number)
    {
        if ($number) {
            return $query->where('number', 'ILIKE', "%$number%");
        }
    }

}