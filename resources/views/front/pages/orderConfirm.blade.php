@extends('front.layout.app')
@section('title', 'Order Details')

@push('style')
    <style>
        .com_content {
            display: flex;
            padding: 10px;
            width: 100%;
        }

       .com_content .com_address {
            font-size: 14px
        }
        .order-success-wrapper {
            position: relative;
            overflow: hidden;
            margin-bottom: 25px;
            border-radius: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #f6fff9 50%, #effff5 100%);
            border: 1px solid rgba(25, 135, 84, 0.12);
            box-shadow: 0 12px 40px rgba(25, 135, 84, 0.10);
            text-align: center;
            padding: 35px 20px 30px;
        }
        .order-success-wrapper::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(25, 135, 84, 0.07);
            top: -150px;
            left: -100px;
            animation: successFloat 5s ease-in-out infinite;
        }
        .order-success-wrapper::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(13, 110, 253, 0.04);
            right: -100px;
            bottom: -140px;
            animation: successFloat 6s ease-in-out infinite reverse;
        }
        .success-icon {
            position: relative;
            z-index: 2;
            width: 82px;
            height: 82px;
            margin: 0 auto 18px;
            border-radius: 50%;
            background: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow:
                0 0 0 10px rgba(25, 135, 84, 0.08),
                0 0 0 20px rgba(25, 135, 84, 0.04),
                0 12px 30px rgba(25, 135, 84, 0.25);
            animation: successPop 0.8s cubic-bezier(.17, .67, .32, 1.35);
        }
        .success-icon i {
            color: #fff;
            font-size: 38px;
            animation: checkDraw 0.7s ease 0.45s both;
        }
        .success-title {
            position: relative;
            z-index: 2;
            margin-bottom: 8px;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #173b2a;
            animation: successText 0.7s ease 0.25s both;
        }
        .success-message {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
            color: #64748b;
            font-size: 15px;
            line-height: 1.7;
            animation: successText 0.7s ease 0.4s both;
        }
        .success-order-number {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 15px;
            padding: 8px 15px;
            border-radius: 50px;
            background: rgba(25, 135, 84, 0.08);
            color: #198754;
            font-size: 13px;
            font-weight: 600;
            animation: successText 0.7s ease 0.55s both;
        }
        .confetti {
            position: absolute;
            z-index: 1;
            width: 7px;
            height: 13px;
            border-radius: 2px;
            opacity: 0;
            animation: confettiFall 3.2s ease-in-out infinite;
        }
        .confetti:nth-child(1) {
            left: 10%;
            top: 5%;
            animation-delay: .2s;
            transform: rotate(20deg);
        }
        .confetti:nth-child(2) {
            left: 20%;
            top: 0;
            animation-delay: 1s;
            transform: rotate(55deg);
        }
        .confetti:nth-child(3) {
            left: 32%;
            top: 8%;
            animation-delay: .6s;
            transform: rotate(80deg);
        }
        .confetti:nth-child(4) {
            left: 68%;
            top: 4%;
            animation-delay: 1.4s;
            transform: rotate(30deg);
        }
        .confetti:nth-child(5) {
            left: 78%;
            top: 10%;
            animation-delay: .4s;
            transform: rotate(65deg);
        }
        .confetti:nth-child(6) {
            left: 90%;
            top: 3%;
            animation-delay: 1.8s;
            transform: rotate(15deg);
        }
        .confetti:nth-child(7) {
            left: 15%;
            top: 55%;
            animation-delay: 1.7s;
            transform: rotate(45deg);
        }
        .confetti:nth-child(8) {
            left: 85%;
            top: 50%;
            animation-delay: .9s;
            transform: rotate(75deg);
        }
        @keyframes successPop {
            0% {
                opacity: 0;
                transform: scale(0.2);
            }
            70% {
                transform: scale(1.12);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes checkDraw {
            0% {
                opacity: 0;
                transform: scale(0.5) rotate(-20deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(0);
            }
        }

        @keyframes successText {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes confettiFall {
            0% {
                opacity: 0;
                transform: translateY(-20px) rotate(0deg);
            }
            20% {
                opacity: 1;
            }

            70% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(150px) rotate(360deg);
            }
        }

        @keyframes successFloat {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20px, 15px);
            }
        }

        /* Mobile */
        @media (max-width: 576px) {
            .order-success-wrapper {
                padding: 30px 15px 25px;
                border-radius: 16px;
            }
            .success-icon {
                width: 70px;
                height: 70px;
            }
            .success-icon i {
                font-size: 32px;
            }
            .success-title {
                font-size: 23px;
            }
            .success-message {
                font-size: 14px;
            }
        }
        @media print {
            body * {
                visibility: hidden !important;
            }
            #invoiceContent,
            #invoiceContent * {
                visibility: visible !important;
            }
            .com_content {
                display: flex;
                padding: 10px;
                width: 100%;
            }
            .com_content .com_address {
                font-size: 14px
            }
            body {
                margin: 0;
                padding: 0;
            }
            #invoiceContent {
                position: relative;
                width: 100%;
                margin: 0 auto;
                padding: 10px;
            }
            /* bootstrap container fix */
            .container {
                max-width: 100% !important;
                width: 100% !important;
            }
            /* row fix */
            .row {
                display: flex;
                flex-wrap: wrap;
            }
            /* button hide */
            button {
                display: none !important;
            }
            /* table clean */
            table {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            th,
            td {
                padding: 6px !important;
                font-size: 12px;
                border: 1px solid black !important;
            }
            /* image fix */
            img {
                max-width: 100% !important;
            }
        }
        @media print {
            .ll {
                color: red !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dash-shell header_margin">
        <main class="dash-main col-sm-12 col-md-12 col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
            <section class="invoice py-4">
                <div class="container">
                        <div class="order-success-wrapper">
                            <span class="confetti"></span>
                            <span class="confetti"></span>
                            <span class="confetti"></span>
                            <span class="confetti"></span>
                            <span class="confetti"></span>
                            <span class="confetti"></span>
                            <span class="confetti"></span>
                            <span class="confetti"></span>
                            <div class="success-icon">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <h2 class="success-title">
                                🎉 Thank You for Your Order!
                            </h2>
                            <p class="success-message">
                                Your order has been placed successfully.
                                We truly appreciate your trust in us.
                                <br>
                                Your order is now <strong>confirmed</strong> and
                                we will take care of the rest. 
                            </p>
                            <div class="success-order-number">
                                <i class="fa-solid fa-receipt"></i>
                                Order #{{ $orders->SaleMaster_InvoiceNo }}
                            </div>
                        </div>
                    <div class="bg-white p-4 shadow-sm">
                        <div class="d-flex justify-content-end mb-4">
                            <div>
                                <button onclick="printDiv()" class="btn btn-outline-dark btn-sm">
                                    <i class="fa-solid fa-print me-1"></i> Print
                                </button>
                            </div>
                        </div>
                        <div id="invoiceContent">
                            <div class="com_content">
                                <img src="{{ $softUrl . $setting->Company_Logo_thum }}" class="align-self-center me-2"
                                    height="90" alt="">
                                <div class="com_address">
                                    <h5>{{ $setting->Company_Name }}</h5>
                                    <p class="m-0">
                                        {{ $setting->address }}
                                    </p>
                                    <p class="m-0">
                                        <strong>Mobile:</strong>
                                        {{ $setting->phone }}
                                    </p>
                                    <p class="m-0 ll">
                                        <strong>Email:</strong>
                                        {{ $setting->email }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-start py-1"
                                style="border-bottom: 1px dashed black; border-top: 1px dashed black">
                                <h4 class="fw-bold mb-0">
                                    Order Invoice
                                </h4>
                            </div>
                            <div class="row mt-3 mb-3 small">
                                <div class="col-sm-7 small">
                                <div><strong>Customer ID:</strong> CG00001</div>
                                <div><strong>Customer Name:</strong> {{optional($orders)->customerName}}</div>
                                <div><strong>Customer Mobile:</strong> {{optional($orders)->customerMobile}}</div>
                                <div><strong>Customer Address:</strong> {{ optional($orders)->customerAddress }}</div>
                                </div>
                                <div class="col-sm-5 text-end small">
                                    <div>
                                        <strong>Invoice No:</strong>
                                        {{ $orders->SaleMaster_InvoiceNo }}
                                    </div>
                                    <div>
                                        <strong>Order Status:</strong>
                                        {{
                                            match ($orders->status) {
                                                'p' => 'Pending',
                                                'pr' => 'Processing',
                                                's' => 'Shipping',
                                                'a' => 'Confirmed',
                                                'd' => 'Cancelled',
                                                default => 'Unknown',
                                            }
                                        }}
                                    </div>
                                    <div>
                                        <strong>Order Date:</strong>
                                        {{ date_format(date_create($orders->AddTime), 'd M Y') }}
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered mb-1 mt-3 small">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">Sl.</th>
                                        <th>Product</th>
                                        <th width="100">Color</th>
                                        <th width="100">Size</th>
                                        <th width="100">Qty</th>
                                        <th width="120">Unit Price</th>
                                        <th width="120" class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders->orderDetails as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->product->Product_Name }}</td>
                                            <td> {{ optional($item->product->color)->Color_Name ?? "N/A" }}</td>
                                            <td>
                                                {{ optional($item->size)->Size_Name ?? "N/A" }}
                                            </td>
                                            <td>
                                                {{ $item->SaleDetails_TotalQuantity }}
                                            </td>
                                            <td>
                                                {{ number_format($item->SaleDetails_Rate, 2) }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($item->SaleDetails_TotalAmount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-9 small mt-0"></div>
                                <div class="col-md-3 mt-0">
                                    <table class="table table-bordered table-sm small">
                                        <tr>
                                            <th>Sub Total:</th>
                                            <td class="text-end">
                                                {{ number_format($orders->SaleMaster_SubTotalAmount, 2) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Cost:</th>
                                            <td class="text-end">
                                                {{ number_format($orders->SaleMaster_Freight, 2) }}
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <th>Total:</th>
                                            <td class="text-end">
                                                {{ number_format($orders->SaleMaster_TotalSaleAmount, 2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection
@push('script')
    <script>
        async function printDiv() {
            let content = document.getElementById("invoiceContent").innerHTML;
            let myWindow = window.open('','',`width=${screen.width},height=${screen.height}`);
            myWindow.document.write(`
                <html>
                    <head>
                        <title>Invoice</title>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" >
                        <style>
                            body {
                                padding: 20px;
                                font-size: 12px;
                            }
                            table {
                                width: 100%;
                            }
                            .com_content {
                                display: flex;
                                padding: 10px;
                                width: 100%;
                            }
                            .com_content .com_address {
                                font-size: 16px
                            }
                            .small,
                            small {
                                font-size: 20px;
                            }
                        </style>
                    </head>
                    <body>
                        ${content}
                    </body>
                </html>
            `);
            myWindow.focus();
            await new Promise((resolve) => setTimeout(resolve, 100));
            myWindow.print();
            myWindow.close();
        }
    </script>
@endpush