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
                    <li class="breadcrumb-item"><a href="{{ route('proyek.detail', $kegiatan->proyek_id) }}">Proyek</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kegiatan.detail', $id) }}">Kegiatan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                <div class="card shadow-sm rounded rounded-4">
                    <div class="card-header card-primary">
                        <h5 class="mb-0 fw-bold">Form Pencairan Dana</h5>
                    </div>
                    <div class="card-body">
                        <form id="form-pencairan" action="{{ route('pencairan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">
                            <div class="mb-3">
                                <label for="nominal" class="form-label fw-bold">Nominal Pencairan*</label>
                                <input type="text" class="form-control number" id="nominal" name="total" placeholder="Masukkan nominal" required>
                            </div>

                            <div class="mb-3">
                                <label for="perihal" class="form-label fw-bold">Perihal*</label>
                                <input type="text" class="form-control" id="perihal" name="perihal" placeholder="Masukkan perihal pencairan" required>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label fw-bold">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="lampiran" class="form-label fw-bold">Lampiran (PDF)</label>
                                <input type="file" class="form-control @error('lampiran') is-invalid @enderror"
                                    id="lampiran" name="lampiran" accept="application/pdf">
                                <small class="text-muted">Unggah file dalam format PDF (maks 2MB).</small>
                                @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-outline-secondary me-2">Batal</button>
                                <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form-pencairan')">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Detail Informasi Kegiatan</h6>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Nama Kegiatan</label>
                            <p class="fw-bold mb-2">{{ $kegiatan->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Jenis Kegiatan</label>
                            <p class="fw-bold mb-2">{{ $kegiatan->jenisKegiatan->nama_jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Tanggal Pelaksanaan</label>
                            <p class="fw-bold mb-2">{{ $kegiatan->tanggal_mulai }} s.d {{ $kegiatan->tanggal_selesai }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Unit Kerja</label>
                            <p class="fw-bold mb-2">{{ $kegiatan->proyek->user->pegawai->uker->nama_uker }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0">Status</label><br>
                            @if ($kegiatan->status == 'true') <span class="badge bg-success">Disetujui</span> @endif
                            @if ($kegiatan->status == 'false') <span class="badge bg-danger">Ditolak</span> @endif
                            @if ($kegiatan->status == null) <span class="badge bg-warning">Verifikasi</span> @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
