<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Cecy\DetailPlanification;
use phpDocumentor\Reflection\DocBlock\Description;
use App\Models\App\Cecy\Registration;
use App\Models\App\Catalogue;
use App\Models\App\Cecy\AditionalInformation;

/**
 * @property BigInteger id
 * @property date  date_start
 * @property date  date_end
 * @property string summary
 * @property date planned_end_date
 * @property string location_certificate
 * @property string code_certificate
 * @property integer  capacity
 * @property string observation
 * @property json needs
 * @property date need_date

 * 
 * 
 */

class DetailPlanification extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'detail.planifications';

    protected static $instance;

    protected $fillable = [
        'date_start',
        'date_end',
        'summary',
        'planned_end_date',
        'location_certificate',
        'code_certificate',
        'capacity',
        'observation',
        'needs',
        'need_date',
    ];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
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
  

    public function planification()
    {
        return $this->belongsTo(Planification::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function statusCertificate()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function siteDictate()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function conference()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function authorityRector()
    {
        return $this->belongsTo(AuthorityRector::class);
    }
}
