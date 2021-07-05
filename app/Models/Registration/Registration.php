<?php

namespace App\Models\Registration;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Status;
use App\Models\Authentication\System;


class Registration extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-authentication';
    protected $table = 'authentication.modules';

    protected $fillable = [
    'code',
    'name',
    'description',
    'icon',
    'state'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function system()
    {
        return $this->belongsTo(System::class);
    }

}
