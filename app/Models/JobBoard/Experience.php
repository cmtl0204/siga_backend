<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Brick\Math\BigInteger;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string employer
 * @property string position
 * @property date start_date
 * @property date end_date
 * @property json activities
 * @property string reason_leave
 * @property boolean is_workign
 */
class Experience extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.experiences';

    protected $with = ['area'];

    protected $fillable = [
        'employer',
        'position',
        'start_date',
        'end_date',
        'activities',
        'reason_leave',
        'is_working',
    ];
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'activities' => 'array',
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function area()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
