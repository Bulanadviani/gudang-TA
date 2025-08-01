<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>SMWarehouse | Inventaris Laptop</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/login/iconplus.png" />
    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') }}" />
    <!-- Select2 -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.css') }}"> -->


    <!-- ====== DataTables CSS ====== -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css">

    @stack('styles')
</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <!-- <div id="loading-center"></div> -->
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <div class="iq-sidebar sidebar-default">
            <div class="iq-sidebar-logo d-flex align-items-center">
                <h3 class="logo-title light-logo" style="margin: 0;">
                    <span style="color: #dddddd;">SM</span><span style="color: #1F0C75;">WAREHOUSE</span>
                </h3>
                </a>
                <div class="iq-menu-bt-sidebar ml-0">
                    <i class="las la-bars wrapper-menu"></i>
                </div>
            </div>
            <div class="data-scrollbar" data-scroll="1">
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu">
                        <li class="">
                            <a href="{{ url('dashboard') }}" class="svg-icon">
                                <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span class="ml-4">Dashboards</span>
                            </a>
                        </li>
                        @can('users.view')
                            <li class="">
                                <a href="{{ url('users') }}" class="svg-icon">
                                    <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span class="ml-4">Users</span>
                                </a>
                            </li>
                        @endcan
                        @can('masuk.view')
                            <li class="">
                                <a href="{{ route('masuk.index') }}" class="svg-icon">
                                    <svg class="svg-icon" width="25" height="25" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                        <path
                                            d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                        </path>
                                        <rect x="6" y="14" width="12" height="8"></rect>
                                    </svg>
                                    <span class="ml-4">Barang Masuk</span>
                                </a>
                            </li>
                        @endcan
                        @can('keluar.view')
                            <li class="">
                                <a href="{{ url('keluar') }}" class="svg-icon">
                                    <svg class="svg-icon" width="25" height="25"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2">
                                        </path>
                                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1">
                                        </rect>
                                    </svg>
                                    <span class="ml-4">Barang Keluar</span>
                                </a>
                            </li>
                        @endcan
                        @can('peminjaman.view')
                            <li class="">
                                <a href="{{ url('peminjaman') }}" class="svg-icon">
                                    <svg class="svg-icon" width="25" height="25"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                        </path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                    <span class="ml-4">Peminjaman</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.view')
                            <li class="">
                                <a href="{{ url('report') }}" class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                                        <path
                                            d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z" />
                                        <path
                                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1" />
                                    </svg>
                                    <span class="ml-4">Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('pengaturan.view')
                            <li class="">
                                <a href="{{ url('pengaturan') }}" class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M19.9 12.66a1 1 0 0 1 0-1.32l1.28-1.44a1 1 0 0 0 .12-1.17l-2-3.46a1 1 0 0 0-1.07-.48l-1.88.38a1 1 0 0 1-1.15-.66l-.61-1.83a1 1 0 0 0-.95-.68h-4a1 1 0 0 0-1 .68l-.56 1.83a1 1 0 0 1-1.15.66L5 4.79a1 1 0 0 0-1 .48L2 8.73a1 1 0 0 0 .1 1.17l1.27 1.44a1 1 0 0 1 0 1.32L2.1 14.1a1 1 0 0 0-.1 1.17l2 3.46a1 1 0 0 0 1.07.48l1.88-.38a1 1 0 0 1 1.15.66l.61 1.83a1 1 0 0 0 1 .68h4a1 1 0 0 0 .95-.68l.61-1.83a1 1 0 0 1 1.15-.66l1.88.38a1 1 0 0 0 1.07-.48l2-3.46a1 1 0 0 0-.12-1.17ZM18.41 14l.8.9l-1.28 2.22l-1.18-.24a3 3 0 0 0-3.45 2L12.92 20h-2.56L10 18.86a3 3 0 0 0-3.45-2l-1.18.24l-1.3-2.21l.8-.9a3 3 0 0 0 0-4l-.8-.9l1.28-2.2l1.18.24a3 3 0 0 0 3.45-2L10.36 4h2.56l.38 1.14a3 3 0 0 0 3.45 2l1.18-.24l1.28 2.22l-.8.9a3 3 0 0 0 0 3.98Zm-6.77-6a4 4 0 1 0 4 4a4 4 0 0 0-4-4Zm0 6a2 2 0 1 1 2-2a2 2 0 0 1-2 2Z" />
                                    </svg>
                                    <span class="ml-4">Pengaturan</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </nav>

                <div class="pt-5 pb-2"></div>
            </div>
        </div>
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
                <nav class="navbar navbar-expand-lg navbar-light p-0">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <i class="ri-menu-line wrapper-menu"></i>
                        <a href="/index.html" class="header-logo">
                            <h4 class="logo-title text-uppercase">

                            </h4>
                        </a>
                    </div>
                    <div class="navbar-breadcrumb">
                        <h5></h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                <li class="nav-item nav-icon dropdown caption-content">
                                    <a href="#" class="search-toggle dropdown-toggle d-flex align-items-center"
                                        id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center mt-2">
                                            <div
                                                class="avatar avatar-40 rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center">
                                                {{ strtoupper(collect(explode(' ', Auth::user()->name))->take(2)->map(fn($word) => substr($word, 0, 1))->implode('')) }}
                                            </div>
                                            <div class="caption ml-2">
                                                <h6 class="mb-0 line-height">
                                                    {{ Auth::user()->name }}
                                                    <i class="las la-angle-down ml-1"></i>
                                                </h6>
                                            </div>
                                        </div>

                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right border-none"
                                        aria-labelledby="dropdownMenuButton">
                                        <form action="{{ route('logout') }}" method="POST">
                                            <li class="dropdown-item d-flex align-items-center">
                                                <svg class="svg-icon mr-0 text-primary" id="h-05-p" width="20"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                @csrf @method('delete')
                                                <button class="border-none bg-white text-secondary btn-none px-4"
                                                    type="submit">
                                                    Logout
                                                </button>
                                            </li>
                                        </form>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="content-page">
            <div class="container-fluid">
                @yield('content')
                <!-- Page end  -->
            </div>
        </div>
    </div>

    <footer class="iq-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">

                        </li>
                        <li class="list-inline-item">

                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 text-right">
                    <span class="mr-1">
                        <script></script>

                    </span>

                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('assets/js/customizer.js') }}"></script>


    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('assets/js/slider.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/vendor/moment.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <script src="{{ asset('assets/vendor/tui-calendar/tui-code-snippet/dist/tui-code-snippet.js') }}"></script>
    <script src="{{ asset('assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/calendar.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>

    <script>
        // alert from FE
        function showAlert(type, message) {
            Swal.fire({
                text: message,
                icon: type,
                draggable: true
            });
        }
        //  alert from BE
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}"
                });
            @endif
        });
    </script>



    @stack('scripts')
</body>

</html>
