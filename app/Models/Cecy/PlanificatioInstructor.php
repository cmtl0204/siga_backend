<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property BigInteger id
 */

class Module extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.registrations';

    protected static $instance;

    // protected $fillable = [
    //     'date',
    //     'nnumber'
    // ];

    // protected $casts = [
    //     'deleted_at' => 'date:Y-m-d h:m:s',
    //     'created_at' => 'date:Y-m-d h:m:s',
    //     'updated_at' => 'date:Y-m-d h:m:s',
    // ];

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
    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }

    public function planifications()
    {
        return $this->hasMany(Planification::class);
    }
}
