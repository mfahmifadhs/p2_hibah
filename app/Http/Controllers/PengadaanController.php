<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\Pengadaan;
use App\Models\PengadaanDana;
use App\Models\Program;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use Auth;
use Str;

class PengadaanController extends Controller
{
    public function show()
    {
        $data = Pengadaan::count();
        return view('pages.pengadaan.show', compact('data'));
    }

    public function detail($id)
    {
        $data = Pengadaan::where('id', $id)->first();

        $total = new \stdClass();
        $total->alokasi   = number_format($data->dana->sum('nilai_alokasi'), 0, ',', '.');
        $total->realisasi = number_format($data->dana->sum('nilai_realisasi'), 0, ',', '.');
        $total->sisa      = number_format($data->dana->sum('nilai_alokasi') - $data->dana->sum('nilai_realisasi'), 0, ',', '.');

        return view('pages.pengadaan.detail', compact('data', 'total'));
    }

    public function select(Request $request)
    {
        $uker    = $request->uker;
        $program = $request->program;
        $search  = $request->search;

        $data    = Pengadaan::orderBy('nama', 'asc');

        if ($uker || $program || $search) {

            if ($uker) {
                $res = $data->whereHas('program.uker', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($program) {
                $res = $data->where('program_id', $program);
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
                <a href="' . route('pengadaan.detail', $row->id) . '" class="text-dark rounded border-dark">
                    <i class="bi bi-info-circle p-1" style="font-size: 12px;"></i>
                </a>

                <a href="' . route('pengadaan.edit', $row->id) . '" class="text-dark rounded border-dark">
                    <i class="bi bi-pencil p-1" style="font-size: 12px;"></i>
                </a>
            ';

            $response[] = [
                'no'       => $no,
                'id'       => $row->id,
                'aksi'     => $aksi,
                'program'  => $row->program->nama_program,
                'kode'     => $row->kode,
                'nama'     => $row->nama
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function create()
    {
        $data = new \stdClass();
        $data->donor    = Auth::user()->role_id == 4 ? Auth::user()->donor : Donor::get();
        $data->program  = Auth::user()->role_id == 4 ? Auth::user()->program : Program::get();
        $data->dana     = SumberDana::get();

        return view('pages.pengadaan.create', compact('data'));
    }

    public function store(Request $request)
    {
        $id   = Pengadaan::withTrashed()->count() + 1;
        Pengadaan::create([
            'id'         => $id,
            'program_id' => $request->program_id,
            'kode'       => strtoupper(Str::random(8)),
            'nama'       => $request->nama_kegiatan,
        ]);

        if ($request->alokasi_apbn || $request->alokasi_bok || $request->alokasi_donor)
        {

            if ($request->alokasi_apbn) {
                $danaId = PengadaanDana::withTrashed()->count() + 1;
                PengadaanDana::create([
                    'id'               => $danaId,
                    'pengadaan_id'     => $id,
                    'sumber_dana_id'   => 1,
                    'nilai_alokasi'    => (float) str_replace('.', '', $request->alokasi_apbn),
                    'jumlah_alokasi'   => (float) str_replace('.', '', $request->jumlah_alokasi_apbn),
                    'satuan_alokasi'   => strtolower($request->satuan_alokasi_apbn),
                    'nilai_realisasi'  => (float) str_replace('.', '', $request->realisasi_apbn),
                    'jumlah_realisasi' => (float) str_replace('.', '', $request->jumlah_realisasi_apbn),
                    'satuan_realisasi' => strtolower($request->satuan_realisasi_apbn)
                ]);
            }

            if ($request->alokasi_bok) {
                $danaId = PengadaanDana::withTrashed()->count() + 1;
                PengadaanDana::create([
                    'id'               => $danaId,
                    'pengadaan_id'     => $id,
                    'sumber_dana_id'   => 2,
                    'nilai_alokasi'    => (float) str_replace('.', '', $request->alokasi_bok),
                    'jumlah_alokasi'   => (float) str_replace('.', '', $request->jumlah_alokasi_bok),
                    'satuan_alokasi'   => strtolower($request->satuan_alokasi_bok),
                    'nilai_realisasi'  => (float) str_replace('.', '', $request->realisasi_bok),
                    'jumlah_realisasi' => (float) str_replace('.', '', $request->jumlah_realisasi_bok),
                    'satuan_realisasi' => strtolower($request->satuan_realisasi_bok)
                ]);
            }

            if ($request->alokasi_donor) {
                $danaId = PengadaanDana::withTrashed()->count() + 1;
                PengadaanDana::create([
                    'id'               => $danaId,
                    'pengadaan_id'     => $id,
                    'sumber_dana_id'   => 3,
                    'donor_id'         => $request->donor_id,
                    'nilai_alokasi'    => (float) str_replace('.', '', $request->alokasi_donor),
                    'jumlah_alokasi'   => (float) str_replace('.', '', $request->jumlah_alokasi_donor),
                    'satuan_alokasi'   => strtolower($request->satuan_alokasi_donor),
                    'nilai_realisasi'  => (float) str_replace('.', '', $request->realisasi_donor),
                    'jumlah_realisasi' => (float) str_replace('.', '', $request->jumlah_realisasi_donor),
                    'satuan_realisasi' => strtolower($request->satuan_realisasi_donor),
                ]);
            }
        }

        return redirect()->route('pengadaan.detail', $id)->with('success', ' Berhasil Menambah Data');
    }

    public function edit($id)
    {
        $data = new \stdClass();
        $data->pengadaan = Pengadaan::where('id', $id)->first();
        $data->donor     = Auth::user()->role_id == 4 ? Auth::user()->donor : Donor::get();
        $data->program   = Auth::user()->role_id == 4 ? Auth::user()->program : Program::get();
        $data->dana      = SumberDana::get();
        return view('pages.pengadaan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $pengadaan = Pengadaan::findOrFail($id);

        $pengadaan->update([
            'program_id' => $request->program_id,
            'nama'       => $request->nama_kegiatan,
        ]);

        $existingDana = $pengadaan->dana()->pluck('id', 'sumber_dana_id')->toArray();

        $requested = [
            1 => $request->alokasi_apbn ? true : false,
            2 => $request->alokasi_bok ? true : false,
            3 => $request->alokasi_donor ? true : false,
        ];

        foreach ($existingDana as $sumberDanaId => $rowId) {
            if (!($requested[$sumberDanaId] ?? false)) {
                PengadaanDana::where('id', $rowId)->delete();
            }
        }

        foreach ($requested as $sumberId => $active) {
            if (!$active) continue; // skip jika tidak dipakai

            // Cek apakah sumber dana sudah ada
            $rowId = $existingDana[$sumberId] ?? null;

            // Data yang akan disimpan
            $data = [
                'pengadaan_id'     => $id,
                'sumber_dana_id'   => $sumberId,
                'nilai_alokasi'    => (float) str_replace('.', '', $request->input("alokasi_" . strtolower($this->keyName($sumberId)))),
                'jumlah_alokasi'   => (float) str_replace('.', '', $request->input("jumlah_alokasi_" . strtolower($this->keyName($sumberId)))),
                'satuan_alokasi'   => strtolower($request->input("satuan_alokasi_" . strtolower($this->keyName($sumberId)))),
                'nilai_realisasi'  => (float) str_replace('.', '', $request->input("realisasi_" . strtolower($this->keyName($sumberId)))),
                'jumlah_realisasi' => (float) str_replace('.', '', $request->input("jumlah_realisasi_" . strtolower($this->keyName($sumberId)))),
                'satuan_realisasi' => strtolower($request->input("satuan_realisasi_" . strtolower($this->keyName($sumberId)))),
            ];

            // khusus DONOR (id = 3)
            if ($sumberId == 3) {
                $data['donor_id'] = $request->donor_id;
            }

            // Jika sudah ada → UPDATE
            if ($rowId) {
                PengadaanDana::where('id', $rowId)->update($data);
            }
            // Jika belum ada → CREATE
            else {
                $newId = PengadaanDana::withTrashed()->count() + 1;
                $data['id'] = $newId;
                PengadaanDana::create($data);
            }
        }

        return redirect()
            ->route('pengadaan.detail', $id)
            ->with('success', 'Berhasil Update Data');
    }

    public function matriks()
    {
        $data = Program::get();
        return view('pages.pengadaan.matriks', compact('data'));
    }
}
