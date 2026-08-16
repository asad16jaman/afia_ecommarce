<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.webp') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/swift.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri&display=swap" rel="stylesheet">
    <style>
        
    </style>
    @stack('style')
</head>

<body>

    <!-- header section start -->
    @include('front.partials.header')
    <!-- header section end -->



    @yield('content')

    <!-- footer section start -->
    @include('front.partials.footer')
    <!-- footer section end -->

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">
                Shopping Cart
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
            </button>
        </div>
    
        <div class="offcanvas-body p-0">
            <div class="cart-items" id="cart_itemContainer">
                {{-- Cart Item --}}
            </div>
        </div>
        {{-- Cart Footer --}}
        <div class="cart-footer border-top">
            <div class="cart-subtotal">
                <span>Subtotal</span>
                <strong id="item_subtotal">৳ 7,050</strong>
            </div>
            <a href="{{ route('checkout_page') }}" class="cart-checkout-btn">
                Proceed to Checkout
            </a>
        </div>
    </div>

    <!-- all script -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper12.2.js') }}"></script>
    <script src="{{ asset('assets/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        if (window.innerWidth < 992) {
            document.querySelectorAll(".submenu-toggle").forEach(function (item) {
                item.addEventListener("click", function (e) {
                    e.preventDefault();
                    let submenu = this.nextElementSibling;
                    submenu.classList.toggle("show");
                });
            });
        }

        function product_count(count = 0){
            document.getElementById('product_count').innerHTML = count;
        }

        function create_cart_item(key,ob){
            return `<div class="cart-item" >
                    <div class="cart-item-image">
                        <img src="${ob.image}" alt="Product">
                    </div>
                    <div class="cart-item-content">
                        <div class="cart-item-top">
                            <div class="cart-item-name">
                                ${ob.name}
                            </div>
                            <button type="button" class="cart-remove-btn" onclick="item_delete('${key}')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                        <div class="cart-item-bottom">
                            <div class="cart-quantity">
                                <button type="button" class="qty-btn ${(ob.qty <= 1) ? 'disableBtn' : ''}" onclick="card_decrease('${key}',${ob.qty})">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="qty-value">${ ob.qty }</span>
                                <button type="button" class="qty-btn" onclick="card_increase('${key}',${ob.qty})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <div>
                                <span>Size: ${ob.size_name}</span>
                            </div>
                            <div class="cart-item-price">
                                ৳ ${ob.price}
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        function generate_cart(ob){
            let card_code = ''
            for (const key in ob.cart) {
                const item = ob.cart[key];
                card_code += create_cart_item(key,item);
            }
            $('#cart_itemContainer').html(card_code)
            $('#item_subtotal').html(ob.subtotal);
            product_count(ob.count)
        }

        function get_cart(){
                $.ajax({
                url: "{{ route('cart.get') }}",
                type: "get",
                success: function (res) {
                    if (res.success) {
                        generate_cart(res)
                    }
                },
                error: function (xhr) {
                    console.error("Add to cart error:", xhr.responseText);
                }
            });
        }
        get_cart()
        function update_cart(url,data){
            $.ajax({
                url:url,
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        get_cart()
                    }
                },
                error: function (xhr) {
                    console.error("Add to cart error:", xhr.responseText);
                }
            });
        }
        function card_increase(key, current) {
                let data = {
                    key: key,
                    qty: current + 1
                }
                let url = "{{ route('cart.updat') }}";
                update_cart(url, data)
            }

        function card_decrease(key, current) {
                if (current <= 1) {
                    return;
                }
                let data = {
                    key: key,
                    qty: current - 1
                }
                let url = "{{ route('cart.updat') }}";
                update_cart(url, data)
            }
        function item_delete(key){
            let url = "{{ route('cart.delete') }}";
            update_cart(url, {key:key})
        }

    </script>


    <script>
        function addToCart(product, size, qty = 1) {
            const data = {
                product_id: product.Product_SlNo,
                size: size.sizeid,
                size_name: size.sizename,
                price: product.Product_MinimumSellingPrice,
                qty: qty,
                name: product.Product_Name,
                img: product.thum_image
            };
            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {

                        get_cart()
                        // console.log("Cart:", res.cart);
                        // console.log("Count:", res.count);
                        // console.log("Subtotal:", res.subtotal);
                        
                        // $('.cart-count').text(res.count);

                    }
                },

                error: function (xhr) {
                    console.error("Add to cart error:", xhr.responseText);
                }
            });
        }

        



    </script>

    
      <script>
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: @json(session('success')),
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
    @endif

    @if(session('error'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: @json(session('error')),
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
    @endif
</script>
   


    @stack('script')
</body>

</html>