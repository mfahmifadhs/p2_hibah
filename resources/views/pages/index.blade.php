@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Home</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
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
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-primary mb-0">
                            <i class="bi bi-pie-chart-fill me-2"></i> Grafik Jumlah Donor per Unit Kerja
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="donorUkerChart" height="232"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-success mb-0">
                            <i class="bi bi-table me-2"></i> Daftar Donor per Unit Kerja
                        </h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle text-center small">
                            <thead>
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th>Nama Unit Kerja</th>
                                    <th>Daftar Donor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ukers as $index => $uker)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-start fs-8" style="white-space: nowrap;">{{ $uker->nama_uker }}</td>
                                    <td class="text-start">
                                        @forelse ($uker->donor as $donor)
                                        <span class="badge bg-primary me-1 mb-1">{{ $donor->donor->nama_donor }}</span>
                                        @empty
                                        <span class="text-muted fst-italic">Belum ada donor</span>
                                        @endforelse
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
<div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-success mb-0">
                            <i class="bi bi-table me-2"></i> Daftar Donor per Unit Kerja
                        </h5>
                    </div>
                    <div class="card-body table-responsive">
                        <!--  -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    @php
    $labels = $ukers->pluck('nama_uker');
    $data = $ukers->map(fn($u) => $u->donor->count());
    @endphp
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('donorUkerChart');

        new Chart(ctx, {
            type: 'bar', // bisa diganti 'pie' atau 'doughnut' atau 'line'
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Donor',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
                        '#e74a3b', '#858796', '#2e59d9', '#17a673'
                    ],
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Distribusi   Donor per Unit Kerja',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => ' Total Donor: ' + context.parsed.y
                        }
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Donor'
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: false,
                            callback: function(value, index, ticks) {
                                let label = this.getLabelForValue(value);
                                return label.length > 25 ? label.substr(0, 25) + '…' : label;
                            },
                            maxRotation: 30,
                            minRotation: 0,
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
@endsection

