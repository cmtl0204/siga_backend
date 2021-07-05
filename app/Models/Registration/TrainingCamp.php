<?php

namespace App\Models\Registration;

// Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;

// Application
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\App\Catalogue;

/**
 * @property BigInteger id
 * @property string name
 */
class TrainingCamp extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-registration';
    protected $table = 'registration.training_camps';

    protected $fillable = [
        'name',];

}
