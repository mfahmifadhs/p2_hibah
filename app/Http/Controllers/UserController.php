<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\Role;
use App\Models\TimKerja;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $data    = User::count();
        $role    = Role::get();
        $uker    = UnitKerja::get();
        $timker  = TimKerja::get();
        $jabatan = Jabatan::get();
        $status  = $request->status;
        $pegawai = Pegawai::get();

        $listUker    = UnitKerja::orderBy('nama_uker', 'asc')->get();
        $listJabatan = Jabatan::get();

        return view('pages.users.show', compact('pegawai', 'role', 'uker', 'timker', 'jabatan', 'data', 'status', 'listUker', 'listJabatan'));
    }

    public function detail($id)
    {
        $data = User::findOrFail($id);

        return view('pages.users.detail', compact('data'));
    }

    public function select(Request $request)
    {
        $uker       = $request->uker;
        $jabatan    = $request->jabatan;
        $status     = $request->status;
        $search     = $request->search;

        $data       = User::orderBy('status', 'desc');

        if ($uker || $jabatan || $status || $search) {

            if ($uker) {
                $res = $data->whereHas('pegawai.uker', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($jabatan) {
                $res = $data->whereHas('pegawai', function ($query) use ($jabatan) {
                    $query->where('jabatan_id', $jabatan);
                });
            }

            if ($status) {
                $res = $data->where('status', $status);
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
                <a href="' . route('users.detail', $row->id) . '" class="text-dark rounded border-dark">
                    <i class="bi bi-info-circle p-1" style="font-size: 12px;"></i>
                </a>

                <a href="' . route('users.edit', $row->id) . '" class="text-dark rounded border-dark">
                    <i class="bi bi-pencil p-1" style="font-size: 12px;"></i>
                </a>
            ';

            if ($row->status == 'true') {
                $status .= '
                    <span class="badge bg-success">Aktif</span>
                ';
            } else {
                $status .= '
                    <span class="badge bg-danger">Tidak aktif</span>
                ';
            }

            $response[] = [
                'no'       => $no,
                'id'       => $row->id,
                'aksi'     => $aksi,
                'role'     => $row->role->nama_role,
                'nama'     => $row->pegawai->nama,
                'username' => $row->username,
                'uker'     => $row->pegawai->uker->nama_uker ?? '',
                'jabatan'  => $row->pegawai->jabatan->nama_jabatan,
                'timker'   => $row->pegawai->timker->nama_timker ?? '',
                'status'   => $status
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function create()
    {
        $role    = Role::get();

        return view('pages.users.create', compact('role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id'    => 'required',
            'username'   => 'unique:users',
            'pegawai_id' => 'unique:users',
        ]);

        $id   = User::withTrashed()->count() + 1;

        User::create([
            'id'            => $id,
            'role_id'       => $request->role_id,
            'pegawai_id'    => $request->pegawai_id,
            'username'      => $request->username,
            'akses'         => $request->akses,
            'password'      => Hash::make($request->password),
            'password_text' => $request->password,
            'status'        => $request->status
        ]);

        return redirect()->route('users')->with('success', 'Berhasil Menambahkan');
    }

    public function edit($id)
    {
        $data  = User::findOrFail($id);
        $role  = Role::get();

        return view('pages.users.edit', compact('data', 'role'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username'   => 'unique:users,username,' . $user->id,
            'pegawai_id' => 'unique:users,pegawai_id,' . $user->id
        ]);

        $user->update([
            'role_id'       => $request->role_id,
            'pegawai_id'    => $request->pegawai_id,
            'username'      => $request->username,
            'akses'         => $request->akses,
            'password'      => Hash::make($request->password),
            'password_text' => $request->password,
            'status'        => $request->status
        ]);

        return redirect()->route('users.detail', $id)->with('success', ' Berhasil Menyimpan');
    }
}
