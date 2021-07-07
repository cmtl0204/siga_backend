<?php

namespace App\Models\App;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Career;


class MeshStudent extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-app';
    protected $table = 'app.mesh_student';

    protected $with = ['student', 'mesh'];

    protected static $instance;

    protected $fillable = [
        'is_graduated'
    ];
    protected $casts = [
        'start_cohort' => 'date:Y-m-d h:m:s',
        'end_cohort' => 'date:Y-m-d h:m:s',
        'deleted_at' => 'date:Y-m-d h:m:s',
        'created_at' => 'date:Y-m-d h:m:s',
        'updated_at' => 'date:Y-m-d h:m:s',
    ];
    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function mesh()
    {
        return $this->belongsTo(Mesh::class);
    }
}
