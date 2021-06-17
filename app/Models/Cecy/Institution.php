<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Cecy\Institution;
use phpDocumentor\Reflection\DocBlock\Description;

/**
 * @property BigInteger id
 * @property string code
 * @property string ruc
 * @property string logo
 * @property string name
 * @property string slogan
 * 
 */

class Institution extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy_institutions';

    protected static $instance;

    protected $fillable = [
        'code',
        'ruc',
        'logo',
        'name',
        'slogan',

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
  
///
public static function getInstance($id)
{
    if (is_null(static::$instance)) {
        static::$instance = new static;
    }
    static::$instance->id = $id;
    return static::$instance;
}

public function setCodeAttribute($value)
{
    $this->attributes['code'] = strtolower($value);
}

public function setNameAttribute($value)
{
    $this->attributes['name'] = strtoupper($value);
}

public function teachers()
{
    return $this->morphedByMany(Teacher::class, 'institutionable');
}

public function careers()
{
    return $this->hasMany(Career::class);
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}

public function users()
{
    return $this->morphedByMany(User::class, 'institutionable', 'app.institutionables');
}
}


}
