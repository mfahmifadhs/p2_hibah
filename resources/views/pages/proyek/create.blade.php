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
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid col-md-10">
        <div class="card shadow-sm border-1 border-dark">
            <div class="card-header border-dark">
                <h4 class="card-title">Create Proyek</h4>
            </div>
            <form id="form" action="{{ route('proyek.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="status" value="1">
                <div class="card-body">
                    @if (Auth::user()->role_id == 1)
                    <div class="input-group">
                        <div class="w-25"><label class="col-form-label">Pegawai</label></div>
                        <div class="w-75">
                            <select id="pegawai" class="form-control select2" name="user_id" style="width: 100%;" required>
                                <option value="">-- Cari Pegawai --</option>
                            </select>
                        </div>
                    </div>
                    @else
                    <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
                    @endif


                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Donor</label></div>
                        <div class="w-75">
                            <select class="form-control select2" name="donor_id" style="width: 100%;" required>
                                <option value="">-- Pilih Donor --</option>
                                @foreach ($donor as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_donor }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Kode Hibah</label></div>
                        <div class="w-75">
                            <input type="text" class="form-control" name="kode_hibah" required>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">No. Register</label></div>
                        <div class="w-75">
                            <input type="text" class="form-control" name="no_register" required>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Nama Proyek</label></div>
                        <div class="w-75">
                            <input type="text" class="form-control" name="nama_proyek" required>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Periode Awal</label></div>
                        <div class="w-25">
                            <input type="number" class="form-control border-dark" min="2010" value="2025" name="periode_awal">
                        </div>

                        <div class="w-25 text-end"><label class="col-form-label mx-5">Periode Akhir</label></div>
                        <div class="w-25">
                            <input type="number" class="form-control border-dark" min="2010" value="2025" name="periode_akhir">
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Total Budget IDR</label></div>
                        <div class="w-75">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-dark">IDR</span>
                                <input type="text" class="form-control border-dark number" name="total_budget_idr" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">ISS</label></div>
                        <div class="w-75">
                            <textarea name="iss" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">IKP</label></div>
                        <div class="w-75">
                            <textarea name="ikp" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">IKK</label></div>
                        <div class="w-75">
                            <textarea name="ikk" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Keterangan</label></div>
                        <div class="w-75">
                            <textarea name="keterangan" class="form-control"></textarea>
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
