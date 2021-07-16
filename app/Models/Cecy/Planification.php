<?php

namespace App\Models\Cecy;


use App\Models\App\Catalogue;
use App\Models\Authentication\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;




class Planification extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected static $instance;
    
    protected $connection = 'pgsql-cecy';

    protected $table = 'cecy.planifications';
    
    //Para arrays
    protected $casts = [
      'needs' => 'array'
    ];

    protected $fillable = [
      'date_start',
      'date_end',
    
  ];

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
