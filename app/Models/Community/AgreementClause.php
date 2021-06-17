<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Community\Agreement;
/**
 * @property BigInteger id
 * @property string code
 * @property string clause_name
 * @property string description
 *
 */


class AgreementClause extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-community';
    protected $table = 'community.agreement_clauses';

    protected $fillable = [
        'code',
        'clause_name',
        'description',
        
		
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
    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

   
}
