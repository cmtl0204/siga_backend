<?php

namespace App\Models\Uic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Uic\Project;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use App\Models\App\File;

class ProjectPlan extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.project_plans';

    protected $fillable = [
        'title',
        'description',
        'act_code',
        'approval_date',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];
    protected $with = [];
    protected $cascadeDeletes = ['projects', 'files'];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    //Relationships
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function tutors()
    {
        return $this->hasMany(Tutor::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function scopeTitle($query, $title)
    {
        if ($title) {
            return $query->where('title', 'ILIKE', "%$title%");
        }
    }
    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description', 'ILIKE', "%$description%");
        }
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
