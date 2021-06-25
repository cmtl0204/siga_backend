<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use Brick\Math\BigInteger;
use App\Models\App\Catalogue;
use App\Models\App\File;

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
    
   // Relationships
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function idiom()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function written_level()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function spoken_level()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function read_level()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}