@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Unit Utama</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Unit Utama</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card border-dark">
            <div class="card-header border-dark">
                <label class="card-title">
                    Daftar Unit Utama
                </label>
            </div>
            <div class="table-responsive">
                <div class="card-body">
                    <table id="table" class="table table-bordered text-center">
                        <thead class="text-xs">
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th>Unit Utama</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                        <i class="bi bi-pencil" style="font-size: 12px;"></i>
                                    </a>
                                </td>
                                <td>{{ $row->nama_utama }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit -->
@foreach($data as $row)
<div class="modal fade" id="editModal-{{ $row->id }}" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUpdate-{{ $row->id }}" action="{{ route('utama.update', $row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="uker" class="col-form-label">Nama Unit Utama:</label>
                        <input type="text" class="form-control" id="utama" name="utama" value="{{ $row->nama_utama }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
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
            title: 'penyedia',
            exportOptions: {
                columns: [0, 2, 3, 4],
            },
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success me-1 rounded-1 my-2',
            title: 'penyedia',
            exportOptions: {
                columns: ':not(:nth-child(2))'
            },
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
