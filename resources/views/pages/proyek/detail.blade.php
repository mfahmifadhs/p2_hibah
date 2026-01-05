@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="mb-0 fw-bold">Proyek</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('proyek.show') }}">Proyek</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <!-- Kolom kiri -->
            <div class="col-md-4 border-end pe-4">
                @php
                if (!$data->status) {
                $status = '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Verifikasi</span>';
                } elseif ($data->status == 'false') {
                $status = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Tolak</span>';
                } elseif ($data->status == 'true') {
                $status = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Setuju</span>';
                }
                @endphp
                <div class="row">
                    <div class="col-md-8">
                        {{ $data->donor->nama_donor.' | '.$data->kode_hibah.' | '.$data->no_register }}
                    </div>
                    <div class="col-md-4 text-end">
                        {!! $status !!}
                    </div>
                </div>
                <h3 class="fw-bold">{{ $data->nama_proyek }}</h3>
                <h6 class="mt-0 fs-7    ">{{ $data->user->pegawai->uker->nama_uker}}</h6>
                <p class="fs-7">Periode : {{ $data->periode_awal == $data->periode_akhir ? $data->periode_akhir : $data->periode_awal.' '.$data->periode_akhir }}</p>


                <a href="{{ route('proyek.edit', $data->id) }}" class="btn btn-warning btn-sm w-100 mb-2 border-dark">
                    <i class="bi bi-pencil"></i> Edit
                </a>

                <hr class="border-2">

                <div class="form-group">
                    <label class="fw-bold">ISS</label>
                    <h6>{{ $data->iss }}</h6>
                </div>

                <div class="form-group my-5">
                    <label class="fw-bold">IKP</label>
                    <h6>{{ $data->ikp }}</h6>
                </div>

                <div class="form-group">
                    <label class="fw-bold">IKK</label>
                    <h6>{{ $data->ikk }}</h6>
                </div>

                <hr class="border boder-dark mt-5">

                <div class="form-group">
                    <label class="fw-bold mb-3">Linimasa</label>
                    <div class="timeline small">
                        @foreach ($data->timeline as $row)
                        <div class="time-label fs-8">
                            <span class="text-bg-danger bg-opacity-100">
                                {{ Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM, Y') }}
                            </span>
                        </div>

                        <div>
                            <i class="timeline-icon bi bi-people text-bg-light"> </i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="bi bi-clock-fill"></i>
                                    {{ Carbon\Carbon::parse($row->created_at)->isoFormat('HH:mm') }}
                                </span>
                                <h3 class="timeline-header fs-8">
                                    <a href="#">{{ $row->user->pegawai->nama }}</a>
                                    @if ($row->status == 'kirim') <label> mengirimkan usulan</label> @endif
                                    @if ($row->status == 'kembali') <label> mengembalikan usulan</label> @endif
                                    @if ($row->status == 'true') <label> usulan disetujui</label> @endif
                                </h3>

                                @if ($row->keterangan && $row->status != 'true')
                                <div class="timeline-body fs-8">
                                    {{ $row->keterangan }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom kanan -->
            <div class="col-md-8 ps-4">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="text-dark fw-bold bg-secondary bg-opacity-10 px-3 py-1 rounded">
                            {{ $data->kegiatan->count() }} <br>
                            <small>Kegiatan</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-success fw-bold bg-success bg-opacity-10 px-3 py-1 rounded">
                            Rp {{ $total->anggaran }} <br>
                            <small class="text-muted">Total Budget IDR</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-primary fw-bold bg-primary bg-opacity-10 px-3 py-1 rounded">
                            Rp {{ $total->realisasi }} <br>
                            <small class="text-muted">Total Realisasi</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-danger fw-bold bg-danger bg-opacity-10 px-3 py-1 rounded">
                            Rp {{ $total->sisa }} <br>
                            <small class="text-muted">Sisa Anggaran</small>
                        </div>
                    </div>
                </div>

                @if (!$aksi)

                <label class="fw-bold fs-4 mb-3">Alokasi Anggaran</label>
                @if ($data->periode_awal == $data->periode_akhir)
                <div class="card shadow-sm border-2 rounded-4 p-1 mb-4">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h6 class="fw-bold mb-1 fs-5">
                                Tahun {{ $data->periode_akhir }}
                            </h6>
                            @if ($data->alokasi->where('tahun', $data->periode_akhir)->count() == 1)
                                <p class="fw-bold mb-0 text-primary fs-4">
                                    Rp {{ number_format($data->alokasi->where('tahun', $data->periode_akhir)->first()->nilai_alokasi, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>

                        <div class="card-tools">
                            @if ($data->alokasi->where('tahun', $data->periode_akhir)->count() == 0)
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                                    data-bs-toggle="modal" data-bs-target="#modalAlokasi-{{ $data->periode_akhir }}">
                                    <i class="bi bi-plus-circle-dotted"></i> Tambah
                                </a>
                            @else
                                <div class="d-flex gap-2">
                                    <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm d-flex align-items-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $data->periode_akhir }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="{{ route('proyek.detail', ['id' => $data->id, 'tahun' => $data->periode_akhir, 'aksi' => 'kegiatan']) }}" class="btn btn-outline-primary btn-sm align-items-center">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#modalRiwayat-{{ $data->periode_akhir }}">
                                        <i class="bi bi-file-earmark-text-fill"></i> Riwayat
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                @for ($tahun = $data->periode_awal; $tahun <= $data->periode_akhir; $tahun++)
                <div class="card shadow-sm border-2 rounded-4 p-1 mb-4">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div>
                            <h6 class="fw-bold mb-1 fs-5">
                                Tahun {{ $tahun }}
                            </h6>
                            @if ($data->alokasi->where('tahun', $tahun)->count() == 1)
                                <p class="fw-bold mb-0 text-primary fs-4">
                                    Rp {{ number_format($data->alokasi->where('tahun', $tahun)->first()->nilai_alokasi, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>

                        <div class="card-tools">
                            @if ($data->alokasi->where('tahun', $tahun)->count() == 0)
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                                    data-bs-toggle="modal" data-bs-target="#modalAlokasi-{{ $tahun }}">
                                    <i class="bi bi-plus-circle-dotted"></i> Tambah
                                </a>
                            @else
                                <div class="d-flex gap-2">
                                    <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm d-flex align-items-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#modalEdit-{{ $tahun }}">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="{{ route('proyek.detail', ['id' => $data->id, 'tahun' => $tahun, 'aksi' => 'kegiatan']) }}" class="btn btn-outline-primary btn-sm align-items-center">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1"
                                        data-bs-toggle="modal" data-bs-target="#modalRiwayat-{{ $tahun }}">
                                        <i class="bi bi-file-earmark-text-fill"></i> Riwayat
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endfor
                @endif

                @else

                <label class="fw-bold fs-4 mb-3">Kegiatan {{ $tahun }}</label>
                <table id="table" class="table align-middle bg-white rounded shadow-sm border border-dark">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                            <th>Realisasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kegiatan as $row)
                        <tr class="border rounded-3">
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td class="text-start">
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        <small class="text-muted">
                                            ID: {{ $row->id }}
                                        </small>
                                        <div class="fw-semibold">{{ $row->nama }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                {{ $row->tanggal_awal ? $row->tanggal_awal.' - '.$row->tanggal_selesai : $row->tanggal_selesai }}
                            </td>

                            <td style="white-space: nowrap;">
                                Rp {{ number_format($row->nilai_kegiatan, 0, ',', '.') }}
                            </td>

                            <td style="white-space: nowrap;">
                                Rp {{ number_format($row->nilai_realisasi, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($row->status == 'true')
                                <span class="badge bg-success">Selesai</span>
                                @elseif ($row->status == 'false')
                                <span class="badge bg-danger">Ditolak</span>
                                @else
                                <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('kegiatan.detail', $row->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                                <a href="{{ route('kegiatan.edit', $row->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
            </div>
        </div>
    </div>
</div>



<!-- Modal Alokasi Anggaran -->
@for ($tahun = $data->periode_awal; $tahun <= $data->periode_akhir; $tahun++)
<div class="modal fade" id="modalAlokasi-{{ $tahun }}"  aria-labelledby="modalAlokasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAlokasiLabel">
                    <i class="bi bi-wallet2 me-1"></i> Tambah Alokasi Anggaran {{ $tahun }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-{{ $tahun }}" action="{{ route('alokasi.store', $data->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun" class="form-label fw-semibold">Tahun Alokasi</label>
                        <input type="number" class="form-control bg-light" name="tahun" value="{{ $tahun }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nilai" class="form-label fw-semibold">Nilai Alokasi </label>
                        <input type="text" name="nilai" id="nilai" class="form-control number" placeholder="Masukkan nilai anggaran">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Tuliskan keterangan..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form-{{ $tahun }}')">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endfor

<!-- Modal Edit Alokasi Anggaran -->
@foreach ($alokasi as $row)
<div class="modal fade" id="modalEdit-{{ $row->tahun }}"  aria-labelledby="modalAlokasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAlokasiLabel">
                    <i class="bi bi-wallet2 me-1"></i> Edit Alokasi Anggaran {{ $row->tahun }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-edit-{{ $row->id }}" action="{{ route('alokasi.update', $row->id) }}" method="POST">
                @csrf
                <input type="hidden" name="proyek_id" value="{{ $data->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun" class="form-label fw-semibold">Tahun Alokasi</label>
                        <input type="number" class="form-control bg-light" name="tahun" value="{{ $row->tahun }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nilai" class="form-label fw-semibold">Nilai Alokasi </label>
                        <input type="text" name="nilai" class="form-control number" placeholder="Masukkan nilai anggaran" value="{{ number_format($row->nilai_alokasi, 0, ',', '.') }}">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Tuliskan keterangan...">{{ $row->keterangan }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form-edit-{{ $row->id }}')">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Edit Alokasi Anggaran -->
@foreach ($alokasi as $row)
<div class="modal fade" id="modalRiwayat-{{ $row->tahun }}"  aria-labelledby="modalAlokasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAlokasiLabel">
                    <i class="bi bi-wallet2 me-1"></i> Riwayat Alokasi Anggaran {{ $row->tahun }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nilai Alokasi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($row->riwayat->sortByDesc('tanggal') as $subRow)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Carbon\Carbon::parse($subRow->tanggal)->isoFormat('DD MMM Y HH:mm') }}</td>
                            <td>Rp {{ number_format($subRow->nilai_alokasi, 0, ',', '.') }}</td>
                            <td>{{ $subRow->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach



@section('js')
<script>
    $("#table").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "info": true,
        "paging": true,
        "searching": true,
        buttons: [{
            extend: 'pdf',
            text: ' PDF',
            pageSize: 'A4',
            className: 'bg-danger me-1 rounded-1 my-2',
            title: 'kegiatan',
            exportOptions: {
                columns: [0, 1, 2, 3, 4],
            },
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success me-1 rounded-1 my-2',
            title: 'kegiatan',
            exportOptions: {
                columns: [0, 1, 2, 3, 4],
            },
        }, {
            text: ' Tambah',
            className: 'bg-primary me-1 rounded-1 my-2',
            action: function(e, dt, button, config) {
                window.location.href = `{{ route('kegiatan.create', ['id' => $data->id, 'tahun' => $data->periode_akhir]) }}`;
            }
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
