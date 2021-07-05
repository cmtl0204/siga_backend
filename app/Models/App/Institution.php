<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Authentication\User;

class Institution extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-app';
    protected $table = 'app.institutions';

    protected $fillable = [
        'code',
        'name',
        'short_name',
        'acronym',
        'email',
        'slogan',
        'logo',
        'web',
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtolower($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function teachers()
    {
        return $this->morphedByMany(Teacher::class, 'institutionable');
    }

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'institutionable', 'app.institutionables');
    }
}
