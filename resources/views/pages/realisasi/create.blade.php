@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h2 class="mb-0 fw-bold">Proyek</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('proyek.detail', $data->proyek_id) }}">Proyek</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kegiatan.detail', $data->id) }}">Kegiatan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Realisasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <!-- Kolom kiri -->
            <div class="col-md-4 border-end pe-4">



                <h4 class="fw-bold mb-4 text-primary">Detail Kegiatan</h4>
                <h6>{{ 'Hibah '.$data->jenisHibah->nama_jenis.' | '.$data->jenisKegiatan->nama_jenis.' | Tahun '.$data->rencana_thn_pelaksana }}</h6>
                <h3 class="fw-bold">{{ $data->nama }}</h3>
                <h6 class="mt-0 fs-7">{{ $data->timker->nama_timker }}</h6>
                <h6 class="mt-0 fs-7">{{ $data->proyek->user->pegawai->uker->nama_uker}}</h6>
                <h6 class="fs-7">{{ $data->volume }} {{ $data->satuanKegiatan->nama_satuan }}</h6>
                <h6 class="fs-7">Total Anggaran : Rp {{ number_format($data->nilai_kegiatan, 0, ',', '.') }}</h6>

                <hr class="border-2 my-4">

                <h4 class="fw-bold mb-4 text-primary">Detail Proyek</h4>
                <h6>{{ $data->proyek->donor->nama_donor.' | '.$data->proyek->kode_hibah.' | '.$data->proyek->no_register }}</h6>
                <h3 class="fw-bold">{{ $data->proyek->nama_proyek }}</h3>
                <h6 class="mt-0 fs-7    ">{{ $data->proyek->user->pegawai->uker->nama_uker}}</h6>
                <p class="fs-7">Periode : {{ $data->proyek->periode_awal }} {{ $data->proyek->periode_akhir }}</p>
            </div>

            <!-- Kolom kanan -->
            <div class="col-md-8 ps-4">
                <h3 class="fw-bold mb-4">Tambah Realisasi</h3>

                <form id="form" action="{{ route('realisasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kegiatan_id" value="{{ $id }}">
                    <div class="card-body">

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Tanggal Mulai*</label></div>
                            <div class="w-25">
                                <input type="date" class="form-control" name="tanggal_mulai" required>
                            </div>

                            <div class="w-25 text-center"><label class="col-form-label">Tanggal Selesai*</label></div>
                            <div class="w-25">
                                <input type="date" class="form-control" name="tanggal_selesai" required>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Nilai Kegiatan*</label></div>
                            <div class="w-75">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-dark">Rp</span>
                                    <input type="text" class="form-control border-dark number" name="nilai" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Deskripsi*</label></div>
                            <div class="w-75">
                                <textarea class="form-control" name="deskripsi" required></textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Output yang Dicapai</label></div>
                            <div class="w-75">
                                <textarea name="keterangan_output" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Penerima Manfaat</label></div>
                            <div class="w-75">
                                <textarea name="penerima_manfaat" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Kendala/Hambatan</label></div>
                            <div class="w-75">
                                <textarea name="keterangan_kendala" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Rencana Tindak Lanjut</label></div>
                            <div class="w-75">
                                <textarea name="keterangan_tindaklanjut" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Keterangan Lain</label></div>
                            <div class="w-75">
                                <textarea name="keterangan_lain" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Data Pendukung</label></div>
                            <div class="w-75">
                                <textarea name="data_pendukung" class="form-control"></textarea>
                                <small class="fs-8 text-danger">Lampirkan data pendukung (link Google Drive)</small>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" onclick="confirmSubmit(event, 'form')">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js')
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Paksa browser menampilkan native date picker
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.showPicker && this.showPicker(); // untuk Chrome, Edge, Opera
            });
        });
    });
</script>

@endsection

@endsection
