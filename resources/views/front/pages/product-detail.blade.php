@extends('front.layout.app')
@section('title', 'Product Pages')
@push('style')
    <style>

    </style>
@endpush

@section('content')
                            <?php
$cart_product = [
    'Product_SlNo' => $product->Product_SlNo,
    'Product_Name' => $product->Product_Name,
    'thum_image' => $product->thum_image,
    'Product_MinimumSellingPrice' => $product->Product_MinimumSellingPrice,
]
                            ?>
                            <section class="product-details pb-5 header_margin">
                                <div class="container pt-4">

                                    <div class="small text-muted">
                                        <nav aria-label="breadcrumb">
                                            <ol class="breadcrumb custom-breadcrumb mb-0">
                                                <li class="breadcrumb-item">
                                                    <a href="#">Home</a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    <a href="#">{{ $product->category->ProductCategory_Name }}</a>
                                                </li>
                                                <li class="breadcrumb-item active" aria-current="page">
                                                    {{ $product->Product_Name }}
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>

                                    <div class="row g-1 align-items-start">
                                        <div class="col-lg-5">
                                            <div class="main-product-img position-relative">
                                                <img src="{{ $softUrl . $product->thum_image }}" id="mainProductImage"
                                                    class="img-fluid product-img" alt="{{ $product->Product_Name }}">
                                            </div>
                                            <div class="thumb-slider mt-4">
                                                <div>
                                                    <img src="{{ $softUrl . $product->thum_image  }}" class="thumb-img"
                                                        data-img="{{ $softUrl . $product->thum_image }}">
                                                </div>
                                                @foreach ($product->product_images as $img)
                                                    <div>
                                                        <img src="{{ $softUrl . $img->image }}" class="thumb-img"
                                                            data-img="{{ $softUrl . $img->image }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-lg-7">
                                            <div class="ms-lg-4">
                                                <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="premium-badge">
                                                        @if($product->new_arrival)
                                                        New Arrival
                                                        @elseif($product->popular_product)
                                                           Popular Product   
                                                        @else
                                                            Product  
                                                        @endif
                                                    </span>
                                                    <div class="color-second small">
                                                        ★★★★☆
                                                        <span class="text-muted">(124 Reviews)</span>
                                                    </div>
                                                </div>

                                                <h1 class="fw-bold product-title mb-2">{{ $product->Product_Name }}</h1>
                                                <p class="mb-2">Category : {{ optional($product->category)->ProductCategory_Name }}</p>

                                                <div class="price mb-4">
                                                    <span class="old-price">{{ $product->Product_SellingPrice }}{{ $currency }}</span>
                                                    <span class="current-price">{{ $product->Product_MinimumSellingPrice }}{{ $currency }}</span>
                                                </div>

                                                <div class="mb-1 fw-semibold">
                                                    <!-- <i class="bi bi-shield-check me-2 text-warning"></i> -->
                                                    Product short description
                                                </div>

                                                <p class="text-muted small lh-lg">
                                                   {{ $product->short_description }}
                                                </p>

                                                <div class="mt-4">
                                                    <div class="d-flex justify-content-between mb-3">
                                                        <span class="fw-semibold">Select Size</span>
                                                        <!-- <a href="#" class="weight-guide">Weight Guide</a> -->
                                                    </div>
                                                    @if($product->current_stock >= 1)
                                                        <div class="d-flex gap-2 flex-wrap" id="selected_product_size" data-selectedid="{{ $product->size_wise_stock[0]->Size_SlNo ?? '' }}" data-selected_size_name="{{ $product->size_wise_stock[0]->Size_Name ?? '' }}">
                                                            @foreach ($product->size_wise_stock as $size)
                                                                <button class=" {{ $size->current_stock > 0 ? 'weight-btn' : 'of_stock' }} weight-btn_fun {{ $loop->index == 0 ? 'active' : '' }}" data-current_stock="{{ $size->current_stock }}" data-size="{{ $size->Size_SlNo }}" data-size_name="{{ $size->Size_Name }}">{{ $size->Size_Name }}</button>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="d-flex gap-2 flex-wrap">
                                                            <button class="weight-btn2">Stock out</button>
                                                        </div>
                                                    @endif

                                                </div>

                                                <div class="d-flex gap-3 mt-3">
                                                    <button class="detail_page_addToCard" data-product='@json($cart_product)' onclick="add_to_cart(event)">
                                                        <i class="fa-solid fa-cart-plus me-1" ></i> Add to Cart
                                                    </button>

                                                    <button class="detail_page_byNow" data-product='@json($cart_product)'>
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
                                                                {!! $product->Product_description !!}
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

                                            @foreach ($r_products as $_rp)
                                                <div class="swiper-slide">
                                                    @include('front.components.productCard', ['ob' => $_rp])
                                                </div>
                                            @endforeach

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
            let selectedSize_name = $btn.data('size_name');
            let stock = $btn.data('current_stock');

            // Parent
            let $parent = $btn.parent();

            // Previous active remove
            $parent.find('.weight-btn').removeClass('active');

            // Current active
            $btn.addClass('active');

            // Update parent's data-selectedId
            $parent.attr('data-selectedid', selectedSize);
            $parent.attr('data-selected_size_name', selectedSize_name);
        });

        $(document).on('click', '.of_stock', function () {
                alert("This Size Stock out")
            });

        function add_to_cart(event) {
            const button = event.currentTarget;
            const product = JSON.parse(button.dataset.product);
            const size = document.getElementById('selected_product_size').dataset.selectedid;
            const size_name = document.getElementById('selected_product_size').dataset.selected_size_name;
            addToCart(product,{sizeid:size,sizename:size_name},1)
        }

    </script>
    <script src="{{ asset('assets/js/add_to_cart_from_product_card.js') }}"></script>
@endpush