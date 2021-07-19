<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property String logo
 * @property String ruc
 * @property String name
 * @property String short_name
 * @property String mail
 * @property String permanent_phone
 * @property String movil_phone
 * @property String document_main
 * @property String document_secondary
 * @property Boolean state
 */
class Entity extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;
    protected $connection = 'pgsql-community'; 
    protected $table = 'community.entities'; // nombre del esquema.nombretabla
    protected $fillable = [
        'logo',
        'ruc',
        'name',
        'short_name',
        'mail',
        'permanent_phone',
        'movil_phone',
        'document_main',
        'document_secondary',
        'state'
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function economicActivity()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function nature()
    {
        return $this->belongsTo(Catalogue::class);
    }

}