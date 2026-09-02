@extends('front.layout.app')
@section('title', 'Product Detail Page')
@push('style')
    <style>
        .detail_off{
            margin-left: 12px;
    background: var(--color-second);
    padding: 3px 7px;
    color: #fff;
    border-radius: 5px;
        }
        .reviewtext {
            border-radius: 2px;
            margin-bottom: 12px;
        }

        .customer-review {
            padding-bottom: 20px;
        }

        .review-avatar {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .review-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .review-rating {
            color: #f5a623;
            font-size: 14px;
            white-space: nowrap;
        }

        .customer-review p {
            font-size: 14px;
        }

        .nextPrevbutton {
            background-color: var(--nav-color);
            border: 1px solid #fff;
            color: #fff
        }

        .nextPrevbutton:hover {
            background-color: yellow;
            border: 1px solid #fff;
        }

        .disable {
            background-color: gray;
            cursor: not-allowed !important
        }

        .disable:hover {
            background-color: gray;
            border: 1px solid #fff;
        }

        .authentic {
            color: green;
            font-style: italic;
            font-weight: 600;
        }

        .main-product-img {
            overflow: hidden;
            cursor: zoom-in;
        }

        .main-product-img .product-img {
            width: 100%;
            transition: transform 0.15s ease;
        }

        .main-product-img.zoomed .product-img {
            transform: scale(2);
        }
        .scroll_tab{
                    height: 760px;
        overflow-y: scroll;
        text-align: justify;
        }
    </style>
@endpush

@section('content')
            <?php

$minSellPrice = $product->Product_MinimumSellingPrice;
$discount = $product->discount;
if ((float) $product->category->category_discount > (float) $product->discount) {
    $minSellPrice = $product->Product_SellingPrice - ((float) $product->Product_SellingPrice * (float) $product->category->category_discount) / 100;
    $discount = $product->category->category_discount;
}

$cart_product = [
    'Product_SlNo' => $product->Product_SlNo,
    'Product_Name' => $product->Product_Name,
    'thum_image' => $product->thum_image,
    'Product_MinimumSellingPrice' => $minSellPrice,
];
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
                                                                        <img src="{{ $softUrl . $product->thum_image }}" id="mainProductImage" class="img-fluid product-img"
                                                                            alt="{{ $product->Product_Name }}">
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
                                                                    @if($product->youtube_link)
                                                                        <div class="card">
                                                                        @php
$youtubeUrl = $product->youtube_link;
preg_match(
    '/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([^?&\/]+)/',
    $youtubeUrl,
    $matches
);
$videoId = $matches[1] ?? null;
                                                                        @endphp
                                                                        <div class="card-body">
                                                                            @if($videoId)
                                                                                <iframe
                                                                                    width="100%"
                                                                                    height="400"
                                                                                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1&loop=1&playlist={{ $videoId }}"
                                                                                    title="YouTube video player"
                                                                                    frameborder="0"
                                                                                        allow="accelerometer; autopl        ay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                                                    referrerpolicy="strict-o            rigin-when-cross-origin"
                                                                                                                                allowfullscreen>
                                                                                            </iframe>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    
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
                                                                                <span class="text-muted">({{ $total_reviews }} Reviews)</span>
                                                                            </div>
                                                                        </div>

                                                                        <h1 class="fw-bold product-title mb-2">{{ $product->Product_Name }}</h1>
                                                                        <div class="price mb-4">
                                                                            <span class="old-price">{{ $product->Product_SellingPrice }}{{ $currency }}</span>
                                                                            <span class="current-price">{{ $minSellPrice }}{{ $currency }}</span>
                                                                            <span class="detail_off">
                                                                                {{ $discount }} % OFF
                                                                            </span>
                                                                        </div>
                                                                        <p class="authentic mb-2">100% Authentic Product</p>
                                                                        <p class="mb-2"><strong>SKU</strong> : {{ optional($product)->Product_Code }}</p>
                                                                        <p class="mb-2"><strong>Category</strong> : {{ optional($product->category)->ProductCategory_Name }}
                                                                        </p>
                                                                        <p class="mb-2"><strong>Sub Category</strong> : {{ optional($product->subcategory)->name }}</p>
                                                                        <p class="mb-2"><strong>Brand</strong> : {{ optional($product->p_brand)->brand_name }}</p>

                                                                        @if ($product->have_size)
                                                                        <div class="mt-4">
                                                                            <div class="d-flex justify-content-between mb-3">
                                                                                <span class="fw-semibold">Select Size</span>
                                                                                <!-- <a href="#" class="weight-guide">Weight Guide</a> -->
                                                                            </div>

                                                                            <div class="d-flex gap-2 flex-wrap" id="selected_product_size"
                                                                                data-selectedid="{{ $product->size_wise_stock[0]->Size_SlNo ?? '' }}"
                                                                                data-selected_size_name="{{ $product->size_wise_stock[0]->Size_Name ?? '' }}">
                                                                                @foreach ($product->size_wise_stock as $size)
                                                                                    <button class="weight-btn weight-btn_fun {{ $loop->index == 0 ? 'active' : '' }}"
                                                                                        data-current_stock="{{ $size->current_stock }}" data-size="{{ $size->Size_SlNo }}"
                                                                                        data-size_name="{{ $size->Size_Name }}">{{ $size->Size_Name }}</button>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                        @else
                                                                            <div class="" id="selected_product_size"
                                                                                data-selectedid="0"
                                                                                data-selected_size_name="0">
                                                                            </div>
                                                                        @endif

                                                                        <div class="mt-3">
                                                                            <div class="d-flex gap-3">
                                                                                <button class="detail_page_addToCard" data-product='@json($cart_product)'
                                                                                    onclick="add_to_cart(event)">
                                                                                    <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                                                                                </button>
                                                                                <button class="detail_page_byNow" data-product='@json($cart_product)'
                                                                                    onclick="by_now_from_detail(event)">
                                                                                    <i class="fa fa-shopping-bag me-1"></i> Buy Now
                                                                                </button>
                                                                            </div>

                                                                            <div class="d-flex gap-3 mt-2">
                                                                                <a class="detail_whatsapp"
                                                                                    href="https://wa.me/<?= ltrim($setting->whatsapp, '+') ?>?text=<?= urlencode('Hello, I want to order: ' . $product->Product_Name . ' - ' . url()->current()) ?>"
                                                                                    target="_blank" rel="noopener noreferrer">
                                                                                    <i class="bi bi-whatsapp"></i>
                                                                                    Order On Whatsapp
                                                                                </a>

                                                                                <a class="detail_call" href="tel:<?= $setting->phone ?>">
                                                                                    <i class="bi bi-telephone"></i>
                                                                                    Call For Order
                                                                                </a>
                                                                            </div>
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
                                                                                        Customer Reviews ({{ $total_reviews }})
                                                                                    </button>
                                                                                </li>
                                                                                <li class="nav-item" role="presentation">
                                                                                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#deliveryPolicy" type="button" role="tab">
                                                                                        {{ $deliveryPolicy->title }}
                                                                                    </button>
                                                                                </li>
                                                                                <li class="nav-item" role="presentation">
                                                                                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#returnPolicy" type="button" role="tab">
                                                                                        {{  $returnPolicy->title }}
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                            <div class="tab-content">
                                                                                <!-- Description -->
                                                                                <div class="tab-pane fade  show active" id="description" role="tabpanel">
                                                                                    <div class="tab-card scrol-lg">
                                                                                        {!! $product->Product_description !!}
                                                                                    </div>
                                                                                </div>
                                                                                <!-- Review -->
                                                                                <div class="tab-pane fade" id="review" role="tabpanel">
                                                                                    <div class="tab-card scrol-lg">
                                                                                        <div class="row">
                                                                                            <div class="col-12">
                                                                                                <h6 class="fw-bold mb-3">Write a Review</h6>
                                                                                            </div>
                                                                                            <div class="col-12">
                                                                                                <div class="mb-4">
                                                                                                    <label class="form-label fw-semibold">Rating</label>
                                                                                                    <input type="hidden" id="ratingValue" name="rating" value="0">
                                                                                                    <div class="rating-stars">
                                                                                                        <i :class="parseInt(hoverstar) > 0 ? 'bi-star-fill' : 'bi bi-star' "
                                                                                                            @click="selectStar(1)" @mouseenter="hoverone(1)"
                                                                                                            @mouseleave="hoverleav(1)"></i>
                                                                                                        <i :class="parseInt(hoverstar) > 1 ? 'bi-star-fill' : 'bi bi-star' "
                                                                                                            @click="selectStar(2)" @mouseenter="hoverone(2)"
                                                                                                            @mouseleave="hoverleav(2)"></i>
                                                                                                        <i :class="parseInt(hoverstar) > 2 ? 'bi-star-fill' : 'bi bi-star' "
                                                                                                            @click="selectStar(3)" @mouseenter="hoverone(3)"
                                                                                                            @mouseleave="hoverleav(3)"></i>
                                                                                                        <i :class="parseInt(hoverstar) > 3 ? 'bi-star-fill' : 'bi bi-star' "
                                                                                                            @click="selectStar(4)" @mouseenter="hoverone(4)"
                                                                                                            @mouseleave="hoverleav(4)"></i>
                                                                                                        <i :class="parseInt(hoverstar) > 4 ? 'bi-star-fill' : 'bi bi-star' "
                                                                                                            @click="selectStar(5)" @mouseenter="hoverone(5)"
                                                                                                            @mouseleave="hoverleav(5)"></i>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        @if(!Auth::guard('customer')->check())
                                                                                            <div class="row">
                                                                                                <div class="col-6 mt-0">
                                                                                                    <label for="name" class="form-label fw-semibold">Full Name</label>
                                                                                                    <input type="text" v-model="reviewob.name" name="name" id="name"
                                                                                                        class="form-control reviewtext">
                                                                                                </div>
                                                                                                <div class="col-6 mt-0">
                                                                                                    <label for="phone" class="form-label fw-semibold">Phone</label>
                                                                                                    <input type="text" v-model="reviewob.phone" name="phone" id="phone"
                                                                                                        class="form-control reviewtext">
                                                                                                </div>
                                                                                                <div class="col-12  mt-0">
                                                                                                    <label for="address" class="form-label fw-semibold">Address</label>
                                                                                                    <input type="text" v-model="reviewob.address" name="address" id="address"
                                                                                                        class="form-control reviewtext">
                                                                                                </div>
                                                                                            </div>
                                                                                        @else
                                                                                            <input type="hidden" name="Customer_SlNo" v-model="reviewob.Customer_SlNo">
                                                                                        @endif

                                                                                        <!-- Review -->
                                                                                        <div class="row">
                                                                                            <div class="col-12 mt-0">
                                                                                                <div class="mb-3">
                                                                                                    <label class="form-label fw-semibold">Your Review</label>
                                                                                                    <textarea class="form-control review-textarea" v-model="reviewob.review"
                                                                                                        name="review" rows="5" placeholder="Write your review here..."
                                                                                                        class="message"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-12" @click="saveReview">
                                                                                                <button type="button" class="btn-review">
                                                                                                    Submit Review
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row mt-4">
                                                                                            <div class="col-12">
                                                                                                <h5 class="fw-bold mb-4">Customer Reviews</h5>
                                                                                                <!-- Review 1 -->
                                                                                                <div v-for="(review,key) in reviews"
                                                                                                    class="customer-review mb-2 pb-1 border-bottom">
                                                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                                                        <!-- Left: Image + Name + Date -->
                                                                                                        <div class="d-flex align-items-center">
                                                                                                            <div class="review-avatar me-1">
                                                                                                                <img v-if="review.customer && review.customer.web_profile"
                                                                                                                    :src="'/'+review.customer.web_profile"
                                                                                                                    alt="Asad Uzzaman">

                                                                                                                <img v-else src="/assets/images/review_profile.avif" alt="">
                                                                                                            </div>
                                                                                                            <div>
                                                                                                                <h6 class="fw-bold mb-0">
                                                                                                                    @{{ review.customer ? review.customer.Customer_Name :
                                                                                                                    review.name }}
                                                                                                                </h6>
                                                                                                                <small class="text-muted">
                                                                                                                    @{{ formatDate(review.created_at) }}
                                                                                                                </small>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <!-- Right: Rating -->
                                                                                                        <div class="review-rating">
                                                                                                            <i class="bi bi-star-fill"></i>
                                                                                                            <i
                                                                                                                :class="parseInt(review.rating) >= 2 ?  'bi bi-star-fill' : 'bi bi-star'"></i>
                                                                                                            <i
                                                                                                                :class="parseInt(review.rating) >= 3 ?  'bi bi-star-fill' : 'bi bi-star'"></i>
                                                                                                            <i
                                                                                                                :class="parseInt(review.rating) >= 4 ?  'bi bi-star-fill' : 'bi bi-star'"></i>
                                                                                                            <i
                                                                                                                :class="parseInt(review.rating) >= 5 ?  'bi bi-star-fill' : 'bi bi-star'"></i>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!-- Review -->
                                                                                                    <div class="">
                                                                                                        <p class="text-muted mb-0 lh-lg">
                                                                                                            @{{ review.review }}
                                                                                                        </p>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="next_prev_container d-flex justify-content-end">
                                                                                                    <div class="btn-group" role="group"
                                                                                                        aria-label="Basic mixed styles example">
                                                                                                        <button type="button" class="btn nextPrevbutton"
                                                                                                            v-if="prevUrl || nextUrl" :class="{disable : !prevUrl }"
                                                                                                            @click="getAllReviews(prevUrl)">Prev</button>
                                                                                                        <button type="button" class="btn nextPrevbutton"
                                                                                                            v-if="prevUrl || nextUrl" :class="{disable : !nextUrl }"
                                                                                                            @click="getAllReviews(nextUrl)">Next</button>
                                                                                                    </div>
                                                                                                </div>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                 <div class="tab-pane fade" id="deliveryPolicy" role="tabpanel">
                                                                                    <div class="tab-card scrol-lg scroll_tab">
                                                                                        {!! $deliveryPolicy->description !!}
                                                                                      </div>
                                                                                </div>
                                                                                <div class="tab-pane fade" id="returnPolicy" role="tabpanel">
                                                                                    <div class="tab-card scrol-lg scroll_tab">
                                                                                        {!! $returnPolicy->description !!}
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

        const productImgContainer = document.querySelector('.main-product-img');
        const productImg = document.querySelector('#mainProductImage');
        productImgContainer.addEventListener('mousemove', function (e) {
            const rect = productImgContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const xPercent = (x / rect.width) * 100;
            const yPercent = (y / rect.height) * 100;
            productImg.style.transformOrigin = `${xPercent}% ${yPercent}%`;
            productImg.style.transform = 'scale(2)';
        });
        productImgContainer.addEventListener('mouseleave', function () {
            productImg.style.transform = 'scale(1)';
            productImg.style.transformOrigin = 'center center';
        });

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

            addToCart(product, { sizeid: (size == '0') ? null : size, sizename: size_name == '0' ? null : size_name}, 1)
        }

        function by_now_from_detail(event) {
            const button = event.currentTarget;
            const product = JSON.parse(button.dataset.product);
            const size = document.getElementById('selected_product_size').dataset.selectedid;
            const size_name = document.getElementById('selected_product_size').dataset.selected_size_name;

            byNow(product, { sizeid: (size == '0') ? null : size, sizename: size_name == '0' ? null : size_name }, 1)
        }

    </script>
    <script src="{{ asset('assets/js/add_to_cart_from_product_card.js') }}"></script>
    <script src="{{ asset('assets/js/vue.js') }}"></script>
    <script>
        new Vue({
            el: "#review",
            data() {
                return {
                    reviewob: {
                        name: '',
                        phone: '',
                        Product_SlNo: "{{ $product->Product_SlNo }}",
                        address: '',
                        Customer_SlNo: "{{ optional(Auth::guard('customer')->user())->Customer_SlNo }}",
                        review: '',
                        stars: 0,
                    },
                    hoverstar: 0,
                    reviews: [],
                    nextUrl: null,
                    prevUrl: null

                }
            },
            created() {
                this.getAllReviews("{{ route('get_reviews') }}");
            },
            methods: {
                selectStar(star) {
                    this.reviewob.stars = star;
                    this.hoverstar = star;
                },
                hoverone(star) {
                    this.hoverstar = star;
                },
                hoverleav(star) {
                    this.hoverstar = this.reviewob.stars;
                },
                getAllReviews(url) {
                    $.ajax({
                        method: 'get',
                        url: url,
                        data: { Product_SlNo: "{{ $product->Product_SlNo }}" },
                        success: (res) => {
                            if (res.status) {
                                this.reviews = res.data.data
                                this.prevUrl = res.data.prev_page_url
                                this.nextUrl = res.data.next_page_url
                            } else {
                            }
                        },
                        error: (res) => {
                            console.log(res)
                        }
                    })
                },
                alertmessage(type, message) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: type,
                        title: message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        showClass: {
                            popup: 'animate__animated animate__fadeInRight'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutRight'
                        }
                    });
                },
                saveReview() {
                    if (this.reviewob.Customer_SlNo == null || this.reviewob.Customer_SlNo == '') {
                        if (this.reviewob.name == '' || this.reviewob.name.length < 3) {
                            this.alertmessage('error', 'Name must be more than 3 letter')
                            return;
                        }
                        if (!this.reviewob.phone || !/^(?:\+88)?01[3-9]\d{8}$/.test(this.reviewob.phone.trim())) {
                            this.alertmessage('error', 'Must Be Valid Bangladeshi Phone Number');
                            return;
                        }

                        if (this.reviewob.address == '' || this.reviewob.address.length < 3) {
                            this.alertmessage('error', 'Address must be more than 3 letter')
                            return;
                        }
                    }
                    if (parseInt(this.reviewob.stars) < 1) {
                        this.alertmessage('error', 'You must be Select Rating');
                        return;
                    }
                    if (this.reviewob.review.length == 0) {
                        this.alertmessage('error', 'Type Your Review');
                        return;
                    }

                    $.ajax({
                        method: 'post',
                        url: "{{ route('store_review') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: this.reviewob,
                        success: (res) => {
                            if (res.status) {
                                this.alertmessage('success', res.message)
                                this.getAllReviews("{{ route('get_reviews') }}");
                            } else {
                                this.alertmessage('error', res.errormessage)
                                this.getAllReviews("{{ route('get_reviews') }}");
                            }
                            this.clearForm()
                        },
                        error: (res) => {
                            console.log(res)
                        }
                    })

                },

                clearForm() {
                    this.reviewob = {
                        name: '',
                        phone: '',
                        Product_SlNo: "{{ $product->Product_SlNo }}",
                        address: '',
                        Customer_SlNo: "{{ optional(Auth::guard('customer')->user())->Customer_SlNo }}",
                        review: '',
                        stars: 0,
                    }
                    this.hoverstar = 0;
                },

                formatDate(date) {
                    const d = new Date(date);

                    return d.toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                }


            }
        })
    </script>
@endpush