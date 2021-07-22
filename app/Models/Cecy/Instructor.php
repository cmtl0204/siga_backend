<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Authentication\User;
use App\Models\App\Catalogue;
use App\Models\App\App;
use App\Models\App\Cecy\Registration;
use App\Models\App\Cecy\AditionalInformation;
use App\Models\App\Cecy\DetailPlanification;


/**
 * @property BigInteger id
 * 
 */

class Instructor extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.instructors';

    protected $fillable = [
        //
    ];

    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
    ];

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class);
    }

    public function typeInstructor()
    {
        return $this->belongsTo(Catalogues::class);
    }

    // Accessors
    /* public function getFullPartialGradeAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['partial_grade']}";
    }

    public function getFullFinalExamAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['final_exam']}";
    }

    public function getFullCodeCertificateAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['code_certificate']}";
    }

    public function getFullCertificateWithdrawnAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['certificate_withdrawn']}";
    }

    public function getFullLocationCertificateAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['location_certificate']}";
    }

    public function getFullObservationAttribute()
    {
        return "{$this->attributes['id']}.{$this->attributes['observation']}";
    } */


    // Mutators
    /*public function setFullPartialGradeAttribute()
    {
        $this->attributes['partial_grade'] = strtoupper($value);
    }

    public function setFullFinalExamAttribute()
    {
        $this->attributes['final_exam'] = strtoupper($value);
    }

    public function setFullCodeCertificateAttribute()
    {
        $this->attributes['code_certificate'] = strtoupper($value);
    }

    public function setFullCertificateWithdrawnAttribute()
    {
        $this->attributes['certificate_withdrawn'] = strtoupper($value);
    }

    public function setFullLocationCertificateAttribute()
    {
        $this->attributes['location_certificate'] = strtoupper($value);
    }*/

   // public function setFullObservationAttribute()
    //{
      //  $this->attributes['observation'] = strtoupper($value);
    //}

    // Scopes
   /*  public function scopePartialGrade($query, $partial_grade)
    {
        if ($partial_grade) {
            return $query->where('partial_grade', 'ILIKE', "%$partial_grade%");
        }
    }

    {
        public function scopeFinalExam($query, $final_exam)
        if ($final_exam) {
            return $query->where('final_exam', 'ILIKE', "%$final_exam%");
        }
    }

    public function scopeCodeCertificate($query, $code_certificate)
    {
        if ($code_certificate) {
            return $query->where('code_certificate', 'ILIKE', "%$code_certificate%");
        }
    }

    public function scopeCertificateWithdrawn($query, $certificate_withdrawn)
    {
        if ($certificate_withdrawn) {
        return $query->where('certificate_withdrawn', 'ILIKE', "%$certificate_withdrawn%");
        }
    }

    public function scopeLocationCertificate($query, $location_certificate)
    {
        if ($location_certificate) {
            return $query->where('location_certificate', 'ILIKE', "%$location_certificate%");
        }
    }

    public function scopeObservation($query, $observation)
    {
        if ($observation) {
            return $query->where('observation', 'ILIKE', "%$observation%");
        }
    }
 */

}
