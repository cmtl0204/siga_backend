<?php

namespace App\Models\Uic;

use App\Models\App\File;
use App\Models\App\MeshStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Uic\Requirement;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class MeshStudentRequirement extends Model implements Auditable
{
    use HasFactory;
    use Auditing;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.mesh_student_requirements';
    use SoftDeletes;
    use CascadeSoftDeletes;

    private static $instance;

    protected $with = ['requirement', 'meshStudent', 'files', 'file'];
    protected $cascadeDeletes = ['files'];

    protected $fillable = [
        'observations'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
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

    //Relationships
    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function meshStudent()
    {
        return $this->belongsTo(MeshStudent::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    //scope

    public function scopeStudent($query, $student)
    {
        if ($student) {
            return $query->where('mesh_student_id', '=', $student);
        }
    }
}
