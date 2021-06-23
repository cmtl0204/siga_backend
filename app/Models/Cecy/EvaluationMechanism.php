<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Catalogue;
use App\Models\App\Status;

/**
 * @property BigInteger id
 * @property string technique
 * @property string instrument
 */

class EvaluationMechanism extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    //use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-cecy';
    //nombre del esquema
    protected $table = 'cecy.evaluation_mechanisms';

    protected $fillable = [
        //campos propios de la tabla
        'technique',  //tecnica
        'instrument',  //instrumento
    ];

    // protected $casts = [
    //     'deleted_at'=>'date:Y-m-d h:m:s',
    //     'created_at'=>'date:Y-m-d h:m:s',
    //     'updated_at'=>'date:Y-m-d h:m:s',
    // ];

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
    public function state(){
        return $this->belongsTo(Status::class);
    }
    public function type(){
        return $this->belongsTo(Catalogue::class);
    }

} 
    

    