<?php

namespace App\Http\Controllers;

use App\Models\UnitUtama;
use Illuminate\Http\Request;

class UtamaController extends Controller
{
    public function show()
    {
        $data = UnitUtama::get();
        return view('pages.users.utama.show', compact('data'));
    }

    public function update(Request $request, $id)
    {
        UnitUtama::where('id', $id)->update([
            'nama_utama' => $request->utama
        ]);

        return redirect()->route('utama')->with('success', 'Berhasil Memperbaharui');
    }


}
