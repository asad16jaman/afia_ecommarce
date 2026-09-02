@extends('front.layout.app')
@section('title', 'Profile')
@push('style')
        <style>
            /* =========================================================
       CUSTOMER PROFILE PAGE
       Based on existing dashboard/sidebar design
       ========================================================= */

    :root {
        --base-color: #F85606;
        --brand: #F85606;
        --brand-light: #fff4ef;

        --sidebar-bg: #fff;
        --sidebar-border: #e5e5e5;

        --content-bg: #f5f4f0;
        --border: #ebebeb;

        --radius: 6px;
        --shadow: 0 1px 3px rgba(0, 0, 0, .06);
    }


    /* =========================================================
       MAIN DASHBOARD WRAPPER
       ========================================================= */

    #container.header_margin {
        width: 100%;
        min-height: calc(100vh - 56px);
        background: var(--content-bg);
        padding: 0;
    }

    #container.header_margin > .row {
        display: flex;
        flex-wrap: nowrap;
        margin: 0;
        min-height: calc(100vh - 56px);
    }


    /* =========================================================
       SIDEBAR COLUMN
       ========================================================= */

    #column-right {
        width: 210px;
        max-width: 210px;
        flex: 0 0 210px;

        padding: 0 !important;
        margin: 0;

        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);
    }


    /* =========================================================
       CUSTOMER SIDEBAR
       ========================================================= */

    .dash-sidebar {
        width: 210px;

        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);

        display: flex;
        flex-direction: column;

        position: sticky;
        top: 0;

        height: 100vh;

        overflow-y: auto;

        scrollbar-width: thin;
        scrollbar-color: #ddd transparent;
    }

    .dash-sidebar::-webkit-scrollbar {
        width: 3px;
    }

    .dash-sidebar::-webkit-scrollbar-thumb {
        background: #ddd;
    }


    /* =========================================================
       SIDEBAR USER
       ========================================================= */

    .sb-user {
        padding: 8px 10px;

        border-bottom: 1px solid var(--sidebar-border);

        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sb-avatar {
        width: 36px;
        height: 36px;

        border-radius: 50%;

        background: var(--base-color);
        color: #fff;

        font-size: 15px;
        font-weight: 800;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;
    }

    .sb-name {
        font-size: 13px;
        font-weight: 700;

        color: #1a1a1a;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;

        line-height: 1.3;
    }

    .sb-sub {
        font-size: 10px;
        color: #aaa;
        margin-top: 1px;
    }


    /* =========================================================
       SIDEBAR LABEL
       ========================================================= */

    .sb-label {
        font-size: 9.5px;
        font-weight: 700;

        letter-spacing: 1.2px;
        text-transform: uppercase;

        color: #bbb;

        padding: 7px 10px 4px;
    }


    /* =========================================================
       SIDEBAR GROUP
       ========================================================= */

    .sb-group {
        border-bottom: 1px solid var(--sidebar-border);
    }


    /* =========================================================
       SIDEBAR LINK
       ========================================================= */

    .sb-link {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 7px 10px;

        font-size: 13px;
        font-weight: 500;

        color: #555;

        text-decoration: none !important;

        border-left: 3px solid transparent;
        border-bottom: 1px solid var(--sidebar-border);

        transition: all .13s;

        gap: 6px;
    }

    .sb-link:last-of-type {
        border-bottom: none;
    }

    .sb-link:hover {
        background: #eeecea;
        color: #1a1a1a;

        text-decoration: none;
    }

    .sb-link.active {
        background: var(--brand-light);
        color: var(--base-color);

        border-left-color: var(--base-color);

        font-weight: 700;
    }

    .sb-link-l {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .sb-link .bi,
    .sb-link i {
        font-size: 13px;

        width: 15px;

        text-align: center;

        flex-shrink: 0;

        color: #aaa;
    }

    .sb-link:hover .bi,
    .sb-link:hover i {
        color: #555;
    }

    .sb-link.active .bi,
    .sb-link.active i {
        color: var(--base-color);
    }


    /* =========================================================
       SIDEBAR BADGE
       ========================================================= */

    .sb-badge {
        background: #ebebeb;
        color: #888;

        font-size: 9.5px;
        font-weight: 700;

        padding: 1px 7px;

        border-radius: 10px;

        min-width: 20px;

        text-align: center;

        line-height: 1.7;
    }

    .sb-link.active .sb-badge {
        background: var(--base-color);
        color: #fff;
    }


    /* =========================================================
       SIDEBAR FOOTER
       ========================================================= */

    .sb-footer {
        margin-top: auto;

        border-top: 1px solid var(--sidebar-border);
    }

    .sb-logout {
        display: flex;
        align-items: center;
        gap: 9px;

        padding: 11px 14px;

        font-size: 13px;
        font-weight: 500;

        color: var(--base-color);

        background: none;

        border: none;

        cursor: pointer;

        width: 100%;

        text-align: left;

        transition: all .13s;
    }

    .sb-logout:hover {
        background: #fff0ee;
        color: var(--base-color);
    }

    .sb-logout .bi {
        font-size: 13px;
    }


    /* =========================================================
       PROFILE CONTENT COLUMN
       ========================================================= */

    #content {
        flex: 1;

        width: auto;
        max-width: none;

        padding: 18px 20px !important;

        margin: 0;

        background: var(--content-bg);

        min-width: 0;
    }


    /* =========================================================
       PROFILE CARD
       ========================================================= */

    .customer_profile {
        width: 100%;

        background: #fff;

        border: 1px solid var(--border);

        border-radius: var(--radius);

        box-shadow: var(--shadow);

        overflow: hidden;
    }


    /* =========================================================
       PROFILE HEADER
       ========================================================= */

    .customer_profile > h4 {
        margin: 0;

        padding: 12px 16px;

        display: flex;
        align-items: center;

        gap: 8px;

        font-size: 14px;
        font-weight: 700;

        color: #1a1a1a;

        background: #fff;

        border-bottom: 1px solid var(--border);
    }

    .customer_profile > h4 i {
        width: 26px;
        height: 26px;

        border-radius: 5px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: var(--brand-light);

        color: var(--base-color);

        font-size: 12px;
    }


    /* =========================================================
       PROFILE FORM AREA
       ========================================================= */

    .customer_form {
        padding: 18px 16px 20px;
    }

    .customer_form form {
        width: 100%;
    }


    /* =========================================================
       FORM GROUP
       ========================================================= */

    .customer_form .form-group {
        margin-bottom: 13px;

        display: flex;
        align-items: center;

        min-height: 38px;
    }


    /* =========================================================
       FORM LABEL
       ========================================================= */

    .customer_form label {
        font-size: 12px;

        font-weight: 600;

        color: #555;

        padding-top: 0;
        padding-bottom: 0;
    }


    /* =========================================================
       FORM INPUT
       ========================================================= */

    .customer_form .form-control {
        height: 36px;

        border: 1px solid #ddd;

        border-radius: 5px;

        background: #fff;

        color: #333;

        font-size: 12px;

        padding: 7px 10px;

        box-shadow: none !important;

        transition:
            border-color .13s,
            box-shadow .13s;
    }

    .customer_form .form-control::placeholder {
        color: #aaa;
    }

    .customer_form .form-control:focus {
        border-color: var(--base-color);

        box-shadow:
            0 0 0 2px rgba(248, 86, 6, .08) !important;

        outline: none;
    }


    /* =========================================================
       TEXTAREA
       ========================================================= */

    .customer_form textarea.form-control {
        height: auto;

        min-height: 90px;

        resize: vertical;

        line-height: 1.5;
    }


    /* =========================================================
       UPDATE BUTTON
       ========================================================= */

    .customer_btn {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 6px;

        min-height: 34px;

        padding: 7px 17px;

        background: var(--base-color);

        color: #fff;

        border: 1px solid var(--base-color);

        border-radius: 5px;

        font-size: 12px;

        font-weight: 700;

        cursor: pointer;

        transition: all .15s;

        text-decoration: none;
    }

    .customer_btn:hover {
        background: #e04d00;

        border-color: #e04d00;

        color: #fff;

        transform: translateY(-1px);

        box-shadow:
            0 3px 10px rgba(248, 86, 6, .25);
    }

    .customer_btn:active {
        transform: translateY(0);

        box-shadow: none;
    }


    /* =========================================================
       REMOVE BOOTSTRAP FOCUS EFFECT
       ========================================================= */

    .customer_form .form-control:focus,
    .customer_btn:focus,
    .customer_btn:active {
        outline: none !important;
    }


    /* =========================================================
       FORM VALIDATION
       ========================================================= */

    .customer_form .is-invalid {
        border-color: #dc2626 !important;

        box-shadow:
            0 0 0 2px rgba(220, 38, 38, .07) !important;
    }

    .customer_form .invalid-feedback {
        font-size: 10px;

        margin-top: 3px;
    }


    /* =========================================================
       PROFILE FORM - EMPTY LABEL COLUMN
       ========================================================= */

    .customer_form .form-group:last-child {
        margin-bottom: 0;
    }

    .customer_form .form-group:last-child label {
        visibility: hidden;
    }


    /* =========================================================
       HORIZONTAL FORM SPACING
       ========================================================= */

    .customer_form .row {
        margin-left: -6px;
        margin-right: -6px;
    }

    .customer_form .row > [class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }


    /* =========================================================
       RESPONSIVE
       ========================================================= */

    {{-- @media (max-width: 767px) {

        #container.header_margin > .row {
            display: block;

            min-height: auto;
        }

        #column-right {
            width: 100%;
            max-width: 100%;

            flex: none;

            border-right: none;
        }

        .dash-sidebar {
            width: 100%;

            height: auto;

            position: static;

            border-right: none;

            border-bottom: 1px solid var(--sidebar-border);

            overflow-x: auto;
            overflow-y: hidden;
        }

        .sb-user,
        .sb-label,
        .sb-footer {
            display: none;
        }

        .dash-sidebar nav {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .sb-group {
            display: flex;

            flex-direction: row;

            border-bottom: none;
        }

        .sb-link {
            padding: 10px 13px;

            border-left: none;

            border-bottom: 2px solid transparent;

            white-space: nowrap;
        }

        .sb-link.active {
            border-left: none;

            border-bottom-color: var(--brand);

            background: var(--brand-light);
        }

        .sb-badge {
            margin-left: 5px;
        }

        #content {
            width: 100%;

            padding: 14px 15px !important;
        }

        .customer_form {
            padding: 15px;
        }

        .customer_form .form-group {
            display: block;

            margin-bottom: 12px;
        }

        .customer_form label {
            display: block;

            margin-bottom: 5px;

            padding: 0 !important;
        }

        .customer_form .form-group:last-child label {
            display: none;
        }

        .customer_form .form-group:last-child .d-flex {
            justify-content: flex-start !important;

            margin-top: 5px !important;
        }
    } --}}


    /* =========================================================
       SMALL MOBILE
       ========================================================= */

    @media (max-width: 480px) {

        #content {
            padding: 10px !important;
        }

        .customer_profile > h4 {
            padding: 11px 13px;

            font-size: 13px;
        }

        .customer_form {
            padding: 13px;
        }

        .customer_form .form-control {
            height: 35px;

            font-size: 12px;
        }

        .customer_form textarea.form-control {
            min-height: 80px;
        }

        .customer_btn {
            width: 100%;
        }
    }


    /* =========================================================
       OPTIONAL: HIDE OLD SIDEBAR LOGOUT LINK
       Because footer already has logout
       ========================================================= */

    .sb-group > .sb-link:last-child {
        /* Remove this block if you want Logout inside menu */
    }


    /* =========================================================
       GENERAL TABLE / BOOTSTRAP CLEANUP
       ========================================================= */

    .table th,
    .table td {
        vertical-align: middle;
    }

    .btn:focus,
    .btn:active,
    .form-control:focus {
        outline: none !important;
        box-shadow: none;
    }


    /* =========================================================
       SCROLLBAR
       ========================================================= */

    .dash-sidebar {
        scrollbar-width: thin;
        scrollbar-color: #ddd transparent;
    }

    .dash-sidebar::-webkit-scrollbar {
        width: 3px;
        height: 3px;
    }

    .dash-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .dash-sidebar::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 10px;
    }
        </style>
