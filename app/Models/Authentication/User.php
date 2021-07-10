<?php

namespace App\Models\Authentication;

use App\Models\JobBoard\Company;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Address;
use App\Models\App\AdministrativeStaff;
use App\Models\App\Catalogue;
use App\Models\App\Image;
use App\Models\App\Institution;
use App\Models\App\Teacher;
use App\Models\App\Status;
use App\Models\App\File;
use App\Models\JobBoard\Professional;

/**
 * @property BigInteger id
 * @property integer attempts
 * @property string avatar
 * @property Date birthdate
 * @property string email
 * @property Date email_verified_at
 * @property string first_lastname
 * @property string names
 * @property string identification
 * @property boolean is_changed_password
 * @property string password
 * @property string personal_email
 * @property string phone
 * @property string second_lastname
 * @property string username
 */
class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.users';

    protected static $instance;

    const ATTEMPTS = 3;

    protected $fillable = [
        'attempts',
        'avatar',
        'birthdate',
        'email',
        'email_verified_at',
        'first_lastname',
        'names',
        'identification',
        'is_changed_password',
        'password',
        'personal_email',
        'phone',
        'second_lastname',
        'username',
    ];

   // protected $appends = ['full_name', 'full_lastname', 'partial_name', 'partial_lastname'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'date:Y-m-d h:m:s',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    // Instance
    static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Define el campo por el cual valida passport el usuario para el login
    function findForPassport($username)
    {
        return $this->firstWhere('username', $username);
    }

    // Relationships
    function Address()
    {
        return $this->belongsTo(Address::class);
    }

    function administrativeStaff()
    {
        return $this->hasOne(AdministrativeStaff::class);
    }

    function bloodType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    function company()
    {
        return $this->hasOne(Company::class);
    }

    function civilStatus()
    {
        return $this->belongsTo(Catalogue::class);
    }

    function ethnicOrigin()
    {
        return $this->belongsTo(Catalogue::class);
    }

    function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    function gender()
    {
        return $this->belongsTo(Catalogue::class);
    }

    function identificationType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    function institutions()
    {
        return $this->morphToMany(Institution::class, 'institutionable', 'app.institutionables');
    }

    function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    function professional(){
        return $this->hasOne(Professional::class);
    }

    function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    function securityQuestions()
    {
        $this->belongsToMany(SecurityQuestion::class)->withPivot('answer')->withTimestamps();
    }

    function sex()
    {
        return $this->belongsTo(Catalogue::class);
    }

    function shortcuts()
    {
        return $this->hasMany(Shortcut::class);
    }

    function status()
    {
        return $this->belongsTo(Status::class);
    }

    function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    // Accessors
    function getFullNameAttribute()
    {
        return "{$this->attributes['names']}" .
            "{$this->attributes['first_lastname']} {$this->attributes['second_lastname']}";
    }

    function getFullLastnameAttribute()
    {
        return "{$this->attributes['names']}" .
            "{$this->attributes['first_lastname']} {$this->attributes['second_lastname']}";
    }

    function getPartialNameAttribute()
    {
        return "{$this->attributes['names']} {$this->attributes['first_lastname']}";
    }

    function getPartialLastnameAttribute()
    {
        return "{$this->attributes['first_lastname']} {$this->attributes['names']}";
    }

    // Mutators
    function setFirstnameAttribute($value)
    {
        $this->attributes['names'] = strtoupper($value);
    }

    function setFirstLastnameAttribute($value)
    {
        $this->attributes['first_lastname'] = strtoupper($value);
    }

    function setSecondLastnameAttribute($value)
    {
        $this->attributes['second_lastname'] = strtoupper($value);
    }

    function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    function setPersonalEmailAttribute($value)
    {
        $this->attributes['personal_email'] = strtolower($value);
    }

    function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Scopes
    function scopeEmail($query, $email)
    {
        if ($email) {
            return $query->where('email', 'ILIKE', "%$email%");
        }
    }

    function scopeFirstLastname($query, $first_lastname)
    {
        if ($first_lastname) {
            return $query->orWhere('first_lastname', 'ILIKE', "%$first_lastname%");
        }
    }

    function scopeNames($query, $names)
    {
        if ($names) {
            return $query->orWhere('names', 'ILIKE', "%$names%");
        }
    }

    function scopeIdentification($query, $identification)
    {
        if ($identification) {
            return $query->orWhere('identification', 'ILIKE', "%$identification%");
        }
    }

    function scopeSecondLastname($query, $second_lastname)
    {
        if ($second_lastname) {
            return $query->orWhere('second_lastname', 'ILIKE', "%$second_lastname%");
        }
    }
}
