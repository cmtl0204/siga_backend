<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use phpDocumentor\Reflection\DocBlock\Description;

/**
 * @property BigInteger id
 * @property integer days
 * @property integer day_hours
 * @property date proposed_date
 * @property json needs
 * @property integer practice_hours
 * @property integer theory_hours
 * @property date approval_date
 * @property string project
 * @property json installations
 */

class Planification extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.planifications';

    protected static $instance;

    protected $fillable = [
        'days',
        'day_hours',
        'proposed_date',
        'needs',
        'practice_hours',
        'theory_hours',
        'approval_date',
        'project',
        'installations'
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
    public function routes(){
        return $this->hasMany(Route::class);
    }
    public function course(){
        return $this->belongsTo(Courses::class);
    }
    public function teacher() {
        return $this->belongsTo(Users::class)
    }
    public function responsible() {
        return $this->belongsTo(Authorities::class)
    }
    public function career() {
        return $this->belongsTo(Careers::class)
    }
    public function school_period() {
        return $this->belongsTo(School_periods::class)
    }
    public function location() {
        return $this->belongsTo(Locations::class)
    }
    public function status() {
        return $this->belongsTo(Catalogues::class)
    }