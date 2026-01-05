@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid col-md-10">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Users</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
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
                <h4 class="card-title">Detail Users</h4>
            </div>
            <div class="card-body">
                <form id="form" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-2">
                                <label for="pegawai" class="col-form-label">Pilih Pegawai:</label>
                                <select id="pegawai" class="form-control select2" name="pegawai_id" style="width: 100%;" required>
                                    <option value="">-- Cari Pegawai --</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="akses" class="col-form-label">Pilih Role:</label>
                                <select class="form-control" name="role_id">
                                    <option value="">Tidak ada</option>
                                    @foreach ($role as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama_role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="username" class="col-form-label">Username:</label>
                                <input id="username" type="text" class="form-control" name="username" required>
                            </div>
                            <div class="col-md-6 mb-2 mt-1">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control bg-light" name="password" id="passwordInput" placeholder="Password" required>
                                    <span class="input-group-text bg-light" onclick="togglePassword()" style="cursor: pointer;">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="keterangan" class="col-form-label">Akses:</label>
                                <select name="akses" class="form-control">
                                    <option value="">-- Pilih Akses --</option>
                                    <option value="ksphln">KSPHLN</option>
                                    <option value="keuangan">Keuangan</option>
                                    <option value="pa">Program Anggaran</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="keterangan" class="col-form-label">Keterangan:</label>
                                <input id="keterangan" type="text" class="form-control" name="keterangan">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="col-form-label">Status:</label> <br>
                                <div class="input-group">
                                    <input type="radio" id="true" name="status" value="true" checked>
                                    <label for="true" class="my-auto ml-2 mr-5">&nbsp; Aktif</label>
                                    &emsp;
                                    <input type="radio" id="false" name="status" value="false">
                                    <label for="false" class="my-auto ml-2">&nbsp; Tidak Aktif</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
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
