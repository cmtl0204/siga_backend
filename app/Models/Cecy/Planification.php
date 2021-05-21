<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use phpDocumentor\Reflection\DocBlock\Description;

/**
 * @property BigInteger id
 * @property integer days
 * @property integer day_hours
 * @property date proposed_date
 * @property json needs
 * @property integer practice_hours
 * @property integer theory_hours
 * @property date approval_date
 * @property string project
 * @property json installations
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
        'days',
        'day_hours',
        'proposed_date',
        'needs',
        'practice_hours',
        'theory_hours',
        'approval_date',
        'project',
        'installations'
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


    