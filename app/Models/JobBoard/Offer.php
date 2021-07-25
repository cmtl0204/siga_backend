<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use App\Models\App\Catalogue;
use App\Models\App\Status;
use App\Models\App\Location;
use App\Models\JobBoard\Professional;
use Dyrynda\Database\Support\CascadeSoftDeletes;

/**
 * @property BigInteger id
 * @property string code
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
    // use CascadeSoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.offers';
    protected $fillable = [
        'code',
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

    protected $with = [
        'position',
        'location',
        'categories',
        'contractType',
        'trainingHours',
        'experienceTime',
        'workingDay',
        'sector',
        'status'
    ];

    protected $casts = [
        'activities' => 'array',
        'requirements' => 'array',
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d h:m:s',
        'updated_at' => 'datetime:Y-m-d h:m:s',
        'deleted_at' => 'datetime:Y-m-d h:m:s',
    ];

    protected $cascadeDeletes = ['categories'];
    protected $hidden = ['pivot'];

    // Instance
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contractType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function position()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function professionals()
    {
        return $this->belongsToMany(Professional::class)->withTimestamps();
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
    public function scopeAditionalInformation($query, $aditionalInformation)
    {
        if ($aditionalInformation) {
            return $query->orWhere('aditional_information', 'ILIKE', "%$aditionalInformation%");
        }
    }

    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->orWhere('code', 'ILIKE', "%$code%");
        }
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function scopeProfessional($query, $professional)
    {
        if ($professional) {
            $query->whereDoesntHave('professionals', function ($professionals) use ($professional) {
                $professionals->where('professionals.id', $professional->id);
            });
        }
    }

    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->whereHas('status', function ($query) use ($status) {
                $query->where('code', $status);
            });
        }
    }

    public function scopeProvince($query, $province)
    {
        if ($province) {
            $query->whereHas('location', function ($location) use ($province) {
                $location->where('parent_id', $province);
            });
        }
    }

    public function scopeCanton($query, $canton)
    {
        if ($canton) {
            $query->where('location_id', $canton);
        }
    }

    public function scopePosition($query, $position)
    {
        if ($position) {
            $query->whereHas('position', function ($query) use ($position) {
                $query->where('name', 'ILIKE', "%$position%");
            });
        }
    }

    public function scopeIdCategories($query, $categories)
    {
        if ($categories) {
            $query->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }
    }

    public function scopeParentCategory($query, $category)
    {
        if ($category) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->whereIn('categories.parent_id', $category);
            });
        }
    }

    // estos scopes son usados en el imput de texto
    public function scopeLocation($query, $location){
        if ($location) {
            return$query->orWhereHas('location', function ($query) use ($location) {
                $query->where('name', 'ILIKE', "%$location%");
            });
        }
    }

    public function scopeCategoryName($query, $name){
        if ($name) {
            return $query->orWhereHas('categories', function ($query) use ($name) {
                $query->Where('name', $name);
            });
        }
    }
}
