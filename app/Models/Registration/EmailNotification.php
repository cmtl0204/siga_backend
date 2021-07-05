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
 * @property string lastname
 * @property string email
 */
class EmailNotification extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-registration';
    protected $table = 'registration.email_notifications';

    protected $fillable = [
        'name',
        'lastname',
        'email'];

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

}
