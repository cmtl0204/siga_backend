<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Traits State
use Illuminate\Database\Eloquent\SoftDeletes;


// Models
use App\Models\Authentication\User;
use App\Models\Attendance\Attendance;
use App\Models\TeacherEval\Evaluation;
use App\Models\TeacherEval\ExtraCredit;
use App\Models\TeacherEval\Research;

class Teacher extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-app';
    protected $table = 'app.teachers';

    protected $fillable = ['name'];

    // Instance
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Relationsships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->morphMany(Attendance::class, 'attendanceable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function evaluation()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function extraCredit()
    {
        return $this->hasMany(ExtraCredit::class);
    }

    public function research()
    {
        return $this->hasMany(Research::class);
    }

}
