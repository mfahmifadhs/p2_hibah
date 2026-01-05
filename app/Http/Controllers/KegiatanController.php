<?php

namespace App\Http\Controllers;

use App\Models\Alokasi;
use App\Models\Donor;
use App\Models\JenisHibah;
use App\Models\JenisKegiatan;
use App\Models\Kegiatan;
use App\Models\KegiatanTimeline;
use App\Models\Program;
use App\Models\Proyek;
use App\Models\SatuanKegiatan;
use App\Models\StatusProses;
use App\Models\TimKerja;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class KegiatanController extends Controller
{

    public function show(Request $request)
    {
        $data     = Kegiatan::count();
        $kegiatan = Kegiatan::whereNull('status')->get();
        $user     = User::get();
        $uker     = UnitKerja::get();
        $donor    = Donor::get();
        $jenis    = JenisKegiatan::get();
        $proyek   = Proyek::orderBy('nama_proyek', 'asc');
        $proyek   = Auth::user()->role_id == 4 ? $proyek->where('user_id', Auth::user()->id)->get() : $proyek->get();
        $tahun    = range(2021, date('Y'));

        $select = new \stdClass();
        $select->uker   = $request->uker_id;
        $select->donor  = $request->donor_id;
        $select->jenis  = $request->jenis_id;
        $select->status = $request->status;
        $select->tahun  = $request->tahun;
        $select->proyek = $request->proyek_id;

        $selUker   = $request->uker_id;
        $selDonor  = $request->donor_id;
        $selJenis  = $request->jenis_id;
        $selStatus = $request->status;
        $selTahun  = $request->tahun;

        $listUker    = UnitKerja::orderBy('nama_uker', 'asc')->get();
        $listDonor   = Donor::orderBy('nama_donor', 'asc')->get();
        $liststatus  = StatusProses::get();

        return view('pages.kegiatan.show', compact('data', 'kegiatan', 'user', 'uker', 'donor', 'proyek', 'jenis', 'tahun', 'select', 'listUker', 'listDonor', 'liststatus'));
    }

    public function detail($id)
    {
        $data = Kegiatan::where('id', $id)->first();

        $total = new \stdClass();
        $total->kegiatan    = $data->nilai_kegiatan;
        $total->pencairan   = $data->pencairan->sum('total');
        $total->sisa        = $total->kegiatan - $total->pencairan;
        $total->realisasi   = $total->kegiatan - $data->realisasi->sum('nilai');

        return view('pages.kegiatan.detail', compact('data', 'total'));
    }

    public function create(Request $request, $id)
    {
        $proyek  = $id ?? null;
        $data    = Proyek::where('id', $id)->first();
        $uker    = UnitKerja::orderBy('nama_uker', 'asc')->get();
        $jenis   = JenisKegiatan::orderBy('nama_jenis', 'asc')->get();
        $program = Program::orderBy('nama_program', 'asc');
        $satuan  = SatuanKegiatan::orderBy('nama_satuan', 'asc')->get();
        $hibah   = JenisHibah::orderBy('nama_jenis', 'asc')->get();
        $tahun   = $request->tahun ?? null;

        $program = Auth::user()->role_id == 4 ? $program->where('uker_id', Auth::user()->pegawai->uker_id)->get() : $program->get();

        if ($data->status != 'true') {
            return back()->with('failed', 'Proyek belum disetujui');
        }

        if (Auth::user()->role_id == 4) {
            $timker = TimKerja::where('uker_id', Auth::user()->pegawai->uker_id)->orderBy('nama_timker', 'asc')->get();
        } else {
            $timker = '';
        }

        return view('pages.kegiatan.create', compact('id', 'data', 'proyek', 'uker', 'timker', 'jenis', 'program', 'satuan', 'hibah', 'tahun'));
    }

    public function store(Request $request)
    {
        $alokasi =  Alokasi::where('proyek_id', $request->proyek_id)->where('tahun', $request->tahun)->sum('nilai_alokasi');
        $nilai   = (float) str_replace('.', '', $request->nilai_kegiatan);

        if ($nilai > $alokasi) {
            return back()->with('failed', 'Melebihi anggaran');
        }

        $id   = Kegiatan::withTrashed()->count() + 1;
        $kode = 'KG' . date('Ymd') . '-' . str_pad($id, 3, '0', STR_PAD_LEFT);

        Kegiatan::create([
            'id'                        => $id,
            'proyek_id'                 => $request->proyek_id,
            'kode'                      => $kode,
            'nama'                      => $request->nama,
            'jenis_kegiatan_id'         => $request->jenis_kegiatan_id,
            'volume'                    => $request->volume,
            'satuan_kegiatan_id'        => $request->satuan_kegiatan_id,
            'rencana_thn_pelaksana'     => $request->tahun,
            'jenis_hibah_id'            => $request->jenis_hibah_id,
            'nilai_kegiatan'            => (float) str_replace('.', '', $request->nilai_kegiatan),
            'nilai_realisasi'           => (float) str_replace('.', '', $request->nilai_realisasi),
            'justifikasi_realisasi'     => $request->justifikasi_realisasi,
            'pilar_pendukung'           => $request->pilar_pendukung,
            'kode_program'              => $request->kode_program,
            'tanggal_mulai'             => $request->tanggal_mulai,
            'tanggal_selesai'           => $request->tanggal_selesai,
            'timker_id'                 => $request->timker_id,
            'penerima_manfaat'          => $request->penerima_manfaat,
            'keterangan_output'         => $request->keterangan_output,
            'keterangan_kendala'        => $request->keterangan_kendala,
            'keterangan_tindaklanjut'   => $request->keterangan_tindaklanjut,
            'keterangan_lain'           => $request->keterangan_lain
        ]);

        return redirect()->route('kegiatan.detail', $id)->with('success', ' Berhasil Menambah Data');
    }

    public function edit($id)
    {
        $data    = Kegiatan::where('id', $id)->first();
        $uker    = UnitKerja::orderBy('nama_uker', 'asc')->get();
        $jenis   = JenisKegiatan::orderBy('nama_jenis', 'asc')->get();
        $satuan  = SatuanKegiatan::orderBy('nama_satuan', 'asc')->get();
        $hibah   = JenisHibah::orderBy('nama_jenis', 'asc')->get();
        $program = Program::orderBy('nama_program', 'asc');
        $program = Auth::user()->role_id == 4 ? $program->where('uker_id', Auth::user()->pegawai->uker_id)->get() : $program->get();

        if($data->status == 'true') {
            return back()->with('failed', 'Tidak dapat diubah');
        }

        if (Auth::user()->role_id == 4) {
            $timker = TimKerja::where('uker_id', Auth::user()->pegawai->uker_id)->orderBy('nama_timker', 'asc')->get();
        } else {
            $timker = '';
        }

        return view('pages.kegiatan.edit', compact('id', 'data', 'uker', 'timker', 'jenis', 'satuan', 'hibah', 'program'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $kegiatan->update([
            'id'                        => $id,
            'proyek_id'                 => $kegiatan->proyek_id,
            'kode'                      => $kegiatan->kode,
            'nama'                      => $request->nama,
            'jenis_kegiatan_id'         => $request->jenis_kegiatan_id,
            'volume'                    => $request->volume,
            'satuan_kegiatan_id'        => $request->satuan_kegiatan_id,
            'rencana_thn_pelaksana'     => $request->tahun,
            'jenis_hibah_id'            => $request->jenis_hibah_id,
            'nilai_kegiatan'            => (float) str_replace('.', '', $request->nilai_kegiatan),
            'nilai_realisasi'           => (float) str_replace('.', '', $request->nilai_realisasi),
            'justifikasi_realisasi'     => $request->justifikasi_realisasi,
            'pilar_pendukung'           => $request->pilar_pendukung,
            'kode_program'              => $request->kode_program,
            'tanggal_mulai'             => $request->tanggal_mulai,
            'tanggal_selesai'           => $request->tanggal_selesai,
            'timker_id'                 => $request->timker_id,
            'penerima_manfaat'          => $request->penerima_manfaat,
            'keterangan_output'         => $request->keterangan_output,
            'keterangan_kendala'        => $request->keterangan_kendala,
            'keterangan_tindaklanjut'   => $request->keterangan_tindaklanjut,
            'keterangan_lain'           => $request->keterangan_lain
        ]);

        return redirect()->route('kegiatan.edit', $id)->with('success', ' Berhasil Menyimpan');
    }

    public function select(Request $request)
    {
        $uker     = $request->uker;
        $donor    = $request->donor;
        $jenis    = $request->jenis;
        $status   = $request->status;
        $search   = $request->search;
        $tahun    = $request->tahun;
        $proyek   = $request->proyek;
        // dd($request->all());

        $user_id  = Auth::user()->id;

        $data     = Kegiatan::orderBy('status', 'asc');

        if (Auth::user()->role_id == 4) {
            $res = $data->whereHas('proyek', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            });
        }

        if ($uker || $donor || $jenis || $status || $search || $tahun || $proyek) {

            if ($uker) {
                $res = $data->whereHas('proyek.user.pegawai', function ($query) use ($uker) {
                    $query->where('uker_id', $uker);
                });
            }

            if ($donor) {
                $res = $data->whereHas('proyek', function ($query) use ($donor) {
                    $query->where('donor_id', $donor);
                });
            }

            if ($jenis) {
                if ($jenis == 'kosong') {
                    $res = $data->whereNull('jenis_kegiatan_id');
                } else {
                    $res = $data->where('jenis_kegiatan_id', $jenis);
                }
            }

            if ($tahun) {
                $res = $data->where('rencana_thn_pelaksana', $tahun);
            }

            if ($proyek) {
                $res = $data->where('proyek_id', $proyek);
            }

            if ($status) {
                if ($status == 'null') {
                    $res = $data->whereNull('kegiatan.status');
                } else {
                    $res = $data->where('kegiatan.status', $status);
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
                    <a href="' . route('kegiatan.detail', $row->id) . '" class="text-dark rounded border-dark">
                        <i class="bi bi-info-circle-fill p-1"></i>
                    </a>
                ';
            }

            if ($row->status != 'true') {
                $aksi .= '
                    <a href="' . route('kegiatan.edit', $row->id) . '" class="text-dark rounded border-dark">
                        <i class="bi bi-pencil-square p-1"></i>
                    </a>
                ';
            }

            if ($row->status == 'true' && $row->proyek->user_id == Auth::user()->id) {
                $aksi .= '
                    <a href="' . route('pencairan.create', $row->id) . '" class="text-dark rounded border-dark">
                        <i class="bi bi-cash-stack p-1 text-primary"></i>
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
                'uker'      => $row->proyek?->user->pegawai->uker->nama_uker,
                'proyek'    => $row->proyek?->nama_proyek,
                'donor'     => $row->proyek?->donor->nama_donor,
                'kode'      => $row->proyek?->kode_hibah,
                'register'  => $row->proyek?->no_register,
                'proyek'    => $row->proyek?->nama_proyek,
                'nama'      => $row->nama,
                'jenis'     => $row->jenisKegiatan?->nama_jenis ?? null,
                'volume'    => $row->volume ?? '',
                'satuan'    => $row->satuanKegiatan?->nama_satuan ?? '',
                'tahun'     => $row->rencana_thn_pelaksana,
                'total'     => 'Rp ' . number_format($row->nilai_kegiatan, 0, ',', '.'),
                'realisasi' => 'Rp ' . number_format($row->nilai_realisasi, 0, ',', '.'),
                'status'    => $status
            ];

            $no++;
        }

        return response()->json($response);
    }

    public function verif(Request $request, $id)
    {
        if ($id == '*') {
            $kegiatanId = $request->kegiatan_id;

            foreach ($kegiatanId as $i => $id) {
                $data       = Kegiatan::findOrFail($id);
                $status     = $request->status[$i];
                $keterangan = $request->keterangan[$i];

                if ($status) {
                    $data->update([
                        'status' => $status
                    ]);

                    $statusData = $status == 'false' ? 'kembali' : ($status == 'true' ? 'true' : 'kirim');

                    KegiatanTimeline::create([
                        'user_id'      => Auth::user()->id,
                        'kegiatan_id'  => $id,
                        'status'       => $statusData,
                        'keterangan'   => $status == 'true' ? 'Disetujui' : $keterangan
                    ]);
                }
            }

            return redirect()->route('kegiatan.show')->with('success', 'Berhasil Verifikasi');
        }

        $data = Kegiatan::findOrFail($id);

        if ($request->revisi) {
            $data->update([
                'status' => null
            ]);

            KegiatanTimeline::create([
                'user_id'       => Auth::user()->id,
                'kegiatan_id'   => $id,
                'status'        => 'kirim',
                'keterangan'    => 'Selesai diperbaiki'
            ]);

            return redirect()->route('kegiatan.detail', $id)->with('success', 'Berhasil Proses');
        } else {
            $data->update([
                'status' => $request->status
            ]);

            KegiatanTimeline::create([
                'user_id'       => Auth::user()->id,
                'kegiatan_id'   => $id,
                'status'        => 'kirim',
                'keterangan'    => $request->status == 'false' ? $request->keterangan : 'Disetujui'
            ]);

            return redirect()->route('kegiatan.detail', $id)->with('success', 'Berhasil Proses');
        }
    }
}
