@extends('front.layout.app')
@section('title', 'Customer Profile')
@push('style')
    <style>
        .error_message{
                color: red;
    font-size: 9px;
        }
        .is-invalid{
            border: 1px solid red !important;
        }
        .dash-main {
            flex: 1;
            min-width: 0;
            background: #f5f4f0;
            padding: 18px 20px;
            box-sizing: border-box;
        }

        .customer-profile-section {
            width: 100%;
        }

        .profile-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 31% 69%;
            gap: 16px;
            align-items: start;
        }

        .profile-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
            padding: 16px;
            text-align: center;
            min-height: 314px;
        }

        .customer-profile-img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border-radius: 50%;
            display: block;
            margin: 0 auto 8px;
            border: none;
        }

        .customer-name {
            margin: 0 0 5px;
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .customer-contact {
            color: var(--nav-color);
            font-size: 12px;
            line-height: 1.8;
        }

        .customer-contact div {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .customer-contact i {
            font-size: 12px;
            color: #666;
        }

        .profile-divider {
            height: 1px;
            background: #ccc;
            margin: 8px 0 10px;
        }

        .default-address-title {
            font-size: 13px;
            color: var(--nav-color);
            margin-bottom: 5px;
            font-weight: 600;
        }

        .default-address {
            font-size: 11px;
            color: var(--nav-color);
            line-height: 1.5;
        }

        .account-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
            overflow: hidden;
        }


        /* Header */

        .account-header {
            padding: 11px 16px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            background: var(--nav-color);
        }

        .account-body {
            padding: 12px 16px 15px;
        }

        .form-row {
            display: grid;
            gap: 14px;
            margin-bottom: 9px;
        }

        .three-columns {
            grid-template-columns: repeat(3, 1fr);
        }

        .two-columns {
            grid-template-columns: repeat(2, 1fr);
        }

        .four-columns {
            grid-template-columns: repeat(4, 1fr);
        }

        .form-group {
            min-width: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            color: var(--nav-color);
            font-weight: 600;
        }

        .profile-input {
            width: 100%;
            height: 38px;
            padding: 7px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            color: #555;
            font-size: 13px;
            outline: none;
            transition: border-color .13s,
                box-shadow .13s;
            box-sizing: border-box;
        }

        .profile-input::placeholder {
            color: #777;
        }

        .profile-input:focus {
            border-color: var(--base-color, #F85606);
            box-shadow:
                0 0 0 2px rgba(248, 86, 6, .08);
            outline: none;
        }

        .profile-file {
            width: 100%;
            height: 38px;
            padding: 5px 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            color: #555;
            font-size: 12px;
            cursor: pointer;
            box-sizing: border-box;
        }

        .profile-file:focus {
            border-color: var(--base-color, #F85606);
            outline: none;
            box-shadow:
                0 0 0 2px rgba(248, 86, 6, .08);
        }

        .profile-file::file-selector-button {
            height: 28px;
            padding: 0 9px;
            margin-right: 7px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f8f8f8;
            color: #555;
            font-size: 11px;
            cursor: pointer;
        }

        .section-title {
            font-size: 13px;
            font-weight: 600;
            color: #222;
            margin: 2px 0 7px;
        }

        .password-title {
            margin-top: 2px;
        }

        .address-field {
            margin-bottom: 8px;
        }

        .profile-textarea {
            width: 100%;
            min-height: 85px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #fff;
            color: #555;
            font-size: 13px;
            resize: vertical;
            outline: none;
            line-height: 1.5;
            box-sizing: border-box;
            transition: border-color .13s,
                box-shadow .13s;
        }

        .profile-textarea::placeholder {
            color: #777;
        }

        .profile-textarea:focus {
            border-color: var(--base-color, #F85606);
            box-shadow:
                0 0 0 2px rgba(248, 86, 6, .08);
            outline: none;
        }

        .profile-update-btn {
            border: none;
            border-radius: 4px;
            background: var(--base-color, #F85606);
            color: #fff;
            padding: 8px 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .profile-update-btn:hover {
            background: #e04d00;
            transform: translateY(-1px);
            box-shadow:
                0 3px 10px rgba(248, 86, 6, .25);
        }

        .profile-update-btn:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .profile-update-btn:focus {
            outline: none;
        }

        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 900px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-left {
                width: 100%;
            }

            .profile-card {
                min-height: auto;
            }

            .customer-profile-img {
                width: 120px;
                height: 120px;
            }
        }

        /* =========================================================
           TABLET
           ========================================================= */

        @media (max-width: 700px) {
            .three-columns {
                grid-template-columns: 1fr;
            }
            .two-columns {
                grid-template-columns: 1fr;
            }

            .four-columns {
                grid-template-columns: repeat(2, 1fr);
            }

            .account-body {
                padding: 12px;
            }
        }


        /* =========================================================
           MOBILE
           ========================================================= */

        @media (max-width: 480px) {
            .profile-grid {
                gap: 10px;
            }

            .four-columns {
                grid-template-columns: 1fr;
            }

            .account-header {
                padding: 10px 12px;

                font-size: 13px;
            }

            .account-body {
                padding: 12px 10px;
            }

            .profile-card {
                padding: 14px;
            }

            .profile-update-btn {
                width: 100%;
            }
        }
        .is-invalid{
            border: 1px solid red !important;
        }
    </style>
@endpush

@section('content')
    <section class="header_margin dash-shell">
        <aside class="col-sm-12 col-md-4 col-lg-2 hidden-xs" id="column-right">
            @include('front.partials.cus_sidebar')
        </aside>
        <main class="dash-main">

            <section class="customer-profile-section">
                <div class="profile-container">
                    <div class="profile-grid">
                         <div class="profile-left">
                            <div class="profile-card">
                                <img src="{{ Auth::guard('customer')->user()->web_profile ? asset(Auth::guard('customer')->user()->web_profile) : asset('images/pro.png') }}" alt="Customer" class="customer-profile-img">
                                <h5 class="customer-name">
                                    {{ Auth::guard('customer')->user()->Customer_Name }}
                                </h5>
                                <div class="customer-contact">
                                    <div>
                                        <i class="bi bi-envelope-fill"></i>
                                        {{ Auth::guard('customer')->user()->Customer_Email }}
                                    </div>
                                    <div>
                                        <i class="bi bi-telephone-fill"></i>
                                        {{ Auth::guard('customer')->user()->Customer_Mobile }}
                                    </div>
                                </div>
                                <div class="profile-divider"></div>
                                <div class="default-address-title">
                                    Default Address
                                </div>
                                <div class="default-address">
                                    {{ Auth::guard('customer')->user()->Customer_Address }}
                                </div>
                            </div>
                        </div> 
                        <div class="profile-right">
                            <div class="account-card">
                                <div class="account-header">
                                    Account Information
                                </div>
                                <div class="account-body">
                                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        <!-- First Row -->
                                        <div class="form-row two-columns">
                                            <div class="form-group">
                                                <label for="web_profile">
                                                    Profile Image
                                                </label>
                                                <input type="file" id="web_profile" name="web_profile" class="profile-file">
                                            </div>
                                            <div class="form-group">
                                                <label for="Customer_Name">
                                                    Full Name
                                                </label>
                                                <input type="text" name="Customer_Name" class="profile-input @error('Customer_Name') is-invalid @enderror" id="Customer_Name" value="{{ old('Customer_Name', Auth::guard('customer')->user()->Customer_Name) }}">
                                                @error('Customer_Name')
                                                    <strong class="error_message">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group" for="Customer_Mobile">
                                                <label for="Customer_Mobile">Phone</label>
                                                <input type="text" class="profile-input  @error('Customer_Mobile') is-invalid @enderror" id="Customer_Mobile" name="Customer_Mobile" value="{{ old('Customer_Mobile', Auth::guard('customer')->user()->Customer_Mobile)  }}">
                                                @error('Customer_Mobile')
                                                    <strong class="error_message">{{ $message }}</strong>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="Customer_Email">Email</label>
                                                <input type="email" name="Customer_Email" id="Customer_Email" class="profile-input  @error('Customer_Email') is-invalid @enderror" value="{{ old('Customer_Email', Auth::guard('customer')->user()->Customer_Email)  }}">
                                                @error('Customer_Email')
                                                    <strong class="error_message">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Default Address -->
                                        <div class="section-title">
                                            Default Address
                                        </div>

                                        <div class="form-group address-field">
                                            <textarea class="profile-textarea  @error('Customer_Address') is-invalid @enderror" name="Customer_Address" placeholder="Full Address"
                                                rows="4">{{ old('Customer_Address', Auth::guard('customer')->user()->Customer_Address)  }}</textarea>
                                            @error('Customer_Address')
                                                <strong class="error_message">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        <!-- Change Password -->
                                        <div class="section-title password-title">
                                            Change Password
                                        </div>
                                        <div class="form-row three-columns">
                                            <div class="form-group">
                                                <input type="password" class="profile-input @error('current_password') is-invalid @enderror" name="current_password" placeholder="Current Password">
                                                @error('current_password')
                                                    <strong class="error_message">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="profile-input @error('password') is-invalid @enderror" name="password" placeholder="New Password">
                                                @error('password')
                                                    <strong class="error_message">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="profile-input" name="confirm_password"
                                                    placeholder="Confirm New Password">
                                            </div>
                                        </div>
                                        <button type="submit" class="profile-update-btn">
                                            Update Profile
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </section>

        </main>
    </section>
@endsection

@push('script')
    <script>

    </script>
@endpush