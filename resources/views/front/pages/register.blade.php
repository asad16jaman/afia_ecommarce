@extends('front.layout.app')
@section('title', 'Customer Register')
@push('style')
    <style>
        .register-section {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
        }

        .register-card {
            width: 380px;
            background: #fff;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
        }

        .register-title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .register-subtitle {
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

        .register-btn {
            width: 100%;
            background: var(--color-second);
            color: #fff;
            padding: 5px;
            border: none;
            font-size: 15px;
            font-weight: bold;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }

        .register-btn:hover {
            background: var(--color-second);
            opacity: 0.9;
        }

        .login-text {
            text-align: center;
            font-size: 13px;
            margin-top: 20px;
        }

        .login-text a {
            color: var(--logo-color);
            font-weight: bold;
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    <section class="register-section py-5 header_margin">
        <div class="register-card">

            <div class="register-title">Create your account</div>
            <div class="register-subtitle">Register with your email or phone number</div>

            <form method="POST" action="{{ route('customer.register.store') }}">
                @csrf

                <div class="form-group">
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Full Name">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="number" name="phone" value="{{ old('phone') }}"
                        class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number">
                    @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="email" name="email" name="phone" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="Email Address">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password">
                    @error('password')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="register-btn">REGISTER</button>
            </form>

            <div class="login-text">
                Already have an account?
                <a href="{{ route('customer.login') }}">Login here</a>
            </div>

        </div>
    </section>
@endsection

@push('script')
    <script>

    </script>
@endpush