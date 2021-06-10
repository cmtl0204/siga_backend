<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property BigInteger id
 * @property String 'description',
 * @property Integer 'order',
 * @property String 'name',
 */

class Unit extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.units';

    protected $fillable = [
        'description',
        'order',
        'name',
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
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function pea()
    {
        return $this->belongsTo(Pea::class);
    }

}
