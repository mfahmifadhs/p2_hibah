@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 my-auto">
                <h5 class="fw-bold">Total Anggaran Hibah {{ \Carbon\Carbon::now()->year }}</h5>
                <h1 class="fw-bold text-primary">Rp {{ $total->anggaran }}</h1>
            </div>
            <div class="col-md-6 my-auto">
                <h5 class="fw-bold">Total Realisasi Hibah {{ \Carbon\Carbon::now()->year }}</h5>
                <h1 class="fw-bold text-primary d-flex gap-3">
                    Rp {{ $total->realisasi }}
                    <span class="badge bg-danger fs-7 my-auto">{{ $total->persentase }}</span>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-primary rounded-4">
                            <div class="inner">
                                <h3>{{ $total->proyek->count() }} <small class="fs-6">proyek</small></h3>
                            </div>
                            <i class="small-box-icon bi bi-clipboard-fill"></i>
                            <a
                                href="{{ route('proyek.show') }}"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Selengkapnya <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-success rounded-4">
                            <div class="inner">
                                <h3>{{ $total->kegiatan->count() }} <small class="fs-6">kegiatan</small></h3>
                            </div>
                            <i class="small-box-icon bi bi-shadows"></i>
                            <a
                                href="#"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Selengkapnya <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-warning rounded-4">
                            <div class="inner">
                                <h3>{{ $total->donor->count() }} <small class="fs-6">donor</small></h3>
                            </div>
                            <i class="small-box-icon bi bi-hand-thumbs-up-fill"></i>
                            <a
                                href="#"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Selengkapnya <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-danger rounded-4">
                            <div class="inner">
                                <h3>{{ $total->users->count() }} <small class="fs-6">pengguna</small></h3>
                            </div>
                            <i class="small-box-icon bi bi-people"></i>
                            <a
                                href="#"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Selengkapnya <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Row-->
        <div class="row">
            <!-- Usulan Proyek -->
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Usulan Proyek</h6>
                    </div>

                    <!-- Item: Verifikasi -->
                    <a href="{{ route('proyek.show', ['status' => 'null']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Verifikasi</div>
                                <small class="text-muted">Menunggu Persetujuan</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->proyek->where('status', '')->count() }}</div>
                        </div>
                    </a>

                    <a href="" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Selesai</div>
                                <small class="text-muted">Telah Diverifikasi</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->proyek->where('status', 'true')->count() }}</div>
                        </div>
                    </a>

                    <!-- Item: Selesai -->
                    <a href="{{ route('proyek.show', ['status' => 'false']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-x-octagon-fill"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Ditolak</div>
                                <small class="text-muted">Telah Ditolak</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->proyek->where('status', 'false')->count() }}</div>
                        </div>
                    </a>
                </div>

                <!-- Usulan Kegiatan -->
                <div class="card shadow-sm border-0 rounded-4 p-3 mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Usulan Kegiatan</h6>
                    </div>

                    <!-- Item: Verifikasi -->
                    <a href="{{ route('kegiatan.show', ['status' => 'null']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Verifikasi</div>
                                <small class="text-muted">Menunggu Persetujuan</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->kegiatan->where('status', '')->count() }}</div>
                        </div>
                    </a>

                    <a href="{{ route('kegiatan.show', ['status' => 'true']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Selesai</div>
                                <small class="text-muted">Telah Diverifikasi</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->kegiatan->where('status', 'true')->count() }}</div>
                        </div>
                    </a>

                    <!-- Item: Selesai -->
                    <a href="{{ route('kegiatan.show', ['status' => 'false']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-x-octagon-fill"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Ditolak</div>
                                <small class="text-muted">Telah Ditolak</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->kegiatan->where('status', 'false')->count() }}</div>
                        </div>
                    </a>
                </div>

                <!-- Usulan Pencairan -->
                <div class="card shadow-sm border-0 rounded-4 p-3 mt-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Usulan Pencairan</h6>
                    </div>

                    <!-- Item: Verifikasi -->
                    <a href="{{ route('pencairan.show', ['status' => 'status_1']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Verifikasi KSPHLN</div>
                                <small class="text-muted">Menunggu Persetujuan</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->pencairan->where('status_1', '')->count() }}</div>
                        </div>
                    </a>

                    <a href="{{ route('pencairan.show', ['status' => 'status_2']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Verifikasi Keuangan</div>
                                <small class="text-muted">Menunggu Persetujuan</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->pencairan->where('status_1', 'true')->where('status_2', '')->count() }}</div>
                        </div>
                    </a>

                    <a href="{{ route('pencairan.show', ['status' => 'true']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Selesai</div>
                                <small class="text-muted">Telah Diverifikasi</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">{{ $total->pencairan->where('status_1', 'true')->where('status_2', 'true')->count() }}</div>
                        </div>
                    </a>

                    <!-- Item: Selesai -->
                    <a href="{{ route('pencairan.show', ['status' => 'false']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded-3 bg-light hover-card text-dark text-decoration-none">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle">
                                <i class="bi bi-x-octagon-fill"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">Ditolak</div>
                                <small class="text-muted">Telah Ditolak</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-dark">
                                {{ $total->pencairan->filter(fn($p) => $p->status_1 == 'false' || $p->status_2 == 'false')->count() }}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Total Hibah Direktorat -->
            <div class="col-md-9">
                <div class="card shadow-sm border-0 rounded-4 p-1">

                    <div class="d-flex justify-content-between align-items-center mb-3 px-3 pt-3">
                        <h6 class="fw-bold mb-0">
                            Total Realisasi Unit Kerja <br>
                            <span class="fs-6 fw-light text-primary">Rp {{ number_format($total->perUker->sum('total_realisasi_int'), 0, ',', '.') }}</span>
                        </h6>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="table" class="table text-center table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Unit Kerja</th>
                                    <th class="text-start">Alokasi 2025</th>
                                    <th class="text-start">Realisasi 2025</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($total->perUker->sortByDesc('persentase') as $row)
                                <tr onclick="window.location=`{{ route('kegiatan.show', ['uker_id' => $row->uker_id ?? null, 'tahun' => \Carbon\Carbon::now()->year]) }}`" style="cursor:pointer;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $row->unit_kerja }}</td>
                                    <td class="text-start" style="white-space: nowrap;" data-order="{{ $row->total_alokasi_raw }}">
                                        {{ $row->total_alokasi }}
                                    </td>
                                    <td class="text-start" style="white-space: nowrap;" data-order="{{ $row->total_realisasi_raw }}">
                                        {{ $row->total_realisasi }}
                                    </td>
                                    <td data-order="{{ $row->persentase_raw }}">
                                        @php
                                        if ($row->persentase <= 50) {
                                            $warna='badge bg-danger' ;
                                            } elseif ($row->persentase <= 80) {
                                                $warna='badge bg-warning' ;
                                                } else {
                                                $warna='badge bg-success' ;
                                                }
                                                @endphp

                                                <span class="{{ $warna }}">{{ $row->persentase }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card shadow-2xl border-0 rounded-4 p-1 my-3">

                    <div class="d-flex justify-content-between align-items-center mb-3 px-3 pt-3">
                        <h6 class="fw-bold mb-0">
                            Total Realisasi Donor <br>
                            <span class="fs-6 fw-light text-primary">Rp {{ number_format($total->perDonor->sum('total_realisasi_int'), 0, ',', '.') }}</span>
                        </h6>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Donor</th>
                                    <th class="text-start">Alokasi 2025</th>
                                    <th class="text-start">Realisasi 2025</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($total->perDonor->sortByDesc('persentase') as $row)
                                <tr onclick="window.location=`{{ route('kegiatan.show', ['donor_id' => $row->donor_id ?? null, 'tahun' => \Carbon\Carbon::now()->year]) }}`" style="cursor:pointer;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $row->nama_donor }}</td>
                                    <td class="text-start" style="white-space: nowrap;" data-order="{{ $row->total_alokasi_raw }}">
                                        {{ $row->total_alokasi }}
                                    </td>
                                    <td class="text-start" style="white-space: nowrap;" data-order="{{ $row->total_realisasi_int }}">
                                        {{ $row->total_realisasi }}
                                    </td>
                                    <td data-order="{{ $row->pesentase_raw }}">
                                        @php
                                        if ($row->persentase <= 50) {
                                            $warna='badge bg-danger' ;
                                            } elseif ($row->persentase <= 80) {
                                                $warna='badge bg-warning' ;
                                                } else {
                                                $warna='badge bg-success' ;
                                                }
                                                @endphp

                                                <span class="{{ $warna }}">{{ $row->persentase }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card shadow-2xl border-0 rounded-4 p-1 my-3">

                    <div class="d-flex justify-content-between align-items-center mb-3 px-3 pt-3">
                        <h6 class="fw-bold mb-0">
                            Total Realisasi Jenis Kegiatan <br>
                            <span class="fs-6 fw-light text-primary">Rp {{ number_format($total->perJenis->sum('total_realisasi_int'), 0, ',', '.') }}</span>
                        </h6>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Jenis Kegiatan</th>
                                    <th class="text-start">Alokasi 2025</th>
                                    <th class="text-start">Realisasi 2025</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($total->perJenis->sortByDesc('persentase') as $row)
                                <tr onclick="window.location=`{{ route('kegiatan.show', ['jenis_id' => $row->jenis_id ?? null, 'tahun' => \Carbon\Carbon::now()->year ]) }}`" style="cursor:pointer;">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $row->nama_jenis }}</td>
                                    <td class="text-start" style="white-space: nowrap;" data-order="{{ $row->total_alokasi_raw }}">
                                        {{ $row->total_alokasi }}
                                    </td>
                                    <td class="text-start" style="white-space: nowrap;" data-order="{{ $row->total_realisasi_int }}">
                                        {{ $row->total_realisasi }}
                                    </td>
                                    <td data-order="{{ $row->persentase_raw }}">
                                        @php
                                        if ($row->persentase <= 50) {
                                            $warna='badge bg-danger' ;
                                            } elseif ($row->persentase <= 80) {
                                                $warna='badge bg-warning' ;
                                                } else {
                                                $warna='badge bg-success' ;
                                                }
                                                @endphp

                                                <span class="{{ $warna }}">{{ $row->persentase }}</span>
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
    $(".table").DataTable({
        "responsive": false,
        "lengthChange": true,
        "autoWidth": false,
        "info": true,
        "paging": false,
        "searching": true,
        buttons: [{
            extend: 'pdf',
            text: ' PDF',
            pageSize: 'A4',
            className: 'bg-danger me-1 rounded-1 my-2',
            title: 'show',
            exportOptions: {
                columns: [0, 1, 2, 3],
            },
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success me-1 rounded-1 my-2',
            title: 'show',
            exportOptions: {
                columns: [0, 1, 2, 3],
            },
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
