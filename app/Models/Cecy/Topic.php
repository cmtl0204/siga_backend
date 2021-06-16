<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Cecy\ParentCode;
use App\Models\App\Cecy\Type;
use App\Models\App\Cecy\Course;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property String description
 */

class Topic extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.topics';

    protected static $instance;

    protected $fillable = [
        'description'
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
    public function parentCode()
    {
        return $this->belongsTo(Topic::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
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
