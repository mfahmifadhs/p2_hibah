<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Role;
use App\Models\TimKerja;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function show(Request $request)
    {
        $data    = Pegawai::count();
        $role    = Role::get();
        $uker    = UnitKerja::get();
        $timker  = TimKerja::get();
        $jabatan = Jabatan::get();
        $status  = $request->status;

        $listUker    = UnitKerja::orderBy('nama_uker', 'asc')->get();
        $listJabatan = Jabatan::get();

        return view('pages.pegawai.show', compact('role', 'uker', 'timker', 'jabatan', 'data', 'status', 'listUker', 'listJabatan'));
    }

    public function detail($id)
    {
        $data = Pegawai::findOrFail($id);

        return view('pages.pegawai.detail', compact('data'));
    }

    public function create()
    {
        $uker    = UnitKerja::get();
        $timker  = TimKerja::get();
        $jabatan = Jabatan::get();

        return view('pages.pegawai.create', compact('uker', 'timker', 'jabatan'));
    }

    public function select(Request $request)
    {
        $uker       = $request->uker;
        $jabatan    = $request->jabatan;
        $search     = $request->search;

        $data       = Pegawai::orderBy('nama', 'desc');

        if ($uker || $jabatan || $search) {

            if ($uker) {
                $res = $data->whereHas('uker', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($jabatan) {
                $res = $data->whereHas('pegawai', function ($query) use ($jabatan) {
                    $query->where('jabatan_id', $jabatan);
                });
            }

            if ($search) {
                $res = $data->whereHas('pegawai.uker', function ($query) use ($search) {
                    $query->where('nama_pegawai', 'like', '%' . $search . '%');
                });
            }

            $result = $res->get();
        } else {
            $result = $data->get();
        }

        $no         = 1;
        $response   = [];
        foreach ($result as $row) {
            $aksi   = '';
            $status = '';

            $aksi .= '
                <a href="' . route('users.edit', $row->id) . '" class="text-dark rounded border-dark">
                    <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                </a>
            ';

            $response[] = [
                'no'         => $no,
                'id'         => $row->id,
                'aksi'       => $aksi,
                'uker'       => $row->uker->nama_uker,
                'nip'        => $row->nip,
                'nama'       => $row->nama,
                'notelp'     => $row->no_telepon,
                'email'      => $row->email,
                'jabatan'    => $row->jabatan->nama_jabatan,
                'timker'     => $row->timker->nama_timker ?? '',
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'nullable|unique:pegawai,email',
            'nip'   => 'required|min:18',
        ]);

        Pegawai::create([
            'uker_id'       => $request->uker,
            'timker_id'     => $request->timker,
            'jabatan_id'    => $request->jabatan,
            'nama'          => $request->nama,
            'nip'           => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon'    => $request->no_telepon,
            'email'         => $request->email
        ]);

        return redirect()->route('pegawai')->with('success', ' Berhasil Menambah Data');
    }

    public function get($id)
    {
        $pegawai = Pegawai::with(['uker', 'timker', 'jabatan'])->findOrFail($id);

        return response()->json([
            'nama'          => $pegawai->nama,
            'nip'           => $pegawai->nip,
            'jenis_kelamin' => $pegawai->jenis_kelamin,
            'no_telp'       => $pegawai->no_telepon,
            'email'         => $pegawai->email,
            'uker'          => optional($pegawai->uker)->nama_uker ?? '-',
            'timker'        => optional($pegawai->timker)->nama_timker ?? '-',
            'jabatan'       => optional($pegawai->jabatan)->nama_jabatan ?? '-',
        ]);
    }

    public function edit($id)
    {
        $uker    = UnitKerja::get();
        $timker  = TimKerja::get();
        $jabatan = Jabatan::get();
        $data    = Pegawai::findOrFail($id);

        return view('pages.pegawai.edit', compact('uker', 'timker', 'jabatan', 'data'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $request->validate([
            'nama'  => 'required|string|max:255',
            'email' => 'nullable|unique:pegawai,email' . $pegawai->id,
            'nip'   => 'required|min:18',
        ]);

        $pegawai->update([
            'uker_id'       => $request->uker,
            'timker_id'     => $request->timker,
            'jabatan_id'    => $request->jabatan,
            'nama'          => $request->nama,
            'nip'           => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon'    => $request->no_telepon,
            'email'         => $request->email
        ]);

        return redirect()->route('pegawai')->with('success', ' Berhasil Menyimpan Data');
    }

    public function delete($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return back()->with('success', 'Berhasil Menghapus');
    }

    public function json(Request $request)
    {
        $search = $request->search;

        $data = Pegawai::where('nama', 'like', "%$search%")
            ->select('id', 'nama as text')
            ->limit(20)
            ->get();

        return response()->json($data);
    }
}
