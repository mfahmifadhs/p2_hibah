<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonorUker extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "donor_uker";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'uker_id',
        'donor_id'
    ];

    public function uker()
    {
        return $this->belongsTo(UnitKerja::class, 'uker_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'donor_id');
    }
}
