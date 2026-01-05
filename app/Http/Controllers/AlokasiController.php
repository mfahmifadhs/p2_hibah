<?php

namespace App\Http\Controllers;

use App\Models\Alokasi;
use App\Models\AlokasiRiwayat;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlokasiController extends Controller
{
    public function store(Request $request, $id)
    {
        $nilai     = (float) str_replace('.', '', $request->nilai);
        $alokasiId = Alokasi::withTrashed()->count() + 1;
        $proyek    = Proyek::where('id', $id)->first();
        $alokasi   = Alokasi::where('proyek_id', $id)->sum('nilai_alokasi');

        if ($nilai >= $proyek->total_budget_idr || $alokasi >= $proyek->total_budget_idr) {
            return back()->with('failed', 'Melebihi total anggaran');
        }

        Alokasi::create([
            'id'            => $alokasiId,
            'proyek_id'     => $id,
            'tahun'         => $request->tahun,
            'nilai_alokasi' => $nilai,
            'keterangan'    => $request->keterangan
        ]);

        return redirect()->route('proyek.detail', $id)->with('success', ' Berhasil');
    }

    public function update(Request $request, $id)
    {
        Alokasi::where('id', $id)->update([
            'id'            => $id,
            'proyek_id'     => $request->proyek_id,
            'tahun'         => $request->tahun,
            'nilai_alokasi' => (float) str_replace('.', '', $request->nilai),
            'keterangan'    => $request->keterangan
        ]);

        AlokasiRiwayat::create([
            'alokasi_id'    => $id,
            'tahun'         => $request->tahun,
            'tanggal'       => Carbon::now(),
            'nilai_alokasi' => (float) str_replace('.', '', $request->nilai),
            'keterangan'    => $request->keterangan
        ]);

        return redirect()->route('proyek.detail', $request->proyek_id)->with('success', ' Berhasil');
    }
}
