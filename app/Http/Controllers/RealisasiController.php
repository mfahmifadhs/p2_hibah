<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Realisasi;
use Illuminate\Http\Request;

class RealisasiController extends Controller
{
    public function detail($id)
    {
        $data = Realisasi::where('id', $id)->first();
        return view('pages.realisasi.detail', compact('id', 'data'));
    }

    public function create($id)
    {
        $data = Kegiatan::where('id', $id)->first();

        if ($data->status != 'true') {
            return back()->with('failed', 'Kegiatan belum disetujui');
        }

        return view('pages.realisasi.create', compact('id', 'data'));
    }

    public function store(Request $request)
    {
        $id   = Realisasi::withTrashed()->count() + 1;

        Realisasi::create([
            'id'                        => $id,
            'kegiatan_id'               => $request->kegiatan_id,
            'deskripsi'                 => $request->deskripsi,
            'tanggal_mulai'             => $request->tanggal_mulai,
            'tanggal_selesai'           => $request->tanggal_selesai,
            'nilai'                     => (float) str_replace('.', '', $request->nilai),
            'penerima_manfaat'          => $request->penerima_manfaat,
            'keterangan_output'         => $request->keterangan_output,
            'keterangan_kendala'        => $request->keterangan_kendala,
            'keterangan_tindaklanjut'   => $request->keterangan_tindaklanjut,
            'keterangan_lain'           => $request->keterangan_lain,
            'data_pendukung'            => $request->data_pendukung
        ]);

        return redirect()->route('kegiatan.detail', $request->kegiatan_id)->with('success', ' Berhasil Menambah Data');
    }

    public function edit($id)
    {
        $data = Realisasi::where('id', $id)->first();

        return view('pages.realisasi.edit', compact('id', 'data'));
    }

    public function update(Request $request, $id)
    {
        $realisasi = Realisasi::findOrFail($id);

        $realisasi->update([
            'id'                        => $id,
            'kegiatan_id'               => $request->kegiatan_id,
            'deskripsi'                 => $request->deskripsi,
            'tanggal_mulai'             => $request->tanggal_mulai,
            'tanggal_selesai'           => $request->tanggal_selesai,
            'nilai'                     => (float) str_replace('.', '', $request->nilai),
            'penerima_manfaat'          => $request->penerima_manfaat,
            'keterangan_output'         => $request->keterangan_output,
            'keterangan_kendala'        => $request->keterangan_kendala,
            'keterangan_tindaklanjut'   => $request->keterangan_tindaklanjut,
            'keterangan_lain'           => $request->keterangan_lain,
            'data_pendukung'            => $request->data_pendukung
        ]);

        return redirect()->route('kegiatan.detail', $request->kegiatan_id)->with('success', ' Berhasil Menyimpan');
    }
}
