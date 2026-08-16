@extends('front.layout.app')
@section('title', 'Home Page')
@push('style')
    <style>
         .login-section {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
        }

        .login-card {
            width: 360px;
            background: #fff;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
        }

        .login-title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 5px;
            color: var('--logo-color');
        }

        .login-subtitle {
            font-size: 13px;
            color: #757575;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 6px 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 3px;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--color-second);
        }

        .forgot {
            text-align: right;
            margin-bottom: 15px;
        }

        .forgot a {
            font-size: 12px;
            color: var(--base-color);
            text-decoration: none;
        }

        .login-btn {
            width: 100%;
            background: var(--color-second);

            color: #fff;
            padding: 5px;
            border: none;
            font-size: 15px;
            font-weight: bold;
            border-radius: 3px;
            cursor: pointer;
        }

        .login-btn:hover {
            background: var(--color-second);
            opacity: 0.9;

        }

        .divider {
            text-align: center;
            margin: 20px 0;
            font-size: 12px;
            color: #999;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: "";
            height: 1px;
            width: 40%;
            background: #ddd;
            position: absolute;
            top: 50%;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .register-text {
            text-align: center;
            font-size: 13px;
        }

        .register-text a {
            color: var(--logo-color);
            font-weight: bold;
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
     <section class="login-section py-5 header_margin">
        <div class="login-card">

            <div class="login-title">Please login</div>
            <div class="login-subtitle">Login with your email or phone number</div>
            @if (session('error'))
                <div class="alert alert-danger"><small>{{ session('error') }}</small></div>
            @endif

            @if (session('success'))
                <div class="alert alert-success"><small>{{ session('success') }}</small></div>
            @endif

            <form method="POST" action="{{ route('customer.login.process') }}">
                @csrf

                <div class="form-group">
                    <input type="text" value="{{ old('login') }}" name="login" placeholder="Email or Phone Number">
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div class="form-group d-flex" >
                     <input type="checkbox" style="width:14px;margin-right: 10px;"  name="remember"> <label for="" style="font-size: 12px;color: #000000bd;">Remember Me</label>
                </div>

                <!-- <div class="forgot">
                    <a href="#">Forgot password?</a>
                </div> -->

                <button type="submit" class="login-btn">LOGIN</button>
            </form>

            <div class="divider">OR</div>
            <div class="register-text">
                New here? <a href="{{ route('customer.register') }}">Create your account</a>
            </div>

        </div>
    </section>
@endsection

@push('script')
    <script>

    </script>
@endpush