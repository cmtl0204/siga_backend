<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use App\Models\App\Catalogue;
use App\Models\App\Status;
use App\Models\App\Location;

/**
 * @property BigInteger id
 * @property string code
 * @property string description
 * @property string contact_name
 * @property string contact_email
 * @property string contact_phone
 * @property string contact_cellphone
 * @property string remuneration
 * @property integer vacancies
 * @property Date start_date
 * @property Date end_date
 * @property string aditional_information
 * @property json activities
 * @property json requirements
 */
class Offer extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.offers';

    protected $fillable = [
        'code',
        'description',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_cellphone',
        'remuneration',
        'vacancies',
        'start_date',
        'end_date',
        'aditional_information',
    ];

    protected $casts = [
        'activities' => 'array',
        'requirements' => 'array',
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function contractType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function position()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function sector()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function workingDay()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function experienceTime()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function trainingHours()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Scopes
    public function scopeAditional_information($query, $aditional_information)
    {
        if ($aditional_information) {
            return $query->Where('aditional_information', 'ILIKE', "%$aditional_information%");
        }
    }

    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->orWhere('code', 'ILIKE', "%$code%");
        }
    }

    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description', 'ILIKE', "%$description%");
        }
    }
    
    
}
