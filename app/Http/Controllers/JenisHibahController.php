<?php

namespace App\Http\Controllers;

use App\Models\JenisHibah;
use Illuminate\Http\Request;

class JenisHibahController extends Controller
{
    public function show()
    {
        $data = JenisHibah::get();
        return view('pages.donor.jenis.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = JenisHibah::withTrashed()->count() + 1;
        $tambah = new JenisHibah();
        $tambah->id          = $id;
        $tambah->nama_jenis  = $request->jenis;
        $tambah->deskripsi   = $request->deskripsi;
        $tambah->save();

        return redirect()->route('jenisHibah.show')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        JenisHibah::where('id', $id)->update([
            'nama_jenis' => $request->jenis,
            'deskripsi'  => $request->deskripsi
        ]);

        return redirect()->route('jenisHibah.show')->with('success', 'Berhasil Memperbaharui');
    }
}
