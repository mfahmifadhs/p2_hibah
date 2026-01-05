<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function show()
    {
        $data = Donor::get();
        return view('pages.donor.show', compact('data'));
    }

    public function store(Request $request)
    {
        $id = Donor::withTrashed()->count() + 1;
        $tambah = new Donor();
        $tambah->id          = $id;
        $tambah->nama_donor  = $request->donor;
        $tambah->deskripsi   = $request->deskripsi;
        $tambah->save();

        return redirect()->route('donor.show')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        Donor::where('id', $id)->update([
            'nama_donor' => $request->donor,
            'deskripsi'  => $request->deskripsi
        ]);

        return redirect()->route('donor.show')->with('success', 'Berhasil Memperbaharui');
    }
}
