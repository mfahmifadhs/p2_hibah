@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid col-md-10 mx-auto">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="mb-0 fw-bold">Pengadaan</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengadaan.show') }}">Pengadaan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="app-content">
    <div class="container-fluid col-md-10 mx-auto">
        <div class="row mb-4 mt-3">
            <div class="col-md-12 pe-4 mb-3">
                <p>{{ $data->program->nama_program.' | '.$data->kode }}</p>
                <h3 class="fw-bold">{{ $data->nama }}</h3>
            </div>
            <div class="col-md-4 mb-3">
                <div class="text-success fw-bold bg-success bg-opacity-10 px-3 py-1 rounded">
                    Rp {{ $total->alokasi }} <br>
                    <small class="text-muted">Total Alokasi</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-primary fw-bold bg-primary bg-opacity-10 px-3 py-1 rounded">
                    Rp {{ $total->realisasi }} <br>
                    <small class="text-muted">Total Realisasi</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-warning fw-bold bg-warning bg-opacity-10 px-3 py-1 rounded">
                    Rp {{ $total->sisa }} <br>
                    <small class="text-muted">Sisa Anggaran</small>
                </div>
            </div>
        </div>

        <div class="align-items-center mb-2">
            <table id="table" class="table align-middle bg-white rounded shadow-sm border border-dark text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Sumber Dana</th>
                        <th>Donor</th>
                        <th>Alokasi</th>
                        <th>Realisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->dana as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->sumber->nama_sumber }}</td>
                        <td>{{ $row->donor->nama_donor ?? '-' }}</td>
                        <td>{{ number_format($row->nilai_alokasi, 0, ',', '.') }}</td>
                        <td>{{ number_format($row->nilai_realisasi, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

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
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
