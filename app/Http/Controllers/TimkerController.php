<?php

namespace App\Http\Controllers;

use App\Models\TimKerja;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class TimkerController extends Controller
{
    public function show()
    {
        $data = TimKerja::get();
        $uker = UnitKerja::get();
        return view('pages.users.timker.show', compact('data', 'uker'));
    }

    public function store(Request $request)
    {
        $id = TimKerja::withTrashed()->count() + 1;
        $tambah = new TimKerja();
        $tambah->id          = $id;
        $tambah->uker_id     = $request->uker_id;
        $tambah->nama_timker = $request->timker;
        $tambah->save();

        return redirect()->route('timker')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        TimKerja::where('id', $id)->update([
            'nama_timker' => $request->timker
        ]);

        return redirect()->route('timker')->with('success', 'Berhasil Memperbaharui');
    }
}
