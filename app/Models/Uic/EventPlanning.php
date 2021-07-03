<?php

namespace App\Models\Uic;

use App\Models\App\File;
use App\Models\Uic\Planning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class EventPlanning extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;


    protected static $instance;

    protected $connection = 'pgsql-uic';
    protected $table = 'uic.event_planning';

    protected $fillable = [
        'id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'observations' => 'array',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    protected $with = ['event', 'planning', 'files'];

    protected $cascadeDeletes = ['files'];
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
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
