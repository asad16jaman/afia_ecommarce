@extends('front.layout.app')
@section('title', 'Home Page')
@push('style')
    <style>

    </style>
@endpush

@section('content')
    <section class="hero-section py-4 header_margin">
        <div class="container">
            <div class="row">
                <!-- Slider -->
                <div class="col-lg-8 mt-0 g-lg-0">
                    <div id="heroSlider" class="carousel slide hero-slider" data-bs-ride="carousel">

                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#heroSlider" data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/images/slider/alider1.jpg') }}" class="d-block w-100" alt="">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/slider/alider1.jpg') }}" class="d-block w-100" alt="">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/slider/alider1.jpg') }}" class="d-block w-100" alt="">
                            </div>
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
                <div class="col-12 col-lg-4 mt-lg-0">
                    <div class="row g-3 h-100 ">
                        <div class="col-lg-12 col-6 mt-custom">
                            <a href="#">
                                <img src="{{ asset('assets/images/slider/b1.png') }}" class="img-fluid banner-img" alt="">
                            </a>
                        </div>
                        <div class="col-lg-12 col-6 mt-custom">
                            <a href="#">
                                <img src="{{ asset('assets/images/slider/b2.png') }}" class="img-fluid banner-img" alt="">
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
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mt-4">
                    <div class="card bedge_card">
                        <div class="card-body">
                            <a href="">
                                <div class="d-flex gap-3">
                                    <div class="left_bedge">
                                        <span><i class="bi bi-patch-check-fill"></i></span>
                                    </div>
                                    <div class="right_bedge">
                                        <h4>100% Authentic</h4>
                                        <p>All Product Sourced Directly</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mt-4">
                    <div class="card bedge_card">
                        <div class="card-body">
                            <a href="">
                                <div class="d-flex gap-3">
                                    <div class="left_bedge">
                                        <span><i class="bi bi-shield-lock"></i></span>
                                    </div>
                                    <div class="right_bedge">
                                        <h4>Safe & Secure Payment</h4>
                                        <p>Cash on Delivery and Online Payments</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="categories" class="py-4">
        <div class="container-fluid px-2 px-md-4 px-lg-5">
            <div class="d-flex align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">Our Categories</h4>
                    <p class="text-muted small mb-0">
                        <!-- Handpicked selection of the finest Bangladeshi honey -->
                    </p>
                </div>
                <!-- <a href="#" class="view-all ms-auto">View All →</a> -->
            </div>

            <div class="row g-4 d-flex justify-content-center">
                <div class="swiper categorySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            @include('front.components.categoryCard', ['img' => 'assets/images/category/cat1.webp', 'name' => 'Party Borka Design'])
                        </div>
                        <div class="swiper-slide">
                            @include('front.components.categoryCard', ['img' => 'assets/images/category/cat2.webp', 'name' => 'Attest Koti Borka'])
                        </div>
                        <div class="swiper-slide">
                            @include('front.components.categoryCard', ['img' => 'assets/images/category/cat3.webp', 'name' => 'Abaya Borka Design'])
                        </div>
                        <div class="swiper-slide">
                            @include('front.components.categoryCard', ['img' => 'assets/images/category/cat4.webp', 'name' => 'Hijab & Khimar'])
                        </div>
                        <div class="swiper-slide">
                            @include('front.components.categoryCard', ['img' => 'assets/images/category/cat-5.webp', 'name' => 'Simple Borka Design'])
                        </div>
                        <div class="swiper-slide">
                            @include('front.components.categoryCard', ['img' => 'assets/images/category/cat2.webp', 'name' => 'Attest Koti Borka'])
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
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
                <div class="row g-3">
                    <!-- Product -->
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <!-- Product -->
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <!-- Product -->
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <!-- Product -->
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <!-- Product -->
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <!-- Product -->
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <!-- Product -->
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <!-- Product -->
                    <div class="col-lg-3 col-md-3 col-6">
                        @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                </div>
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
            <div class="gallery-slider">
                <div class="">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <div class="">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <div class="">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <div class="">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <div class="">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>

                <div class="">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <div class="">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>

                <div class="">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>

            </div>
        </div>
    </section>

    <section id="gallery" class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <a href="">
                        <div class="banner_container">
                            <img src="{{ asset('assets/images/banner/1-1.webp') }}" alt="dd">
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-12">
                    <a href="">
                        <div class="banner_container">
                            <img src="{{ asset('assets/images/banner/1-17.webp') }}" alt="dd">
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
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-6">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-6">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-6">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-6">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-6">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-6">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-6">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
                <!-- Product -->
                <div class="col-lg-3 col-md-3 col-6">
                    @include('front.components.productCard', ['img' => 'assets/images/product/p2.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                </div>
            </div>
            <!-- Button -->
            <div class="text-center mt-4">
                <a href="#" class="show_more rounded-pill px-4 text-black">
                    Show More Products
                    <i class="fa-solid fa-chevron-down ms-2"></i>
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
            <div class="swiper reviewSwiper p-3">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        @include('front.components.reviewCard', ['img' => 'assets/images/review/1-17.jpeg', 'title' => 'review_card'])
                    </div>
                    <div class="swiper-slide">
                        @include('front.components.reviewCard', ['img' => 'assets/images/review/1-29.jpeg', 'title' => 'review_card'])
                    </div>
                    <div class="swiper-slide">
                        @include('front.components.reviewCard', ['img' => 'assets/images/review/1-30.jpeg', 'title' => 'review_card'])
                    </div>
                    <div class="swiper-slide">
                        @include('front.components.reviewCard', ['img' => 'assets/images/review/1-17.jpeg', 'title' => 'review_card'])
                    </div>
                    <div class="swiper-slide">
                        @include('front.components.reviewCard', ['img' => 'assets/images/review/1-17.jpeg', 'title' => 'review_card'])
                    </div>
                    <div class="swiper-slide">
                        @include('front.components.reviewCard', ['img' => 'assets/images/review/1-17.jpeg', 'title' => 'review_card'])
                    </div>
                </div>
                <!-- চাইলে Pagination -->
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>
    </section>
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

                // চাইলে Pagination
                // pagination: {
                //     el: ".reviewSwiper .swiper-pagination",
                //     clickable: true,
                // },
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
    </script>
@endpush