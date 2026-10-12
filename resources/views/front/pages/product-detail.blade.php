@extends('front.layout.app')
@section('title', $product->Product_Name)
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}" />
    <style>
        .detail_off {
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
        .scroll_tab {
            max-height: 760px;
            overflow-y: scroll;
            text-align: justify;
        }
        .desTab ul {
            padding-left: 32px;
            list-style: disc !important;
        }
        .swal2-actions{
            margin-top: 0px;
        }
        .my-swal-text {
            font-size: 16px !important;
            color: #333 !important;
        }

        .my-swal-button {
            font-size: 14px !important;
            color: #fff !important;
            background: #000 !important;
            padding: 8px 20px !important;
            border-radius: 5px !important;
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
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('category.products', ['slug' => $product->category->slug]) }}">{{ $product->category->ProductCategory_Name }}
                                </a>
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
                            @if($product->product_images->isNotEmpty() && $product->product_images->first()->image)
                                <img src="{{ $softUrl . $product->product_images->first()->image }}" id="mainProductImage"
                                    class="img-fluid product-img" alt="{{ $product->Product_Name }}">
                            @else
                                <img src="{{  asset('assets/images/product_default.png')  }}" id="mainProductImage"
                                    class="img-fluid product-img" alt="{{ $product->Product_Name }}">
                            @endif
                        </div>
                        <div class="swiper thumb-slider mt-4">
                            <div class="swiper-wrapper">
                                @foreach ($product->product_images as $img)
                                    <div class="swiper-slide">
                                        <img src="{{ $softUrl . $img->image }}" class="thumb-img"
                                            data-img="{{ $softUrl . $img->image }}">
                                    </div>
                                @endforeach

                            </div>
                            <div class="swiper-button-prev thumb-prev"></div>
                            <div class="swiper-button-next thumb-next"></div>
                        </div>
                        @if($product->youtube_link)
                            <div class="card">
                                <div class="card-body">
                                    <iframe width="100%" height="400" src="{{ $product->youtube_link }}?autoplay=1&mute=1&loop=1"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; 
                                                                                                                                                                                picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen> </iframe>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-7">
                        <div class="ms-lg-4" id="detailProduct">
                            {{-- <div class="mb-3 d-flex align-items-center gap-3 flex-wrap">
                                <span class="premium-badge">
                                    @if($product->new_arrival)
                                        New Arrival
                                    @elseif($product->popular_product)
                                        Popular Product
                                    @else
                                        Product
                                    @endif
                                </span>
                            </div> --}}
                            <h1 class="fw-bold product-title mb-2">{{ $product->Product_Name }}</h1>
                            <div class="price mb-4">
                                @if($product->Product_SellingPrice > $minSellPrice)
                                    <span class="old-price">{{ $product->Product_SellingPrice }}{{ $currency }}</span>
                                @else
                                    <span class="">Selling Price : </span>
                                @endif
                                <span class="current-price">{{ $minSellPrice }}{{ $currency }}</span>
                                @if($discount > 0)
                                    <span class="detail_off">
                                        {{ $discount }} % OFF
                                    </span>
                                @endif
                            </div>
                            <p class="authentic mb-2">100% Authentic Product</p>
                            <p class="mb-2"><strong>SKU</strong> : {{ optional($product)->Product_Code }}</p>
                            <p class="mb-2"><strong>Brand</strong> : {{ optional($product->p_brand)->brand_name }}</p>
                            <p class="mb-2"><strong>Color</strong> : {{ optional($product->color)->Color_Name }}</p>
                            
                            <div class="mt-4" v-if="product.have_size"  style="visibility:hidden" :style="{visibility:ismount ? 'visible' : ''}" >
                                <div v-if="sizes.length > 0">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="fw-semibold">Select Size</span>
                                        <!-- <a href="#" class="weight-guide">Weight Guide</a> -->
                                    </div>
                                    <div class="d-flex gap-2 flex-wrap" id="selected_product_size">
                                        <button v-for="size in sizes" :key="size.Size_SlNo" class="weight-btn weight-btn_fun"
                                            :class="{ active: selectedSize && selectedSize.Size_SlNo == size.Size_SlNo }" @click="selectSizeMethod(size)">
                                            @{{ size.Size_Name }}
                                        </button>
                                    </div>
                                </div>
                                <div v-else>
                                    <span class="text-danger fw-semibold">Stock Out</span>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex gap-3">
                                    <button class="detail_page_addToCard"
                                        @click="add_to_cart('addCard')">
                                        <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                                    </button>
                                    <button class="detail_page_byNow" @click="add_to_cart('byNow')">
                                        <i class="fa fa-shopping-bag me-1"></i> Order Now
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
                                        <button class="nav-link" id="delvery-tab" data-bs-toggle="tab"
                                            data-bs-target="#deliveryPolicy" type="button" role="tab">
                                            {{ $deliveryPolicy->title }}
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="return-tab" data-bs-toggle="tab"
                                            data-bs-target="#returnPolicy" type="button" role="tab">
                                            {{  $returnPolicy->title }}
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <!-- Description -->
                                    <div class="tab-pane fade  show active" id="description" role="tabpanel">
                                        <div class="tab-card scrol-lg desTab">
                                            {!! $product->Product_description !!}
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

        const thumbSlider = new Swiper(".thumb-slider", {
            slidesPerView: 5,
            slidesPerGroup: 1,
            spaceBetween: 10,
            loop: false,
            navigation: {
                nextEl: ".thumb-next",
                prevEl: ".thumb-prev",
            },
            breakpoints: {
                0: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 7,
                }
            }
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
    </script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue.js') }}"></script>
    <script>
        new Vue({
            el: "#detailProduct",
            data() {
                return {
                    cart_product: @json($cart_product),
                    product: @json($product),
                    sizes: [],
                    selectedSize: null,
                    ismount:false
                }
            },
            created() {

               if(this.product.have_size){
                    if(this.product.stocks.length > 0){
                        this.selectSizeMethod(this.product.stocks[0])
                    }
                    this.sizes = this.product.stocks;
                }


            },
            methods: {

                selectSizeMethod(ob) {
                    this.selectedSize = ob
                },

                firemessage(message){
                    Swal.fire({
                                    text: message,
                                    customClass: {
                                        popup: 'my-swal-popup',
                                        title: 'my-swal-title',
                                        htmlContainer: 'my-swal-text',
                                        confirmButton: 'my-swal-button'
                                    }
                                    });
                },
                add_to_cart(type){
                     if(this.product.have_size){
                        if(this.selectedSize == null ){
                            this.firemessage('You Need To Select Size')
                             return 
                        }
                    }
                    let size;

                    if(this.selectedSize){
                         size = {
                           size_id : this.selectedSize.Size_SlNo,
                           size_name : this.selectedSize.Size_Name
                        }
                    }else{
                         size = {
                            size_id : null,
                            size_name : null
                        }
                    }
                    if(type == 'byNow'){
                        byNow(this.cart_product, size, 1);
                    }else{
                        addToCart(this.cart_product, size, 1);
                    }
                },
            },
            mounted(){
                this.ismount = true
            }
        })
    </script>

    <script>

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
    </script>
@endpush