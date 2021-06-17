<?php

namespace App\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @property BigInteger id
 * @property string code
 * @property date suscription_date
 * @property date due_date
 * @property integer time
 * @property string accordance
 * @property json clause_one
 * @property json clause_two
 * @property json clause_three
 * @property json clause_four
 *
 */


class Agreement extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;

    protected $connection = 'pgsql-community';
    protected $table = 'community.agreements';

    protected $fillable = [
        'code',
        'suscription_date',
        'due_date',
        'time',
        'accordance',
		'clause_one',
		'clause_two',
		'clause_three',
		'clause_four',
		
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
    public function itv()
    {
        return $this->belongsTo(Itv::class);
    }

   
}
