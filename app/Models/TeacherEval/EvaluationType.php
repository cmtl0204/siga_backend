<?php

namespace App\Models\TeacherEval;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use CascadeSoftDeletes;

/**
 * @property BigInteger id 
 * @property string name
 * @property string code
 * @property double percentage
 * @property double global_percentage
 */
class EvaluationType extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;
    protected static $instance;

    protected $connection = 'pgsql-teacher-eval';
    protected $table = 'teacher_eval.evaluation_types';

    protected $fillable = [
        'name',
        'code',
        'percentage',
        'global_percentage'
    ];
    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
    ];

    public static function getInstance($id){
        if(is_null(static::$instance)){
            static::$instance = new static;
        }
        static::$instance -> id = $id;
        return static::$instance;
    }

    //relantioships 





    public function parent(){
        return $this->belongsTo(EvaluationType::class, 'parent_id');
    }
    public function children(){
        return $this->hasMany(EvaluationType::class, 'parent_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
        // Scopes
        public function scopeName($query, $name)
        {
            if ($name) {
                return $query->where('name', 'ILIKE', "%$name%");
            }
        }

        protected $cascadeDeletes = ['parent', 'status'];
}