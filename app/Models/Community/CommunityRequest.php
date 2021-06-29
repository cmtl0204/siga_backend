<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property BigInteger id
 * @property date date_request
 * @property string status
 * @property string observation
 * @property string academic_period
 * @property string nivel
 *
 */


class CommunityRequest extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-community';
    protected $table = 'community.community_requests';

    protected $fillable = [
        'date_request',
        'status',
        'observation',
        'academic_period',
        'nivel',
		
		
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}