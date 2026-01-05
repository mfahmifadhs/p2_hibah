@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pegawai</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
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
                    Daftar Pegawai
                </label>
            </div>
            <div class="table-responsive">
                <div class="card-body">
                    <table id="table-data" class="table table-hover table-bordered table-striped mb-0 text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width: 8%;">Aksi</th>
                                <th>Nama</th>
                                <th style="width: 25%;">Unit Kerja</th>
                                <th>NIP</th>
                                <th>No. Telepon</th>
                                <th>Email</th>
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModal">Tambah</h5>

                <button type="button" class="btn btn-default close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="role" class="col-form-label">Unit Kerja:</label>
                            <select class="form-control" name="uker" required>
                                <option value="">-- Pilih Unit Kerja --</option>
                                @foreach ($uker as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_uker }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="role" class="col-form-label">Tim Kerja:</label>
                            <select class="form-control" name="timker" required>
                                <option value="">-- Pilih Tim Kerja --</option>
                                @foreach ($timker as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_timker }}</option>
                                @endforeach
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Pengguna</h5>
                <button type="button" class="btn btn-default close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalDetailContent">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <h6 for="role" class="col-form-label"><b>Unit Kerja</b></h6>
                            <span id="getUker"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <h6 for="role" class="col-form-label"><b>Tim Kerja</b></h6>
                            <span id="getTimker"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <h6 for="role" class="col-form-label"><b>Jabatan</b></h6>
                            <span id="getJabatan"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <h6 for="nama" class="col-form-label"><b>Nama</b></h6>
                            <span id="getNama"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <h6 for="nip" class="col-form-label"><b>NIP</b></h6>
                            <span id="getNip"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <h6 for="jenis_kelamin" class="col-form-label"><b>Jenis Kelamin</b></h6>
                            <span id="getJenisKelamin"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <h6 for="notelp" class="col-form-label"><b>No Telepon</b></h6>
                            <span id="getNoTelp"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <h6 for="email" class="col-form-label"><b>Email</b></h6>
                            <span id="getEmail"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    $('#detailModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var pegawaiId = button.data('id');

        $.get('/pegawai/json/' + pegawaiId, function(data) {
            console.log(data.nama)
            $('#getNama').text(data.nama);
            $('#getNip').text(data.nip);
            $('#getJenisKelamin').text(data.jenis_kelamin);
            $('#getNoTelp').text(data.no_telp);
            $('#getEmail').text(data.email);
            $('#getUker').text(data.uker);
            $('#getTimker').text(data.timker);
            $('#getJabatan').text(data.jabatan);
        });
    });
</script>
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
                            let detailUrl = "{{ route('pegawai.detail', ':id') }}".replace(':id', item.id);
                            let editUrl = "{{ route('pegawai.edit', ':id') }}".replace(':id', item.id);
                            let deleteUrl = "{{ route('pegawai.delete', ':id') }}".replace(':id', item.id);
                            actionButton = `
                                <a href="#" class="text-dark rounded border-dark" data-toggle="modal" data-target="#detailModal" data-id="${item.id}">

                                </a>
                                <a href="${detailUrl}" class="text-dark rounded border-dark">
                                    <i class="bi bi-info-circle p-1" style="font-size: 12px;"></i>
                                </a>
                                <a href="${editUrl}" class="text-dark rounded border-dark">
                                    <i class="bi bi-pencil p-1" style="font-size: 12px;"></i>
                                </a>
                                <a href="${deleteUrl}" class="text-dark rounded border-dark rounded border-dark"
                                onclick="confirmLink(event, '${deleteUrl}')">
                                    <i class="bi bi-trash p-1" style="font-size: 12px;"></i>
                                </a>
                             `;
                            tbody.append(`
                                <tr>
                                    <td class="align-middle">${item.no}</td>
                                    <td class="align-middle">${actionButton}</td>
                                    <td class="align-middle text-left">${item.nama} </td>
                                    <td class="align-middle">${item.uker}, ${item.jabatan} ${item.timker}</td>
                                    <td class="align-middle text-left">${item.nip}</td>
                                    <td class="align-middle text-left">${item.notelp}</td>
                                    <td class="align-middle text-left">${item.email}</td>
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
                                    window.location.href = "{{ route('pegawai.create') }}";
                                }
                            }, ],
                            // {
                            //     text: ' Tambah',
                            //     className: 'bg-primary',
                            //     action: function(e, dt, button, config) {
                            //         $('#createModal').modal('show');
                            //     }
                            // },
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
