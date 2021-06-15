<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property BigInteger id
 * @property Integer 'week',
 * @property json 'contents',
 * @property Integer 'teaching_hours',
 * @property json 'teaching_activities',
 * @property Integer 'practical_hours',
 * @property json 'practical_activities',
 * @property Integer 'autonomous_hours',
 * @property json 'autonomous_activities',
 * @property json 'observations'
 */

class Content extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.contents';

    protected $fillable = [
        'week',
        'contents',
        'teaching_hours',
        'teaching_activities',
        'practical_hours',
        'practical_activities',
        'autonomous_hours',
        'autonomous_activities',
        'observations'


    ];

    protected $casts = [
        'contents' => 'array',
        'teaching_activities' => 'array',
        'practical_activities' => 'array',
        'autonomous_activities' => 'array',
        'observations' => 'array'
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
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
