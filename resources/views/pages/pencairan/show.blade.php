@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pencairan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pencairan</li>
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
                    Daftar Pencairan
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
                                <th>Kegiatan</th>
                                <th>Perihal</th>
                                <th>Tanggal</th>
                                <th style="white-space: nowrap;">Nilai Pencairan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="small">
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

<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="Filter">Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form method="GET" action="{{ route('pencairan.show') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label class="col-form-label fw-bold">Pilih Unit Kerja</label>
                        <select name="uker_id" class="form-control">
                            <option value="">Seluruh Uker</option>
                            @foreach ($uker as $row)
                            <option value="{{ $row->id }}" <?= $row->id == $select->uker ? 'selected' : ''; ?>>
                                {{ $row->nama_uker }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="col-form-label fw-bold">Pilih Status</label>
                        <select name="status" class="form-control">
                            <option value="">Seluruh Status</option>
                            <option value="status_1" <?= $select->status == 'status_1' ? 'selected' : ''; ?>>Verifikasi KSPHLN</option>
                            <option value="status_2" <?= $select->status == 'status_2' ? 'selected' : ''; ?>>Verifikasi Keuangan</option>
                            <option value="true" <?= $select->status == 'true' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="false" <?= $select->status == 'false' ? 'selected' : ''; ?>>Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('pencairan.show') }}" class="btn btn-danger btn-sm">
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
    $('#checkAll').on('click', function() {
        $('.checkItem').prop('checked', this.checked);
    });
</script>
<script>
    $(document).ready(function() {
        let uker    = $('[name="uker_id"]').val();
        let status  = $('[name="status"]').val();
        let akses   = `{{ Auth::user()->akses }}`;

        console.log('halo' + status)
        loadTable(uker, status);

        function loadTable(uker, status) {
            $.ajax({
                url: `{{ route('pencairan.select') }}`,
                method: 'GET',
                data: {
                    uker: uker,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    let tbody = $('#table-data tbody');
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
                                    <td class="align-middle text-start ">${item.uker}</td>
                                    <td class="align-middle text-start ">${item.kegiatan}</td>
                                    <td class="align-middle text-start ">${item.perihal}</td>
                                    <td class="align-middle">${item.tanggal}</td>
                                    <td class="align-middle">${item.total}</td>
                                    <td class="align-middle">${item.status}</td>
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
                                },
                                (akses === 'ksphln' ? [{
                                    text: '<i class="bi bi-check2-circle"></i> Verifikasi',
                                    className: 'bg-primary text-white me-1 rounded-1 my-2',
                                    action: function() {
                                        $('#verifikasiModal').modal('show');
                                    }
                                }] : [])
                            ],
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
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.status-select');

        selects.forEach(select => {
            // jalankan saat load awal
            updateColor(select);

            // ubah warna setiap kali berubah
            select.addEventListener('change', function() {
                updateColor(select);
            });
        });

        function updateColor(select) {
            // reset warna dulu
            select.classList.remove('bg-success', 'bg-danger', 'bg-secondary', 'text-white');

            // ubah warna sesuai nilai
            if (select.value === 'true') {
                select.classList.add('bg-success', 'text-white');
            } else if (select.value === 'false') {
                select.classList.add('bg-danger', 'text-white');
            } else {
                select.classList.add('bg-warning', 'text-white');
            }
        }
    });
</script>
@endsection

@endsection
