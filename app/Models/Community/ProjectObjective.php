<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Community\Project;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property String code
 * @property Text description
 * @property JSON verification_means
 * @property Boolean state
 */
class ProjectObjective extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;
    protected $connection = 'pgsql-community'; 
    protected $table = 'community.project_objectives'; // nombre del esquema.nombretabla
    protected $fillable = [
        'code',
        'description',
        'verification_means',
        'state'
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function parent()
    {
        return $this->belongsTo(ProjectObjective::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProjectObjective::class, 'parent_id');
    }
}