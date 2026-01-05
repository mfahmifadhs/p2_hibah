<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Kegiatan;
use App\Models\Pencairan;
use App\Models\PencairanTimeline;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

class PencairanController extends Controller
{
    public function show(Request $request)
    {
        $data     = Pencairan::count();
        $user     = User::get();
        $uker     = UnitKerja::get();
        $donor    = Donor::get();

        $select = new \stdClass();
        $select->uker    = $request->uker;
        $select->status  = $request->status;

        return view('pages.pencairan.show', compact('data', 'user', 'uker', 'donor', 'select'));
    }

    public function detail($id)
    {
        $data = Pencairan::where('id', $id)->first();

        $total = new \stdClass();
        $total->kegiatan    = $data->kegiatan->nilai_kegiatan;
        $total->pencairan   = $data->kegiatan->pencairan->sum('total');
        $total->sisa        = $total->kegiatan - $total->pencairan;
        $total->realisasi   = $total->kegiatan - $data->kegiatan->realisasi->sum('nilai');

        return view('pages.pencairan.detail', compact('id', 'data', 'total'));
    }

    public function select(Request $request)
    {
        $uker     = $request->uker;
        $status   = $request->status;
        $search   = $request->search;
        $user_id  = Auth::user()->id;

        $data     = Pencairan::orderBy('status_1', 'asc');

        if (Auth::user()->role_id == 4) {
            $res = $data->whereHas('kegiatan.proyek', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            });
        }

