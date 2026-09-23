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
    </div>
</div>
