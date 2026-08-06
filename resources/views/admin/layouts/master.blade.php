
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Dashboard | @yield('title')</title>

    {{-- Favicon --}}
    @if ($setting->favicon_image)
        <link rel="shortcut icon" href="{{ asset('uploads/logo_and_icon/' . $setting->favicon_image) }}"
            type="image/x-icon" />
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/no_images/no-image.png') }}" type="image/x-icon" />
    @endif

    {{-- Core CSS --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- In your admin layout head -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    #pageLoader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        z-index: 9999;
    }

    .loader-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner-wrapper {
        position: relative;
        width: 110px;
        height: 110px;
    }

    .spinner-border {
        width: 110px;
        height: 110px;
    }

    .loader-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 10px;
        font-weight: 500;
        text-align: center;
        width: 100px;
    }
</style>
    @stack('style')
</head>

<body class="sb-nav-fixed">
<div id="pageLoader" class="d-none">
        <div class="loader-content text-center">
            <div class="spinner-wrapper">
                <div class="spinner-border text-primary" role="status"></div>
                <div class="loader-text">
                    Image resizing & uploading...<br>Please wait...
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.navbar')

    <div id="layoutSidenav">
        @include('admin.partials.sidebar')

        <div id="layoutSidenav_content">
            @yield('main-content')
            @include('admin.partials.footer')
        </div>
    </div>

    {{-- jQuery (must load before any $() usage) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Core JS --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/simple-datatables@latest.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    {{-- Toastr JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Clock Script --}}
    <script>
        setInterval(function() {
            const now = new Date();
            let h = now.getHours(),
                m = now.getMinutes(),
                s = now.getSeconds();
            const ampm = h < 12 ? 'AM' : 'PM';
            h = h % 12 || 12;
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('timer').innerHTML = `${h}:${m}:${s} ${ampm}`;
        }, 1000);
    </script>

    {{-- Toastr + SweetAlert2 Setup --}}
    <script>
        $(document).ready(function() {
            //── Toastr Options & Flash Messages 
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @elseif (session('error'))
                toastr.error("{{ session('error') }}");
            @elseif (session('warning'))
                toastr.warning("{{ session('warning') }}");
            @elseif (session('info'))
                toastr.info("{{ session('info') }}");
            @endif

            //── SweetAlert2 Delete Confirmation 
            $(document).on('click', '.show-confirm', function() {
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#product_select').select2({
                placeholder: "Select Products",
                allowClear: true
            });
        });
    </script>

    <!-- for tooltips -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );

            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });

        });

        $('.form').on('submit', function() {
            $('#pageLoader').removeClass('d-none');
        });
        
    </script>

    

    @stack('script')
</body>

</html>
