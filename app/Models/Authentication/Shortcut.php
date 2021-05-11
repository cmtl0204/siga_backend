<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

/**
 * @property BigInteger id
 * @property string name
 * @property string description
 * @property string image
 */
class Shortcut extends Model implements Auditable
{
    use HasFactory;
    use Auditing;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.shortcuts';

    protected static $instance;

    protected $fillable = [
        'name',
        'description',
        'image',
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
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function routePermission()
    {
        return $this->hasOneThrough(Route::class, Permission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
