<?php

namespace App\Models\Uic;

// Laravel

use App\Models\App\Catalogue;
use App\Models\App\MeshStudent;
use App\Models\App\Student;
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
 * @property String company_work
 */

class StudentInformation extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.student_informations';

    protected $fillable = [
        'company_work'
    ];


    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected $with = ['student', 'relationLaboralCareer', 'companyArea', 'companyPosition'];
    protected $cascadeDeletes = [];

    /*Relatioship*/
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function relationLaboralCareer()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function companyArea()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function companyPosition()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