@endpush

@section('content')
    <div id="container" class="header_margin">


            <!-- Breadcrumb End-->
            <div class="row">
                <!--Right Part Start -->
                <aside class="col-sm-3 hidden-xs" id="column-right">
                    @include('front.partials.cus_sidebar')
                </aside>
                <!--Right Part End -->

                <div id="content" class="col-md-6">
                <div class="customer_profile">

                    <h4><i class="fa fa-user" aria-hidden="true"></i> Update Profile</h4>

                    <div class="customer_form">
                        <form action="{{-- route('customer.profile.update', Auth::guard('customer')->user()->id) --}}" method="post">
                            @csrf

                            @method('PUT')
                            <div class="form-group row">
                              <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
                              <div class="col-sm-10">
                                <input type="text" name="name" value="{{-- Auth::guard('customer')->user()->name --}}" class="form-control shadow-none" id="" placeholder="Enter Name">
                              </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                  <input type="email" name="email" value="{{-- Auth::guard('customer')->user()->email --}}" class="form-control shadow-none" id="" placeholder="Enter Email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                  <input type="text" name="phone" value="{{-- Auth::guard('customer')->user()->phone --}}" class="form-control shadow-none" id="" placeholder="Enter Phone">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                  <textarea name="address" class="form-control shadow-none" rows="4"> </textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10 d-flex justify-content-end mt-2">
                                    <button class="customer_btn" type="submit">Update change</button>
                                </div>

                            </div>

                        </form>
                    </div>

                </div>
            </div>



            </div>

    </div>

@endsection

@push('script')
    <script>

    </script>
@endpush