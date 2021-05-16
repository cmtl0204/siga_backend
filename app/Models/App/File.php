<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use phpseclib3\Math\BigInteger;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property BigInteger id
 * @property string name
 * @property string description
 * @property string extension
 * @property string directory
 */
class File extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-app';
    protected $table = 'app.files';

    protected $fillable = [
        'name',
        'description',
        'extension',
        'directory',
    ];

    protected $hidden = ['fileable_type'];

    protected $appends = ['full_name', 'full_path', 'partial_path'];

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
    public function fileable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'ILIKE', "%$name%");
        }
    }

    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description', 'ILIKE', "%$description%");
        }
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return "{$this->attributes['name']}.{$this->attributes['extension']}";
    }

    public function getFullPathAttribute()
    {
        return "files/{$this->attributes['id']}.{$this->attributes['extension']}";
    }

    public function getPartialPathAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['extension']}";
    }

    function setExtensionAttribute($value)
    {
        $this->attributes['extension'] = strtolower($value);
    }
}
