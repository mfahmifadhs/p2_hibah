<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\UnitUtama;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function show()
    {
        $data = Jabatan::get();
        return view('pages.pegawai.jabatan.show', compact('data'));
    }

    public function update(Request $request, $id)
    {
        Jabatan::where('id', $id)->update([
            'nama_jabatan' => $request->nama_jabatan
        ]);

        return redirect()->route('jabatan')->with('success', 'Berhasil Memperbaharui');
    }


}
