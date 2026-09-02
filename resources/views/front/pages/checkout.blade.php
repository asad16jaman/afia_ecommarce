@extends('front.layout.app')

@section('title', 'Checkout Page')

@push('style')
    <style>
        .checkout-section {
            padding: 50px 0;
            background: #f8f9fa;
        }

        .checkout-form-card {
            background: #fff;
            border-radius: 3px;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        .checkout-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--nav-color);
            margin-bottom: 28px;
            position: relative;
            padding-bottom: 12px;
        }

        .checkout-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 45px;
            height: 3px;
            background: var(--color-second);
            border-radius: 10px;
        }

        .checkout-field {
            margin-bottom: 12px;
        }

        .checkout-field label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .checkout-field label .required {
            color: #e60000;
            margin-left: 2px;
        }

        .checkout-input,
        .checkout-textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 2px;
            padding: 2px 15px;
            font-size: 14px;
            color: #333;
            background: #fff;
            outline: none;
            transition: all .25s ease;
        }

        .checkout-input {
            height: 35px;
        }

        .checkout-textarea {
            min-height: 130px;
            resize: vertical;
        }

        .checkout-input::placeholder,
        .checkout-textarea::placeholder {
            color: #999;
        }

        .checkout-input:focus,
        .checkout-textarea:focus {
            border-color: var(--color-second);
            box-shadow: 0 0 0 3px rgba(12, 0, 0, 0.08);
        }

        .different-address {
            margin: 5px 0 25px;
            padding: 14px 15px;
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .different-address .form-check {
            margin: 0;
            min-height: auto;
        }

        .different-address .form-check-input {
            width: 17px;
            height: 17px;
            margin-top: 2px;
            cursor: pointer;
        }

        .different-address .form-check-input:checked {
            background-color: #e60000;
            border-color: #e60000;
        }

        .different-address .form-check-label {
            font-size: 14px;
            color: #444;
            cursor: pointer;
            margin-left: 4px;
        }

        .notes-title {
            margin-top: 5px;
        }

        @media (max-width: 991px) {
            .checkout-section {
                padding: 30px 0;
            }

            .checkout-form-card {
                padding: 22px;
            }
        }

        @media (max-width: 575px) {
            .checkout-form-card {
                padding: 18px;
                border-radius: 12px;
            }

            .checkout-title {
                font-size: 21px;
            }
        }




        /* =========================
                           CHECKOUT CART
                        ========================= */

        .checkout-cart {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #eee;
        }


        /* Checkout Item */

        .checkout-cart .cart-item {
            padding: 12px 0;
        }


        /* Image size */

        .checkout-cart .cart-item-image {
            width: 65px;
            height: 65px;
        }


        /* Product name */

        .checkout-cart .cart-item-name {
            font-size: 14px;
        }


        /* Quantity + size + price */

        .checkout-cart .cart-item-bottom {
            gap: 10px;
        }


        /* Size */

        .checkout-cart .cart-item-size {
            font-size: 12px;
            color: #777;
        }


        /* Summary */

        .checkout-summary {
            margin-top: 15px;
            border-top: 1px solid #eee;
        }

        .checkout-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .checkout-summary-row strong {
            color: #e60000;
        }


        /* Shipping */

        .checkout-shipping {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .checkout-shipping-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
            font-size: 14px;
        }

        .checkout-shipping-option-left {
            display: flex;
            align-items: center;
            gap: 7px;
        }


        /* Total */

        .checkout-total {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;

            font-size: 16px;
            font-weight: 600;
        }

        .checkout-total-price {
            color: #e60000;
            font-size: 18px;
            font-weight: 700;
        }


        /* Payment */

        .checkout-payment {
            margin-top: 15px;
        }

        .checkout-payment-option {
            display: flex;
            align-items: center;
            gap: 8px;

            padding: 8px 0;

            font-size: 14px;
        }

        .checkout-payment-info {
            padding: 12px;
            margin: 3px 0 8px;

            background: #fafafa;
            border-radius: 6px;

            font-size: 13px;
            color: #555;
        }


        /* Order Button */

        .checkout-place-order {
            width: 100%;
            border: 0;

            padding: 11px;
            margin-top: 10px;

            border-radius: 6px;

            background: var(--nav-color);
            color: #fff;

            font-size: 16px;
            font-weight: 600;

            transition: .25s;
        }

        .checkout-place-order:hover {
            background: var(--color-second);
        }


        .shipment-row {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            border: 1px solid #eee;
        }

        .shipment-title {
            flex-shrink: 0;
            white-space: nowrap;

            font-size: 14px;
            color: #333;
        }

        .shipment-options {
            flex: 1;
            min-width: 0;
        }

        .shipment-option {
            display: flex;
            align-items: center;
            justify-content: end;
            width: 100%;
            margin-bottom: 7px;
            font-size: 14px;
            gap: 10px;
        }

        .shipment-option:last-child {
            margin-bottom: 0;
        }

        .shipment-option label {
            cursor: pointer;
    min-width: 130px;
        }

        .shipment-option input {
            width: 15px;
            height: 15px;

            cursor: pointer;
            flex-shrink: 0;
        }

        .order-total {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-top: 8px;
            padding: 15px 0;

            border-top: 1px solid #ddd;
        }

        .order-total h5 {
            margin: 0;

            font-size: 17px;
            font-weight: 600;

            color: #222;
        }

        .order-total strong {
            font-size: 21px;
            font-weight: 700;

            color: var(--nav-color);
        }


        /* Order Now Button */

        .order-now-btn {
            display: block;

            width: 100%;

            border: 0;
            border-radius: 6px;

            padding: 12px 15px;

            background: var(--nav-color);
            color: #fff;

            font-size: 16px;
            font-weight: 600;

            text-align: center;
            text-decoration: none;

            transition: all .25s ease;
        }

        .order-now-btn:hover {
            background: var(--color-second);
            color: #fff;
        }

        .order_summary_card {
            border: none;
            box-shadow: 0px 0px 7px 0px #00000040;
            border-radius: 0px;
        }

        .order_summary {
            font-size: 24px;
            font-weight: 700;
            color: var(--nav-color);
            position: relative;
        }

        .cart-item-size {
            font-size: 13px;
            font-weight: 900;
        }
        .is-invalid{
            border: 1px solid red;
        }
        .error_message{
            font-size: 10px;
    color: red;
        }
    </style>
@endpush

@section('content')

    <section class="checkout-section header_margin">
        <div class="container">
            <form action="{{ route('store_order') }}" method="post">
                @csrf
                <div class="row g-4">
                    {{-- LEFT : BILLING DETAILS --}}
                    <div class="col-lg-6 col-12">
                        <div class="checkout-form-card">
                            <h2 class="checkout-title">
                                BILLING DETAILS
                            </h2>
                            {{-- Name --}}
                            <div class="checkout-field">
                                <label for="customer_name">
                                    আপনার নাম
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="customer_name" value="{{ old('customer_name', optional(Auth::guard("customer")->user())->Customer_Name) }}" name="customer_name" class="checkout-input @error('customer_name') is-invalid  @enderror"
                                    placeholder="আপনার নাম লিখুন">
                                @error('customer_name')
                                    <strong class="error_message">{{ $message }}</strong>
                                @enderror
                            </div>
                            {{-- Mobile --}}
                            <div class="checkout-field">
                                <label for="customer_mobile">
                                    মোবাইল নাম্বার
                                    <span class="required">*</span>
                                </label>
                                <input type="tel" id="customer_mobile" value="{{ old('customer_mobile', optional(Auth::guard("customer")->user())->Customer_Mobile) }}" name="customer_mobile" class="checkout-input  @error('customer_mobile') is-invalid  @enderror"
                                    placeholder="মোবাইল নাম্বার লিখুন">
                                @error('customer_mobile')
                                    <strong class="error_message">{{ $message }}</strong>
                                @enderror
                            </div>
                            {{-- Address --}}
                            <div class="checkout-field">
                                <label for="customer_address">
                                    সম্পূর্ণ ঠিকানা
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="customer_address" value="{{ old('customer_address', optional(Auth::guard("customer")->user())->Customer_Address) }}" name="customer_address" class="checkout-input  @error('customer_address') is-invalid  @enderror"
                                    placeholder="গ্রামঃ , থানাঃ , জেলার নাম লিখুন">
                                @error('customer_address')
                                    <strong class="error_message">{{ $message }}</strong>
                                @enderror
                            </div>
                            {{-- Order Notes --}}
                            <div class="checkout-field notes-title">
                                <label for="order_notes">
                                    Order notes
                                    <span class="text-muted fw-normal">
                                        (optional)
                                    </span>
                                </label>
                                <textarea id="order_notes" name="order_notes" class="checkout-textarea @error('order_notes') is-invalid  @enderror"
                                    placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('order_notes') }}</textarea>
                                    @error('order_notes')
                                        <strong class="error_message">{{ $message }}</strong>
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card order_summary_card">
                            <div class="card-body">
                                <h5 class="text-center order_summary">Order Summary</h5 class="text-center">
                                <hr>
                                <div id="card_summary_item_container">
                                    @foreach ($cart as $key => $c_item)
                                        <div class="cart-item">
                                            <div class="cart-item-image">
                                                <img src="{{ $c_item['image'] }}" alt="Product">
                                            </div>
                                            <div class="cart-item-content">
                                                <div class="cart-item-top">
                                                    <div class="cart-item-name">
                                                        {{ $c_item['name'] }}
                                                    </div>
                                                </div>
                                                <div class="cart-item-bottom">
                                                    <div class="cart-quantity">
                                                        <button class="qty-btn" type="button"
                                                            onclick="decreaseFromSummary('{{ $key }}',{{ $c_item['qty'] }})">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                        <span class="qty-value">{{ $c_item['qty'] }}</span>
                                                        <button class="qty-btn" type="button"
                                                            onclick="increaseFromSummary('{{ $key }}',{{ $c_item['qty'] }})">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="cart-item-size">
                                                        @if($c_item['size_name'])
                                                            Size: {{ $c_item['size_name'] }}
                                                        @endif

                                                    </div>
                                                    <div class="cart-item-price">
                                                        {{ $c_item['price'] }} X {{ $c_item['qty'] }} = {{ number_format((int) $c_item['total_price'] * (int) $c_item['qty'], 2)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="subtotal order-total d-flex justify-content-between py-2">
                                    <h5>Subtotal</h5>
                                    <strong id="subtotal" data-subtotal="{{ $subtotal }}">৳{{ number_format($subtotal, 2) }}</strong>
                                </div>
                                <div class="shipment-row">
                                    {{-- Shipment Title --}}
                                    <div class="shipment-title">
                                        Shipping Charge
                                    </div>
                                    {{-- Shipment Options --}}
                                    <div class="shipment-options">
                                        <div class="shipment-option">
                                            <input type="radio" name="shipment" id="inside_dhaka" value="{{ $setting->insite_dhaka }}" checked>
                                            <label for="inside_dhaka">
                                                ঢাকার ভিতর: <strong>{{ $setting->insite_dhaka }}৳</strong>
                                            </label>

                                        </div>
                                        <div class="shipment-option">
                                            <input type="radio" name="shipment" id="outside_dhaka" value="{{ $setting->outsite_dhaka }}">
                                            <label for="outside_dhaka">
                                                ঢাকার বাহিরে: <strong>{{ $setting->outsite_dhaka }}৳</strong>
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="order-total">
                                    <h5>Total</h5>
                                    <strong id="trandTotal">
                                        ৳ {{ number_format($subtotal + $setting->insite_dhaka, 2) }}
                                    </strong>
                                </div>
                                <input type="submit" value="Order Now" class="order-now-btn">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

@push('script')
    <script>

        function createSummeryCartItem(key, ob) {
            return `<div class="cart-item">
                    <div class="cart-item-image">
                        <img src="${ob.image}" alt="Product">
                    </div>
                    <div class="cart-item-content">
                        <div class="cart-item-top">
                            <div class="cart-item-name">
                                ${ob.name}
                            </div>
                        </div>
                        <div class="cart-item-bottom">
                            <div class="cart-quantity">
                                <button type="button" class="qty-btn" onclick="decreaseFromSummary('${key}',${ob.qty})">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span  class="qty-value">${ob.qty}</span>
                                <button type="button" class="qty-btn" onclick="increaseFromSummary('${key}',${ob.qty})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <div class="cart-item-size">
                                ${ob.size_name ? 'Size: '+ob.size_name : ''}
                            </div>
                            <div class="cart-item-price">
                                ${ob.price} X ${ob.qty} = ${(ob.total_price * ob.qty).toFixed(2)}
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        function generate_summary_cart(ob){
            let card_code2 = ''
            for (const key in ob.cart) {
                const item2 = ob.cart[key];
                card_code2 += createSummeryCartItem(key, item2);
            }
            $('#card_summary_item_container').html(card_code2)
            $('#subtotal').html("৳"+ob.subtotal.toFixed(2)).attr('data-subtotal', ob.subtotal);

            let shipping = parseInt($('input[name="shipment"]:checked').val());
            let total = parseInt(ob.subtotal) + shipping;
            $('#trandTotal').html("৳"+total.toFixed(2));
        }

        function get_cart2() {
                $.ajax({
                    url: "{{ route('cart.get') }}",
                    type: "get",
                    success: function (res) {
                        if (res.success) {
                            generate_summary_cart(res)
                        }
                    },
                    error: function (xhr) {
                        console.error("Add to cart error:", xhr.responseText);
                    }
                });
            }

        function increaseFromSummary(key,qty){
            card_increase(key,qty)
            get_cart2()
        } 

        function decreaseFromSummary(key,qty){
            if (qty <= 1) {
                    return;
            }
            card_decrease(key,qty)
            get_cart2()
        }

        $(document).on('change', 'input[name="shipment"]', function () {
                let subtotal = parseFloat($('#subtotal').attr('data-subtotal')) || 0;
                let shipping = parseFloat($(this).val()) || 0;
                let total = subtotal + shipping
                $('#trandTotal').html("৳"+total.toFixed(2));
            });

    </script>
@endpush