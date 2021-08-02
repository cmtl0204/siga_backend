<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-app';
    protected $table = 'app.locations';

    protected $fillable = [
        'code',
        'name',
        'short_name',
    ];

    protected $hidden = ['created_at', 'updated_at','deleted_at'];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }
}
