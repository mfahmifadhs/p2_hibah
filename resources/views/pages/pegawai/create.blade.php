@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid col-md-10 col-12">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pegawai</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pegawai') }}">Pegawai</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid col-md-10 col-12">
        <div class="card shadow-sm border-1 border-dark">
            <div class="card-header border-dark">
                <h4 class="card-title">Tambah Pegawai</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="form" action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="role" class="col-form-label">Unit Kerja:</label>
                                    <select id="uker" class="form-control" name="uker" required>
                                        <option value="">-- Pilih Unit Kerja --</option>
                                        @foreach ($uker as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_uker }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="role" class="col-form-label">Tim Kerja:</label>
                                    <select id="timker" class="form-control" name="timker" required>
                                        <option value="">-- Pilih Tim Kerja --</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="role" class="col-form-label">Jabatan:</label>
                                    <select class="form-control" name="jabatan" required>
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach ($jabatan as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="nama" class="col-form-label">Nama:</label>
                                    <input id="nama" type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="nip" class="col-form-label">NIP:</label>
                                    <input id="nip" type="number" class="form-control" name="nip" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin:</label>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="notelp" class="col-form-label">No Telepon:</label>
                                    <input id="notelp" type="number" class="form-control" name="no_telepon">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">Submit</button>
                        </div>
                    </form>
                </div>
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
                url: `{{ route('pegawai.select') }}`,
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
                            let deleteUrl = "{{ route('users.delete', ':id') }}".replace(':id', item.id);
                            actionButton = `
                                <a href="#" class="btn btn-default btn-xs bg-danger rounded border-dark"
                                onclick="confirmRemove(event, '${deleteUrl}')">
                                    <i class="fas fa-trash-alt p-1" style="font-size: 12px;"></i>
                                </a>
                             `;
                            tbody.append(`
                                <tr>
                                    <td class="align-middle">${item.no}</td>
                                    <td class="align-middle">${item.aksi}</td>
                                    <td class="align-middle">${item.role}</td>
                                    <td class="align-middle text-left">${item.nama} </td>
                                    <td class="align-middle">${item.uker}, ${item.jabatan} ${item.timker}</td>
                                    <td class="align-middle text-left">${item.nip}</td>
                                    <td class="align-middle text-left">${item.username}</td>
                                    <td class="align-middle">${item.status}</td>
                                </tr>
                            `);
                        });

                        $("#table-data").DataTable({
                            "responsive": false,
                            "lengthChange": false,
                            "autoWidth": false,
                            "info": true,
                            "paging": true,
                            "searching": true,
                            buttons: [{
                                extend: 'pdf',
                                text: ' PDF',
                                pageSize: 'A4',
                                className: 'bg-danger',
                                title: 'kegiatan',
                                exportOptions: {
                                    columns: [0, 2, 3, 4],
                                },
                            }, {
                                extend: 'excel',
                                text: ' Excel',
                                className: 'bg-success',
                                title: 'kegiatan',
                                exportOptions: {
                                    columns: [0, 2, 3, 4, 5, 6, 7, 8],
                                },
                            }, {
                                text: ' Tambah',
                                className: 'bg-primary',
                                action: function(e, dt, button, config) {
                                    $('#createModal').modal('show');
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

<script>
    $(document).ready(function() {
        $('#uker').on('change', function() {
            var ukerID = $(this).val();

            // Kosongkan dropdown Tim Kerja saat ganti Unit Kerja
            $('#timker').empty().append('<option value="">-- Pilih Tim Kerja --</option>');

            if (ukerID) {
                $.ajax({
                    url: '/uker/timker/' + ukerID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#timker').append('<option value="' + value.id + '">' + value.nama_timker + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
@endsection

@endsection
