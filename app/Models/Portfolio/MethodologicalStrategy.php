<?php

namespace App\Models\Portfolio;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property BigInteger id
 * @property String 'purpose'
 */

class MethodologicalStrategy extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.methodological_strategies';

    protected $fillable = [
        'purpose'
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

    public function pea()
    {
        return $this->belongsTo(Pea::class);
    }
    public function strategy()
    {
        return $this->belongsTo(Catalogue::class);
    }

}
