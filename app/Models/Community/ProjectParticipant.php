<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Community\Project;
use App\Models\App\Catalogue;
use App\Authentication\User;

/**
 * @property BigInteger id
 * @property Date start_date
 * @property Date end_date
 * @property String schedule_job
 * @property String position
 * @property Integer working_hours
 * @property JSON functions
 * @property Boolean state
 */
class ProjectParticipant extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;
    protected $connection = 'pgsql-community'; 
    protected $table = 'community.project_participants'; // nombre del esquema.nombretabla
    protected $fillable = [
        'start_date',
        'end_date',
        'schedule_job',
        'position',
        'working_hours',
        'functions',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}