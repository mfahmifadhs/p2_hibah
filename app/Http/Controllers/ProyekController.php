<?php

namespace App\Http\Controllers;

use App\Models\Alokasi;
use App\Models\Donor;
use App\Models\Kegiatan;
use App\Models\Proyek;
use App\Models\ProyekTimeline;
use App\Models\StatusProses;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class ProyekController extends Controller
{
    public function show(Request $request)
    {
        $data    = Proyek::count();
        $user    = User::get();
        $donor   = Donor::get();

        $selUker   = $request->uker;
        $selDonor  = $request->donor;
        $selStatus = $request->status;

        $listUker    = UnitKerja::orderBy('nama_uker', 'asc')->get();
        $listDonor   = Donor::orderBy('nama_donor', 'asc')->get();
        $liststatus  = StatusProses::get();

        return view('pages.proyek.show', compact('data', 'user', 'donor', 'selUker', 'selDonor', 'selStatus', 'listUker', 'listDonor', 'liststatus'));
    }

    public function detail(Request $request, $id)
    {
        $data     = Proyek::findOrFail($id);
        $alokasi  = Alokasi::where('proyek_id', $id)->get();
        $aksi     = $request->aksi;
        $tahun    = $request->tahun;
        $kegiatan = Kegiatan::where('proyek_id', $id)->orderBy('status', 'desc')->get();

        $total = new \stdClass();

        $anggaran  = (int) $data->total_budget_idr;
        $realisasi = (int) $data->kegiatan
            ->where('rencana_thn_pelaksana', now()->year)
            ->sum('nilai_realisasi');

        $total->anggaran    = number_format($anggaran, 0, ',', '.');
        $total->realisasi   = number_format($realisasi, 0, ',', '.');
        $total->sisa        = number_format($anggaran - $realisasi, 0, ',', '.');
        $total->persentase  = $anggaran > 0 ? number_format(($realisasi / $anggaran) * 100, 2, ',', '.') . ' %' : '0 %';
        return view('pages.proyek.detail', compact('data', 'alokasi', 'aksi', 'tahun', 'kegiatan', 'total'));
    }

    public function select(Request $request)
    {
        $uker     = $request->uker;
        $donor    = $request->donor;
        $status   = $request->status;
        $search   = $request->search;

        $data     = Proyek::orderBy('status', 'asc');

        if (Auth::user()->role_id == 4) {
            $data = $data->where('user_id', Auth::user()->id);
        }

        if ($uker || $donor || $status || $search) {

            if ($uker) {
                $res = $data->whereHas('user.pegawai', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($donor) {
                $res = $data->where('uker_id', $uker);
            }

            if ($status) {
                if ($status == 'null') {
                    $res = $data->whereNull('status');
                } else {
                    $res = $data->where('status', $status);
                }
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

            if ($row->status != 'false') {
                $aksi .= '
                    <a href="' . route('proyek.detail', $row->id) . '" class="text-dark rounded border-dark">
                        <i class="bi bi-info-circle-fill p-1"></i>
                    </a>
                ';
            }

            if ($row->status == 'false') {
                $aksi .= '
                    <a href="' . route('proyek.edit', $row->id) . '" class="text-dark rounded border-dark">
                        <i class="bi bi-pencil-square p-1"></i>
                    </a>
                ';
            }

            if (!$row->status && (Auth::user()->role_id == 2 && Auth::user()->akses == 'ksphln')) {
                $aksi .= '
                    <a href="' . route('proyek.verif', $row->id) . '" class="text-dark rounded border-dark">
                        <i class="bi bi-arrow-up-right-circle-fill p-1"></i>
                    </a>
                ';
            } else {
                $aksi .= '
                    <a href="' . route('proyek.edit', $row->id) . '" class="text-dark rounded border-dark">
                        <i class="fas fa-edit p-1" style="font-size: 12px;"></i>
                    </a>
                ';
            }

            if (!$row->status) {
                $status = '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Verifikasi</span>';
            } else if ($row->status == 'false') {
                $status = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Tolak</span>';
            } else if ($row->status == 'true') {
                $status = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Setuju</span>';
            }

            $response[] = [
                'no'        => $no,
                'id'        => $row->id,
                'aksi'      => $aksi,
                'user'      => $row->user->pegawai->nama,
                'uker'      => $row->user->pegawai->uker->nama_uker,
                'donor'     => $row->donor->nama_donor,
                'kode'      => $row->kode_hibah,
                'register'  => $row->no_register,
                'proyek'    => $row->nama_proyek,
                'periode'   => $row->periode_awal ? $row->periode_awal . '-' . $row->periode_akhir : $row->periode_akhir,
                'total_idr' => 'Rp ' . number_format($row->total_budget_idr, 0, ',', '.'),
                'total_usd' => '$ ' . number_format($row->total_budget_usd, 2, '.', ','),
                'total_alokasi' => $row->total_alokasi,
                'tahun_alokasi' => $row->tahun_alokasi,
                'iss'        => $row->iss,
                'ikp'        => $row->ikp,
                'ikk'        => $row->ikk,
                'keterangan' => $row->keterangan,
                'status'     => $status
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function create()
    {
        $donor   = Donor::get();

        return view('pages.proyek.create', compact('donor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_register' => 'nullable|unique:proyek,no_register'
        ]);

        $id   = Proyek::withTrashed()->count() + 1;
        Proyek::create([
            'id'                => $id,
            'user_id'           => $request->user_id,
            'donor_id'          => $request->donor_id,
            'kode_hibah'        => $request->kode_hibah,
            'no_register'       => $request->no_register,
            'nama_proyek'       => $request->nama_proyek,
            'periode_awal'      => $request->periode_awal,
            'periode_akhir'     => $request->periode_akhir,
            'total_budget_idr'  => (float) str_replace('.', '', $request->total_budget_idr),
            'total_budget_usd'  => (float) str_replace('.', '', $request->total_budget_usd),
            'total_alokasi'     => (float) str_replace('.', '', $request->total_alokasi),
            'tahun_alokasi'     => $request->tahun_alokasi,
            'iss'               => $request->iss,
            'ikp'               => $request->ikp,
            'ikk'               => $request->ikk,
            'keterangan'        => $request->keterangan,
            'status_proses_id'  => $request->status,
        ]);

        return redirect()->route('proyek.show')->with('success', ' Berhasil Menambah Data');
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
        $data  = Proyek::where('id', $id)->first();
        $donor = Donor::get();

        if ($data->status == 'true' && Auth::user()->role_id == 4) {
            return back()->with('failed', 'Sudah tidak dapat di edit');
        }

        return view('pages.proyek.edit', compact('data', 'donor'));
    }

    public function update(Request $request, $id)
    {
        $proyek = Proyek::findOrFail($id);

        $proyek->update([
            'id'                => $id,
            'user_id'           => $request->user_id,
            'donor_id'          => $request->donor_id,
            'kode_hibah'        => $request->kode_hibah,
            'no_register'       => $request->no_register,
            'nama_proyek'       => $request->nama_proyek,
            'periode_awal'      => $request->periode_awal,
            'periode_akhir'     => $request->periode_akhir,
            'total_budget_idr'  => (float) str_replace('.', '', $request->total_budget_idr),
            'total_budget_usd'  => (float) str_replace('.', '', $request->total_budget_usd),
            'total_alokasi'     => (float) str_replace('.', '', $request->total_alokasi),
            'tahun_alokasi'     => $request->tahun_alokasi,
            'iss'               => $request->iss,
            'ikp'               => $request->ikp,
            'ikk'               => $request->ikk,
            'keterangan'        => $request->keterangan,
        ]);

        return redirect()->route('proyek.edit', $id)->with('success', ' Berhasil Menyimpan');
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

    public function verif(Request $request, $id)
    {
        $data = Proyek::findOrFail($id);

        if ($request->status) {
            $data->update([
                'status' => $request->status
            ]);

            $status = $request->status == 'false' ? 'kembali' : ($request->status == 'true' ? 'true' : 'kirim');

            ProyekTimeline::create([
                'user_id'    => Auth::user()->id,
                'proyek_id'  => $id,
                'status'     => $status,
                'keterangan' => $request->status == 'true' ? 'Disetujui' : $request->keterangan
            ]);

            return redirect()->route('proyek.detail', $id)->with('successs', 'Berhasil Proses');
        }

        if ($request->revisi) {
            $data->update([
                'status' => null
            ]);

            ProyekTimeline::create([
                'user_id'       => Auth::user()->id,
                'proyek_id'     => $id,
                'status'        => 'kirim',
                'keterangan'    => 'Selesai diperbaiki'
            ]);

            return redirect()->route('proyek.detail', $id)->with('successs', 'Berhasil Proses');
        }

        return view('pages.proyek.verif', compact('id', 'data'));
    }
}
