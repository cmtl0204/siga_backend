<?php

namespace App\Models\Uic;

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

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.requirements';

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'is-required' => 'boolean',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];
    protected $with = [];
    protected $cascadeDeletes = ['meshStudentRequirements', 'files'];
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
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
