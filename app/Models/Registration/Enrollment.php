<?php

namespace App\Models\Registration;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;

// Models App
use App\Models\App\Catalogue;
use App\Models\App\Mesh;
use App\Models\App\AcademicPeriod;

// Models Registration
use App\Models\Registration\EnrollmentType;

/**
 * @property BigInteger id
 * @property string code
 * @property date date
 * @property date application_date
 * @property date form_date
 * @property string folio
 * @property string project
 * @property json observations
 */
class Enrollment extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-registration';
    protected $table = 'registration.enrollments';

    protected static $instance;

    protected $fillable = [
        'code',
        'date',
        'application_date',
        'form_date',
        'folio',
        'observations'];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function workingDay()
    {
        return $this->belongsTo(Catalogue::class, 'working_day_id');
    }

    public function workingDayOperative()
    {
        return $this->belongsTo(Catalogue::class, 'working_day_operative_id');
    }

    public function mainParallel()
    {
        return $this->belongsTo(Catalogue::class, 'main_parallel_id');
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function mesh()
    {
        return $this->belongsTo(Mesh::class);
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function enrollmentType()
    {
        return $this->belongsTo(EnrollmentTy::class);
    }
}
