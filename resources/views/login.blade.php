<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }}</title>


    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/login/iconplus.png" />
    <link rel="stylesheet" href="{{ asset('assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css') }}">
</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <!-- <div id="loading-center"> -->
    </div>
    </div>
    <!-- loader END -->

    <div class="wrapper">
        <section class="login-content">
            <div class="container">
                <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-8">
                        <div class="card auth-card">
                            <div class="card-body p-0">
                                <!-- Header kiri dan kanan -->
                                <div
                                    style="position: absolute; top: 0px; left: 20px; right: 20px; z-index: 1000; display: flex; justify-content: space-between; align-items: center;">
                                    <!-- Tulisan kiri -->
                                    <h3 class="logo-title light-logo" style="margin: 0;">
                                        <span style="color: #dddddd;">SM</span><span
                                            style="color: #1F0C75;">WAREHOUSE</span>
                                    </h3>
                                    <!-- Logo kanan -->
                                    <img src="{{ asset('assets/images/login/iconplus.png') }}" alt="Logo"
                                        style="height: 100px;">
                                </div>
                                <div class="d-flex align-items-center auth-content">
                                    <div class="col-lg-6 bg-primary content-left">
                                        <div class="p-3">
                                            <h3 class="mb-2 text-white">Login</h3>
                                            <p>
                                                @if (Session::has('error'))
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ Session::get('error') }}
                                                    </div>
                                                @endif
                                            </p>
                                            <form action="{{ route('login') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input id="email" class="floating-input form-control"
                                                                type="email" name="email" placeholder=" " required>
                                                            <label>Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input id="password" class="floating-input form-control"
                                                                type="password" name="password" placeholder=" "
                                                                required>
                                                            <label>Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-white w-100">Login</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 content-right">
                                        <img src="{{ asset('assets/images/login/01.png') }}"
                                            class="img-fluid image-right" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('assets/js/chart-custom.js') }}"></script>
    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('assets/js/slider.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/vendor/moment.min.js') }}"></script>

    <script>
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('invalid', function(event) {
            if (!event.target.validity.valid) {
                event.target.setCustomValidity('Harap isi username');
            }
        });
        emailInput.addEventListener('input', function(event) {
            event.target.setCustomValidity('');
        });

        const passwordInput = document.getElementById('password');
        passwordInput.addEventListener('invalid', function(event) {
            if (!event.target.validity.valid) {
                event.target.setCustomValidity('Harap isi password');
            }
        });
        passwordInput.addEventListener('input', function(event) {
            event.target.setCustomValidity('');
        });
    </script>

</body>

</html>
