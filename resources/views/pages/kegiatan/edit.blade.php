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
                    <li class="breadcrumb-item"><a href="{{ route('kegiatan.detail', $id) }}">Kegiatan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Kegiatan</li>
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
                <p>{{ $data->proyek->donor->nama_donor.' | '.$data->proyek->kode_hibah.' | '.$data->proyek->no_register }}</p>
                <h3 class="fw-bold">{{ $data->proyek->nama_proyek }}</h3>
                <h6 class="mt-0 fs-7    ">{{ $data->proyek->user->pegawai->uker->nama_uker}}</h6>
                <p class="fs-7">Periode : {{ $data->proyek->periode_awal }} {{ $data->proyek->periode_akhir }}</p>

                <hr class="border-2">

                <div class="form-group">
                    <label class="fw-bold">ISS</label>
                    <h6>{{ $data->proyek->iss }}</h6>
                </div>

                <div class="form-group my-5">
                    <label class="fw-bold">IKP</label>
                    <h6>{{ $data->proyek->ikp }}</h6>
                </div>

                <div class="form-group">
                    <label class="fw-bold">IKK</label>
                    <h6>{{ $data->proyek->ikk }}</h6>
                </div>

                <hr class="border boder-dark mt-5">

                <div class="form-group">
                    <label class="fw-bold mb-3">Linimasa</label>
                    <div class="timeline small">
                        @foreach ($data->proyek->timeline as $row)
                        <div class="time-label fs-8">
                            <span class="text-bg-danger bg-opacity-100">
                                {{ Carbon\Carbon::parse($row->created_at)->isoFormat('DD MMM, Y') }}
                            </span>
                        </div>

                        <div>
                            <i class="timeline-icon bi bi-people text-bg-light"> </i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="bi bi-clock-fill"></i>
                                    {{ Carbon\Carbon::parse($row->created_at)->isoFormat('HH:mm') }}
                                </span>
                                <h3 class="timeline-header fs-8">
                                    <a href="#">{{ $row->proyek->user->pegawai->nama }}</a>
                                    @if ($row->status == 'kirim') <label> mengirimkan usulan</label> @endif
                                    @if ($row->status == 'kembali') <label> mengembalikan usulan</label> @endif
                                    @if ($row->status == 'perbaikan') <label> memperbaiki usulan</label> @endif
                                </h3>

                                @if ($row->keterangan)
                                <div class="timeline-body fs-8">
                                    {{ $row->keterangan }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Kolom kanan -->
            <div class="col-md-8 ps-4">
                <h3 class="fw-bold mb-4">Edit Kegiatan {{ $data->rencana_thn_pelaksana }}</h3>

                <form id="form" action="{{ route('kegiatan.update', $id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="proyek_id" value="{{ $id }}">
                    <div class="card-body">
                        @if (Auth::user()->role_id != 4)
                        <div class="input-group">
                            <div class="w-25"><label class="col-form-label">Unit Kerja*</label></div>
                            <div class="w-75">
                                <select id="uker" class="form-control select2" name="uker_id" style="width: 100%;" required>
                                    <option value="">-- Cari Unit Kerja --</option>
                                    @foreach ($uker as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama_uker }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @else
                        <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
                        @endif


                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Tim Kerja*</label></div>
                            <div class="w-75">
                                <select id="timker" class="form-control select2" name="timker_id" style="width: 100%;" required>
                                    <option value="">-- Pilih Tim Kerja --</option>
                                    @if (Auth::user()->role_id == 4)
                                    @foreach ($timker as $row)
                                    <option value="{{ $row->id }}" <?= $row->id == $data->timker_id ? 'selected' : ''; ?>>
                                        {{ $row->nama_timker }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Nama Kegiatan*</label></div>
                            <div class="w-75">
                                <input type="text" class="form-control" name="nama" value="{{ $data->nama }}" required>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Jenis Kegiatan*</label></div>
                            <div class="w-75">
                                <select name="jenis_kegiatan_id" class="form-control" required>
                                    <option value="">-- Pilih Jenis Kegiatan --</option>
                                    @foreach ($jenis as $row)
                                    <option value="{{ $row->id }}" <?= $row->id == $data->jenis_kegiatan_id ? 'selected' : ''; ?>>
                                        {{ $row->nama_jenis }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Program</label></div>
                            <div class="w-75">
                                <select name="program_id" class="form-control">
                                    <option value="">-- Pilih Program --</option>
                                    @foreach ($program as $row)
                                    <option value="{{ $row->id }}" <?= $row->id == $data->program_id ? 'selected' : ''; ?>>
                                        {{ $row->nama_program }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Volume*</label></div>
                            <div class="w-25">
                                <input type="number" class="form-control border-dark text-center" name="volume" min="1" value="{{ $data->volume }}" required>
                            </div>
                            <div class="w-25 text-end"><label class="col-form-label mx-5">Satuan/Target*</label></div>
                            <div class="w-25">
                                <select name="satuan_kegiatan_id" class="form-control text-center" required>
                                    <option value="">-- Pilih Satuan Kegiatan --</option>
                                    @foreach ($satuan as $row)
                                    <option value="{{ $row->id }}" <?= $row->id == $data->satuan_kegiatan_id ? 'selected' : ''; ?>>
                                        {{ $row->nama_satuan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Tahun Pelaksanaan*</label></div>
                            <div class="w-25">
                                <input type="number" class="form-control border-dark text-center" name="tahun" min="1" value="{{ $data->rencana_thn_pelaksana }}" readonly>
                            </div>
                            <div class="w-25 text-end"><label class="col-form-label mx-5">Modalitas*</label></div>
                            <div class="w-25">
                                <select name="jenis_hibah_id" class="form-control text-center" required>
                                    <option value="">-- Pilih Modalitas Hibah --</option>
                                    @foreach ($hibah as $row)
                                    <option value="{{ $row->id }}" <?= $row->id == $data->jenis_hibah_id ? 'selected' : ''; ?>>
                                        {{ $row->nama_jenis }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Tgl. Mulai*</label></div>
                            <div class="w-25">
                                <input type="date" class="form-control border-dark text-center" name="tanggal_mulai" value="{{ $data->tanggal_mulai }}" required>
                            </div>
                            <div class="w-25 text-end"><label class="col-form-label mx-5">Tgl. Selesai*</label></div>
                            <div class="w-25">
                                <input type="date" class="form-control border-dark text-center" name="tanggal_selesai" value="{{ $data->tanggal_selesai }}" required>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Nilai Kegiatan*</label></div>
                            <div class="w-75">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-dark">Rp</span>
                                    <input type="text" class="form-control border-dark number" name="nilai_kegiatan" min="1" value="{{ number_format($data->nilai_kegiatan, 0, ',', '.') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Justifikasi Realisasi</label></div>
                            <div class="w-75">
                                <textarea name="justifikasi_realisasi" class="form-control">{{ $data->justifikasi_realisasi }}</textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Mendukung Pilar</label></div>
                            <div class="w-75">
                                <input type="text" class="form-control" name="pilar_pendukung" value="{{ $data->pilar_pendukung }}" required>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Kode Program</label></div>
                            <div class="w-75">
                                <input type="text" class="form-control" name="kode_program" value="{{ $data->kode_program }}" required>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Output yang Dicapai</label></div>
                            <div class="w-75">
                                <textarea name="keterangan_output" class="form-control">{{ $data->kode_program }}</textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Penerima Manfaat</label></div>
                            <div class="w-75">
                                <textarea name="penerima_manfaat" class="form-control">{{ $data->kode_program }}</textarea>
                            </div>
                        </div>

                        <div class="input-group my-3">
                            <div class="w-25"><label class="col-form-label">Kendala/Hambatan</label></div>
                            <div class="w-75">
                                <textarea name="keterangan_kendala" class="form-control">{{ $data->kode_program }}</textarea>
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
