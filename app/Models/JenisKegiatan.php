<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Auth;

class JenisKegiatan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "jenis_kegiatan";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'nama_jenis',
        'deskripsi'
    ];


    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'jenis_kegiatan_id');
    }

    public static function totalPerJenis()
    {
        $data = self::with(['kegiatan.proyek.alokasi'])->get();
        $role = Auth::user()->role_id;
        $id   = Auth::user()->id;

        $hasil = $data->map(function ($jenis) use ($role, $id) {
            $tahun = '2025';
            // Ubah relasi kegiatan jadi collection
            $kegiatan = collect($jenis->kegiatan);

            // Jika role = 4, filter kegiatan berdasarkan proyek->user_id
            if ($role == 4 && $id) {
                $kegiatan = $kegiatan->filter(function ($item) use ($id) {
                    return optional($item->proyek)->user_id == $id;
                });
            }

            $proyekList = $kegiatan->pluck('proyek')->unique('id')->filter();

            $totalAlokasi = $proyekList->flatMap(function ($proyek) use ($tahun) {
                return $proyek->alokasi->where('tahun', $tahun);
            })->sum('nilai_alokasi');

            $totalRealisasi = $kegiatan->where('rencana_thn_pelaksana', $tahun)->sum('nilai_realisasi');
            $totalAnggaran  = $kegiatan->where('rencana_thn_pelaksana', $tahun)->sum('nilai_kegiatan');

            $alokasi = (float) $totalAlokasi;
            $realisasi = (float) $totalRealisasi;

            $persentase = $alokasi > 0
                ? ($realisasi / $alokasi) * 100
                : 0;

            return (object) [
                'jenis_id'            => $jenis->id,
                'nama_jenis'          => strtoupper($jenis->nama_jenis ?? '-'),
                'total_alokasi'       => 'Rp ' . number_format($totalAlokasi, 0, ',', '.'),
                'total_alokasi_raw'   => $totalAlokasi,
                'total_realisasi'     => 'Rp ' . number_format($totalRealisasi, 0, ',', '.'),
                'total_realisasi_int' => $totalRealisasi,
                'persentase'          => number_format($persentase, 2, ',', '.') . ' %',
                'persentase_raw'      => $persentase, 2, ',', '.',
            ];
        });

        // Kegiatan tanpa jenis_kegiatan_id
        $tanpaJenis = \App\Models\Kegiatan::with('proyek.alokasi')->whereNull('jenis_kegiatan_id')
            ->when($role == 4 && $id, function ($query) use ($id) {
                $query->whereHas('proyek', function ($q) use ($id) {
                    $q->where('user_id', $id);
                });
            })
            ->get();

        if ($tanpaJenis->count() > 0) {
            $tahun = '2025';
            $proyekList = $tanpaJenis->pluck('proyek')->unique('id')->filter();

            $totalAlokasi = $proyekList->flatMap(function ($proyek) use ($tahun) {
                return $proyek->alokasi->where('tahun', $tahun);
            })->sum('nilai_alokasi');

            $totalRealisasi = $tanpaJenis->where('rencana_thn_pelaksana', $tahun)->sum('nilai_realisasi');
            $totalAnggaran  = $tanpaJenis->sum('nilai_kegiatan');

            $persentase = $totalAlokasi > 0
                ? ($totalRealisasi / $totalAlokasi) * 100
                : 0;

            $hasil->push((object) [
                'jenis_id'            => 'kosong',
                'nama_jenis'          => 'TIDAK DITENTUKAN',
                'total_alokasi'       => 'Rp ' . number_format($totalAlokasi, 0, ',', '.'),
                'total_alokasi'       => $totalAlokasi,
                'total_realisasi'     => 'Rp ' . number_format($totalRealisasi, 0, ',', '.'),
                'total_realisasi_int' => $totalRealisasi,
                'persentase'          => number_format($persentase, 2, ',', '.') . ' %',
                'persentase_raw'      => $persentase,
            ]);
        }

        return $hasil
            ->sortByDesc(fn($item) => floatval(str_replace(',', '.', $item->persentase)))
            ->values();
    }
}
