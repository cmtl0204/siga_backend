<?php

namespace App\Models\Attendance;

use App\Models\App\Observation;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use App\Models\App\Catalogue;

class Task extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;


    protected $connection = 'pgsql-attendance';

    protected $fillable = [
        'description',
        'percentage_advance',
        'state',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }



    public function observations()
    {
        return $this->morphMany(Observation::class, 'observationable');
    }
}
