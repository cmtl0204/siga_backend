<?php

namespace App\Models\Uic;

use App\Models\App\Career;
use App\Models\App\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Uic\MeshStudentRequirement;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Requirement extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.requirements';
    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'is-required' => 'boolean',
        'is-is_solicitable' => 'boolean',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }
    protected $with = ['career'];
    protected $cascadeDeletes = ['meshStudentRequirements', 'files'];
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public function career()
    {
        return $this->belongsTo(Career::class);
    }
    public function meshStudentRequirements()
    {
        return $this->hasMany(MeshStudentRequirement::class);
    }
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'ILIKE', "%$name%");
        }
    }
}
