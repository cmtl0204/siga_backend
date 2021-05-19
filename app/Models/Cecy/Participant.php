<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Authentication;
use App\Models\App\App;

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
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function type()
    {
        return $this->hasMany(Catalogue::class);
    }
}
