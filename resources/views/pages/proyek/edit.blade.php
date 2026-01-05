@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid col-md-10">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Proyek</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('proyek.show') }}">Proyek</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('proyek.detail', $data->id) }}">Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid col-md-10">

        @if ($data->status == 'false')
        <div class="callout callout-danger mb-4 d-flex gap-2 p-2">
            <i class="bi bi-exclamation-octagon my-auto fs-2"></i>
            <h5 class="fw-bold mt-1">
                Ditolak <br>
                <span class="fs-8">{{ optional($data->timeline->where('proyek_id', $data->id)->where('status', 'kembali')->last())->keterangan }}</span>
            </h5>
        </div>
        @endif

        <div class="card shadow-sm border-1 border-dark">
            <div class="card-header border-dark">
                <h4 class="card-title mt-1">Edit Proyek</h4>
                @if ($data->status == 'false')
                <div class="card-tools">
                    <a href="#" class="btn btn-primary btn-sm bg-opacity-50 fw-bold"
                    onclick="confirmLink(event, `{{ route('proyek.verif', ['id' => $data->id, 'revisi' => 'true']) }}`)">
                        <i class="bi bi-pencil-square"></i> &nbsp; Selesai Diperbaiki
                    </a>
                </div>
                @endif
            </div>
            <form id="form" action="{{ route('proyek.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @if (Auth::user()->role_id == 1)
                    <div class="input-group">
                        <div class="w-25"><label class="col-form-label">Pegawai</label></div>
                        <div class="w-75">
                            <select id="pegawai" class="form-control select2" name="user_id" style="width: 100%;" required>
                                <option value="{{ $data->user_id }}">{{ $data->user->pegawai->nama }}</option>
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
                    @endif

                    @if ($data->status == 'false')
                    <input type="hidden" name="status" value="">
                    @endif


                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Donor*</label></div>
                        <div class="w-75">
                            <select class="form-control select2" name="donor_id" style="width: 100%;" required>
                                <option value="">-- Pilih Donor --</option>
                                @foreach ($donor as $row)
                                <option value="{{ $row->id }}" <?= $row->id == $data->donor_id ? 'selected' : ''; ?>>
                                    {{ $row->nama_donor }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Kode Hibah*</label></div>
                        <div class="w-75">
                            <input type="text" class="form-control" name="kode_hibah" value="{{ $data->kode_hibah }}" required>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">No. Register*</label></div>
                        <div class="w-75">
                            <input type="text" class="form-control" name="no_register" value="{{ $data->no_register }}" required>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Nama Proyek*</label></div>
                        <div class="w-75">
                            <input type="text" class="form-control" name="nama_proyek" value="{{ $data->nama_proyek }}" required>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Periode Awal</label></div>
                        <div class="w-25">
                            <input type="text" class="form-control border-dark" name="periode_awal" value="{{ $data->periode_awal }}">
                        </div>

                        <div class="w-25 text-end"><label class="col-form-label mx-5">Periode Akhir</label></div>
                        <div class="w-25">
                            <input type="text" class="form-control border-dark" name="periode_akhir" value="{{ $data->periode_akhir }}">
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Total Budget IDR*</label></div>
                        <div class="w-75">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-dark">IDR</span>
                                <input type="text" class="form-control border-dark number" name="total_budget_idr" value="{{ number_format($data->total_budget_idr, 0, ',', '.') }}" min="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">ISS</label></div>
                        <div class="w-75">
                            <textarea name="iss" class="form-control">{{ $data->iss }}</textarea>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">IKP</label></div>
                        <div class="w-75">
                            <textarea name="ikp" class="form-control">{{ $data->ikp }}</textarea>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">IKK</label></div>
                        <div class="w-75">
                            <textarea name="ikk" class="form-control">{{ $data->ikk }}</textarea>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Keterangan</label></div>
                        <div class="w-75">
                            <textarea name="keterangan" class="form-control">{{ $data->keterangan }}</textarea>
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

@section('js')
<script>
    $(document).ready(function() {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        $("#pegawai").select2({
            placeholder: "Cari Pegawai...",
            allowClear: true,
            ajax: {
                url: "{{ route('pegawai.json') }}",
                type: "GET",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term
                    }
                },
                processResults: function(response) {
                    return {
                        results: response.map(function(item) {
                            console.log('halo' + item.text)
                            return {
                                id: item.id,
                                text: item.text
                            };
                        })
                    };
                },
                cache: true
            }
        })

        $(".pegawai").each(function() {
            let selectedId = $(this).find("option:selected").val();
            let selectedText = $(this).find("option:selected").text();

            if (selectedId) {
                let newOption = new Option(selectedText, selectedId, true, true);
                $(this).append(newOption).trigger('change');
            }
        });
    });
</script>
@endsection

@endsection
