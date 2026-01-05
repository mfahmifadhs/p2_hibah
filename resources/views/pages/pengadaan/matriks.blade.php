@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
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
    <div class="container-fluid">
        <table class="table table-bordered align-middle bg-white rounded shadow-sm border border-dark text-center fs-8">
            <thead>
                <tr>
                    <th colspan="16">
                        <h5 class="fw-bold text-start">Matriks Sandingan</h5>
                    </th>
                </tr>
                <tr class="align-middle">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Program</th>
                    <th rowspan="2">Kegiatan</th>

                    <th colspan="4">APBN</th>
                    <th colspan="4">BOK/DAK</th>
                    <th colspan="5">Donor</th>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <th>Alokasi</th>
                    <th>Jumlah</th>
                    <th>Realisasi</th>

                    <th>Jumlah</th>
                    <th>Alokasi</th>
                    <th>Jumlah</th>
                    <th>Realisasi</th>

                    <th>Jumlah</th>
                    <th>Alokasi</th>
                    <th>Jumlah</th>
                    <th>Realisasi</th>
                    <th>Donor</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $i => $program)
                @php
                $jumlah_kegiatan = $program->pengadaan->count();
                @endphp

                @foreach ($program->pengadaan as $k => $keg)
                @php
                // Ambil sumber dana
                $apbn = $keg->dana->where('sumber.id', 1)->first();
                $bok = $keg->dana->where('sumber.id', 2)->first();
                $donor = $keg->dana->where('sumber.id', 3)->first();
                @endphp

                <tr>
                    {{-- No + Program hanya muncul pada baris pertama --}}
                    @if ($k == 0)
                    <td rowspan="{{ $jumlah_kegiatan }}">{{ $i+1 }}</td>
                    <td rowspan="{{ $jumlah_kegiatan }}">{{ $program->nama_program }}</td>
                    @endif

                    {{-- Nama kegiatan --}}
                    <td class="text-start">{{ $keg->nama }}</td>

                    {{-- APBN --}}
                    <td class="text-end bg-info fw-bold">{{ number_format(optional($apbn)->jumlah_alokasi, 0, ',', '.') }} {{ optional($apbn)->satuan_alokasi }}</td>
                    <td class="text-end bg-info fw-bold">Rp {{ number_format(optional($apbn)->nilai_alokasi, 0, ',', '.') }}</td>
                    <td class="text-end bg-info fw-bold">{{ number_format(optional($apbn)->jumlah_realisasi, 0, ',', '.') }} {{ optional($apbn)->satuan_realisasi }}</td>
                    <td class="text-end bg-info fw-bold">Rp {{ number_format(optional($apbn)->nilai_realisasi, 0, ',', '.') }}</td>

                    {{-- BOK --}}
                    <td class="text-end bg-danger fw-bold">{{ number_format(optional($bok)->jumlah_alokasi, 0, ',', '.') }} {{ optional($bok)->satuan_alokasi }}</td>
                    <td class="text-end bg-danger fw-bold">Rp {{ number_format(optional($bok)->nilai_alokasi, 0, ',', '.') }}</td>
                    <td class="text-end bg-danger fw-bold">{{ number_format(optional($bok)->jumlah_realisasi, 0, ',', '.') }} {{ optional($bok)->satuan_realisasi }}</td>
                    <td class="text-end bg-danger fw-bold">Rp {{ number_format(optional($bok)->nilai_realisasi, 0, ',', '.') }}</td>

                    {{-- Donor --}}
                    <td class="text-end bg-danger fw-bold">{{ number_format(optional($donor)->jumlah_alokasi, 0, ',', '.') }} {{ optional($donor)->satuan_alokasi }}</td>
                    <td class="text-end bg-warning fw-bold">Rp {{ number_format(optional($donor)->nilai_alokasi, 0, ',', '.') }}</td>
                    <td class="text-end bg-danger fw-bold">{{ number_format(optional($donor)->realisasi, 0, ',', '.') }} {{ optional($donor)->realisasi }}</td>
                    <td class="text-end bg-warning fw-bold">Rp {{ number_format(optional($donor)->nilai_realisasi, 0, ',', '.') }}</td>
                    <td class="bg-warning fw-bold">{{ $donor->donor->nama_donor ?? '' }}</td>
                </tr>

                @endforeach
                @endforeach
            </tbody>
        </table>

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
