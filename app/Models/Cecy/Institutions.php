<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\DocBlock\Description;
use App\Models\App\Institution;
use Dyrynda\Database\Support\CascadeSoftDeletes;

/**
 * @property BigInteger id
 * @property string ruc
 * @property string logo
 * @property string name
 * @property string slogan
 * @property string code
 * 
 */

class Institutions extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.institutions';

    protected static $instance;
    protected $cascadeDeletes = ['institution','authority'];

    protected $fillable = [
        'ruc',
        'logo',
        'name',
        'slogan',
        'code',

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


//public function setCodeAttribute($value)
//{
  //  $this->attributes['code'] = strtolower($value);
//}

//public function setNameAttribute($value)
//{
  //  $this->attributes['name'] = strtoupper($value);
//}
public function institution()
{
    return $this->belongsTo(Institution::class);
}
public function authority()
{
    return $this->belongsTo(Authority::class);
}
}


