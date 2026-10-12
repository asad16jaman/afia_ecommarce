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

            .is-invalid {
                border: 1px solid red;
            }

            .error_message {
                font-size: 10px;
                color: red;
            }
        </style>

        <style>
            .previous-paid-card {
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                overflow: hidden;
                background: #fff;
            }

            .previous-paid-header {
                padding: 14px 16px;
                background: #f8fafc;
                border-bottom: 1px solid #e5e7eb;
            }
            .previous-paid-header h6 {
                margin: 0;
                font-size: 16px;
                font-weight: 600;
                color: #1f2937;
            }
            .previous-paid-header h6 i {
                color: #198754;
            }

            .previous-paid-header small {
                color: #6b7280;
                font-size: 12px;
            }
            .previous-paid-body {
                padding: 16px;
            }
            .paid-field label {
                display: block;
                margin-bottom: 7px;
                font-size: 13px;
                font-weight: 600;
                color: #374151;
            }
            .paid-field .input-group-text {
                background: #f8fafc;
                border-color: #dfe3e8;
                font-weight: 600;
                color: #198754;
            }
            .paid-field .form-control {
                border-color: #dfe3e8;
                box-shadow: none;
            }
            .paid-field .form-control:focus {
                border-color: #198754;
                box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.08);
            }
            .upload-box {
                position: relative;
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px;
                border: 1px dashed #cbd5e1;
                border-radius: 9px;
                background: #fafafa;
                transition: 0.2s ease;
                flex-wrap: wrap;
            }
            .upload-box:hover {
                border-color: #198754;
                background: #f8fffb;
            }
            .upload-box>i {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                background: #e9f7ef;
                color: #198754;
                font-size: 20px;
            }
            .upload-content {
                display: flex;
                flex-direction: column;
                flex: 1;
            }
            .upload-content strong {
                font-size: 13px;
                color: #374151;
            }
            .upload-content small {
                margin-top: 2px;
                color: #9ca3af;
                font-size: 11px;
            }
            .upload-box input[type="file"] {
                width: auto;
                max-width: 170px;
                font-size: 11px;
                border: 0;
                background: transparent;
                border: 1px dotted #00082d8f;
            }
            .payment-note {
                margin-top: 14px;
                padding: 9px 11px;
                border-radius: 7px;
                background: #f8fafc;
                color: #6b7280;
                font-size: 11px;
                line-height: 1.5;
            }
            .payment-image-preview {
                margin-top: 12px;
                padding: 10px;
                border: 1px solid #e5e7eb;
                border-radius: 9px;
                background: #fafafa;
            }
            .payment-image-preview.d-none {
                display: none !important;
            }
            .preview-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 8px;
                font-size: 12px;
                font-weight: 600;
                color: #374151;
            }
            .preview-header span i {
                color: #198754;
            }
            .preview-header button {
                width: 26px;
                height: 26px;
                padding: 0;
                border: none;
                border-radius: 50%;
                background: #fee2e2;
                color: #dc2626;
                cursor: pointer;
            }
            .preview-header button:hover {
                background: #fecaca;
            }
            .payment-image-preview img {
                display: block;
                width: 100%;
                max-height: 300px;
                object-fit: contain;
                border-radius: 7px;
                border: 1px solid #e5e7eb;
                background: #fff;
            }
            .order-error-popup {
                border-radius: 18px;
                padding: 12px 12px;
            }
            .order-contact-icons {
                display: flex;
                justify-content: center;
                gap: 18px;
                margin: 10px 0 22px;
            }
            .contact-icon {
                width: 55px;
                height: 55px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 27px;
                color: #fff !important;
                text-decoration: none !important;
                transition: transform .2s ease;
            }

            .contact-icon:hover {
                transform: scale(1.1);
            }

            .contact-icon.whatsapp {
                background: #25D366;
            }

            .contact-icon.phone {
                background: #0d6efd;
            }

        .order-error-message {
            font-size: 15px;
            line-height: 1.7;
            color: #555;
            margin: 0;
        }
        </style>
@endpush

