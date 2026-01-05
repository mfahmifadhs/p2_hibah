@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Jenis Hibah</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jenis Hibah</li>
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
                    Daftar Jenis Hibah
                </label>
            </div>
            <div class="table-responsive">
                <div class="card-body">
                    <table id="table" class="table table-bordered text-center">
                        <thead class="text-xs">
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th>Jenis Hibah</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="#" class="" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                        <i class="bi bi-pencil" style="font-size: 12px;"></i>
                                    </a>
                                </td>
                                <td class="text-left">{{ $row->nama_jenis }}</td>
                                <td class="text-left">{{ $row->deskripsi }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Tambah -->
<div class="modal fade" id="createModal" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit">Create</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-create" action="{{ route('jenisHibah.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis" class="col-form-label">Jenis Hibah:</label>
                        <input type="text" class="form-control" id="jenis" name="jenis" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="col-form-label">Deskripsi:</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form-create')">Create</button>
                </div>
            </form>
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
            <form id="formUpdate-{{ $row->id }}" action="{{ route('jenisHibah.update', $row->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="jenis" class="col-form-label">Jenis Hibah:</label>
                        <input type="text" class="form-control" id="jenis" name="jenis" value="{{ $row->nama_jenis }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="col-form-label">Deskripsi:</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $row->deskripsi }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'formUpdate-{{ $row->id }}')">Update</button>
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
            title: 'show',
            exportOptions: {
                columns: [0, 2, 3, 4],
            },
        }, {
            extend: 'excel',
            text: ' Excel',
            className: 'bg-success me-1 rounded-1 my-2',
            title: 'show',
            exportOptions: {
                columns: ':not(:nth-child(2))'
            },
        }, {
            text: ' Tambah',
            className: 'bg-primary me-1 rounded-1 my-2',
            action: function(e, dt, button, config) {
                $('#createModal').modal('show');
            }
        }, ],
        "bDestroy": true
    }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
</script>
@endsection
@endsection
