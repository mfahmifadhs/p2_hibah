<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proyek extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "proyek";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'donor_id',
        'kode_hibah',
        'no_register',
        'nama_proyek',
        'periode_awal',
        'periode_akhir',
        'total_budget_idr',
        'total_budget_usd',
        'total_alokasi',
        'tahun_alokasi',
        'iss',
        'ikp',
        'ikk',
        'keterangan',
        'status',
        'ttd_1',
        'ttd_2',
        'ttd_3',
        'ttd_4',
        'ttd_5'
    ];


    public function uker()
    {
        return $this->belongsTo(User::class, 'user_id')->join('pegawai', 'id', 'pegawai_id')->join('unit_kerja', 'id', 'uker_id');
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

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'proyek_id');
    }

    public function timeline()
    {
        return $this->hasMany(ProyekTimeline::class, 'proyek_id');
    }

    public function alokasi()
    {
        return $this->hasMany(Alokasi::class, 'proyek_id');
    }

    public static function totalPerUnit()
    {
        return self::with(['user.pegawai.uker', 'kegiatan'])
            ->get()
            ->groupBy(fn($proyek) => $proyek->user->pegawai->uker_id ?? null)
            ->map(function ($proyeks) {
                $tahun = '2025';
                $first = $proyeks->first();
                $ukerId    = $first->user->pegawai->uker_id ?? '-';
                $unitKerja = $first->user->pegawai->uker->nama_uker ?? '-';

                $totalAlokasi   = $proyeks->sum(fn($p) => $p->alokasi->where('tahun', $tahun)->sum('nilai_alokasi'));
                $totalRealisasi = $proyeks->sum(fn($p) => $p->kegiatan->where('rencana_thn_pelaksana', $tahun)->sum('nilai_realisasi'));
                $totalAnggaran  = $proyeks->sum(fn($p) => $p->kegiatan->where('rencana_thn_pelaksana', $tahun)->sum('nilai_kegiatan'));

                $persentase = $totalAnggaran > 0
                    ? ($totalRealisasi / $totalAnggaran) * 100
                    : 0;

                return (object) [
                    'uker_id'             => $ukerId,
                    'unit_kerja'          => $unitKerja,
                    'total_alokasi'       => number_format($totalAlokasi, 0, ',', '.'),
                    'total_realisasi'     => number_format($totalRealisasi, 0, ',', '.'),
                    'total_realisasi_int' => $totalRealisasi,
                    'persentase'          => number_format($persentase, 2, ',', '.') . ' %',
                ];
            })
            ->values();
    }

    public static function totalPerDonor()
    {
        return self::with(['donor', 'kegiatan'])
            ->get()
            ->groupBy(fn($donor) => $donor->donor_id ?? null)
            ->map(function ($donors) {
                $tahun = '2025';
                $first = $donors->first();
                $donorId   = $first->donor->id ?? '-';
                $namaDonor = $first->donor->nama_donor ?? '-';

                $totalAlokasi   = $donors->sum(fn($p) => $p->alokasi->where('tahun', $tahun)->sum('nilai_alokasi'));
                $totalRealisasi = $donors->sum(fn($p) => $p->kegiatan->where('rencana_thn_pelaksana', $tahun)->sum('nilai_realisasi'));
                $totalAnggaran  = $donors->sum(fn($p) => $p->kegiatan->where('rencana_thn_pelaksana', $tahun)->sum('nilai_kegiatan'));

                $persentase = $totalAnggaran > 0
                    ? ($totalRealisasi / $totalAnggaran) * 100
                    : 0;

                return (object) [
                    'donor_id'            => $donorId,
                    'nama_donor'          => $namaDonor,
                    'total_alokasi'       => number_format($totalAlokasi, 0, ',', '.'),
                    'total_realisasi'     => number_format($totalRealisasi, 0, ',', '.'),
                    'total_realisasi_int' => $totalRealisasi,
                    'persentase'          => number_format($persentase, 2, ',', '.') . ' %',
                ];
            })
            ->values();
    }
}
