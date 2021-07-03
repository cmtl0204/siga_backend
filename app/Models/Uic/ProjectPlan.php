<?php

namespace App\Models\Uic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Uic\Project;

class ProjectPlan extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

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
    protected $cascadeDeletes = ['projects'];

    //Relationships
    public function projects()
    {
        return $this->hasMany(Project::class);
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
}
