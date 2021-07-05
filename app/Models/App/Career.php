<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $connection = 'pgsql-app';
    protected $table = 'app.careers';

    protected $fillable = [
        'code',
        'name',
        'description',
        'resolution_number',
        'title',
        'acronym',
    ];

    // Relationships
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function modality()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
