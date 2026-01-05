<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SMH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <!-- <meta name="color-scheme" content="light dark" /> -->
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="SMH v1 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
        name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta
        name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />

    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('dist/css/adminlte.css') }}" as="style" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous"
        media="print"
        onload="this.media='all'" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
        crossorigin="anonymous" />

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
        crossorigin="anonymous" />

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Swal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('dist/plugins/select2/css/select2.css') }}">
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                            <i class="bi bi-search"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-chat-text"></i>
                            <span class="navbar-badge badge text-bg-danger">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <a href="#" class="dropdown-item">
                                <!--begin::Message-->
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img
                                            src="{{ asset('dist/img/user1-128x128.jpg') }}"
                                            alt="User Avatar"
                                            class="img-size-50 rounded-circle me-3" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            Brad Diesel
                                            <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                                        </h3>
                                        <p class="fs-7">Call me whenever you can...</p>
                                        <p class="fs-7 text-secondary">
                                            <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img
                                            src="{{ asset('dist/img/user8-128x128.jpg') }}"
                                            alt="User Avatar"
                                            class="img-size-50 rounded-circle me-3" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            John Pierce
                                            <span class="float-end fs-7 text-secondary">
                                                <i class="bi bi-star-fill"></i>
                                            </span>
                                        </h3>
                                        <p class="fs-7">I got your message bro</p>
                                        <p class="fs-7 text-secondary">
                                            <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img
                                            src="{{ asset('dist/img/user3-128x128.jpg') }}"
                                            alt="User Avatar"
                                            class="img-size-50 rounded-circle me-3" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            Nora Silvester
                                            <span class="float-end fs-7 text-warning">
                                                <i class="bi bi-star-fill"></i>
                                            </span>
                                        </h3>
                                        <p class="fs-7">The subject goes here</p>
                                        <p class="fs-7 text-secondary">
                                            <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell-fill"></i>
                            <span class="navbar-badge badge text-bg-warning">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <span class="dropdown-item dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-envelope me-2"></i> 4 new messages
                                <span class="float-end text-secondary fs-7">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-people-fill me-2"></i> 8 friend requests
                                <span class="float-end text-secondary fs-7">12 hours</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                                <span class="float-end text-secondary fs-7">2 days</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img
                                src="{{ asset('dist/img/user2-160x160.jpg') }}"
                                class="user-image rounded-circle shadow"
                                alt="User Image" />
                            <span class="d-none d-md-inline">
                                {{ Auth::user()->pegawai->nama }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary">
                                <img
                                    src="{{ asset('dist/img/user2-160x160.jpg') }}"
                                    class="rounded-circle shadow"
                                    alt="User Image" />
                                <p>
                                    {{ Auth::user()->pegawai->nama }}
                                    <small>
                                        {{ Auth::user()->pegawai->timker->nama_timker }}
                                    </small>
                                </p>
                            </li>
                            <li class="user-body">
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-4 text-center"><a href="#">Followers</a></div>
                                    <div class="col-4 text-center"><a href="#">Sales</a></div>
                                    <div class="col-4 text-center"><a href="#">Friends</a></div>
                                </div>
                            </li>
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-light shadow" data-bs-theme="light">
            <div class="sidebar-brand">
                <a href="./index.html" class="brand-link">
                    <img
                        src="{{ asset('dist/img/AdminLTELogo.png') }}"
                        alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow" />
                    <span class="brand-text fw-light">SMH</span>
                </a>
            </div>

            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul
                        class="nav sidebar-menu flex-column"
                        data-lte-toggle="treeview"
                        role="navigation"
                        aria-label="Main navigation"
                        data-accordion="false"
                        id="navigation">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon bi bi-house"></i>
                                <p>Beranda</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pengadaan.show') }}" class="nav-link">
                                <i class="nav-icon bi bi-box-seam"></i>
                                <p>Hibah Barang</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-left: 2vh;">
                            <a href="{{ route('pengadaan.matriks') }}" class="nav-link">
                                <i class="nav-icon bi bi-table"></i>
                                <p>Matriks Sandingan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('proyek.show') }}" class="nav-link">
                                <i class="nav-icon bi bi-clipboard"></i>
                                <p>Proyek</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-left: 2vh;">
                            <a href="{{ route('kegiatan.show') }}" class="nav-link">
                                <i class="nav-icon bi bi-wallet"></i>
                                <p>Kegiatan</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-left: 2vh;">
                            <a href="" class="nav-link">
                                <i class="nav-icon bi bi-file-earmark-bar-graph"></i>
                                <p>Realisasi</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin-left: 2vh;">
                            <a href="{{ route('pencairan.show') }}" class="nav-link">
                                <i class="nav-icon bi bi-cash-stack"></i>
                                <p>Pencairan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon bi bi-bar-chart-line"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                        @if (Auth::user()->role_id != 4)
                        <li class="nav-item">
                            <a href="{{ route('donor.show') }}" class="nav-link">
                                <i class="nav-icon bi bi-hand-thumbs-up"></i>
                                <p>Donor</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('jenisHibah.show') }}" class="nav-link">
                                <i class="nav-icon bi bi-file-earmark-medical"></i>
                                <p>Jenis Hibah</p>
                            </a>
                        </li>
                        <li class="nav-header">Pengguna & Organisasi</li>
                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link">
                                <i class="nav-icon bi bi-people"></i>
                                <p>Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pegawai') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-lines-fill"></i>
                                <p>Pegawai</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('donor-uker.show') }}" class="nav-link">
                                <i class="nav-icon bi bi-clipboard-data"></i>
                                <p>Donor Uker</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-ui-checks-grid"></i>
                                <p>
                                    Organisasi
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('jabatan') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Jabatan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('timker') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Tim Kerja</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('uker') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Unit Kerja</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('utama') }}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Unit Utama</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            @yield('content')
        </main>

        <footer class="app-footer">

            <div class="float-end d-none d-sm-inline">Anything you want</div>

            <strong>
                Copyright &copy; 2014-2025&nbsp;
                <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>

    <script src="{{ asset('dist/js/adminlte.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('dist/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Include SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <!-- Select2 -->
    <script src="{{ asset('dist/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if (Session::has('failed'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '{{ Session::get("failed") }}',
        });
    </script>
    @endif

    @if (Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ Session::get("success") }}',
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>
    @endif

    <script>
        $(function() {
            var url = window.location.href;

            // === Untuk menu utama tanpa submenu ===
            $('ul.nav-sidebar > li.nav-item > a.nav-link').filter(function() {
                return this.href === url;
            }).addClass('active'); // Tambah class active

            // === Untuk menu dengan submenu (nav-treeview) ===
            $('ul.nav-treeview a.nav-link').filter(function() {
                return this.href === url;
            }).each(function() {
                $(this)
                    .addClass('active') // Tambah class aktif di submenu
                    .closest('.nav-treeview') // Cari parent UL
                    .css('display', 'block') // Tampilkan submenu
                    .closest('.nav-item') // Cari parent LI (menu utama)
                    .addClass('menu-is-opening menu-open') // Buka parent menu
                    .children('a.nav-link').addClass('active'); // Tandai menu utama juga aktif
            });
        });

        $(document).ready(function() {
            $('.number').on('input', function() {
                // Menghapus karakter selain angka (termasuk tanda titik koma sebelumnya)
                var value = $(this).val().replace(/[^0-9]/g, '');
                // Format dengan menambahkan titik koma setiap tiga digit
                var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                $(this).val(formattedValue);
            });
        });
    </script>

    <script>
        // Password
        function togglePassword() {
            const passwordInput = document.getElementById("passwordInput");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        }
    </script>

    <script>
        function displaySelectedFile(input) {
            var selectedFileName = "";
            if (input.files.length > 0) {
                selectedFileName = input.files[0].name;
            }

            document.getElementById("selected-file-name").textContent = selectedFileName;
        }
    </script>

    <script>
        $(function() {
            $('.previewImg').change(function() {
                const previewId = $(this).data('preview'); // Ambil ID target dari data-preview
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    // Ketika file dibaca, update atribut src dari elemen target
                    reader.onload = (e) => {
                        $(`#${previewId}`).attr('src', e.target.result);
                    };

                    reader.readAsDataURL(file); // Membaca file sebagai URL
                }
            });
        });
    </script>

    <script>
        document.querySelector('.previewImg').addEventListener('change', function(event) {
            const previewContainer = document.getElementById(this.dataset.preview);
            previewContainer.innerHTML = ''; // Bersihkan kontainer preview sebelumnya

            const files = event.target.files; // Ambil file yang diunggah
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Tambahkan elemen gambar ke kontainer preview
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview Foto";
                    img.className = "img-fluid w-25 rounded border";
                    img.style.marginRight = "10px";
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file); // Membaca file sebagai Data URL
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

    <script>
        function confirmLink(event, url) {
            event.preventDefault(); // Prevent the default link behavior
            Swal.fire({
                title: 'Proses',
                text: '',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal!',
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

                    window.location.href = url;
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.number').on('input', function() {
                // Menghapus karakter selain angka (termasuk tanda titik koma sebelumnya)
                var value = $(this).val().replace(/[^0-9]/g, '');
                // Format dengan menambahkan titik koma setiap tiga digit
                var formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                $(this).val(formattedValue);
            });
        });
    </script>

    <script>
        function confirmTrue(event) {
            event.preventDefault();

            const form = document.getElementById('form-true');

            Swal.fire({
                title: 'Setuju',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                const selectedDate = result.value.tanggal;
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
        }

        function confirmFalse(event) {
            event.preventDefault();

            const form = document.getElementById('form-false');

            Swal.fire({
                title: 'Konfirmasi Penolakan',
                text: 'Apakah Anda yakin ingin menolak usulan proyek ini?',
                icon: 'warning',
                input: 'textarea',
                inputPlaceholder: 'Berikan alasan penolakan di sini...',
                inputAttributes: {
                    'aria-label': 'Tulis alasan penolakan di sini'
                },
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Alasan penolakan harus diisi!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const alasanPenolakan = result.value;

                    Swal.fire({
                        title: 'Ditolak!',
                        text: 'Usulan telah ditolak dengan alasan: ' + alasanPenolakan,
                        icon: 'success'
                    });

                    document.getElementById('keterangan').value = alasanPenolakan;
                    form.submit();
                }
            });
        }
    </script>

    @yield('js')

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>

    <script
        src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
        crossorigin="anonymous"></script>

    <script>
        new Sortable(document.querySelector('.connectedSortable'), {
            group: 'shared',
            handle: '.card-header',
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    </script>

    <script
        src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
        crossorigin="anonymous"></script>

    <script>
        const sales_chart_options = {
            series: [{
                    name: 'Digital Goods',
                    data: [28, 48, 40, 19, 86, 27, 90],
                },
                {
                    name: 'Electronics',
                    data: [65, 59, 80, 81, 56, 55, 40],
                },
            ],
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            colors: ['#0d6efd', '#20c997'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                type: 'datetime',
                categories: [
                    '2023-01-01',
                    '2023-02-01',
                    '2023-03-01',
                    '2023-04-01',
                    '2023-05-01',
                    '2023-06-01',
                    '2023-07-01',
                ],
            },
            tooltip: {
                x: {
                    format: 'MMMM yyyy',
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector('#revenue-chart'),
            sales_chart_options,
        );
        sales_chart.render();
    </script>

    <script
        src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
        crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
        integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
        crossorigin="anonymous"></script>

    <script>
        new jsVectorMap({
            selector: '#world-map',
            map: 'world',
        });

        const option_sparkline1 = {
            series: [{
                data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline1 = new ApexCharts(document.querySelector('#sparkline-1'), option_sparkline1);
        sparkline1.render();

        const option_sparkline2 = {
            series: [{
                data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline2 = new ApexCharts(document.querySelector('#sparkline-2'), option_sparkline2);
        sparkline2.render();

        const option_sparkline3 = {
            series: [{
                data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline3 = new ApexCharts(document.querySelector('#sparkline-3'), option_sparkline3);
        sparkline3.render();
    </script>

</body>

</html>
