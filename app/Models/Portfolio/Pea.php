<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lcobucci\JWT\Signer;


/**
 * @property BigInteger id
 * @property String student_assessment
 * @property json basic_bibliographies
 * @property json complementary_bibliographies
 */


class Pea extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.peas';

    protected $fillable = [
        'student_assessment',
        'basic_bibliographies',
        'complementary_bibliographies',

    ];

    protected $casts = [
        'basic_bibliographies' => 'array',
        'complementary_bibliographies' => 'array'
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

    public function methodologicalStrategies()
    {
        return $this->hasMany(MethodologicalStrategy::class);
    }
    public function didacticResources()
    {
        return $this->hasMany(DidacticResource::class);
    }
    public function signatures()
    {
        return $this->belongsTo(Signature::class);
    }


}
