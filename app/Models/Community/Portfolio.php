<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property BigInteger id
 * @property date send_date
 * @property date approval_date
 * @property json observations
 * @property string approved_by
 *
 */


class Portfolio extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-community';
    protected $table = 'community.agreements';

    protected $fillable = [
        'send_date',
        'approval_date',
        'observations',
        'approved_by',
        
		
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
    public function student()
    {
        return $this->belongsTo(User::class);
    }
	
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
	
	public function user()
    {
        return $this->belongsTo(User::class);
    }
		
	public function documentType()
    {
        return $this->belongsTo(Catalogues::class);
    }
   
   public function status()
    {
        return $this->belongsTo(Catalogues::class);
    }
	
	
	
	
	
}