        if ($uker || $status || $search) {

            if ($uker) {
                $res = $data->whereHas('kegiatan.proyek.user.pegawai', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($status) {
                if ($status == 'status_1') {
                    $res = $data->whereNull('status_1');
                }

                if ($status == 'status_2') {
                    $res = $data->where('status_1', 'true')->whereNull('status_2');
                }

                if ($status == 'true') {
                    $res = $data->where('status_1', 'true')->where('status_2', 'true');
                }

                if ($status == 'false') {
                    $res = $data->where('status_1', 'false')->orWhere('status_2', 'false');
                }
            }

            if ($search) {
                $res = $data->whereHas('kegiatan.pegawai.uker.pegawai', function ($query) use ($search) {
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
                <a href="' . route('pencairan.detail', $row->id) . '" class="text-dark rounded border-dark">
                    <i class="bi bi-info-circle-fill p-1"></i>
                </a>
            ';

            if (!$row->status_1 || !$row->status_2) {
                $aksi .= '
                    <a href="' . route('pencairan.edit', $row->id) . '" class="text-dark rounded border-dark">
                        <i class="bi bi-pencil-square p-1"></i>
                    </a>
                ';
            }

            if (!$row->status_1 || !$row->status_2) {
                $status = '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Verifikasi</span>';
            } else if ($row->status_1 == 'false' || $row->status_1 == 'false') {
                $status = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>';
            } else if ($row->status_1 == 'true' && $row->status_2 == 'true') {
                $status = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Setuju</span>';
            }

            $response[] = [
                'no'        => $no,
                'id'        => $row->id,
                'aksi'      => $aksi,
                'uker'      => $row->kegiatan->proyek?->user->pegawai->uker->nama_uker,
                'kegiatan'  => $row->kegiatan?->nama,
                'perihal'   => $row->perihal,
                'tanggal'   => Carbon::parse($row->tanggal)->isoFormat('DD MMM Y'),
                'total'     => 'Rp ' . number_format($row->total, 0, ',', '.'),
                'status'    => $status
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function create($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();

        if ($kegiatan->proyek->user_id != Auth::user()->id) {
            return back()->with('failed', 'Eror');
        }

        $total = new \stdClass();
        $total->kegiatan    = $kegiatan->nilai_kegiatan;
        $total->pencairan   = $kegiatan->pencairan->sum('total');
        $total->sisa        = $total->kegiatan - $total->pencairan;
        $total->realisasi   = $total->kegiatan - $kegiatan->realisasi->sum('nilai');

        return view('pages.pencairan.create', compact('id', 'kegiatan', 'total'));
    }

    public function store(Request $request)
    {
        $kegiatan   = Kegiatan::findOrFail($request->kegiatan_id);
        $pencairan  = Pencairan::where('kegiatan_id', $request->kegiatan_id)->where('status_2', 'true')->sum('total');
        $nilai_kegiatan = $kegiatan->nilai_kegiatan - $pencairan;

        $request->validate([
            'lampiran'   => ['file', 'mimes:pdf', 'max:2048'],
        ]);

        $total = (float) str_replace('.', '', $request->total);

        if ($total > $nilai_kegiatan) {
            return back()
                ->withErrors(['nominal' => 'Nominal pencairan tidak boleh lebih besar dari nilai kegiatan (' . number_format($kegiatan->nilai_kegiatan, 0, ',', '.') . ').'])
                ->withInput();
        }

        $id   = Pencairan::withTrashed()->count() + 1;

        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_pencairan', 'public');
        } else {
            $lampiranPath = null;
        }

        Pencairan::create([
            'id'            => $id,
            'kegiatan_id'   => $request->kegiatan_id,
            'perihal'       => $request->perihal,
            'tanggal'       => Carbon::now(),
            'total'         => $total,
            'keterangan'    => $request->keterangan,
            'lampiran'      => $lampiranPath
        ]);

        PencairanTimeline::create([
            'id'            => PencairanTimeline::withTrashed()->count() + 1,
            'user_id'       => Auth::user()->id,
            'pencairan_id'  => $id,
            'status'        => 'kirim',
            'keterangan'    => 'Mengusulkan pencairan',
            'created_at'    => Carbon::now()
        ]);

        return redirect()->route('pencairan.detail', $id)->with('success', ' Berhasil Mengajukan');
    }


    public function edit($id)
    {
        $data = Pencairan::where('id', $id)->first();

        if ($data->kegiatan->proyek->user_id != Auth::user()->id) {
            return back()->with('failed', 'Eror');
        }

        return view('pages.pencairan.edit', compact('id', 'data'));
    }

    public function update(Request $request, $id)
    {
        $data = Pencairan::findOrFail($id);

        $request->validate([
            'lampiran'   => ['file', 'mimes:pdf', 'max:2048'],
        ]);

        $total = (float) str_replace('.', '', $request->total);

        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_pencairan', 'public');
        } else {
            $lampiranPath = $request->lampiran_data ?? null;
        }

        $data->update([
            'kegiatan_id'   => $request->kegiatan_id,
            'perihal'       => $request->perihal,
            'tanggal'       => Carbon::now(),
            'total'         => $total,
            'keterangan'    => $request->keterangan,
            'lampiran'      => $lampiranPath
        ]);

        return redirect()->route('pencairan.detail', $id)->with('success', ' Berhasil Menyimpan');
    }

    public function delete($id)
    {
        Pencairan::where('id', $id)->delete();

        return back()->with('success', 'Berhasil Menghapus');
    }

    public function lampiran($filename)
    {
        $path = storage_path('app/public/lampiran_pencairan/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function verif(Request $request, $id)
    {
        if ($id == '*') {
            $pencairanId = $request->pencairan_id;

            foreach ($pencairanId as $i => $id) {
                $data       = Pencairan::findOrFail($id);
                $status     = $request->status[$i];
                $keterangan = $request->keterangan[$i];

                if ($status) {
                    $data->update([
                        'status' => $status
                    ]);

                    $statusData = $status == 'false' ? 'kembali' : ($status == 'true' ? 'true' : 'kirim');

                    PencairanTimeline::create([
                        'user_id'      => Auth::user()->id,
                        'pencairan_id' => $id,
                        'status'       => $statusData,
                        'keterangan'   => $status == 'true' ? 'Disetujui' : $keterangan
                    ]);
                }
            }

            return redirect()->route('pencairan.show')->with('success', 'Berhasil Verifikasi');
        }

        $data = Pencairan::findOrFail($id);

        if ($request->aksi == 'revisi') {
            $data->update([
                'status_1' => $data->status_1 == 'false' ? null : $data->status_1,
                'status_2' => $data->status_2 == 'false' ? null : null,
            ]);

            $dataId = PencairanTimeline::withTrashed()->count() + 1;
            PencairanTimeline::create([
                'id'            => $dataId,
                'user_id'       => Auth::user()->id,
                'pencairan_id'  => $id,
                'status'        => 'kirim',
                'keterangan'    => 'Selesai diperbaiki'
            ]);

            return redirect()->route('pencairan.detail', $id)->with('success', 'Berhasil Proses');
        } else {
            $data->update([
                'status_1' => !$data->status_1 ? $request->status : $data->status_1,
                'status_2' => $data->status_1 == 'true' ? $request->status : null,
            ]);

            $dataId = PencairanTimeline::withTrashed()->count() + 1;
            PencairanTimeline::create([
                'id'            => $dataId,
                'user_id'       => Auth::user()->id,
                'pencairan_id'  => $id,
                'status'        => 'kirim',
                'keterangan'    => $request->status == 'false' ? $request->keterangan : 'Disetujui'
            ]);

            return redirect()->route('pencairan.detail', $id)->with('success', 'Berhasil Proses');
        }
    }
}
