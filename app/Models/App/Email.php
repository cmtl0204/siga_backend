<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model implements Auditable
{
    use HasFactory;
    use OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $connection = 'pgsql-app';
    protected $table = 'app.emails';

    protected $fillable = [
        'to',
        'from',
        'from_name',
        'subject',
        'body',
        'state'
    ];
}