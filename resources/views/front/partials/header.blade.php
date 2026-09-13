<!-- header section -->
<section id="header" class="fixed-top">
    <div class="container py-lg-2">
        <div class="d-flex justify-content-between align-items-center">
            <a class="d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ $softUrl . $setting->Company_Logo_thum }}" alt="Logo" class="topbarLogo">
                <div class="d-flex flex-column lh-1">
                    <!-- <span class="fw-bold text-black fs-5">KAMRAN</span> -->
                    <!-- <span class="fw-bold" style="font-size:12px; letter-spacing:2px; color:#6f42c1;">HONEY</span> -->
                </div>
            </a>
            <!-- Menu -->
            <div class="justify-content-center ms-lg-4 d-none d-lg-block position-relative" id="navbarNav">
                <form class="search-form  d-none d-lg-block">
                    <div class="input-group search-pill">
                        <input type="text"  id="navSearchBox" class="form-control border-0" placeholder="Search here">
                        <span class="input-group-text bg-white border-0">
                            <i class="fa fa-search color-second"></i>
                        </span>
                    </div>
                </form>
                <div class="position-absolute searchItemContainer" id="searchItemContainer" style="display:none"></div>
            </div>
            <div class="d-flex align-items-center">
                <ul class="d-flex mb-0 gap-lg-4 gap-3">
                    <li class="nav-item d-flex align-items-center ">
                        <div class="d-flex align-items-center nav_social_media_container">
                            <div class="nav_social_media_icon">
                                <!-- position: absolute; right: 47%; top: 10px; -->
                            <div id="google_translate_element" class="hidden-xs" style="">
                            </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <div class="d-flex align-items-center nav_social_media_container">
                            <div class="nav_social_media_icon">
                                <a href="{{ $setting->facebook_link }}" target="_blank"><i class="bi bi-facebook"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <div class="d-flex align-items-center nav_social_media_container">
                            <div class="nav_social_media_icon">
                                <a href="https://wa.me/<?= ltrim($setting->whatsapp, '+') ?>" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-circle" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <div class="d-flex position-relative flex-column flex-md-row align-items-center gap-lg-2">
                                <div class="nav_cart_icon"><i class="bi bi-cart4"></i></div>
                                <span
                                    class="position-absolute translate-middle badge cart_badge_position rounded-pill bg-danger d-lg-none d-block" id="product_count2">
                                    0
                                </span>
                                <div class="nav_cart_text d-none d-lg-block">
                                    <h5>Cart(<span id="product_count">0</span>)</h5>
                                    <span>Add Item</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-black icon-circle" href="{{ Auth::guard('customer')->check() ? route('dashboard') : route('customer.login') }}">
                            <div class="d-flex align-items-center  flex-column flex-md-row gap-lg-2">
                                <div class="nav_cart_icon"><i class="bi bi-person"></i></div>
                                <div class="nav_cart_text text-left d-none d-lg-block">
                                    <h5>Account</h5>
                                    @auth('customer')
                                        <span>Profile</span>
                                    @else
                                        <span>Login And Register</span>
                                    @endauth
                                    
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Navigation -->
    <nav class="navbar nav_shadow navbar-expand-lg navbar-light bg-white shadow-sm py-0">
        <div class="container px-3 px-md-4 px-lg-5">
            <!-- Mobile Header -->
            <div class="d-flex d-lg-none align-items-center w-100 py-2">
                <!-- Toggle -->
                <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Search -->
                <div class="px-3  position-relative">
                    <form class="search-form flex-grow-1">
                        <div class="input-group search-pill">
                            <input type="text" id="navSearchBox2" class="form-control border-0" placeholder="Search here">
                            <span class="input-group-text bg-white border-0">
                                <i class="fa fa-search color-second"></i>
                            </span>
                        </div>
                    </form>
                    <div class="position-absolute searchItemContainer" style="display:none" id="searchItemContainer2"></div>
                </div>
            </div>
            <div class="collapse navbar-collapse position-relative" id="mainNavbar">
                <ul class="navbar-nav mx-auto">
                    <!-- Mega Dropdown -->
                    {{-- <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            Abaya Borka Design
                        </a>
                        <div class="dropdown-menu shadow rounded-0 mt-0">
                            <a class="dropdown-item" href="#">Sub Category1</a>
                            <!-- Child Dropdown -->
                            <div class="dropdown-submenu">
                                <a href="#" class="dropdown-item submenu-toggle">
                                    Phones
                                    <i class="bi bi-chevron-right float-end"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Child Category 1</a>
                                    <a class="dropdown-item" href="#">Child Category 2</a>
                                    <a class="dropdown-item" href="#">Child Category 3</a>
                                    <a class="dropdown-item" href="#">Child Category 4</a>
                                </div>
                            </div>
                            <a class="dropdown-item" href="#">Sub Category3</a>
                            <a class="dropdown-item" href="#">Sub Category4</a>
                            <a class="dropdown-item" href="#">Sub Category5</a>
                        </div>
                    </li> --}}

                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('all.products') }}">Shop</a>
                    </li>

                    @foreach ($nav_categories as $nav_cat)
                        @if(!empty($nav_cat->subcategories) && count($nav_cat->subcategories) > 0)
                            <li class="nav-item dropdown position-static">
                                <a class="nav-link dropdown-toggle" href="{{ route('category.products', ['slug' => $nav_cat->slug]) }}" data-bs-toggle="dropdown">
                                    {{ $nav_cat->ProductCategory_Name }}
                                </a>
                                <div class="dropdown-menu nav_dropdown container shadow rounded-0 mt-0">
                                    <a class="dropdown-item nav_drop_item" href="{{ route('category.products', ['slug' => $nav_cat->slug]) }}">{{ $nav_cat->ProductCategory_Name }}</a>
                                    @foreach ($nav_cat->subcategories as $subcat)
                                        <a class="dropdown-item nav_drop_item" href="{{ route('subcategories.products', ['slug' => $subcat->slug]) }}">{{ $subcat->name }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @else
                                <li class="nav-item" >
                                <a class="nav-link active" href="{{ route('category.products', ['slug' => $nav_cat->slug]) }}">{{ $nav_cat->ProductCategory_Name }}</a>
                            </li>
                        @endif

                    @endforeach

                    
                </ul>
            </div>
        </div>
    </nav>
</section>