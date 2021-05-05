<?php

namespace App\Models\JobBoard;

use App\Models\App\Catalogue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

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
}
