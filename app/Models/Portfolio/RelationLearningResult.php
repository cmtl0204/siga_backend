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
 * @property
 */

class RelationLearningResult extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.relation_learning_results';

    protected $fillable = [
        'pea_id',
        'learning_result_id',
        'contribution_id',  //todas FK
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
    public function pea()
    {
        return $this->belongsTo(Pea::class);
    }
    public function learningResult()
    {
        return $this->belongsTo(LearningResult::class);
    }
    public function contribution()
    {
        return $this->belongsTo(Catalogue::class);
    }

}
