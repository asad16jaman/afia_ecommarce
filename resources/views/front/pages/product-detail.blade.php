@extends('front.layout.app')
@section('title', 'Product Pages')
@push('style')
    <style>

    </style>
@endpush

@section('content')
    <section class="product-details pb-5 header_margin">
        <div class="container pt-4">

            <div class="small text-muted">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb custom-breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Simple Luxury Abaya</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            💕Simple Luxury Abaya💕Sky Blue color
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="row g-1 align-items-start">

                <div class="col-lg-5">
                    <div class="main-product-img position-relative">
                        <img src="{{ asset('assets/images/product/p1.jpg') }}" id="mainProductImage"
                            class="img-fluid product-img" alt="Honey">

                        <!-- <span class="badge new-badge position-absolute">NEW HARVEST</span> -->
                    </div>

                    <div class="thumb-slider mt-4">
                        <div>
                            <img src="{{ asset('assets/images/product/p2.jpg') }}" class="thumb-img"
                                data-img="{{ asset('assets/images/product/p2.jpg') }}">
                        </div>

                        <div>
                            <img src="{{ asset('assets/images/product/p1.jpg') }}" class="thumb-img"
                                data-img="{{ asset('assets/images/product/p1.jpg') }}">
                        </div>

                        <div>
                            <img src="{{ asset('assets/images/product/p3.jpg') }}" class="thumb-img"
                                data-img="{{ asset('assets/images/product/p3.jpg') }}">
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/product/p4.jpg') }}" class="thumb-img"
                                data-img="{{ asset('assets/images/product/p4.jpg') }}">
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/product/p4.jpg') }}" class="thumb-img"
                                data-img="{{ asset('assets/images/product/p4.jpg') }}">
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/product/p4.jpg') }}" class="thumb-img"
                                data-img="{{ asset('assets/images/product/p4.jpg') }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="ms-lg-4">
                        <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
                            <span class="premium-badge">New Arrival</span>
                            <div class="color-second small">
                                ★★★★☆
                                <span class="text-muted">(124 Reviews)</span>
                            </div>
                        </div>

                        <h1 class="fw-bold product-title mb-2">💕Simple Luxury Abaya💕Sky Blue color</h1>
                        <p class="mb-2">Category : Simple Luxury Abaya</p>

                        <div class="price mb-4">
                            <span class="old-price">3,190৳</span>
                            <span class="current-price">2,350৳</span>

                        </div>

                        <div class="mb-1 fw-semibold">
                            <!-- <i class="bi bi-shield-check me-2 text-warning"></i> -->
                            Product short description
                        </div>

                        <p class="text-muted small lh-lg">
                            আপনার প্রিয় 💕Simple Luxury Abaya💕

                            👉নিজের স্টাইলকে আরও দৃষ্টিনন্দন করুন। 👉100% best quality product paben
                            👉বোরকা হাতে পেয়ে মূল্য পরিশোধের সুযোগ।
                        </p>

                        <div class="mt-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-semibold">Select Size</span>
                                <!-- <a href="#" class="weight-guide">Weight Guide</a> -->
                            </div>

                            <div class="d-flex gap-2 flex-wrap" data-selectedId="50">
                                <button class="weight-btn active" data-size="50">50</button>
                                <button class="weight-btn" data-size="52">52</button>
                                <button class="weight-btn" data-size="54">54</button>
                                <button class="weight-btn" data-size="56">56</button>
                                <button class="weight-btn" data-size="58">58</button>
                                <button class="weight-btn" data-size="60">60</button>
                            </div>

                        </div>

                        <div class="d-flex gap-3 mt-3">
                            <button class="detail_page_addToCard">
                                <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                            </button>

                            <button class="detail_page_byNow">
                                <i class="fa fa-shopping-bag me-1"></i> Buy Now
                            </button>
                        </div>
                    </div>
                    <div class="ms-lg-4" id="Product_main_description_section">

                        <div class="product-tabs mt-2 pt-4">

                            <!-- Tabs -->
                            <ul class="nav custom-product-tabs" id="productTab" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab">
                                        Product Description
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                        type="button" role="tab">
                                        Customer Reviews (12)
                                    </button>
                                </li>

                            </ul>

                            <div class="tab-content">

                                <!-- Description -->
                                <div class="tab-pane fade show active" id="description" role="tabpanel">

                                    <div class="tab-card scrol-lg">
                                        <h3>আমাদের উপর কেন আস্থা রাখবেন ?</h3>

                                        <p>✅ বোরকা গুলো আমাদের নিজস্ব কারখানায় তৈরি।</p>

                                        <p>✅আরজিনাল দুবাই চেরি কাপড় দিয়ে তৈরি।</p>

                                        <p>✅ডেলিভারি ম্যান এর সামনে প্রোডাক্ট খুলে কোয়লিটি এবং অরজিনাল দুবাই চেরি কাপড় কি না
                                            তা দেখে তার পর প্রোডাক্ট রিসিভ করতে
                                            পারবেন।</p>

                                        <p>✅আমাদের প্রতি টি বোরকা সিকুয়েন্স এবং জরি সুতার কাজ নিখুঁত সেলাই ও সর্বোচ্চ মান
                                            নিশ্চিত করা হয়</p>

                                        <p>✅💕Simple Luxury Abaya💕 ফুল সেট টিতে যা যা থাকবে।</p>

                                        <p>👉একটি আবায়া।</p>
                                        <p>👉একটি ৯০/৩০ ইঞ্চি লম্বা হিজাব।</p>

                                        <p>✅আমাদের রয়েছে ৩ দিনের মধ্যে এক্সচেঞ্জ এর সুযোগ।(যেকোন সমস্যা হলে চেঞ্জ করে নিতে
                                            পারবেন)।</p>

                                        <p>✅সারা বাংলাদেশ ফুল ক্যাশ অন হোম ডেলিভারি,</p>
                                        <p>👉অর্ডার করার ২/৩ দিনের মধ্যে প্রোডাক্ট হাতে পাবেন।</p>

                                        <p>✅১০০% সেম না হলে সাথে সাথে রিটার্ন করে দিবেন</p>

                                        <p>⚠ দ্রষ্টব্য: ভিডিওতে আলোর কারণে রঙের গ্রেডিং সামান্য পরিবর্তিত হতে পারে।</p>
                                    </div>

                                </div>

                                <!-- Review -->
                                <div class="tab-pane fade" id="review" role="tabpanel">

                                    <div class="tab-card scrol-lg">

                                        <h6 class="fw-bold mb-3">Write a Review</h6>

                                        <!-- Rating -->
                                        <div class="mb-4">

                                            <label class="form-label fw-semibold">Rating</label>

                                            <input type="hidden" id="ratingValue" name="rating" value="0">

                                            <div class="rating-stars">

                                                <i class="bi bi-star" data-value="1"></i>
                                                <i class="bi bi-star" data-value="2"></i>
                                                <i class="bi bi-star" data-value="3"></i>
                                                <i class="bi bi-star" data-value="4"></i>
                                                <i class="bi bi-star" data-value="5"></i>

                                            </div>

                                        </div>

                                        <!-- Review -->
                                        <div class="mb-3">

                                            <label class="form-label fw-semibold">Your Review</label>

                                            <textarea class="form-control review-textarea" rows="5"
                                                placeholder="Write your review here..."></textarea>

                                        </div>

                                        <button type="button" class="btn-review">
                                            Submit Review
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Product Section -->
    <section id="gallery" class="py-4 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-3">Related Products</h2>
            </div>
            <div class="swiper relatedProductsSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">

                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <div class="swiper-slide">

                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>

                    <div class="swiper-slide">

                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <div class="swiper-slide">

                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>

                    <div class="swiper-slide">

                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <div class="swiper-slide">

                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>

                    <div class="swiper-slide">

                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>
                    <div class="swiper-slide">

                        @include('front.components.productCard', ['img' => 'assets/images/product/p1.jpg', 'name' => 'One Piece Abaya Collection One Piece Abaya Collection', 'sell_price' => 2300, 'price' => 2100])
                    </div>

                </div>
                <!-- Navigation -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            </div>
        </div>
    </section>

