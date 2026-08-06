
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Admin | Login</title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="card login-card">
                        <div class="row no-gutters">
                            <div class="col-md-6">
                                <img src="{{ asset('images/login-otp-banner.webp') }}" alt="login"
                                    class="login-card-img" />
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="brand-wrapper" sty>
                                        <img src="{{ asset('uploads/logo_and_icon/' . ($setting->logo ?? 'no-images/no-image.png')) }}"
                                            alt="logo" class="logo" />
                                    </div>
                                    <p class="login-card-description">Sign in into your account !</p>
                                    @if (session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif

                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    <form action="{{ route('admin.login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="email" class="sr-only">Username</label>
                                            <input type="text" name="username" id="username"
                                                class="form-control shadow-none @error('username') is-invalid @enderror"
                                                value="{{ old('username') }}" placeholder="username" />
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="password" class="sr-only">Password</label>
                                            <input type="password" name="password" id="password"
                                                value="{{ old('password') }}"
                                                class="form-control shadow-none @error('password') is-invalid @enderror"
                                                placeholder="Password" />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <input type="submit" name="login" id="login"
                                            class="btn btn-block login-btn mb-4 shadow-none" value="Login" />
                                    </form>
                                    {{-- <a href="#!" class="forgot-password-link">Forgot password?</a> --}}
                                    <nav class="login-card-footer-nav">
                                        <a href="#!">Copyright &copy; {{ date('Y') }}</a>
                                        <a href="#!">{{ $setting->name }}</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-4.min.js') }}"></script>
    <script>
        $("document").ready(function() {
            setTimeout(function() {
                $("div.alert").remove();
            }, 3000); // 5 secs
        });
    </script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
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
        });
    </script>
</body>

</html>
