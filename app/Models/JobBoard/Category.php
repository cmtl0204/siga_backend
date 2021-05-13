<?php

namespace App\Models\JobBoard;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

use Brick\Math\BigInteger;
use App\Models\App\File;
use App\Models\App\Image;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string description
 */


class Category extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use HasFactory;

    private static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.categories';
    protected $with = ['parent'];
    protected $fillable = [
        'code',
        'name',
        'icon'
    ];
//
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

<<<<<<< HEAD
     // Mutators
     public function setCodeAttribute($value)
     {
         $this->attributes['code'] = strtoupper($value);
     }
 
     // Scopes
     public function scopeCode($query, $code)
     {
         if ($code) {
             return $query->where('code', 'ILIKE', "%$code%");
         }
     }

      // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    // Scopes
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'ILIKE', "%$name%");
        }
=======
    public function offers()
    {
        return $this->belongsTo(Offer::class);
>>>>>>> mod_6_jobboard
    }
}
