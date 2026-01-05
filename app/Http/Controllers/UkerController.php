<?php

namespace App\Http\Controllers;

use App\Models\TimKerja;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UkerController extends Controller
{
    public function show()
    {
        $data = UnitKerja::get();
        return view('pages.users.uker.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = UnitKerja::withTrashed()->count() + 1;
        $tambah = new UnitKerja();
        $tambah->id         = $id;
        $tambah->nama_uker  = $request->uker;
        $tambah->save();

        return redirect()->route('uker')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        UnitKerja::where('id', $id)->update([
            'nama_uker' => $request->uker
        ]);

        return redirect()->route('uker')->with('success', 'Berhasil Memperbaharui');
    }

    public function timker($uker_id)
    {
        $timker = TimKerja::where('uker_id', $uker_id)->get();
        return response()->json($timker);
    }
}
