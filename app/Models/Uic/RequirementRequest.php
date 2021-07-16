<?php

namespace App\Models\Uic;

// Laravel

use App\Models\App\Career;
use App\Models\App\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

use Carbon\Carbon;




/**
 * @property BigInteger id
 * @property String name
 * @property Integer number
 * @property String description
 */

class RequirementRequest extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;
    protected $connection = 'pgsql-uic';
    protected $table = 'uic.requirement_requests';

    protected $fillable = [
        'date'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected $with = ['requirement','meshStudentRequirement'];

    /*Relatioship*/
    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }
    public function meshStudentRequirement()
    {
        return $this->hasMany(MeshStudentRequirement::class);
    }
}
