<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TeacherEval\Evaluation;
use App\Models\TeacherEval\Answer;

class Status extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    private static $instance;

    protected $connection = 'pgsql-app';
    protected $table = 'app.status';

    protected $fillable = ['code', 'name'];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function evaluation()
    {
        return $this->hasMany(Evaluation::class);
    public function answers()
    {
        return $this->HasMany(Answer::class);
    }
}
