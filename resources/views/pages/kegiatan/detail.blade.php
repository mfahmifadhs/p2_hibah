@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="mb-0 fw-bold">Kegiatan</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('proyek.detail', $data->proyek_id) }}">Proyek</a></li>
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
                <h3 class="fw-bold mb-4">Detail Proyek</h3>
                <p>{{ $data->proyek->donor->nama_donor.' | '.$data->proyek->kode_hibah.' | '.$data->proyek->no_register }}</p>
                <h3 class="fw-bold">{{ $data->nama_proyek }}</h3>
                <h6 class="mt-0 fs-7    ">{{ $data->proyek->user->pegawai->uker->nama_uker}}</h6>
                <p class="fs-7">Periode : {{ $data->proyek->periode_awal }} {{ $data->proyek->periode_akhir }}</p>

                <hr class="border-2">

                <div class="form-group">
                    <label class="fw-bold">ISS</label>
                    <h6>{{ $data->proyek->iss }}</h6>
                </div>

                <div class="form-group my-5">
                    <label class="fw-bold">IKP</label>
                    <h6>{{ $data->proyek->ikp }}</h6>
                </div>

                <div class="form-group">
                    <label class="fw-bold">IKK</label>
                    <h6>{{ $data->proyek->ikk }}</h6>
                </div>
            </div>

            <!-- Kolom kanan -->
            <div class="col-md-8 ps-4">
                <div class="d-flex justify-content-between mb-4">
                    <div class="text-start my-auto">
                        <h3 class="fw-bold">Detail Kegiatan</h3>
                    </div>
                    <div class="text-end my-auto">
                        @if (Auth::user()->role_id == 2 && !$data->status)
                        <div class="d-flex justify-content-end gap-2">
                            <form id="form-false" action="{{ route('kegiatan.verif', $data->id) }}" method="GET">
                                @csrf
                                <input type="hidden" name="status" value="false">
                                <input type="hidden" name="keterangan" id="keterangan">

                                <button type="submit" class="btn btn-danger btn-sm border-dark mt-2" onclick="confirmFalse(event)">
                                    <i class="bi bi-x-octagon-fill"></i> Tolak
                                </button>
                            </form>

                            <form id="form-true" action="{{ route('kegiatan.verif', $data->id) }}" method="GET">
                                @csrf
                                <input type="hidden" name="usulan" value="{{ $data->id }}">
                                <input type="hidden" name="status" value="true">
                                <button type="submit" class="btn btn-success btn-sm border-dark mt-2" onclick="confirmTrue(event)">
                                    <i class="bi bi-check-circle-fill"></i> Setuju
                                </button>
                            </form>
                        </div>
                        @elseif($data->status != 'true')
                        <a href="{{ route('kegiatan.edit', $data->id) }}" class="btn btn-warning btn-sm fw-bold ">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endif

                        @if (Auth::user()->id == $data->proyek->user_id)
                        <a href="" class="btn btn-primary btn-sm rounded-4 bg-opacity-10 fw-bold">
                            <i class="bi bi-plus-circle"></i> Pencairan
                        </a>
                        @if ($total->pencairan > 0)
                        <a href="" class="btn btn-warning btn-sm rounded-4 bg-opacity-10 fw-bold">
                            <i class="bi bi-plus-circle"></i> Realisasi
                        </a>
                        @endif
                        @endif
                    </div>

                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="text-success fw-bold bg-success bg-opacity-10 px-3 py-1 rounded">
                            Rp {{ number_format($total->kegiatan, 0, ',', '.') }} <br>
                            <small class="text-muted">Nilai Kegiatan</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-primary fw-bold bg-primary bg-opacity-10 px-3 py-1 rounded">
                            Rp {{ number_format($total->pencairan, 0, ',', '.') }} <br>
                            <small class="text-muted">Total Pencairan</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-warning fw-bold bg-warning bg-opacity-10 px-3 py-1 rounded">
                            Rp {{ number_format($total->sisa, 0, ',', '.') }} <br>
                            <small class="text-muted">Sisa Anggaran</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-danger fw-bold bg-danger bg-opacity-10 px-3 py-1 rounded">
                            Rp {{ number_format($total->realisasi, 0, ',', '.') }} <br>
                            <small class="text-muted">Nilai Realisasi</small>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Status</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">
                                @php
                                if (!$data->status) {
                                $status = '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Verifikasi</span>';
                                } elseif ($data->status == 'false') {
                                $status = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Tolak</span>';
                                } elseif ($data->status == 'true') {
                                $status = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Setuju</span>';
                                }
                                @endphp

                                {!! $status !!}
                            </h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Kode</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->kode }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Nama Kegiatan</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->nama }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Tim Kerja</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->timker?->nama_timker }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Jenis Kegiatan</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->jenisKegiatan?->nama_jenis }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Volume</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->volume }} {{ $data->satuanKegiatan?->nama_satuan }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Rencana Pelaksanaan</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->rencana_thn_pelaksana }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Jenis Hibah</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->jenisHibah?->nama_jenis }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Tanggal Pelaksanaan</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">
                                {{ $data->tanggal_mulai ? $data->tanggal_mulai.' - '.$data->tanggal_selesai : $data->tanggal_selesai }}
                            </h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Pilar Pendukung</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->pilar_pendukung }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Kode Program</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0">{{ $data->kode_program }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Penerima Manfaat</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0" style="text-align: justify;">{{ $data->penerima_manfaat }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Output</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0" style="text-align: justify;">{{ $data->keterangan_output }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Kendala/Hambatan</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0" style="text-align: justify;">{{ $data->keterangan_kendala }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Tindak Lanjut</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0" style="text-align: justify;">{{ $data->keterangan_tindaklanjut }}</h6>
                        </div>
                    </div>

                    <div class="row align-items-center mb-2">
                        <div class="col-md-3">
                            <label class="fw-bold mb-0">Keterangan</label>
                        </div>
                        <div class="col-md-9 d-flex align-items-center">
                            <span class="mx-2">:</span>
                            <h6 class="mb-0" style="text-align: justify;">{{ $data->keterangan_lain }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">


                @if ($data->status == 'true')
                <hr class="my-3">
                <h5 class="fw-bold mb-4">Realisasi</h5>
                <table id="table-realisasi" class="table align-middle bg-white rounded shadow-sm border border-dark">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->realisasi as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $row->deskripsi }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M Y') }}
                                s.d
                                {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y') }}
                            </td>
                            <td>Rp {{ number_format($row->nilai, 0, ',', '.') }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#detail-{{ $row->id }}">
                                    <i class="bi bi-info-circle"></i>
                                </a>
                                <a href="{{ route('realisasi.edit', $row->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <div class="modal fade" id="detail-{{ $row->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header bg-primary text-white rounded-top-4">
                                                <h5 class="modal-title fw-semibold" id="detailRealisasiLabel">
                                                    <i class="bi bi-card-list me-2"></i> Detail Realisasi
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body p-4" style="overflow-x: scroll; max-height: 70vh;">
                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-semibold text-muted">Deskripsi</div>
                                                    <div class="col-md-8 d-flex gap-1 text-break">
                                                        <div>:</div>
                                                        <div>{{ $row->deskripsi }}</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-semibold text-muted">Tanggal</div>
                                                    <div class="col-md-8">:
                                                        {{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M Y') }}
                                                        s.d
                                                        {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y') }}
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-semibold text-muted">Nilai</div>
                                                    <div class="col-md-8 d-flex gap-1 text-break">
                                                        <div class="fw-light">:</div>
                                                        <div class="fw-bold">Rp {{ number_format($row->nilai ?? 0, 0, ',', '.') }}</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-semibold text-muted">Data Pendukung</div>
                                                    <div class="col-md-8 d-flex gap-1 text-break">
                                                        <div>:</div>
                                                        <div>{{ $row->data_pendukung }}</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-semibold text-muted">Penerima Manfaat</div>
                                                    <div class="col-md-8 d-flex gap-1 text-break">
                                                        <div>:</div>
                                                        <div>{{ $row->penerima_manfaat }}</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-semibold text-muted">Output</div>
                                                    <div class="col-md-8 d-flex gap-1 text-break">
                                                        <div>:</div>
                                                        <div>{{ $row->keterangan_output }}</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-semibold text-muted">Kendala</div>
                                                    <div class="col-md-8 d-flex gap-1 text-break">
                                                        <div>:</div>
                                                        <div>{{ $row->keterangan_kendala }}</div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4 fw-semibold text-muted">Tindak Lanjut</div>
                                                    <div class="col-md-8 d-flex gap-1 text-break">
                                                        <div>:</div>
                                                        <div>{{ $row->keterangan_tindaklanjut }}</div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 fw-semibold text-muted">Keterangan</div>
                                                    <div class="col-md-8 d-flex gap-1 text-break">
                                                        <div>:</div>
                                                        <div>{{ $row->keterangan_lain }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer bg-light rounded-bottom-4">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="bi bi-x-circle me-1"></i> Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <hr class="my-5">
            <div class="col-md-12">
                <div class="card rounded-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            Pencairan Dana <br>
                            <small class="text-dark fs-6 fw-light">Riwayat Pencairan Dana</small>
                        </h5>
                    </div>

                    <div class="card-body">
                        <table id="table-pencairan" class="table table-hover align-middle text-center">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 5%;">Aksi</th>
                                    <th style="width: 10%;">Tanggal</th>
                                    <th class="text-start">Perihal</th>
                                    <th class="text-start">Nilai</th>
                                    <th class="text-start">Keterangan</th>
                                    <th style="width: 15%;">Lampiran</th>
                                    <th style="width: 15%;">Status</th>
                                </tr>
                            </thead>

                            <tbody class="small">
                                @foreach ($data->pencairan as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="#" class="text-danger" onclick="confirmLink(event, `{{ route('pencairan.delete', $row->id) }}`)">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($row->tanggal)->isoFormat('DD MMM Y') }}</td>
                                    <td class="text-start">{{ $row->perihal }}</td>
                                    <td class="text-start">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                                    <td class="text-start">{{ $row->keterangan }}</td>
                                    <td>
                                        @if ($row->lampiran)
                                        <a href="{{ route('pencairan.lampiran', basename($row->lampiran)) }}" target="_blank" class="btn btn-primary btn-sm fs-8">
                                            <i class="bi bi-file-earmark-post"></i> Lihat Lampiran
                                        </a>
                                        @else
                                        <h6>Tidak ada lampiran</h6>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                        $badge = 'badge bg-warning fs-10 m-0 fw-bold text-dark bg-opacity-25 rounded-3';
                                        $icon = 'bi bi-hourglass-split';

                                        if ($row->status_1 == 'true' || $row->status_2 == 'true') {
                                        $icon = 'bi bi-check-circle';
                                        $badge = 'badge bg-success fs-10 m-0 fw-bold text-dark bg-opacity-25 rounded-3';
                                        } elseif ($row->status_1 == 'false' || $row->status_2 == 'false') {
                                        $icon = 'bi bi-x-circle';
                                        $badge = 'badge bg-danger fs-8 m-0 fw-bold text-dark bg-opacity-50';
                                        }

                                        @endphp

                                        <h6 class="{{ $badge }}">
                                            <i class="{{ $icon }}"></i> KSPHLN
                                        </h6>
                                        <h6 class="{{ $badge }}">
                                            <i class="{{ $icon }}"></i> KEUANGAN
                                        </h6>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    let status = '{{ $data->status }}';
    let user   = `{{ $data->proyek->user_id == Auth::user()->id ? 'true' : 'false' }}`;
    let dana   = `{{ $total->pencairan > 0 ? 'true' : 'false' }}`;

    $("#table-realisasi").DataTable({
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
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table-realisasi_wrapper .col-md-6:eq(0)');
</script>

<script>
    $("#table-pencairan").DataTable({
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
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table-pencairan_wrapper .col-md-6:eq(0)');
</script>


<script>
    function confirmTrue(event) {
        event.preventDefault();

        const form = document.getElementById('form-true');

        Swal.fire({
            title: 'Setuju',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            const selectedDate = result.value.tanggal;
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Proses...',
                    text: 'Mohon menunggu.',
                    icon: 'info',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                form.submit();
            }
        });
    }

    function confirmFalse(event) {
        event.preventDefault();

        const form = document.getElementById('form-false');

        Swal.fire({
            title: 'Konfirmasi Penolakan',
            text: 'Apakah Anda yakin ingin menolak usulan proyek ini?',
            icon: 'warning',
            input: 'textarea',
            inputPlaceholder: 'Berikan alasan penolakan di sini...',
            inputAttributes: {
                'aria-label': 'Tulis alasan penolakan di sini'
            },
            showCancelButton: true,
            confirmButtonText: 'Tolak',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Alasan penolakan harus diisi!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const alasanPenolakan = result.value;

                Swal.fire({
                    title: 'Ditolak!',
                    text: 'Usulan telah ditolak dengan alasan: ' + alasanPenolakan,
                    icon: 'success'
                });

                document.getElementById('keterangan').value = alasanPenolakan;
                form.submit();
            }
        });
    }
</script>
@endsection
@endsection
