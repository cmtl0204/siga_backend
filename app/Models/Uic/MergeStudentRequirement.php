<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Uic\Requirement;
//use App\Models\Uic\MergeStudents;

class MergeStudentRequirement extends Model
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.merge_student_requirements';

    // Instance
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    //Relationships
    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    //public function mergeStudents()
    //{
    //    return $this->hasMany(MergeStudents::class);
    //}

}
