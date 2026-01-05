<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alokasi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "alokasi";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'proyek_id',
        'tahun',
        'nilai_alokasi',
        'keterangan'
    ];

    public function proyek()
    {
        return $this->hasMany(Proyek::class, 'proyek_id');
    }

    public function riwayat()
    {
        return $this->hasMany(AlokasiRiwayat::class, 'alokasi_id');
    }
}
