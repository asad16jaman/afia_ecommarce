@extends('front.layout.app')
@section('title', 'Home Page')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/photo_gallery.css') }}">
    <style>
        .btn-isotop {
            border: 1px solid var(--nav-color);
            padding: 5px 10px;
            background-color: var(--nav-color);
            color: #fff;
            text-transform: capitalize
        }

        .btn-outline-isotop {
            border: 1px solid var(--nav-color);
            background-color: #fff;
            color: var(--nav-color);
            padding: 5px 10px;
            text-transform: capitalize
        }

        .modalcloss {
            z-index: 99;
            border: none;
            display: inline-block;
            padding: 5px;
            background-color: transparent;
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <section class="hero-section py-4 header_margin">
        <div class="container">
            <div class="row">
                <!-- Slider -->
                <div class="col-lg-8 mt-0">
                    <div id="heroSlider" class="carousel slide hero-slider" data-bs-ride="carousel">

                        <div class="carousel-indicators">
                            @foreach ($sliders as $_slider)
                                <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="{{ $loop->index }}"
                                    class="{{ ($loop->index == 0) ? 'active' : ''}}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($sliders as $slider)
                                <div class="carousel-item  {{ $loop->index == 0 ? 'active' : '' }}">
                                    <img src="{{ $softUrl . $slider->image}}" class="d-block w-100" alt="">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroSlider"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
                <!-- Right Banner -->
                <div class="col-12 col-lg-4 ps-lg-0 mt-lg-0">
                    <div class="row g-3 h-100 ">
                        <div class="col-lg-12 col-6 mt-custom">
                            <a href="{{ $banner->slider_first_link }}">
                                <img src="{{ $softUrl . $banner->slider_first }}" class="img-fluid banner-img" alt="">
                            </a>
                        </div>
                        <div class="col-lg-12 col-6 mt-custom">
                            <a href="{{ $banner->slider_second_link }}">
                                <img src="{{ $softUrl . $banner->slider_second }}" class="img-fluid banner-img" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mt-4">
                    <div class="card bedge_card">
                        <a href="{{ route('get_free_shipping') }}">
                            <div class="card-body">
                                <div class="d-flex gap-3">
                                    <div class="left_bedge">
                                        <span><i class="bi bi-truck"></i></span>
                                    </div>
                                    <div class="right_bedge">
                                        <h4>Free Shipping</h4>
                                        <p>By 2 Or More Products</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mt-4">
                    <div class="card bedge_card">
                        <a href="{{ route('get_authenticate') }}">
                            <div class="card-body">
                                
                                    <div class="d-flex gap-3">
                                        <div class="left_bedge">
                                            <span><i class="bi bi-patch-check-fill"></i></span>
                                        </div>
                                        <div class="right_bedge">
                                            <h4>100% Authentic</h4>
                                            <p>All Product Sourced Directly</p>
                                        </div>
                                    </div>
                                
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mt-4">
                    <div class="card bedge_card">
                        <div class="card-body">
                            <a href="{{ route('get_safe_payment') }}">
                                <div class="d-flex gap-3">
                                    <div class="left_bedge">
                                        <span><i class="bi bi-shield-lock"></i></span>
                                    </div>
                                    <div class="right_bedge  overflow-hidden">
                                        <h4 class="text-truncate">Safe & Secure Payment</h4>
                                        <p class="text-truncate">Cash on Delivery and Online Payments</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="categories" class="">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="fw-bold mb-1">Our Categories</h4>
                            <p class="text-muted small mb-0">
                                <!-- Handpicked selection of the finest Bangladeshi honey -->
                            </p>
                        </div>
                        <!-- <a href="#" class="view-all ms-auto">View All →</a> -->
                    </div>
                </div>
            </div>

            <div class="row g-4 d-flex justify-content-center">
                <div class="col-12">
                    <div class="swiper categorySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $cat)
                                <div class="swiper-slide">
                                    @include('front.components.categoryCard', [
        'img' => $softUrl . $cat->image,
        'name' => $cat->ProductCategory_Name,
        'slug' => $cat->slug,
        'id' => $cat->ProductCategory_SlNo
    ])
                                </div>
                            @endforeach
                        </div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <div class="text-center mb-2">
                <h4 class="fw-bold mb-1 text-uppercase" id="event-title">
                    {{ $events->first()->title ?? '' }}
                </h4>
            </div>
            <div class="text-center mb-0">
                @foreach ($events as $collection)
                    <button class="{{ $loop->first ? 'btn-isotop active' : 'btn-outline-isotop' }} filter-btn"
                        data-filter=".collection-{{ $collection->id }}" data-title="{{ $collection->title }}">
                        {{ $collection->title }}
                    </button>
                @endforeach
            </div>
            <div class="row isotope-container">
                @foreach ($events as $collection)
                    @foreach ($collection->attached_products as $product)
                        <div class="col-lg-3 col-md-4 col-6 mb-4 isotope-item collection-{{ $collection->id }}">
                            @include('front.components.productCard', ['ob' => $product])
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <div class="product-section">
                <div class="text-center mb-4">
                    <h4 class="fw-bold mb-1">New Arrivals</h4>
                    <p class="text-muted small mb-0">
                        Discover the latest fashion arrivals crafted for style, comfort, and confidence
                    </p>
                </div>
            </div>
            <div class="row g-3 d-flex justify-content-center">
                <!-- Product -->
                @foreach ($newArrivals as $arrival)
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['ob' => $arrival])
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Popular Product Section -->
    <section id="gallery" class="py-4 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <p class="color-second fw-bold mb-2">Popular Product</p>
                <h2 class="fw-bold mb-3">Our Premium Modest Collection</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="gallery-slider">
                        @foreach ($popular_roduct as $p_product)
                            <div class="">
                                @include('front.components.productCard', ['ob' => $p_product])
                            </div>
                        @endforeach
                        @foreach ($popular_roduct as $p_product)
                            <div class="">
                                @include('front.components.productCard', ['ob' => $p_product])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <a href="{{ $banner->banner_first_link }}">
                        <div class="banner_container">
                            <img src="{{ $softUrl . $banner->banner_first }}" alt="dd">
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-12">
                    <a href="{{ $banner->banner_second_link }}">
                        <div class="banner_container">
                            <img src="{{ $softUrl . $banner->banner_second }}" alt="dd">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-4  bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-1">All Products</h4>
                <p class="text-muted small mb-0">
                    Explore our complete collection of stylish
                </p>
            </div>
            <div class="row g-3 g-md-4 justify-content-center">
                @foreach ($products as $_product)
                    <div class="col-lg-3 col-md-4 col-6">
                        @include('front.components.productCard', ["ob" => $_product])
                    </div>
                @endforeach
            </div>
            <!-- Button -->
            <div class="text-center mt-4">
                <a href="{{ route('all.products') }}" class="show_more rounded-pill px-4 text-black">
                    Show More Products
                    <i class="fa-solid fa-chevron-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery_section" class="py-4">
        <div class="container">
            <div class="text-center">
                <h2 class="fw-bold ">Galleries</h2>
            </div>
            <div class="card gallery_card">
                <div class="card-body ">
                    <div class="row">
                        @foreach ($galleries as $glry)
                            <div
                                class="col-lg-4 col-md-6 col-6 mt-0  {{ $loop->iteration <= 3 ? 'mb-2' : ($loop->iteration <= 4 ? 'mb-2 mb-lg-0' : '')  }}">
                                <div class="gallery-card ">
                                    <a href="{{ $softUrl . $glry->image }}" class="glightbox" data-gallery="gallery1"
                                        data-description="{{ $glry->title }}">
                                        <div class="gallery-image">
                                            <img src="{{ $softUrl . $glry->image }}" alt="{{ $glry->title }}">
                                            <div class="gallery-overlay">
                                                <div class="gallery-content">
                                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags(optional($glry)->title), 30) }}
                                                    </p>
                                                </div>
                                                <span class="gallery-icon ">
                                                    <button class="plusBtn">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('galleries') }}" class="show_more rounded-pill px-4 text-black">
                    Show More Galleries
                    <i class="fa-solid fa-chevron-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="gallery_section" class="py-4  bg-light">
        <div class="container">
            <div class="text-center">
                <h2 class="fw-bold">Blogs</h2>
            </div>
            <div class="row">
                @foreach ($blogs as $blog)
                        <div class="col-12 col-md-4">
                        <a href="{{ route('get_blog', ['slug' => $blog->slug]) }}">
                            <div class="card border-0 rounded-4">
                            <div class="card-body p-2">
                                <div class="mb-3">
                                    <img src="{{ $blog->image ? $softUrl . $blog->image : asset('assets/images/blog/b1.jpg') }}" alt="{{ $blog->title }}"
                                        class="img-fluid rounded-5 fixed-card-img">
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-nav bg-opacity-10 text-warning px-2 py-1 rounded-pill">Writer : {{ $blog->write_by }}</span>
                                </div>
                                <h5 class="card-title fw-bold mb-2">{{ $blog->title }}</h5>
                                <p class="card-text text-muted mb-0">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 160, '...') }}
                                </p>
                            </div>
                        </div>
                        </a>
                    </div>

                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('get_all_blog') }}" class="show_more rounded-pill px-4 text-black">
                    Show More Blogs
                    <i class="fa-solid fa-chevron-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Review Section -->
    <section id="reviews" class="py-4">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2">Customer Review</h2>
                <p class="text-muted mx-auto">
                    Hear from our happy customers who love the style, comfort, and quality of our clothing. ⭐
                </p>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="swiper reviewSwiper p-3">
                        <div class="swiper-wrapper">
                            @foreach ($reviews as $_review)
                                <div class="swiper-slide">
                                    @include('front.components.reviewCard', ['img' => $softUrl . $_review->image, 'title' => $_review->title])
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Modal -->
    <div class="modal fade" id="newsletterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative border-0"> <!-- Close Button --> <button type="button"
                    class="modalcloss position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"><i
                        class="bi bi-x-lg"></i></button>
                <!-- Newsletter Image -->
                <div class="modal-body p-0"> <img src="{{ $softUrl . $setting->newsletter }}" alt="Newsletter"
                        class="img-fluid w-100"> </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
        <script>
            $(document).ready(function () {
                const slickSettings = {
                    rows: 1,
                    arrows: true,
                    dots: false,
                    infinite: true,
                    speed: 400,
                    autoplay: true,
                    autoplaySpeed: 1000000,
                    pauseOnHover: true,
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 5
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        }
                    ]
                };
                $('.gallery-slider').slick(slickSettings);

                const reviewSwiper = new Swiper(".reviewSwiper", {
                    slidesPerView: 5,
                    spaceBetween: 16,
                    loop: true,
                    speed: 400,
                    rtl: true,
                    autoplay: {
                        delay: 2000,
                        disableOnInteraction: false,
                    },
                    breakpoints: {
                        0: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        992: {
                            slidesPerView: 2,
                        },
                        1200: {
                            slidesPerView: 5,
                        }
                    }
                });
                       
                const categorySwiper = new Swiper(".categorySwiper", {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    loop: true,
                    speed: 600,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".categorySwiper .swiper-pagination",
                        clickable: true,
                    },
                    breakpoints: {
                        576: {
                            slidesPerView: 2,
                        },
                        768: {
                            slidesPerView: 3,
                        },
                        992: {
                            slidesPerView: 4,
                        },
                        1200: {
                            slidesPerView: 5,
                        }
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                var isotopeContainer = document.querySelector('.isotope-container');
                if (!isotopeContainer) {
                    return;
                }
                var iso = new Isotope(isotopeContainer, {
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows'
                });
                var filterButtons = document.querySelectorAll('.filter-btn');
                var eventTitle = document.getElementById('event-title');
                filterButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        var filterValue = this.getAttribute('data-filter');
                        var title = this.getAttribute('data-title');
                        // Filter products
                        iso.arrange({
                            filter: filterValue
                        });
                        // Change title
                        eventTitle.textContent = title;
                        // Active button
                        filterButtons.forEach(function (btn) {
                            btn.classList.remove('btn-isotop', 'active');
                            btn.classList.add('btn-outline-isotop');
                        });
                        this.classList.remove('btn-outline-isotop');
                        this.classList.add('btn-isotop', 'active');
                    });
                });

                // First event default selected
                if (filterButtons.length > 0) {
                    var firstFilter = filterButtons[0].getAttribute('data-filter');
                    iso.arrange({
                        filter: firstFilter
                    });
                }
                const newsletterModal = new bootstrap.Modal(document.getElementById('newsletterModal')); newsletterModal.show();
            });

            document.addEventListener("DOMContentLoaded", function () {
                const images = document.querySelectorAll(".lazy-product-image");
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        const img = entry.target;
                        const loader = img.parentElement.querySelector(".image-loader");
                        const image = new Image();
                        image.onload = function () {
                            img.src = img.dataset.src;
                            img.classList.add("loaded");
                            if (loader) {
                                loader.style.display = "none";
                            }
                        };
                        image.onerror = function () {
                            img.src = "{{ asset('assets/images/product_default.png') }}";
                            img.classList.add("loaded");
                            if (loader) {
                                loader.style.display = "none";
                            }
                        };
                        image.src = img.dataset.src;
                        observer.unobserve(img);
                    });
                }, {
                    rootMargin: "100px"
                });

                images.forEach(img => {
                    observer.observe(img);
                });

            });

            const lightbox = GLightbox({
                selector: '.glightbox'
            });
        </script>
        <script src="{{ asset('assets/js/add_to_cart_from_product_card.js') }}"></script>
@endpush