<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Catalogue;
use App\Models\Authentication\User;



// use App\Models\App\Status;
// use phpDocumentor\Reflection\DocBlock\Description;

/**
 * @property BigInteger id
 * @property date date_start
 * @property date date_end
 * @property json needs
 */

class Planification extends Model implements Auditable {

    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.planifications';

    protected static $instance;

    protected $fillable = [
        'date_start',
        'date_end',
        'needs',
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
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function teacher() {
        return $this->belongsTo(User::class);
    }
    public function status() {
        return $this->belongsTo(Catalogue::class);
    }
}