<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Brick\Math\BigInteger;
use App\Models\Authentication\User;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string trade_name
 * @property string comercial_activity
 * @property string web
 */

class Company extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.companies';
    protected $fillable = [
        'trade_name',
        'web',
    ];
    protected $casts = [
        'comercial_activities' => 'array'];

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
    public function activityType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function personType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function professionals()
    {
        return $this->belongsToMany(Professional::class)->withTimestamps();
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Mutators
    public function setTradeNameAttribute($value)
    {
        $this->attributes['trade_name'] = strtoupper($value);
    }
    public function setWebAttribute($value)
    {
        $this->attributes['web'] = strtolower($value);
    }

}
