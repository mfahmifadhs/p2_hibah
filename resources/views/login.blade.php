<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMH | Login</title>

    <!-- Icon Title -->
    <link rel="icon" type="image/png" href="{{ asset('dist/img/logo-kemenkes-icon.png') }}">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <!-- Swal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="form-group first">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p style="color:white;margin: auto;">{{ $message }}</p>
            </div>
            @endif
            @if ($message = Session::get('failed'))
            <div class="alert alert-danger">
                <p style="color:white;margin: auto;">{{ $message }}</p>
            </div>
            @endif
        </div>
        <div class="card" style="border-radius: 20px;">
            <div class="card-header text-center">
                <a href="{{ url('/') }}">
                    <p><img src="{{ url('dist/img/logo-kemenkes.png') }}" class="img-fluid" width="300"></p>
                </a>
                <span class="text-uppercase text-center small" style="font-family: Arial;">
                    Sistem Monitoring Pengelolaan <br> Hibah & Kerjasama
                </span>
            </div>
            <div class="card-body">
                <form id="form" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <label for="username" class="my-1 fw-bold">Username</label>
                    <div id="username" class="input-group mb-3">
                        <div class="input-group-append">
                            <div class="input-group-text rounded-left rounded-0 border border-dark">
                                <span class="bi bi-person-circle"></span>
                            </div>
                        </div>
                        <input type="text" name="username" class="form-control border border-dark" placeholder="Username">
                    </div>
                    <label for="password" class="mb-2 fw-bold">Password</label>
                    <div class="input-group mb-3" id="password">
                        <div class="input-group-append">
                            <div class="input-group-text rounded-left rounded-0 border border-dark">
                                <a type="button" onclick="lihatPassword()">
                                    <i class="bi bi-lock-fill" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <input type="password" name="password" class="form-control border border-dark" placeholder="Password">
                    </div>
                    <div class="social-auth-links text-center mt-2 mb-3">
                        <button type="submit" class="btn btn-block btn-primary form-control" onclick="confirmSubmit(event, 'form')">
                            Masuk
                        </button>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="#">Lupa password ?</a>
                </p>
                <p class="mb-0">
                    <a href="https://wa.me/6285772652563" class="text-center">Bantuan</a>
                </p>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <!-- Include SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <!-- Lihat Password -->
    <script type="text/javascript">
        function lihatPassword() {
            var x = document.getElementById("password");
            if ($('#password input').attr("type") == "password") {
                $('#password input').attr('type', 'text');
                $('#password i').addClass("bi-lock");
                $('#password i').removeClass("bi-lock-fill");
            } else {
                $('#password input').attr('type', 'password');
                $('#password i').removeClass("bi-lock");
                $('#password i').addClass("bi-lock-fill");
            }
        }

        $('#reload').click(function() {
            $.ajax({
                type: 'GET',
                url: 'captcha-reload',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>

    <script>
        function confirmSubmit(event, formId) {
            event.preventDefault();

            const form = document.getElementById(formId);
            const requiredInputs = form.querySelectorAll('input[required]:not(:disabled), select[required]:not(:disabled), textarea[required]:not(:disabled)');

            let allInputsValid = true;

            requiredInputs.forEach(input => {
                if (input.value.trim() === '') {
                    input.style.borderColor = 'red';
                    allInputsValid = false;
                } else {
                    input.style.borderColor = '';
                }
            });

            if (allInputsValid) {
                Swal.fire({
                    title: 'Proses',
                    text: '',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Proses...',
                            text: 'Mohon menunggu.',
                            icon: 'info',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        form.submit();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Ada input yang diperlukan yang belum diisi.',
                    icon: 'error'
                });
            }
        }
    </script>
</body>

</html>
