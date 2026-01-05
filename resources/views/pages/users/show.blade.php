@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Users</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                    Daftar Users
                </label>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table table-hover table-bordered table-striped mb-0 text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th>Role</th>
                                <th>ID</th>
                                <th>Nama</th>
                                <th style="width: 25%;">Unit Kerja</th>
                                <th>Username</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data == 0)
                            <tr class="text-center">
                                <td colspan="8">Tidak ada data</td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="8">Sedang mengambil data ...</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="createModal" aria-labelledby="createModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Tambah</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function() {
        let uker = $('[name="uker"]').val();
        let jabatan = $('[name="jabatan"]').val();
        let status = $('[name="status"]').val();

        loadTable(uker, jabatan, status);

        function loadTable(uker, jabatan, status) {
            $.ajax({
                url: `{{ route('users.select') }}`,
                method: 'GET',
                data: {
                    uker: uker,
                    jabatan: jabatan,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('.table tbody');
                    tbody.empty();

                    if (response.message) {
                        tbody.append(`
                        <tr>
                            <td colspan="9">${response.message}</td>
                        </tr>
                    `);
                    } else {
                        // Jika ada data
                        $.each(response, function(index, item) {
                            let actionButton = '';
                            let detailUrl = "{{ route('users.detail', ':id') }}".replace(':id', item.id);
                            let deleteUrl = "{{ route('users.delete', ':id') }}".replace(':id', item.id);
                            actionButton = `
                                <a href="${detailUrl}" class="text-dark rounded border-dark">
                                    <i class="bi bi-info-circle p-1" style="font-size: 12px;"></i>
                                </a>
                                <a href="#" class="btn btn-default btn-xs bg-danger rounded border-dark"
                                onclick="confirmRemove(event, '${deleteUrl}')">
                                    <i class="bi bi-pencil p-1" style="font-size: 12px;"></i>
                                </a>
                             `;
                            tbody.append(`
                                <tr>
                                    <td class="align-middle text-center">${item.no}</td>
                                    <td class="align-middle text-center">${item.aksi}</td>
                                    <td class="align-middle text-center">${item.role}</td>
                                    <td class="align-middle text-center">${item.id}</td>
                                    <td class="align-middle">${item.nama} </td>
                                    <td class="align-middle">${item.uker}, ${item.jabatan} ${item.timker}</td>
                                    <td class="align-middle text-center">${item.username}</td>
                                    <td class="align-middle text-center">${item.status}</td>
                                </tr>
                            `);
                        });

                        $("#table-data").DataTable({
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
                                    columns: [0, 2, 3, 4],
                                },
                            }, {
                                extend: 'excel',
                                text: ' Excel',
                                className: 'bg-success me-1 rounded-1 my-2',
                                title: 'kegiatan',
                                exportOptions: {
                                    columns: [0, 2, 3, 4, 5, 6, 7, 8],
                                },
                            }, {
                                text: ' Tambah',
                                className: 'bg-primary me-1 rounded-1 my-2',
                                action: function(e, dt, button, config) {
                                    window.location.href = "{{ route('users.create') }}";
                                }
                            }, ],
                            "bDestroy": true
                        }).buttons().container().appendTo('#table-data_wrapper .col-md-6:eq(0)');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }
    });
</script>
@endsection

@endsection
