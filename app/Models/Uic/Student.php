<?php

namespace App\Models\Uic;

// Laravel

use App\Models\App\Career;
use App\Models\App\File;
use App\Models\App\MeshStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

/**
 * @property BigInteger id
 * @property String name
 * @property Integer number
 * @property String description
 */

class Student extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;
    protected $connection = 'pgsql-uic';
    protected $table = 'uic.students';

    protected $fillable = [
       
    ];

    protected $casts = [
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected $with = ['meshStudent','projectPlan'];
    
    /*Relatioship*/
    public function meshStudent()
    {
        return $this->belongsTo(MeshStudent::class);
    }
    public function projectPlan()
    {
        return $this->belongsTo(ProjectPlan::class);
    }
}
