<?php

namespace App\Models\JobBoard;

use App\Models\App\File;
use Brick\Math\BigInteger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use \OwenIt\Auditing\Auditable as Auditing;

use App\Traits\StateActive;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string description
 * @property boolean state
 */
class Skill extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use StateActive;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.skills';

    protected $fillable = [
        'description',
        'state',
        'full_path',
    ];

    protected $hidden = ['description'];

    protected $appends = ['full_description'];

    public static function getInstance($id)
    {
        $model = new Skill();
        $model->id = $id;
        return $model;
    }

    // Relationships
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function file()
    {
        return $this->morphOne(File::class,'fileable');
    }

    public function files()
    {
        return $this->morphMany(File::class,'fileable');
    }

    // Mutators
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
    }

    // Scopes
    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description', 'ILIKE', "%$description%");
        }
    }

    // Accessors
    public function getFullDescriptionAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['description']}";
    }
}
