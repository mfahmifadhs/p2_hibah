@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Kegiatan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kegiatan</li>
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
                    Daftar Kegiatan
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
                                <th style="white-space: nowrap;">Unit Kerja</th>
                                <th style="width: 20%;">Donor</th>
                                <th style="width: 30%;">Kegiatan</th>
                                <th style="white-space: nowrap;">Jenis Kegiatan</th>
                                <th>Volume</th>
                                <th>Tahun</th>
                                <th style="white-space: nowrap;">Total Anggaran</th>
                                <th style="white-space: nowrap;">Total Realisasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @if ($data == 0)
                            <tr class="text-center">
                                <td colspan="11">Tidak ada data</td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="11">Sedang mengambil data ...</td>
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
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="Filter">Filter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form method="GET" action="{{ route('kegiatan.show') }}">
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
                        <label class="col-form-label fw-bold">Pilih Proyek</label>
                        <select name="proyek_id" class="form-control">
                            <option value="">Seluruh Proyek</option>
                            @foreach ($proyek as $row)
                            <option value="{{ $row->id }}" <?= $row->id == $select->proyek ? 'selected' : ''; ?>>
                                {{ $row->no_register.' - '.$row->nama_proyek }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="col-form-label fw-bold">Pilih Donor</label>
                        <select name="donor_id" class="form-control">
                            <option value="">Seluruh Donor</option>
                            @foreach ($donor as $row)
                            <option value="{{ $row->id }}" <?= $row->id == $select->donor ? 'selected' : ''; ?>>
                                {{ $row->nama_donor }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="col-form-label fw-bold">Pilih Jenis Kegiatan</label>
                        <select name="jenis_id" class="form-control">
                            <option value="">Seluruh Jenis Kegiatan</option>
                            <option value="kosong" <?= $select->jenis == 'kosong' ? 'selected' : ''; ?>>Tidak ditentukan</option>
                            @foreach ($jenis as $row)
                            <option value="{{ $row->id }}" <?= $row->id == $select->jenis ? 'selected' : ''; ?>>
                                {{ $row->nama_jenis }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="col-form-label fw-bold">Pilih Status</label>
                        <select name="status" class="form-control">
                            <option value="">Seluruh Status</option>
                            <option value="null" <?php echo $select->status == 'null' ? 'selected' : ''; ?>>Verifikasi</option>
                            <option value="true" <?php echo $select->status == 'true' ? 'selected' : ''; ?>>Setuju</option>
                            <option value="false" <?php echo $select->status  == 'false' ? 'selected' : ''; ?>>Tolak</option>
                            <option value="revisi" <?php echo $select->status == 'revisi' ? 'selected' : ''; ?>>Revisi</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label class="col-form-label fw-bold">Pilih Tahun</label>
                        <select name="tahun" class="form-control">
                            <option value="">Seluruh Tahun</option>
                            @foreach ($tahun as $row)
                            <option value="{{ $row }}" <?= $row == $select->tahun ? 'selected' : ''; ?>>
                                {{ $row }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('kegiatan.show') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-undo"></i> Muat
                    </a>
                    <button class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="form-verif" action="{{ route('kegiatan.verif', '*') }}" method="GET">
                @csrf
                <div class="modal-body" style="overflow-x: scroll; max-height: 75vh;">
                    <table class="table table-bordered align-middle">
                        <thead class="table-bordered text-center">
                            <tr class="align-middle">
                                <th width="5%">No</th>
                                <th width="25%">Unit Kerja</th>
                                <th>Nama Kegiatan</th>
                                <th width="15%" class="text-center">
                                    Verifikasi
                                </th>
                                <th width="25%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kegiatan as $no => $row)
                            <tr>
                                <td class="text-center">{{ $no + 1 }}</td>
                                <td>{{ $row->proyek->user->pegawai->uker->nama_uker }}</td>
                                <td>
                                    <h6 class="fs-8 mb-0">{{ $row->jenisKegiatan->nama_jenis }}</h6>
                                    <h6 class="fs-6 mb-0 fw-bold">{{ $row->nama }}</h6>
                                    <h6 class="fs-6 mb-0">Hibah {{ $row->jenisHibah->nama_jenis }}</h6>
                                    <h6 class="fs-6">Nilai : Rp {{ number_format($row->nilai_kegiatan, 0, ',', '.') }}</h6>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="kegiatan_id[]" value="{{ $row->id }}">
                                    <select name="status[]" class="form-control text-center status-select fw-bold">
                                        <option value="true" class="bg-success">setuju</option>
                                        <option value="false" class="bg-danger">tolak</option>
                                        <option value="" class="bg-warning">tunda</option>
                                    </select>
                                </td>
                                <td>
                                    <textarea type="text" class="form-control" name="keterangan[]"></textarea>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event, 'form-verif')">
                            <i class="bi bi-check2-circle"></i> Verifikasi Terpilih
                        </button>
                    </div>
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
        let donor   = $('[name="donor_id"]').val();
        let jenis   = $('[name="jenis_id"]').val();
        let status  = $('[name="status"]').val();
        let tahun   = $('[name="tahun"]').val();
        let proyek  = $('[name="proyek_id"]').val();
        let akses   = `{{ Auth::user()->akses }}`;

        loadTable(uker, donor, jenis, status, tahun, proyek);

        function loadTable(uker, donor, jenis, status, tahun, proyek) {
            $.ajax({
                url: `{{ route('kegiatan.select') }}`,
                method: 'GET',
                data: {
                    uker: uker,
                    donor: donor,
                    jenis: jenis,
                    status: status,
                    tahun: tahun,
                    proyek: proyek
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
                                    <td class="align-middle text-start ">${item.register} <br> ${item.donor} <br> ${item.proyek}</td>
                                    <td class="align-middle text-start">${item.nama}</td>
                                    <td class="align-middle text-center">${item.jenis}</td>
                                    <td class="align-middle text-center">${item.volume} ${item.satuan}</td>
                                    <td class="align-middle text-center">${item.tahun}</td>
                                    <td class="align-middle text-start">${item.total}</td>
                                    <td class="align-middle text-start">${item.realisasi}</td>
                                    <td class="align-middle text-start">${item.status}</td>
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
