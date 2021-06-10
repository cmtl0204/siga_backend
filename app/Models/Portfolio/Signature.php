<?php

namespace App\Models\Portfolio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

// modelos propios pea no se pone xq esta dentro de la misma carpeta
use App\Models\App\Catalogue;
use App\Models\Authentication\User;

/**
 * @property BigInteger id
 * @property
 */


class Signature extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-portfolio';
    protected $table = 'portfolio.signatures';

    protected $fillable = [
        '', //todas FK
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    // Relationships

    public function pea()
    {
        return $this->belongsTo(Pea::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);

    }

}
