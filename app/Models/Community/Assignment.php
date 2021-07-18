<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Authentication\User; 
use App\Models\App\Career; 

/** 
 * @property BigInteger id
 * @property date date_request
 * @property string status
 * @property string observation
 * @property string level
 *
 */


class Assignment extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-community';
    protected $table = 'community.assignments';

    protected $fillable = [
        'date_request',
        'status',
        'observation',
        'level',
		
		
    ];

    //protected $appends = ['full_name', 'full_lastname']; // crea campo a nivel de programacion.
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function career()
    {
        return $this->belongsTo(Career::class);
    }
   
}