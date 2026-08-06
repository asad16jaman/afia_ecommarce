<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.webp') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swift.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nav.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri&display=swap" rel="stylesheet">
    @stack('style')
</head>

<body>

   <!-- header section start -->
        @include('front.partials.header')
   <!-- header section end -->



    @yield('content')

    <!-- footer section start -->
        @include('front.partials.footer')
    <!-- footer section end -->

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Shopping cart</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="table table-border">
                <thead>
                    <tr>
                        <td>Image</td>
                        <td>Name</td>
                        <td>Qty</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- all script -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper12.2.js') }}"></script>
    <script src="{{ asset('assets/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        if (window.innerWidth < 992) {
            document.querySelectorAll(".submenu-toggle").forEach(function (item) {
                item.addEventListener("click", function (e) {
                    e.preventDefault();
                    let submenu = this.nextElementSibling;
                    submenu.classList.toggle("show");
                });
            });
        }

    </script>

    @stack('script')
</body>

</html>