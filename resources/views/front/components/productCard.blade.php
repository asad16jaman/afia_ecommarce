<div class="product-card ">
    <a href="{{ route('get_product_detail', ['slug' => 'sdlkj']) }}">
        <div class="product-image">
            <span class="discount-badge">30% OFF</span>
            <img src="{{ asset($img) }}" alt="">
        </div>
    </a>
    <div class="product-content text-center">
        <a href="{{ route('get_product_detail', ['slug' => 'sdlkj']) }}">
            <h4>{{ $name }}</h4>
            <div class="product_price_container">
            
                <span class="price">
                    ৳ {{ $sell_price }}
                </span>
                <span>
                    <del>৳ {{ $price }}</del>
                </span>
            </div>
        </a>
        <div class="d-flex flex-column flex-lg-row justify-content-around mt-2">
            <a href="javascript:void(0)" class="addToCart_css"><i class="bi bi-cart-plus"></i> Add To Cart</a>
            <a href="javascript:void(0)" class="buyNow_css"><i class="bi bi-bag-check"></i> By Now</a>
        </div>
    </div>
</div>


