<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Institution;

/**
 * @property BigInteger id
 * @property json actions
 */

class Permission extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use Auditing;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.permissions';

    protected $fillable = [
        'actions'
    ];

    protected $casts = [
        'actions' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected static $instance;

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
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function shortcut()
    {
        return $this->hasOne(Shortcut::class);
    }
}
