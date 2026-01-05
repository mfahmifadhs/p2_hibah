<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlokasiRiwayat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "alokasi_riwayat";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'alokasi_id',
        'tahun',
        'tanggal',
        'nilai_alokasi',
        'keterangan'
    ];

    public function alokasi()
    {
        return $this->belongsTo(Alokasi::class, 'alokasi_id');
    }
}
