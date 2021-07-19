<?php

namespace App\Models\Uic;

// Laravel

use App\Models\App\MeshStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Type;
use App\Models\App\Teacher;
use Dyrynda\Database\Support\CascadeSoftDeletes;

//use App\Models\Uic\Project;



/**
 * @property BigInteger id
 * @property json observations
 */

class Tutor extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.tutors';

    protected $fillable = [];


    protected $casts = [
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected $with = ['projectPlan', 'teacher'];
    protected $cascadeDeletes = [];

    /*Relatioship*/
    public function projectPlan()
    {
        return $this->belongsTo(ProjectPlan::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    //scope

    public function scopeProject($query)
    {
        return $query->where('project_plan_id', '=', null);
    }
}
