<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "unit_kerja";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'utama_id',
        'nama_uker'
    ];

    public function donor()
    {
        return $this->hasMany(DonorUker::class, 'uker_id');
    }
}
