<?php

namespace App\Models\JobBoard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable as Auditing;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Brick\Math\BigInteger;
use App\Models\App\Catalogue;
use App\Models\App\File;

/**
 * @property BigInteger id
 * @property string institution
 * @property string position
 * @property string contact_name
 * @property string contact_phone
 * @property string contact_email
 */
class Reference extends Model implements Auditable
{
    use Auditing;
    use softDeletes;

    private static $instance;

    protected $connection = 'pgsql-job-board';
    protected $table = 'job_board.references';
    protected $with = ['professional','institution'];

    
    protected $fillable = [
        'institution',
        'position',
        'contact_name',
        'contact_phone',
        'contact_email',
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
    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function institution()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }


    // Mutators
    public function setInstitutionAttribute($value)
    {
        $this->attributes['institution'] = strtoupper($value);
    }

    public function setPositionAttribute($value)
    {
        $this->attributes['position'] = strtoupper($value);
    }

    public function setContactNameAttribute($value)
    {
        $this->attributes['contact_name'] = strtoupper($value);
    }

    // Scopes
    public function scopeInstitution($query, $institution)
    {
        if ($institution) {

            return $query->where('institution', 'ILIKE', "%$institution%");
        }
    }

    public function scopePosition($query, $position)
    {
        if ($position) {

            return $query->orWhere('position', 'ILIKE', "%$position%");
        }
    }

    public function scopeContactName($query, $contactName)
    {
        if ($contactName) {
            return $query->orWhere('contact_name', 'ILIKE', "%$contactName%");
        }
    }

    public function scopeContactPhone($query, $contact_phone)
    {
        if ($contact_phone) {
            return $query->orWhere('contact_phone', 'ILIKE', "%$contact_phone%");
        }
    }

    public function scopeContactEmail($query, $contact_email)
    {
        if ($contact_email) {
            return $query->orWhere('contact_email', 'ILIKE', "%$contact_email%");
        }
    }
}