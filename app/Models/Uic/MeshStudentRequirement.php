<?php

namespace App\Models\Uic;

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

    protected $with = ['requirement', 'meshStudent'];

    protected $casts = [
        'observations' => 'array',
        'is_approved' => 'boolean',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',

    ];

    //Relationships
    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function meshStudent()
    {
        return $this->belongsTo(MeshStudent::class);
    }
}
