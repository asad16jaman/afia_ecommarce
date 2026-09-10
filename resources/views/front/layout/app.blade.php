<!DOCTYPE html>
<html lang="en">

<head>
    {!! optional($traking)->fb_pixel_header !!}
    {!! optional($traking)->gtm_header !!}
    {!! optional($traking)->tiktok_pixel_header !!}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ optional($setting)->Company_Name }}</title>
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
        .searchItemContainer {
            width: 100%;
            z-index: 999;
            background: #fff;
            padding: 6px;
            box-shadow: 1px 5px 16px black;
            border-radius: 5px;
        }

        .product_item {
            display: flex;
            gap: 5px;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid var(--nav-color);
            transition: 0.10s ease-in-out;
        }

        .product_item:hover {
            background-color: #00082d2b;
        }

        .search_img_container {
            width: 30px;

        }

        .search_img_container img {
            width: 100%;
        }

        .bg-active {
            background-color: #00082d2b;
        }

        .goog-te-banner-frame.skiptranslate {
			display: none !important;
		}

		.VIpgJd-ZVi9od-ORHb-OEVmcd{
			display: none;
		}

		html body {
			top: 0 !important;
		}
        .goog-te-gadget-icon{
            display: none !important;
        }
        /* .goog-te-gadget-simple {
            background-color: #f27f20 !important;
            border-left: 1px solid #f27f20 !important;
            border-top: 1px solid #f27f20 !important;
            border-bottom: 1px solid #f27f20 !important;
            border-right: 1px solid #f27f20 !important;
            font-size: 10pt;
            display: inline-block;
            padding-top: 1px;
            padding-bottom: 2px;
            cursor: pointer;
        }
        .goog-te-gadget-simple .VIpgJd-ZVi9od-xl07Ob-lTBxed {
            color: #fff !important;
        } */

        .dkuywW{
            display: none !important;
        }
        @media screen and (max-width:768px) {
            .searchItemContainer {
                left: 0;
            }
        }
    </style>
    @stack('style')
</head>

