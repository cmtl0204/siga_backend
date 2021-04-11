<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use phpseclib3\Math\BigInteger;

use App\Traits\StateActive;

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
    use \OwenIt\Auditing\Auditable;
    use StateActive;


    protected $connection = 'pgsql-app';
    protected $table = 'app.files';

    protected $fillable = [
        'name',
        'description',
        'extension',
        'directory',
    ];

    protected $appends = ['full_name', 'full_path'];

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
        return "{$this->id}.{$this->extension}";
    }

    public function getFullPathAttribute()
    {
        return "files/{$this->id}.{$this->extension}";
    }
}
