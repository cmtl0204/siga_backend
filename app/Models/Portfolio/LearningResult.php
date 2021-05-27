<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

// modelos propios 

/**
 * @property BigInteger id
 * @property string code
 * @property string description
 */


class LearningResult extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.learning_results';

    protected $fillable = [
        'code',
        'description',
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

    public function peas()
    {
        return $this->hasMany(Pea::class);
    }

    public function parent()
    {
        return $this->belongsTo(LearningResult::class);
    }
    

    public function type()
    {
        return $this->belongsTo(Catalogue::class);

    }


}
