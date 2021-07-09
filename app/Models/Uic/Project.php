<?php

namespace App\Models\Uic;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

//use App\Models\Uic\Enrollment;
/**
 * @property BigInteger id
 * @property String title
 * @property String description
 */
class Project extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.projects';
    //protected $with = ['projectPlan'];

    protected $fillable = [
        'title',
        'description',
        'score'
    ];

    protected $casts = [
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected $cascadeDeletes = ['tutors'];

    //Relationships
    public function projectPlan()
    {
        return $this->belongsTo(ProjectPlan::class);
    }
    public function tutors()
    {
        return $this->hasMany(Tutor::class);
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
