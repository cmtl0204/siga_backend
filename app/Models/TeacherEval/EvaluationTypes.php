<?php

namespace App\Models\teacherEval;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property BigInteger id 
 */
class PairResults Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    protected static $instance;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.pair_results';

    protected $fillable = {
        'name',
        'code',
        'percentage',
        'global_percentage'

    }

    public static function getInstance($id){
        if(is_null(static::$instance)){
            static::$instance = new static;
        }
        static::$instance -> id = $id;
        return static::$instance;
    }

    //relantioships 
    public function catalogues(){
        return $this->hasOne(catalogues::class);
    }
    public function evaluationTypes(){
        return $this->hasMany(evaluationTypes::class);
    }
    
}