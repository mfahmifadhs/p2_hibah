<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\DonorUker;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class DonorUkerController extends Controller
{
    public function show()
    {
        $data  = DonorUker::get();
        $uker  = UnitKerja::get();
        $donor = Donor::get();
        return view('pages.users.uker.donor.show', compact('data', 'uker', 'donor'));
    }

    public function store(Request $request)
    {
        $cek = DonorUker::where('uker_id', $request->uker_id)
            ->where('donor_id', $request->donor_id)
            ->exists();

        if ($cek) {
            return redirect()->back()
                ->with('failed', 'Donor tersebut sudah terdaftar pada unit kerja ini.')
                ->withInput();
        }

        $id = DonorUker::withTrashed()->count() + 1;
        $tambah = new DonorUker();
        $tambah->id       = $id;
        $tambah->uker_id  = $request->uker_id;
        $tambah->donor_id = $request->donor_id;
        $tambah->save();

        return redirect()->route('donor-uker.show')->with('success', 'Berhasil Menambahkan');
    }

    public function update(Request $request, $id)
    {
        $cek = DonorUker::where('uker_id', $request->uker_id)
            ->where('donor_id', $request->donor_id)
            ->exists();

        if ($cek) {
            return redirect()->back()
                ->with('failed', 'Donor tersebut sudah terdaftar pada unit kerja ini.')
                ->withInput();
        }

        DonorUker::where('id', $id)->update([
            'uker_id'  => $request->uker_id,
            'donor_id' => $request->donor_id
        ]);

        return redirect()->route('donor-uker.show')->with('success', 'Berhasil Memperbaharui');
    }

    public function delete($id)
    {
        DonorUker::where('id', $id)->delete();
        return redirect()->route('donor-uker.show')->with('success', 'Berhasil Menghapus');
    }
}
