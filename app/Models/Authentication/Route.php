<?php

namespace App\Models\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Catalogue;
use App\Models\App\Image;

/**
 * @property BigInteger id
 * @property string description
 * @property string icon
 * @property string logo
 * @property string name
 * @property integer order
 * @property string uri
 */

class Route extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.routes';

    protected static $instance;

    protected $fillable = [
        'description',
        'icon',
        'logo',
        'name',
        'order',
        'uri',
    ];

    protected $casts = [
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

    // Relationships
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function status()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function permission()
    {
        return $this->hasOne(Permission::class);
    }

    public function children()
    {
        return $this->hasMany(Route::class, 'parent_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
