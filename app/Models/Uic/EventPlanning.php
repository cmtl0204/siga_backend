<?php

namespace App\Models\Uic;

use App\Models\App\File;
use App\Models\Uic\Planning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Dyrynda\Database\Support\CascadeSoftDeletes;

/**
 * @property BigInteger id
 * @property string start_date
 * @property string end_date
 */
class EventPlanning extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use CascadeSoftDeletes;
	private static $instance;
    protected $connection = 'pgsql-uic';
    protected $table = 'uic.event_planning';
    //hacer despues
    protected $with = ['event', 'planning'];

    protected $fillable = [
        'start_date',
        'end_date',
    ];

    protected $cascadeDeletes = ['files'];

    protected $casts = [
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
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
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }
}
