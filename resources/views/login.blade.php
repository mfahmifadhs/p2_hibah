<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPEL | Login</title>

    <link rel="icon" type="image/png" href="{{ asset('dist/img/logo-kemenkes-icon.png') }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            min-height: 100vh;
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-left {
            background: linear-gradient(135deg, #1bb3a7, #0f8f87);
            color: #fff;
        }

        .login-left .icon-box {
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 12px;
            padding: 14px;
            margin: 6px;
        }

        .login-card {
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
        }

        .form-control:focus {
            border-color: #1bb3a7;
            box-shadow: 0 0 0 .2rem rgba(27, 179, 167, .15);
        }

        .btn-login {
            background: #1bb3a7;
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #159b91;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row login-wrapper">

            <!-- LEFT -->
            <div class="col-md-6 login-left d-flex align-items-center justify-content-center">
                <div class="text-center px-4">
                    <img src="{{ asset('dist/img/logo-kemenkes.png') }}" width="260" class="mb-4">

                    <h4 class="fw-bold">SIMPEL</h4>
                    <p class="opacity-75 mb-4">
                        Sistem Monitoring Pinjaman dan Hibah Langsung
                    </p>

                    <div class="d-flex justify-content-center flex-wrap mt-4">
                        <div class="icon-box"><i class="bi bi-heart-pulse fs-4"></i></div>
                        <div class="icon-box"><i class="bi bi-shield-check fs-4"></i></div>
                        <div class="icon-box"><i class="bi bi-clipboard-data fs-4"></i></div>
                        <div class="icon-box"><i class="bi bi-hospital fs-4"></i></div>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7">

                    @if ($message = Session::get('failed'))
                    <div class="alert alert-danger">{{ $message }}</div>
                    @endif

                    <div class="card login-card border-0">
                        <div class="card-body p-4 p-md-5">

                            <h4 class="fw-bold mb-1">Masuk</h4>
                            <p class="text-muted mb-4">
                                Masuk ke aplikasi <strong>SIMPEL</strong>
                            </p>

                            <form id="loginForm" action="{{ route('login.post') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-person"></i>
                                        </span>
                                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white">
                                            <i class="bi bi-lock"></i>
                                        </span>

                                        <input
                                            type="password"
                                            name="password"
                                            id="password"
                                            class="form-control"
                                            placeholder="Masukkan password"
                                            required>

                                        <button
                                            type="button"
                                            class="btn btn-light"
                                            onclick="togglePassword()">
                                            <i id="eyeIcon" class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <a href="#" class="small">Lupa password?</a>
                                    <a href="https://wa.me/6285772652563" class="small">Bantuan</a>
                                </div>

                                <button type="button" class="btn btn-login w-100 text-white" onclick="showConfirm()">
                                    Masuk
                                </button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-body text-center p-4">

                    <div id="confirmLottie" style="height:160px;"></div>

                    <h5 class="fw-bold mt-2">Konfirmasi Masuk</h5>
                    <p class="text-muted mb-4">
                        Apakah Anda yakin ingin masuk ke aplikasi SIMPEL?
                    </p>

                    <div class="d-flex gap-2">
                        <button class="btn btn-light w-100" data-bs-dismiss="modal">
                            Tidak
                        </button>
                        <button class="btn btn-login w-100 text-white" onclick="submitLogin()">
                            Ya
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>

    <script>
        // Load Lottie animation
        lottie.loadAnimation({
            container: document.getElementById('confirmLottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://assets3.lottiefiles.com/packages/lf20_jcikwtux.json'
        });

        function showConfirm() {
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        }

        function submitLogin() {
            document.getElementById('loginForm').submit();
        }
    </script>


</body>

</html>
