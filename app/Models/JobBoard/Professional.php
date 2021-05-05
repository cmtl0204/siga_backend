<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use Brick\Math\BigInteger;
use App\Models\Authentication\User;

/**
 * @property BigInteger id
 * @property string about_me
 */
class Professional extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.professionals';

    protected $fillable = [
        'has_travel',
        'has_disability',
        'has_familiar_disability',
        'identification_familiar_disability',
        'has_catastrophic_illness',
        'has_familiar_catastrophic_illness',
        'about_me',
    ];

    protected $casts = [
        'has_travel' => 'boolean',
        'has_disability' => 'boolean',
        'has_familiar_disability' => 'boolean',
        'identification_familiar_disability' => 'boolean',
        'has_catastrophic_illness' => 'boolean',
        'has_familiar_catastrophic_illness' => 'boolean',
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function references()
    {
        return $this->hasMany(Reference::class);
    }

    public function academicFormations()
    {
        return $this->hasMany(AcademicFormation::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function professionals()
    {
        return $this->hasMany(Professional::class);
    }

    public function languages()
    {
        return $this->hasMany(Language::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    // Mutators
    public function setAboutMeAttribute($value)
    {
        $this->attributes['about_me'] = strtoupper($value);
    }
}
