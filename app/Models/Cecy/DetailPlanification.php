<?php

namespace App\Models\Cecy;

use App\Models\App\Catalogue;
use App\Models\App\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property BigInteger id
 * @property date date_start
 * @property date date_end
 * @property string summary
 * @property date planned_end_date 
 * @property string location_certificate
 * @property string code_certificate
 * @property integer capacity 
 * @property string observation
 * @property json needs
 * @property date need_date
 */

class DetailPlanification extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-cecy';
    protected $table = 'cecy.detail_planifications';


    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
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
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function authorityRector()
    {
        return $this->belongsTo(Authority::class);
    }
    public function authorityParticipantsFirm()
    {
        return $this->belongsTo(Authority::class);
    }
    public function authorityInstructorFirm()
    {
        return $this->belongsTo(Authority::class);
    }
    public function statusCertificate()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function state()
    {
        return $this->belongsTo(Status::class);
    }
    public function siteDictate()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function conference()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function parallel()
    {
        return $this->belongsTo(Catalogue::class);
    }

}
