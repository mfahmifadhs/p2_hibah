@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid col-md-8">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="mb-0 fw-bold">Verifikasi</h2>
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
    <div class="container-fluid col-md-8">
        <div class="card shadow-lg border-1 border-dark rounded-2">
            <div class="row align-items-center mb-2 mx-5 mt-5">
                <div class="col-md-12">
                    <h2 class="fw-bold">Detail Kegiatan</h2>
                </div>
            </div>
            <div class="card-body mx-5" style="overflow-y: scroll; max-height: 420px;">
                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Unit Kerja</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">{{ $data->proyek->user->pegawai->uker->nama_uker }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Donor</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">{{ $data->proyek->donor->nama_donor }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Kode Hibah</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">{{ $data->proyek->kode_hibah }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">No. Register</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">{{ $data->proyek->no_register }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Nama Proyek</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">{{ $data->proyek->nama_proyek }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Periode</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">
                            {{ $data->proyek->periode_awal ? $data->proyek->periode_awal.' - '.$data->proyek->periode_akhir : $data->proyek->periode_akhir }}
                        </h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Total Budget IDR</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">Rp {{ number_format($data->proyek->total_budget_idr, 0, ',', '.') }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Total Budget USD</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">$ {{ number_format($data->proyek->total_budget_usd, 0, ',', '.') }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Total Alokasi</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">Rp {{ number_format($data->proyek->total_alokasi, 0, ',', '.') }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Tahun Alokasi</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0">{{ $data->proyek->tahun_alokasi }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">ISS</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0" style="text-align: justify;">{{ $data->proyek->iss }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">IKP</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0" style="text-align: justify;">{{ $data->proyek->ikp }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">IKK</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0" style="text-align: justify;">{{ $data->proyek->ikk }}</h6>
                    </div>
                </div>

                <div class="row align-items-center mb-2">
                    <div class="col-md-3">
                        <label class="fw-bold mb-0">Keterangan</label>
                    </div>
                    <div class="col-md-9 d-flex align-items-center">
                        <span class="mx-2">:</span>
                        <h6 class="mb-0" style="text-align: justify;">{{ $data->proyek->keterangan }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <div class="d-flex justify-content-end gap-2">
                <form id="form-false" action="{{ route('kegiatan.verif', $id) }}" method="GET">
                    @csrf
                    <input type="hidden" name="status" value="false">
                    <input type="hidden" name="keterangan" id="keterangan">

                    <button type="submit" class="btn btn-danger border-dark mt-2" onclick="confirmFalse(event)">
                        <i class="bi bi-x-octagon-fill"></i> Tolak
                    </button>
                </form>

                <form id="form-true" action="{{ route('kegiatan.verif', $id) }}" method="GET">
                    @csrf
                    <input type="hidden" name="usulan" value="{{ $id }}">
                    <input type="hidden" name="status" value="true">
                    <button type="submit" class="btn btn-success border-dark mt-2" onclick="confirmTrue(event)">
                        <i class="bi bi-check-circle-fill"></i> Setuju
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@section('js')
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
