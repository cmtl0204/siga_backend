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
 * @property string technique
 * @property string instrument
 */

class EvaluationMechanism extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.evaluation_mechanisms';

    protected static $instance;

    protected $fillable = [
        'technique',
        'instrument'
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
    public function type(){
        return $this->hasMany(Catalogues::class);
    }
    public function course(){
        return $this->hasMany(Courses::class);
    }

    