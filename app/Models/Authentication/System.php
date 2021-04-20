<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;

// Models
use App\Models\App\Catalogue;


class System extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.systems';

    protected $fillable = ['code', 'name','acronym','description','icon','version','date','state'];


    public function status()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
