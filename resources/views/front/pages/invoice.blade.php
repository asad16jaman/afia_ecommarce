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
    /* //print start */
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
        th,td {
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
        <aside class="col-sm-12 col-md-4 col-lg-2 hidden-xs" id="column-right">
            @include('front.partials.cus_sidebar')
        </aside>
        <main class="dash-main col-sm-12 col-md-8 col-lg-10">
            <section class="invoice py-4">
                <div class="container">
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
                                    <p class="m-0"> {{ $setting->address }}</p>
                                    <p class="m-0"><strong>Mobile:</strong> {{ $setting->phone }}</p>
                                    <p class="m-0 ll"><strong>Email:</strong> {{ $setting->email }}</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-start py-1"
                                style="border-bottom: 1px dashed black; border-top: 1px dashed black">
                                <h4 class="fw-bold mb-0">Order Invoice</h4>
                            </div>

                            <div class="row mt-3 mb-3 small">
                                <div class="col-sm-7 small">
                                    <div><strong>Customer ID:</strong> {{ optional($orders->customer)->Customer_Code }}</div>
                                    <div><strong>Customer Name:</strong> {{optional($orders->customer)->Customer_Name}}</div>
                                    <div><strong>Customer Mobile:</strong> {{optional($orders->customer)->Customer_Mobile}}</div>
                                    <div><strong>Customer Address:</strong> {{ optional($orders->customer)->Customer_Address }}</div>
                                </div>
                                <div class="col-sm-5 text-end small">
                                    <div><strong>Invoice No:</strong> {{ $orders->SaleMaster_InvoiceNo  }}</div>
                                    <div><strong>Order Status:</strong> {{ ($orders->status == 'p') ? "Panding" : (($orders->status == 'a') ? "Confirmed" : "Cancelled") }}</div>
                                    <div><strong>Order Date:</strong> {{ date_format(date_create($orders->AddTime),'d M Y')  }}
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
                                            <td>{{ optional($item->color)->Color_Name ?? "N/A" }}</td>
                                            <td>{{ optional($item->size)->Size_Name ?? "N/A" }}</td>
                                            <td>{{ $item->SaleDetails_TotalQuantity }}</td>
                                            <td>{{ number_format($item->SaleDetails_Rate, 2) }}</td>
                                            <td class="text-end">{{ number_format($item->SaleDetails_TotalAmount, 2) }}
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
                                            <td class="text-end">{{number_format($orders->SaleMaster_SubTotalAmount, 2)}}</td>
                                        </tr>
                                        {{-- <tr>
                                            <th>Discount:</th>
                                            <td class="text-end">{{number_format($order->discount, 2)}}</td>
                                        </tr> --}}
                                        <tr>
                                            <th>Delivery Cost:</th>
                                            <td class="text-end">{{number_format($orders->SaleMaster_Freight, 2)}}</td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <th>Total:</th>
                                            <td class="text-end">{{number_format($orders->SaleMaster_TotalSaleAmount, 2)}}</td>
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
            let myWindow = window.open('', '', `width=${screen.width},height=${screen.height}`);
            myWindow.document.write(`
            <html>
                <head>
                    <title>Invoice</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                        <style>
                            body {padding:20px; font-size:12px; }
                            table {width:100%; }

                            .com_content {
                                display: flex;
                            padding: 10px;
                            width: 100%;
                }
                            .com_content .com_address {
                                font - size: 16px
                }
                            .small, small{
                                font - size:20px;
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