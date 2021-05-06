<?php

namespace App\Models\Authentication;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use App\Models\Authentication\System;


class Module extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.modules';

    protected static $instance;
   

    protected $fillable = [
    'code',
    'name',
    'description',
    'icon',
    'state'];

    public static function getInstance($id)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        static::$instance->id = $id;
        return static::$instance;
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

}
