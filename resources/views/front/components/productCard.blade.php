<?php
$currentProduct = [
    'Product_SlNo' => $ob->Product_SlNo,
    'Product_MinimumSellingPrice' => $ob->Product_MinimumSellingPrice,
    'Product_Name' => $ob->Product_Name,
    'thum_image' => $ob->thum_image
]
?>

<div class="product-card">
    <a href="{{ route('get_product_detail', ['slug' => $ob->slug]) }}">
        <div class="product-image">
            @if($ob->discount)
                <span class="discount-badge">
                    {{ $ob->discount }}% OFF
                </span>
            @endif
            <!-- Loader -->
            <div class="image-loader">
                <div class="spinner"></div>
            </div>
            <!-- Product Image -->
            <img src="{{ asset('assets/images/product_default.webp') }}"
                data-src="{{ $ob->thum_image ? $softUrl . $ob->thum_image : asset('assets/images/product_default.webp') }}"
                alt="{{ $ob->Product_Name }}" class="lazy-product-image">
        </div>
    </a>
    <div class="product-content text-center data_container" data-thiscard='@json($currentProduct)'>
        <a href="{{ route('get_product_detail', ['slug' => $ob->slug]) }}">
            <h4>{{ $ob->Product_Name }}</h4>
            <div class="product_price_container">
                <span class="price">
                    ৳ {{ number_format(ceil($ob->Product_MinimumSellingPrice), 2) }}
                </span>
                <span>
                    <del>
                        ৳ {{ number_format($ob->Product_SellingPrice, 2) }}
                    </del>
                </span>
            </div>
        </a>
        <div class="d-flex flex-column flex-lg-row flex-wrap justify-content-around mt-2">
            @if($ob->have_size)
            <a href="javascript:void(0)" class="addToCart_css" onclick="openProductSizeSelector(event,'add_to_cart')"><i
                    class="bi bi-cart-plus"></i> Order Now</a>
            @else
                <a href="javascript:void(0)" class="addToCart_css" onclick="proceedProductNonSize(event)"><i
                        class="bi bi-cart-plus"></i> Order Now</a>
            @endif
        </div>
    </div>

    {{-- Size Overlay --}}
    <div class="product-size-overlay">
        <div class="size-overlay-header">
            <span>Select Size</span>
            <button type="button" onclick="closeProductSizeSelector(event)">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="product-size-options">
            @foreach ($ob->size_wise_stock ?? [] as $size)
                <label class="product-size-option {{-- $size->current_stock <= 0 ? 'disabled' : '' --}}">
                    <input type="radio" name="product_size_{{ $ob->Product_SlNo }}" value="{{ $size->Size_SlNo }}"
                        data-size_name="{{ $size->Size_Name }}" {{-- $size->current_stock <= 0 ? 'disabled' : '' --}}>
                        <span>
                            {{ $size->Size_Name }}
                        </span>
                        <!-- //if stock check this code will be comment -->
                        <small>
                            available
                        </small>
                </label>
            @endforeach
        </div>
        <button type="button" class="size-proceed-btn proceed-add-to-cart" onclick="proceedProductSize(event)">
            <i class="bi bi-cart-plus"></i>
           Order Now
        </button>
        <button type="button" class="size-proceed-btn proceed-buy-now" onclick="proceedProductSizeByNow(event)">
            <i class="bi bi-bag-check"></i>
            Buy Now
        </button>
    </div>
    

</div>
