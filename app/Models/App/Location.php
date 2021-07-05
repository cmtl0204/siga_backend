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

    protected $connection = 'pgsql-app';
    protected $table = 'app.locations';

    protected $fillable = [
        'code',
        'name',
        'short_name',
    ];

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
