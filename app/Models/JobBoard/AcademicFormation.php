<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

class AcademicFormation extends Model implements Auditable
{

    use Auditing;
    use HasFactory;
    use SoftDeletes;

    private static $instance;
    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.academic_formations';

    protected $fillable = [
        'registration_date',
        'senescyt_code',
        'has_titling',
        'is_principal'
    ];

    protected $casts = [
        'registration_date' => 'datetime'
    ];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function professionalDegree()
    {
        return $this->belongsTo(Category::class);
    }

}
