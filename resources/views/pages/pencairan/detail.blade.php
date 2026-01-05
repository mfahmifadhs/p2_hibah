@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="mb-0 fw-bold">Pencairan</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('proyek.detail', $data->kegiatan->proyek_id) }}">Proyek</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kegiatan.detail', $data->kegiatan_id) }}">Kegiatan</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pencairan.show') }}">Pencairan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
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
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm rounded rounded-4 h-100">
                    <div class="card-body">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary">Detail Pencairan Dana</h5>
                            <div>
                                @if (!$data->status_1)
                                <span class="fs-8 bg-warning bg-opacity-25 p-2 rounded-3 fw-bold me-2">
                                    <i class="bi bi-hourglass"></i> Verifikasi KSPHLN
                                </span>
                                @endif

                                @if ($data->status_1 == 'true')
                                <span class="fs-8 bg-success bg-opacity-25 p-2 rounded-3 fw-bold me-2">
                                    <i class="bi bi-check-circle"></i> Disetujui KSPHLN
                                </span>
                                @endif

                                @if ($data->status_1 == 'false')
                                <span class="fs-8 bg-danger bg-opacity-25 p-2 rounded-3 fw-bold me-2">
                                    <i class="bi bi-x-circle"></i> Ditolak KSPHLN
                                </span>
                                @endif

                                @if (!$data->status_2)
                                <span class="fs-8 bg-warning bg-opacity-25 p-2 rounded-3 fw-bold">
                                    <i class="bi bi-hourglass"></i> Verifikasi Keuangan
                                </span>
                                @endif

                                @if ($data->status_2 == 'true')
                                <span class="fs-8 bg-success bg-opacity-25 p-2 rounded-3 fw-bold">
                                    <i class="bi bi-check-circle"></i> Disetujui Keuangan
                                </span>
                                @endif

                                @if ($data->status_2 == 'false')
                                <span class="fs-8 bg-danger bg-opacity-25 p-2 rounded-3 fw-bold">
                                    <i class="bi bi-x-circle"></i> Ditolak Keuangan
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nominal" class="form-label fw-bold">Tanggal</label>
                            <h6>{{ Carbon\Carbon::parse($data->tanggal)->isoFormat('DD MMMM Y') }}</h6>
                        </div>

                        <div class="mb-3">
                            <label for="nominal" class="form-label fw-bold">Nominal Pencairan</label>
                            <h6>Rp {{ number_format($data->total, 0, ',', '.') }}</h6>
                        </div>

                        <div class="mb-3">
                            <label for="perihal" class="form-label fw-bold">Perihal</label>
                            <h6>{{ $data->perihal }}</h6>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                            <h6>{{ $data->keterangan }}</h6>
                        </div>

                        <div class="mb-4">
                            <label for="lampiran" class="form-label fw-bold">Lampiran (PDF)</label>
                            @if ($data->lampiran)
                            <h6><a href="{{ route('pencairan.lampiran', basename($data->lampiran)) }}" target="_blank">Lihat Lampiran</a></h6>
                            @else
                            <h6>Tidak ada lampiran</h6>
                            @endif
                        </div>

                        @if($data->status_1 == 'false' || $data->status_2 == 'false')
                        <div class="mb-3">
                            <label for="keterangan" class="form-label fw-bold">Keterangan Tolak</label>
                            <h6 class="text-danger">{{ $data->timeline->last()->keterangan }}</h6>
                        </div>
                        @endif

                        <div class="mb-3 text-end">

                            <div class="d-flex justify-content-end gap-2">
                                @if ($data->kegiatan->proyek->user_id == Auth::user()->id)
                                    @if ($data->status_2 != 'true')
                                    <a href="{{ route('pencairan.edit', $data->id) }}" class="btn btn-warning btn-sm border-dark mt-2">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    @endif
                                    @if ($data->status_1 == 'false' || $data->status_2 == 'false')
                                    <a href="#" class="btn btn-primary btn-sm border-dark mt-2" onclick="confirmLink(event, `{{ route('pencairan.verif', ['aksi' => 'revisi', 'id' => $data->id]) }}`)">
                                        <i class="bi bi-pencil-square"></i> Selesai Diperbaiki
                                    </a>
                                    @endif
                                @endif

                                @if ((!$data->status_1 && Auth::user()->akses == 'ksphln') || ($data->status_1 == 'true' && !$data->status_2 && Auth::user()->akses == 'keuangan'))
                                <form id="form-false" action="{{ route('pencairan.verif', $id) }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="status" value="false">
                                    <input type="hidden" name="keterangan" id="keterangan">

                                    <button type="submit" class="btn btn-danger btn-sm border-dark mt-2" onclick="confirmFalse(event)">
                                        <i class="bi bi-x-octagon-fill"></i> Tolak
                                    </button>
                                </form>

                                <form id="form-true" action="{{ route('pencairan.verif', $id) }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="usulan" value="{{ $id }}">
                                    <input type="hidden" name="status" value="true">
                                    <button type="submit" class="btn btn-success btn-sm border-dark mt-2" onclick="confirmTrue(event)">
                                        <i class="bi bi-check-circle-fill"></i> Setuju
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4">
                <div class="card shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 text-primary">Detail Informasi Kegiatan</h6>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Nama Kegiatan</label>
                            <p class="fw-bold mb-2">{{ $data->kegiatan->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Jenis Kegiatan</label>
                            <p class="fw-bold mb-2">{{ $data->kegiatan->jenisKegiatan->nama_jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Tanggal Pelaksanaan</label>
                            <p class="fw-bold mb-2">{{ $data->kegiatan->tanggal_mulai }} s.d {{ $data->kegiatan->tanggal_selesai }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Unit Kerja</label>
                            <p class="fw-bold mb-2">{{ $data->kegiatan->proyek->user->pegawai->uker->nama_uker }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Status</label><br>
                            @if ($data->kegiatan->status == 'true') <span class="badge bg-success">Disetujui</span> @endif
                            @if ($data->kegiatan->status == 'false') <span class="badge bg-danger">Ditolak</span> @endif
                            @if ($data->kegiatan->status == null) <span class="badge bg-warning">Verifikasi</span> @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
