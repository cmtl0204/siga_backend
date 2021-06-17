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
use App\Models\App\Status;
/**
 * @property BigInteger id
 * @property string name
 */ 

class SchoolPeriod extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-app';
    protected $table = 'app.school-period';

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
    public function schoolPeriods()
    {
        return $this->morphTo();
    }
    
}
