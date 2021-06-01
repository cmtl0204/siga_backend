<?php

namespace App\Models\JobBoard;

//use App\Models\App\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\File;
use App\Models\App\Image;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string code
 * @property string name
 * @property string icon
 */


class Category extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

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
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->orWhere('name', 'ILIKE', "%$name%");
        }
    }

      // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

   
}
