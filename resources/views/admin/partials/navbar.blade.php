<nav class="sb-topnav navbar navbar-expand navbar-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{ route('dashboard') }}">
        <span
            class="company-name">{{ \Illuminate\Support\Str::limit($setting->name ?? 'Demo Company', 20) }}</span>
    </a>


    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Clock -->
    <p class="text-white dashboard-date mb-0 d-none d-lg-block">
        <i class="far fa-clock"></i> {{ date('l, j F Y,') }} <span id="timer"></span>
    </p>

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <!-- Optional search form -->
    </form>

    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">

        <li class="nav-item mt-2">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fa fa-home" style="color: white; font-size: 1.5rem;"></i>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img class="profile-img"
                    src="{{ Auth::user()->image ? asset('uploads/user/'.Auth::user()->image) : asset('images/profile.png') }}"
                    alt="">
                <span class="common-text">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fa fa-user"></i> Update Profile
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item" href="{{route('password.change')}}">
                        <i class="fa fa-key"></i> Change Password
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <li>
                        <button class="dropdown-item" type="submit">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </button>
                    </li>
                </form>
            </ul>
        </li>
    </ul>
</nav>

<style>
    .company-name {
        font-size: 14px;
        font-weight: bold;
        color: #ffffff;
    }
</style>
