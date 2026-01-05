<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "kegiatan";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'proyek_id',
        'kode',
        'nama',
        'jenis_kegiatan_id',
        'volume',
        'satuan_kegiatan_id',
        'rencana_thn_pelaksana',
        'jenis_hibah_id',
        'nilai_kegiatan',
        'nilai_realisasi',
        'justifikasi_realisasi',
        'pilar_pendukung',
        'kode_program',
        'tanggal_mulai',
        'tanggal_selesai',
        'timker_id',
        'penerima_manfaat',
        'keterangan_output',
        'keterangan_kendala',
        'keterangan_tindaklanjut',
        'keterangan_lain',
        'data_pendukung',
        'status'
    ];


    public function uker()
    {
        return $this->belongsTo(User::class, 'user_id')->join('pegawai','id','pegawai_id')->join('unit_kerja','id','uker_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'donor_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusProses::class, 'status_proses_id');
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }

    public function timker()
    {
        return $this->belongsTo(TimKerja::class, 'timker_id');
    }

    public function jenisKegiatan()
    {
        return $this->belongsTo(JenisKegiatan::class, 'jenis_kegiatan_id');
    }

    public function jenisHibah()
    {
        return $this->belongsTo(JenisHibah::class, 'jenis_hibah_id');
    }

    public function satuanKegiatan()
    {
        return $this->belongsTo(SatuanKegiatan::class, 'satuan_kegiatan_id');
    }

    public function realisasi()
    {
        return $this->hasMany(Realisasi::class, 'kegiatan_id');
    }

    public function timeline()
    {
        return $this->hasMany(KegiatanTimeline::class, 'kegiatan_id');
    }

    public function pencairan()
    {
        return $this->hasMany(Pencairan::class, 'kegiatan_id');
    }
}
