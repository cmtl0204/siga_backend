<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\App\Catalogue;
use App\Models\Authentication\User;



/**
 * @property BigInteger id
 * @property String description
 */


class Planification extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    
    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.planifications';
    
    protected static $instance;

    protected $fillable = [
        'date_start',
        'date_end',
        'needs',
        'date_end'
  ];


  protected $with = ['course','user','status'];
  protected $casts = [
      'deleted_at' => 'date:Y-m-d h:m:s',
      'created_at' => 'date:Y-m-d h:m:s',
      'updated_at' => 'date:Y-m-d h:m:s',
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

    //Relationships - Las relaciones van el orden alfabetico 

    public function course()
    {
      return $this->belongsTo(Course::class); 
    }

    public function user()
    {
      return $this->belongsTo(User::class); 
    }

    public function status()
    {
      return $this->belongsTo(Catalogue::class); 
    }


}
