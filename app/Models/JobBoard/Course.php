<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Brick\Math\BigInteger;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Catalogue;
use App\Models\App\File;

/**
 * @property BigInteger id
 * @property string name
 * @property string description
 * @property date start_date
 * @property date end_date
 * @property integer hours
 */
class Course extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.courses';
    protected $with = ['type','institution','certificationType','area'];

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'hours',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d'
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Relationships
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function institution()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function certificationType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function area()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }


    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
    }

    // Scopes
    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->where('description', 'ILIKE', "%$description%");
        }
    }
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->orWhere('name', 'ILIKE', "%$name%");
        }
    }
}
