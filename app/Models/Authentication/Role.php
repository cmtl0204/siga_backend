<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\App\Catalogue;
use App\Models\App\Institution;


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

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function shortcuts()
    {
        return $this->hasMany(Shortcut::class);
    }

    public function catalogues()
    {
        return $this->morphToMany(Catalogue::class, 'catalogueable');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    // Mutators
    function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper(Str::of($value)->slug('-'));
    }
}
