 @extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid col-md-6">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Users</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid col-md-6">
        <div class="card shadow-sm border-1 border-dark">
            <div class="card-header border-dark">
                <h4 class="card-title">Detail Users</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 my-2 fw-bold">Unit Kerja</div>
                    <div class="col-md-9 my-2">: {{ $data->pegawai->uker->nama_uker ?? '-' }}</div>

                    <div class="col-md-3 my-2 fw-bold">Tim Kerja</div>
                    <div class="col-md-9 my-2">: {{ $data->pegawai->uker->nama_uker ?? '-' }}</div>

                    <div class="col-md-3 my-2 fw-bold">Jabatan</div>
                    <div class="col-md-9 my-2">: {{ $data->pegawai->jabatan->nama_jabatan ?? '-' }}</div>

                    <div class="col-md-3 my-2 fw-bold">Nama</div>
                    <div class="col-md-9 my-2">: {{ $data->pegawai->nama }}</div>

                    <div class="col-md-3 my-2 fw-bold">NIP</div>
                    <div class="col-md-9 my-2">: {{ $data->pegawai->nip }}</div>

                    <div class="col-md-3 my-2 fw-bold">No. Telepon</div>
                    <div class="col-md-9 my-2">: {{ $data->pegawai->no_telepon }}</div>

                    <div class="col-md-3 my-2 fw-bold">Email</div>
                    <div class="col-md-9 my-2">: {{ $data->pegawai->email }}</div>

                    <div class="col-md-3 my-2 fw-bold">Username</div>
                    <div class="col-md-9 my-2">: {{ $data->username }}</div>

                    <div class="col-md-3 my-2 fw-bold">Password</div>
                    <div class="col-md-9 my-2">: {{ $data->password_text }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
