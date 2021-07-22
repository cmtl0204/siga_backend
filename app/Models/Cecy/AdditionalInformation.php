<?php

namespace App\Models\Cecy;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property BigInteger id
 * @property string company_name
 * @property string company_activity
 * @property string company_address
 * @property string company_phone
 * @property boolean company_sponsor
 * @property string name_contact
 * @property json know_course
 * @property json course_follow
 * @property boolean works
 */

class AdditionalInformation extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-cecy';
    protected $table = 'cecy.additional_informations';


    protected $casts = [
        'deleted_at'=>'date:Y-m-d h:m:s',
        'created_at'=>'date:Y-m-d h:m:s',
        'updated_at'=>'date:Y-m-d h:m:s',
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
    public function levelIntructor()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