<body>
    {!! optional($traking)->tiktok_pixel_footer !!}
    {!! optional($traking)->gtm_footer !!}
    {!! optional($traking)->fb_pixel_footer !!}

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
                <strong id="item_subtotal">৳ 0</strong>
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
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper12.2.js') }}"></script>
    <script src="{{ asset('assets/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

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

        function product_count(count = 0) {
            document.getElementById('product_count').innerHTML = count;
            document.getElementById('product_count2').innerHTML = count;
        }

        function create_cart_item(key, ob) {
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
                                <span class="qty-value">${ob.qty}</span>
                                <button type="button" class="qty-btn" onclick="card_increase('${key}',${ob.qty})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <div>

                                <span>${ob.size_name ? 'Size: '+ ob.size_name : ''}</span>
                            </div>
                            <div class="cart-item-price">
                                ৳ ${ob.price}
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        function generate_cart(ob) {
            let card_code = ''
            for (const key in ob.cart) {
                const item = ob.cart[key];
                card_code += create_cart_item(key, item);
            }
            $('#cart_itemContainer').html(card_code)
            $('#item_subtotal').html(ob.subtotal.toFixed(2) + "৳");
            product_count(ob.count)
        }

        function get_cart() {
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

        function update_cart(url, data) {
            $.ajax({
                url: url,
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
        function item_delete(key) {
            let url = "{{ route('cart.delete') }}";
            update_cart(url, { key: key })
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

                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: "Added to Cart!",
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
                    }
                },
                error: function (xhr) {
                    console.error("Add to cart error:", xhr.responseText);
                }
            });
        }
        function byNow(product, size, qty = 1) {
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
                        window.location.href = "{{ route('checkout_page') }}";
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

    <script>
        let isCustomControl = false;
        let currentActiveIndex = -1;
        let allsearchObject = [];
        let soft_url_for_search = "{{ $softUrl }}";
        function searchContainerShow() {
            if (isCustomControl) {
                $('#searchItemContainer').show()
                $('#searchItemContainer2').show()
            } else {
                $('#searchItemContainer').hide()
                $('#searchItemContainer2').hide()
            }
        }
        searchContainerShow()
        function createSearchProduct(product, activeclass = null) {
            return ` <a href="/product-detail/${product.slug}">
                        <div class="product_item ${activeclass}">
                            <div class="search_img_container">
                                <img class="profileImg" src="${soft_url_for_search + product.thum_image}" alt="${product.Product_Name}">
                            </div>
                            <div class="text-truncate">${product.Product_Name}</div>
                        </div>
                    </a>`
        }
        document.getElementById('navSearchBox').addEventListener('keyup', function (e) {
            if (e.key !== 'ArrowDown' && e.key !== 'ArrowUp') {
                let p_name = e.target.value;
                $.ajax({
                    method: 'get',
                    url: "{{ route('get_search_product') }}",
                    data: { search: p_name },
                    success: function (res) {
                        if (res.status) {
                            currentActiveIndex = -1;
                            let allSearch = res.data.map((ele, ind) => {
                                let activClass = (ind == currentActiveIndex) ? 'bg-active' : ''
                                return createSearchProduct(ele, activClass);
                            })
                            allsearchObject = res.data;
                            if (allSearch.length > 0) {
                                isCustomControl = true;
                            } else {
                                isCustomControl = false;
                            }
                            document.getElementById('searchItemContainer').innerHTML = allSearch.join('')
                            searchContainerShow()
                        }
                    },
                    error: function () { },
                })
            }
        })
        document.getElementById('navSearchBox2').addEventListener('keyup', function (e) {
            if (e.key !== 'ArrowDown' && e.key !== 'ArrowUp') {
                let p_name = e.target.value;
                $.ajax({
                    method: 'get',
                    url: "{{ route('get_search_product') }}",
                    data: { search: p_name },
                    success: function (res) {
                        if (res.status) {
                            currentActiveIndex = -1;
                            let allSearch = res.data.map((ele, ind) => {
                                let activClass = (ind == currentActiveIndex) ? 'bg-active' : ''
                                return createSearchProduct(ele, activClass);
                            })
                            if (allSearch.length > 0) {
                                isCustomControl = true;
                            } else {
                                isCustomControl = false;
                            }
                            document.getElementById('searchItemContainer2').innerHTML = allSearch.join('')
                            searchContainerShow()
                        }
                    },
                    error: function () { },
                })
            }
        })
        window.addEventListener('keydown', function (e) {

            if (isCustomControl && (e.key === 'ArrowDown' || e.key === 'ArrowUp')) {
                e.preventDefault();
                if (e.key === 'ArrowDown') {
                    currentActiveIndex = (currentActiveIndex + 1) % parseInt(allsearchObject.length)

                }
                if (e.key === 'ArrowUp') {
                    currentActiveIndex = (currentActiveIndex == -1) ? parseInt(allsearchObject.length) - 1 : (currentActiveIndex - 1) % parseInt(allsearchObject.length)
                }
                let pp = allsearchObject.map((ele, ind) => {
                    let activClass = (ind == currentActiveIndex) ? 'bg-active' : ''
                    return createSearchProduct(ele, activClass);
                })
                document.getElementById('searchItemContainer').innerHTML = pp.join('')
                document.getElementById('searchItemContainer2').innerHTML = pp.join('')
            }

            if (e.key === 'Enter' && allsearchObject.length > 0) {
                if (currentActiveIndex > -1 && currentActiveIndex <= allsearchObject.length - 1) {
                    e.preventDefault()
                    let activeProduct = allsearchObject[currentActiveIndex];
                    window.location.href = `/product-detail/${activeProduct.slug}`;

                } else {

                }
            }
        }); 
    </script>
    
    <script>
        (function () {
                var options = {
                    whatsapp: "{{ optional($setting)->whatsapp }}",
                    facebook: "{{ optional($setting)->messanger }}",
                    call: "{{ optional($setting)->phone }}",
                    call_to_action: "Chat with us",
                    button_color: "#129BF4",
                    position: "right",
                    order: "whatsapp,facebook,call"
                };

                var proto = document.location.protocol,
                    host = "getbutton.io",
                    url = proto + "//static." + host;

                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = url + '/widget-send-button/js/init.js';
                s.onload = function () {
                    WhWidgetSendButton.init(host, proto, options);
                };
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            })(); 
    </script>
    <script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement(
				{
					pageLanguage: 'en',
					includedLanguages: 'en,bn',
					layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
					autoDisplay: false,
				},
				'google_translate_element'
			);
		}
	</script>
    @stack('script')
</body>

</html>