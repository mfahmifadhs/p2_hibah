@extends('layouts.app')

@section('content')
<div class="app-content-header">
    <div class="container-fluid col-md-10">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pengadaan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengadaan.show') }}">Pengadaan</a></li>
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
                <h4 class="card-title">Create Pengadaan</h4>
            </div>
            <form id="form" action="{{ route('pengadaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Program</label></div>
                        <div class="w-75">
                            <select class="form-control program" name="program_id" style="width: 100%;" required>
                                <option value="">-- Pilih Program --</option>
                                @foreach ($data->program as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_program }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Nama Kegiatan</label></div>
                        <div class="w-75">
                            <input type="text" class="form-control" name="nama_kegiatan" required>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25"><label class="col-form-label">Keterangan</label></div>
                        <div class="w-75">
                            <textarea name="keterangan" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="input-group my-3">
                        <div class="w-25">
                            <label class="col-form-label">Sumber Dana</label>
                        </div>
                        <div class="w-75 d-flex gap-3 mt-2">

                            <div class="form-check">
                                <input class="form-check-input sumberDanaCheck" type="checkbox" value="APBN" id="sd-apbn">
                                <label class="form-check-label" for="sd-apbn">APBN</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input sumberDanaCheck" type="checkbox" value="BOK" id="sd-bok">
                                <label class="form-check-label" for="sd-bok">BOK / DAK</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input sumberDanaCheck" type="checkbox" value="DONOR" id="sd-donor">
                                <label class="form-check-label" for="sd-donor">DONOR</label>
                            </div>

                        </div>
                    </div>

                    <div id="form-sumber-dana"></div>

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
    $('.program').select2()
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

<script type="text/template" id="tpl-apbn-bok">
    <div class="border rounded p-3 mb-3 sumberDanaItem" data-type="[[type]]">
        <h6 class="fw-bold">[[title]]</h6>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Alokasi</label></div>
            <div class="w-75"><input type="text" name="alokasi_[[type]]" class="form-control number" required></div>
        </div>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Jumlah</label></div>
            <div class="w-25"><input type="text" name="jumlah_alokasi_[[type]]" class="form-control number" required></div>

            <div class="w-25 text-center"><label class="col-form-label">Satuan</label></div>
            <div class="w-25"><input type="text" name="satuan_alokasi_[[type]]" class="form-control" required></div>
        </div>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Realisasi</label></div>
            <div class="w-75"><input type="text" name="realisasi_[[type]]" class="form-control number" required></div>
        </div>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Jumlah</label></div>
            <div class="w-25"><input type="text" name="jumlah_realisasi_[[type]]" class="form-control number" required></div>

            <div class="w-25 text-center"><label class="col-form-label">Satuan</label></div>
            <div class="w-25"><input type="text" name="satuan_realisasi_[[type]]" class="form-control" required></div>
        </div>
    </div>
</script>

<!-- Template DONOR -->
<script type="text/template" id="tpl-donor">
    <div class="border rounded p-3 mb-3 sumberDanaItem" data-type="donor">
        <h6 class="fw-bold">DONOR</h6>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Daftar Donor</label></div>
            <div class="w-75">
                <select name="donor_id" class="form-control donor" required>
                    <option value="">-- Pilih Donor --</option>
                    @foreach ($data->donor as $row)
                    <option value="{{ $row->id }}">{{ $row->nama_donor }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Alokasi</label></div>
            <div class="w-75"><input type="text" name="alokasi_donor" class="form-control number" required></div>
        </div>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Jumlah</label></div>
            <div class="w-25"><input type="text" name="jumlah_alokasi_donor" class="form-control number" required></div>

            <div class="w-25 text-center"><label class="col-form-label">Satuan</label></div>
            <div class="w-25"><input type="text" name="satuan_alokasi_donor" class="form-control" required></div>
        </div>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Realisasi</label></div>
            <div class="w-75"><input type="text" name="realisasi_donor" class="form-control number" required></div>
        </div>

        <div class="input-group my-2">
            <div class="w-25"><label class="col-form-label">Jumlah</label></div>
            <div class="w-25"><input type="text" name="jumlah_realisasi_donor" class="form-control number" required></div>

            <div class="w-25 text-center"><label class="col-form-label">Satuan</label></div>
            <div class="w-25"><input type="text" name="satuan_realisasi_donor" class="form-control" required></div>
        </div>
    </div>
</script>

<script>
document.querySelectorAll(".sumberDanaCheck").forEach(chk => {
    chk.addEventListener("change", function () {

        const container = document.getElementById("form-sumber-dana");

        // Hapus form jika uncheck
        if (!this.checked) {
            container.querySelectorAll(`.sumberDanaItem[data-type="${this.value.toLowerCase()}"]`)
                     .forEach(el => el.remove());
            return;
        }

        // Tambahkan form sesuai tipe
        if (this.value === "APBN" || this.value === "BOK") {
            let tpl = document.getElementById("tpl-apbn-bok").innerHTML;
            tpl = tpl.replaceAll("[[type]]", this.value.toLowerCase())
                     .replace("[[title]]", this.value);
            container.insertAdjacentHTML("beforeend", tpl);

            activateNumberFormat();
        }

        if (this.value === "DONOR") {
            let tpl = document.getElementById("tpl-donor").innerHTML;
            container.insertAdjacentHTML("beforeend", tpl);

            $('.donor').last().select2({ width: '100%' });

            activateNumberFormat();
        }
    });
});
</script>

<script>
    function activateNumberFormat() {
        $('.number').off('input').on('input', function() {
            var value = $(this).val().replace(/[^0-9]/g, '');
            var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            $(this).val(formattedValue);
        });
    }
</script>

@endsection

@endsection
