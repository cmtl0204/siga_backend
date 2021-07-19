<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Community\Entity;
use App\Models\App\SchoolPeriod;
use App\Models\App\Career;
use App\Models\App\Catalogue;
use App\Models\App\Location;
use App\Models\Authentication\User;

/**
 * @property BigInteger id
 * @property String code
 * @property Text title
 * @property Date date
 * @property JSON cycles
 * @property Integer lead_time
 * @property Date delivery_date
 * @property Date start_date
 * @property Date end_date
 * @property Text description
 * @property Text diagnosis
 * @property Text justification
 * @property JSON direct_beneficiaries
 * @property JSON indirect_beneficiaries
 * @property JSON strategies
 * @property JSON bibliografies
 * @property JSON observations
 * @property JSON send_quipux
 * @property JSON receive_quipux
 * @property Boolean state
 */
class Project extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;
    protected $connection = 'pgsql-community'; 
    protected $table = 'community.projects'; // nombre del esquema.nombretabla
    protected $fillable = [
        'code',
        'title',
        'date',
        'cycles',
        'lead_time',
        'delivery_date',
        'start_date',
        'end_date',
        'description',
        'diagnosis',
        'justification',
        'direct_beneficiaries',
        'indirect_beneficiaries',
        'strategies',
        'bibliografies',
        'observations',
        'send_quipux',
        'receive_quipux',
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

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function schoolPeriod()
    {
        return $this->belongsTo(SchoolPeriod::class);
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function coverage()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function frequency()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function status()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    // TODO: Not imported the required classes because they're not created yet
    public function entityPersons()
    {
        return $this->hasMany(EntityPerson::class);
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }

    public function projectObjectives()
    {
        return $this->hasMany(ProjectObjective::class);
    }

    public function projectParticipants()
    {
        return $this->hasMany(ProjectParticipant::class);
    }

    public function projectAreas()
    {
        return $this->hasMany(ProjectArea::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function assistances()
    {
        return $this->hasMany(Assistance::class);
    }
}