@section('content')

    <section class="checkout-section header_margin">
        <div class="container">
            <form action="{{ route('store_order') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    {{-- LEFT : BILLING DETAILS --}}
                    <div class="col-lg-6 col-12">
                        <div class="checkout-form-card">
                            <h2 class="checkout-title">
                                BILLING DETAILS
                            </h2>
                            <div class="checkout-field">
                                <label for="customer_name">
                                    আপনার নাম
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="customer_name"
                                    value="{{ old('customer_name', optional(Auth::guard("customer")->user())->Customer_Name) }}"
                                    name="customer_name"
                                    class="checkout-input @error('customer_name') is-invalid  @enderror"
                                    placeholder="আপনার নাম লিখুন">
                                @error('customer_name')
                                    <strong class="error_message">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="checkout-field">
                                <label for="customer_mobile">
                                    মোবাইল নাম্বার
                                    <span class="required">*</span>
                                </label>
                                <input type="tel" id="customer_mobile"
                                    value="{{ old('customer_mobile', optional(Auth::guard("customer")->user())->Customer_Mobile) }}"
                                    name="customer_mobile"
                                    class="checkout-input  @error('customer_mobile') is-invalid  @enderror"
                                    placeholder="মোবাইল নাম্বার লিখুন">
                                @error('customer_mobile')
                                    <strong class="error_message">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="checkout-field">
                                <label for="customer_address">
                                    সম্পূর্ণ ঠিকানা
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="customer_address"
                                    value="{{ old('customer_address', optional(Auth::guard("customer")->user())->Customer_Address) }}"
                                    name="customer_address"
                                    class="checkout-input  @error('customer_address') is-invalid  @enderror"
                                    placeholder="গ্রামঃ , থানাঃ , জেলার নাম লিখুন">
                                @error('customer_address')
                                    <strong class="error_message">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="checkout-field notes-title">
                                <label for="order_notes">
                                    অর্ডার নোট
                                    <span class="text-muted fw-normal">
                                        (optional)
                                    </span>
                                </label>
                                <textarea id="order_notes" name="order_notes"
                                    class="checkout-textarea @error('order_notes') is-invalid  @enderror"
                                    placeholder="আপনার অর্ডার সম্পর্কে কোনো বিশেষ নির্দেশনা থাকলে এখানে লিখুন, যেমন—ডেলিভারি সংক্রান্ত বিশেষ অনুরোধ।">{{ old('order_notes') }}</textarea>
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
                                                        {{ $c_item['price'] }} X {{ $c_item['qty'] }} =
                                                        {{ number_format((int) $c_item['total_price'] * (int) $c_item['qty'], 2)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="subtotal order-total d-flex justify-content-between py-2">
                                    <h5>Subtotal</h5>
                                    <strong id="subtotal"
                                        data-subtotal="{{ $subtotal }}">৳{{ number_format($subtotal, 2) }}</strong>
                                </div>
                                <div class="shipment-row">
                                    <div class="shipment-title">
                                        Shipping Charge
                                    </div>
                                    <div class="shipment-options">
                                        <div class="shipment-option">
                                            <input type="radio" name="shipment" id="inside_dhaka"
                                                value="{{ $setting->insite_dhaka }}" checked>
                                            <label for="inside_dhaka">
                                                ঢাকার ভিতর: <strong>{{ $setting->insite_dhaka }}৳</strong>
                                            </label>
                                        </div>
                                        <div class="shipment-option">
                                            <input type="radio" name="shipment" id="outside_dhaka"
                                                value="{{ $setting->outsite_dhaka }}">
                                            <label for="outside_dhaka">
                                                ঢাকার বাহিরে: <strong>{{ $setting->outsite_dhaka }}৳</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @guest('customer')
                                    <div class="shipment-row">
                                        <div class="shipment-title">
                                            <div class="shipment-option">
                                                <input type="radio" name="checkout_type" id="new_user" value="new_user" checked>
                                                <label for="new_user">
                                                    Create An Account
                                                </label>
                                            </div>
                                            <div class="shipment-option">
                                                <input type="radio" name="checkout_type" id="guest" value="guest">
                                                <label for="guest">
                                                    checkout As Guast
                                                </label>
                                            </div>
                                        </div>
                                        <div class="shipment-options" id="idField">
                                            <div>
                                                <input type="password" name="password" value="{{ old('password') }}"
                                                    placeholder="Type Password" id="passoredId"
                                                    class="checkout-input @error('password') is-invalid  @enderror">
                                                @error('password')
                                                    <strong class="error_message">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                @endguest

                                <div class="order-total">
                                    <h5>Total</h5>
                                    <strong id="trandTotal">
                                        ৳ {{ number_format($subtotal + $setting->insite_dhaka, 2) }}
                                    </strong>
                                </div>
                                @if($setting->advance_order)
                                    <div class="previous-paid-card mb-4">
                                        <div class="previous-paid-header">
                                            <div>
                                                <h6 class="mb-1">
                                                    <i class="bi bi-receipt me-2"></i>
                                                    Previous Paid Document
                                                </h6>
                                                <small>
                                                    If you have already paid, provide the payment details below.
                                                </small>
                                            </div>
                                        </div>
                                        <div class="previous-paid-body">
                                            <div class="paid-field">
                                                <label for="paid_amount">
                                                    Paid Amount
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">৳</span>
                                                    <input type="number" name="paid_amount" id="paid_amount" class="form-control"
                                                        placeholder="Enter paid amount" min="0" value="{{ old('paid_amount') }}" step="1">
                                                </div>
                                                @error('paid_amount')
                                                    <strong class="error_message">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                            <div class="paid-field mt-3">
                                                <label for="payment_document">
                                                    Payment Screenshot
                                                </label>
                                                <div class="upload-box">
                                                    <i class="bi bi-cloud-arrow-up"></i>

                                                    <div class="upload-content">
                                                        <strong>Upload payment screenshot</strong>
                                                        <small>
                                                            Payment confirmation screenshot
                                                        </small>
                                                    </div>
                                                    <input type="file" name="payment_document" id="payment_document" class="form-control" accept="image/*"
                                                        onchange="previewPaymentImage(this)">
                                                </div>
                                                @error('payment_document')
                                                    <strong class="error_message">{{ $message }}</strong>
                                                @enderror

                                                <!-- Image Preview -->
                                                <div id="paymentImagePreview" class="payment-image-preview d-none">
                                                    <div class="preview-header">
                                                        <span>
                                                            <i class="bi bi-image me-1"></i>
                                                            Selected Image
                                                        </span>
                                                        <button type="button" onclick="removePaymentImage()">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                    <img id="paymentPreviewImg" src="" alt="Payment Screenshot Preview">
                                                </div>
                                            </div>
                                            {{-- Optional Note --}}
                                            <div class="payment-note">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Please make sure the paid amount and payment screenshot are clear.
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                                                ${ob.color_name ? 'Size: ' + ob.color_name : ''}
                                            </div>
                                            <div class="cart-item-size">
                                                ${ob.size_name ? 'Size: ' + ob.size_name : ''}
                                            </div>
                                            <div class="cart-item-price">
                                                ${ob.price} X ${ob.qty} = ${(ob.total_price * ob.qty).toFixed(2)}
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
        }

        function generate_summary_cart(ob) {
            let card_code2 = ''
            for (const key in ob.cart) {
                const item2 = ob.cart[key];
                card_code2 += createSummeryCartItem(key, item2);
            }
            $('#card_summary_item_container').html(card_code2)
            $('#subtotal').html("৳" + ob.subtotal.toFixed(2)).attr('data-subtotal', ob.subtotal);

            let shipping = parseInt($('input[name="shipment"]:checked').val());
            let total = parseInt(ob.subtotal) + shipping;
            $('#trandTotal').html("৳" + total.toFixed(2));
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

        function increaseFromSummary(key, qty) {
            card_increase(key, qty)
            get_cart2()
        }

        function decreaseFromSummary(key, qty) {
            if (qty <= 1) {
                return;
            }
            card_decrease(key, qty)
            get_cart2()
        }

        $(document).on('change', 'input[name="shipment"]', function () {
            let subtotal = parseFloat($('#subtotal').attr('data-subtotal')) || 0;
            let shipping = parseFloat($(this).val()) || 0;
            let total = subtotal + shipping
            $('#trandTotal').html("৳" + total.toFixed(2));
        });

        $(document).on('change', 'input[name="checkout_type"]', function () {
            if ($("input[name='checkout_type']:checked").val() == 'guest') {
                $("#idField").hide()
            } else {
                $("#idField").show()
            }
        });

        function previewPaymentImage(input) {
            const previewBox = document.getElementById('paymentImagePreview');
            const previewImg = document.getElementById('paymentPreviewImg');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file.');
                    input.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewBox.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        }

        function removePaymentImage() {
            const input = document.getElementById('payment_document');
            const previewBox = document.getElementById('paymentImagePreview');
            const previewImg = document.getElementById('paymentPreviewImg');
            input.value = '';
            previewImg.src = '';
            previewBox.classList.add('d-none');
        }





    </script>

    @if(session('notify'))
           <script>
                Swal.fire({
                        title: 'Order Cannot Proceed',
                        html: `
                <div class="order-contact-icons">
                    <a href="https://wa.me/{{ $setting->whatsapp }}" target="_blank" class="contact-icon whatsapp" title="WhatsApp Admin">
                        <i class="fab fa-whatsapp"></i>
                    </a>

                    <a href="tel:{{ $setting->phone }}" class="contact-icon phone" title="Call Admin">
                        <i class="fas fa-phone-alt"></i>
                    </a>
                </div>

                <p class="order-error-message">
                    ${@json(session('notify'))}
                </p>
                `,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545',
                        showCloseButton: true,
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'order-error-popup'
                        }
                    });
           </script>
    @endif
@endpush