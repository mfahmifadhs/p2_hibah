@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Proyek</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Proyek</li>
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
                    Daftar Proyek
                </label>
                <div class="card-tools">
                    <a href="" class="btn btn-default btn-sm text-dark" data-bs-toggle="modal" data-bs-target="#modalFilter">
                        <i class="fas fa-filter"></i> Filter
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data" class="table table-hover table-bordered table-striped mb-0 text-center">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th style="width: 20%;">Unit Kerja</th>
                                <th>Kode</th>
                                <th>No.Register</th>
                                <th>Proyek</th>
                                <th>Periode</th>
                                <th style="white-space: nowrap;">Total (IDR)</th>
                                <th style="white-space: nowrap;">Total (USD)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @if ($data == 0)
                            <tr class="text-center">
                                <td colspan="10">Tidak ada data</td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="10">Sedang mengambil data ...</td>
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

<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-filter"></i> Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="{{ route('proyek.show') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Pilih Status</label>
                        <select name="status" class="form-control">
                            <option value="">Seluruh Status</option>
                            <option value="null" <?php echo $selStatus == 'null' ? 'selected' : ''; ?>>Verifikasi</option>
                            <option value="true" <?php echo $selStatus == 'true' ? 'selected' : ''; ?>>Setuju</option>
                            <option value="false" <?php echo $selStatus  == 'false' ? 'selected' : ''; ?>>Tolak</option>
                            <option value="revisi" <?php echo $selStatus == 'revisi' ? 'selected' : ''; ?>>Revisi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('proyek.show') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-undo"></i> Muat
                    </a>
                    <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function() {
        let uker = $('[name="uker"]').val();
        let jabatan = $('[name="jabatan"]').val();
        let status = $('[name="status"]').val();

        console.log('halo' + status)

        loadTable(uker, jabatan, status);

        function loadTable(uker, jabatan, status) {
            $.ajax({
                url: `{{ route('proyek.select') }}`,
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
                            let detailUrl = "{{ route('proyek.detail', ':id') }}".replace(':id', item.id);
                            let editUrl = "{{ route('proyek.edit', ':id') }}".replace(':id', item.id);
                            actionButton = `
                                <a href="${detailUrl}" class="text-dark rounded border-dark">
                                    <i class="bi bi-info-circle p-1" style="font-size: 12px;"></i>
                                </a>
                                <a href="${editUrl}" class="text-dark rounded border-dark">
                                    <i class="bi bi-pencil p-1" style="font-size: 12px;"></i>
                                </a>
                             `;
                            tbody.append(`
                                <tr>
                                    <td class="align-middle text-center">${item.no}</td>
                                    <td class="align-middle text-center">${item.aksi}</td>
                                    <td class="align-middle text-start">${item.uker}</td>
                                    <td class="align-middle text-center">${item.kode}</td>
                                    <td class="align-middle text-center">${item.register}</td>
                                    <td class="align-middle text-start">${item.proyek}</td>
                                    <td class="align-middle text-center">${item.periode}</td>
                                    <td class="align-middle text-center" style="white-space: nowrap;" data-order="${item.total_idr_raw}">${item.total_idr}</td>
                                    <td class="align-middle text-center" style="white-space: nowrap;" data-order="${item.total_usd_raw}">${item.total_usd}</td>
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
                                    window.location.href = "{{ route('proyek.create') }}";
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
