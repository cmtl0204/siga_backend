<?php

namespace App\Models\Uic;

use App\Models\App\Status;
use App\Models\Uic\Modality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property BigInteger id
 * @property string date
 * @property string code
 * @property json code
 */

class Enrollment extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    
    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.enrollments';
    
    protected $fillable = [
        'date',
        'code',
        'observations'
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    //relationships
    public function modality() {
        return $this->belongsTo(Modality::class);
    }

    //No hay ese modelo
    // public function shoolPeriods() {
    //     return $this->belongsTo(SchoolPeriod::class);
    // }

    public function status() {
        return $this->belongsTo(Status::class);
    }
}