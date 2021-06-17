<?php

namespace App\Models\Cecy;

// Librerias que si o si deben importarse
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

//Modelos o librerias Propios en caso de utilizarlas importalar aqui


/**
 * @property BigInteger id
 * @property string code
 * @property string abbreviation
 * @property string name
 * @property integer duration
 * @property string summary
 * @property string project
 * @property json target_groups
 * @property json participant_type
 * @property json technical_requirements
 * @property json general_requirements
 * @property json cross_cutting_topics
 * @property json teaching_strategies
 * @property json bibliographies
 * @property boolean free
 * @property double  cost
 * @property json observations 

 */

class Course extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.courses';

    protected $fillable = [
        'code',
        'name',
        'hours_duration',
        'free',
        'summary',
        'observation',
        'objective',
        'needs',
        'general_requirements',
        'Target_group',
        'facilities',
        'theoretical_phase',
        'practical_phase',
        'main_topics',
        'secondary_topics',
        'cross_cutting_topics',
        'bibliography',
        'teaching_strategies',
        'required_installing_sources',
        'practice_hours',
        'theory_hours',
        'practice_required_resources',
        'aimtheory_required_resources',
        'learning_teaching_strategy',
        'proposed_date',
        'approval_date',
        'local_proposal',
        'project',
        'capacity',
        'place',
        'setec_name',
        'abbreviation',
        'bibliographys',
        'status',
      


    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    //Relationships - Las relaciones van el orden alfabetico 
    public function anc()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function capacitationType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function certifiedType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }


    public function modality()
    {
        return $this->belongsTo(Catalogue::class);
    }

    
    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }
   

    public function specialty()
    {
        return $this->belongsTo(Catalogue::class);
    } 

    public function planificacion()
    {
        return $this->belongsTo(Planification::class);
    } 


}
