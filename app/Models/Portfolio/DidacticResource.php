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
 * @property json 'resources'
 */

class DidacticResource extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.didactic_resources';

    protected $fillable = [
        'resources'
    ];

    protected $casts = [
        'resources' => 'array'
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

    // Relationships preguntar de donde sale la clase type
    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function pea()
    {
        return $this->belongsTo(Pea::class);
    }

}