<?php

namespace App\Models\Uic;

use App\Models\App\Catalogue;
use App\Models\Uic\Planning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

// Application
use Dyrynda\Database\Support\CascadeSoftDeletes;

/**
 * @property BigInteger id
 * @property string name
 * @property string description
 */
class Event extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use CascadeSoftDeletes;
    use SoftDeletes;
    protected $connection = 'pgsql-uic';
    protected $table = 'uic.events';
    //hacer despues
    protected $with = [];

    protected $fillable = [
        'start_date',
        'end_date'
    ];

    protected $cascadeDeletes = [];

    protected $casts = [
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];

    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }
    public function name()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
