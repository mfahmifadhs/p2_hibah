<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengadaanDana extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pengadaan_dana";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'pengadaan_id',
        'sumber_dana_id',
        'donor_id',
        'nilai_alokasi',
        'jumlah_alokasi',
        'satuan_alokasi',
        'nilai_realisasi',
        'jumlah_realisasi',
        'satuan_realisasi'
    ];

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'pengadaan_id');
    }

    public function sumber()
    {
        return $this->belongsTo(SumberDana::class, 'sumber_dana_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'donor_id');
    }
}
