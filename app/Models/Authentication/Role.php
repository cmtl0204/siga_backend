<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Catalogue;
use App\Models\App\Institution;

/**
 * @property BigInteger id
 * @property string code
 * @property string name
 */
class Role extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.roles';

    protected $fillable = [
        'code',
        'name',
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
    public function catalogues()
    {
        return $this->morphToMany(Catalogue::class, 'catalogueable');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function shortcuts()
    {
        return $this->hasMany(Shortcut::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Mutators
    function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper(Str::of($value)->slug('-'));
    }
}
