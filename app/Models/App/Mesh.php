<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Career;

/**
 * @property BigInteger id
 * @property string name
 * @property date start_date
 * @property date end_date
 * @property string resolution_number
 * @property integer number_weeks
 */
class Mesh extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-app';
    protected $table = 'app.meshes';

    protected static $instance;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'resolution_number',
        'number_weeks'];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function carrer()
    {
        return $this->belongsTo(Career::class);
    }

}
