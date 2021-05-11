<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use Brick\Math\BigInteger;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 */
class Language extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.languages';
    protected $with = ['professional','idiom'];

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

    public function idiom()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function writtenLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function spokenLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function readLevel()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