@endsection

@push('script')
    <script>

        $('.thumb-slider').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            infinite: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });

        // on click change main image
        $('.thumb-img').on('click', function () {
            var newImage = $(this).data('img');
            $('#mainProductImage').attr('src', newImage);
        });

        const stars = document.querySelectorAll(".rating-stars i");
        const ratingInput = document.getElementById("ratingValue");

        let selectedRating = 0;

        // Update star UI
        function updateStars(rating) {

            stars.forEach((star, index) => {

                if (index < rating) {
                    star.classList.remove("bi-star");
                    star.classList.add("bi-star-fill");
                } else {
                    star.classList.remove("bi-star-fill");
                    star.classList.add("bi-star");
                }

            });

        }

        // Hover
        stars.forEach(star => {

            star.addEventListener("mouseenter", function () {
                updateStars(this.dataset.value);
            });

            // Click
            star.addEventListener("click", function () {

                selectedRating = this.dataset.value;
                ratingInput.value = selectedRating;

                updateStars(selectedRating);

            });

        });

        // Mouse leave
        document.querySelector(".rating-stars")
            .addEventListener("mouseleave", function () {
                updateStars(selectedRating);
            });

        const relatedProductsSwiper = new Swiper(".relatedProductsSwiper", {
            slidesPerView: 5,
            spaceBetween: 20,

            loop: true,

            speed: 400,

            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },

            navigation: {
                nextEl: ".relatedProductsSwiper .swiper-button-next",
                prevEl: ".relatedProductsSwiper .swiper-button-prev",
            },

            breakpoints: {
                0: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 5
                }
            }
        });

        $(document).on('click', '.weight-btn', function () {
            let $btn = $(this);
            let selectedSize = $btn.data('size');

            // Parent
            let $parent = $btn.parent();

            // Previous active remove
            $parent.find('.weight-btn').removeClass('active');

            // Current active
            $btn.addClass('active');

            // Update parent's data-selectedId
            $parent.attr('data-selectedId', selectedSize);
        });

    </script>
@endpush