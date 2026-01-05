<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Realisasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "realisasi";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'kegiatan_id',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'nilai',
        'penerima_manfaat',
        'keterangan_output',
        'keterangan_kendala',
        'keterangan_tindaklanjut',
        'keterangan_lain',
        'data_pendukung',
        'status'
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}
