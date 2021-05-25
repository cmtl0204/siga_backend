<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pea extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.Peas';

    protected $fillable = [
        'student_assessment',
        'basic_biographies',
        'complementary_biographies',
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
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
    public function didacticResources()
    {
        return $this->hasMany(DidacticResource::class);
    }
    public function methodologicalStrategies()
    {
        return $this->hasMany(MethodologicalStrategy::class);
    }
    
        
}
