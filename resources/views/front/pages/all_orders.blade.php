@extends('front.layout.app')

@section('title', 'My Orders')

@push('style')
    <style>
        .orders-page {
            width: 100%;
        }

        .orders-page .pg-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .orders-page .pg-title {
            display: flex;
            align-items: center;
            gap: 9px;
            color: #222;
            font-size: 15px;
            font-weight: 700;
        }

        .orders-page .pg-title-bar {
            width: 3px;
            height: 16px;
            background: var(--color-second);
            border-radius: 1px;
        }

        .orders-page .o-date {
            color: var(--color-second);
            font-size: 11px;
        }

        .orders-page .stat-row {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 9px;
            margin-bottom: 14px;
        }

        .orders-page .stat-card {
            min-height: 56px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 11px;
            background: #fff;
            border: 1px solid #e2e2e2;
            border-radius: 6px;
            text-decoration: none;
            color: #222;
            transition: .15s ease;
            box-sizing: border-box;
        }

        .orders-page .stat-card:hover {
            border-color: #ddd;
            box-shadow: 0 2px 7px rgba(0, 0, 0, .06);
            text-decoration: none;
        }

        /* Active card */
        .orders-page .stat-card.s-active {
            border-color: var(--color-second);
            background: #fff8f6;
            box-shadow: inset 3px 0 0 var(--color-second);
        }

        .orders-page .stat-ico {
            width: 30px;
            height: 30px;
            min-width: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            font-size: 12px;
        }

        .orders-page .ico-total {
            background: #f0f1f3;
            color: #667085;
        }

        .orders-page .ico-pending {
            background: #fff9e8;
            color: #e8b900;
        }

        .orders-page .ico-process {
            background: #edf4ff;
            color: #1677ff;
        }

        .orders-page .ico-complete {
            background: #eafaf1;
            color: #16a34a;
        }

        .orders-page .ico-cancel {
            background: #fff0f0;
            color: #e60000;
        }

        .orders-page .stat-v {
            font-size: 19px;
            line-height: 17px;
            font-weight: 700;
            color: #222;
        }

        .orders-page .stat-l {
            margin-top: 2px;
            color: var(--nav-color);
            font-size: 9px;
            line-height: 11px;
        }

        .orders-page .tbl-card {
            width: 100%;
            background: #fff;
            border: 1px solid #e2e2e2;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
        }

        .orders-page .tbl-card table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
            table-layout: fixed;
        }


        /* Table Header */

        .orders-page .tbl-card thead th {
            height: 38px;
            padding: 8px 12px;
            background: #fff;
            border-bottom: 1px solid #eeeeee;
            color: var(--nav-color);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .2px;
            vertical-align: middle;
            white-space: nowrap;
        }


        /* Table Body */

        .orders-page .tbl-card tbody td {
            height: 45px;

            padding: 7px 12px;

            border-bottom: 1px solid #eeeeee;

            color: #222;

            font-size: 11px;

            vertical-align: middle;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        /* Last row */

        .orders-page .tbl-card tbody tr:last-child td {
            border-bottom: none;
        }


        /* Row hover */

        .orders-page .tbl-card tbody tr:hover {
            background: #fffafa;
        }


        /* =========================================================
           COLUMN WIDTHS
           ========================================================= */

        .orders-page .tbl-card th:nth-child(1),
        .orders-page .tbl-card td:nth-child(1) {
            width: 14%;
        }

        .orders-page .tbl-card th:nth-child(2),
        .orders-page .tbl-card td:nth-child(2) {
            width: 15%;
        }

        .orders-page .tbl-card th:nth-child(3),
        .orders-page .tbl-card td:nth-child(3) {
            width: 11%;
        }

        .orders-page .tbl-card th:nth-child(4),
        .orders-page .tbl-card td:nth-child(4) {
            width: 17%;
        }

        .orders-page .tbl-card th:nth-child(5),
        .orders-page .tbl-card td:nth-child(5) {
            width: 14%;
        }

        .orders-page .tbl-card th:nth-child(6),
        .orders-page .tbl-card td:nth-child(6) {
            width: 13%;
        }

        .orders-page .tbl-card th:nth-child(7),
        .orders-page .tbl-card td:nth-child(7) {
            width: 10%;
        }


        /* =========================================================
           ORDER CODE
           ========================================================= */

        .orders-page .o-code {
            color: #e60000;

            font-weight: 700;

            font-size: 11px;
        }


        /* Date */

        .orders-page tbody .o-date {
            color: var(--nav-color);

            font-size: 10px;
        }


        /* =========================================================
           STATUS BADGE
           ========================================================= */

        .orders-page .sbadge {
            display: inline-flex;

            align-items: center;

            gap: 5px;

            padding: 3px 8px;

            border-radius: 12px;

            font-size: 9px;

            font-weight: 600;

            line-height: 1;

            text-transform: lowercase;
        }


        /* Dot */

        .orders-page .sbadge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
            background: red;
        }


        /* Pending */

        .orders-page .s-pending {
            color: #0002ff;
            background: #fff9e8;
        }
         .orders-page .s-pending .sbadge-dot {
            background: #0002ff;
        }

        /* Delivered */
        .orders-page .s-delivered {
            color: #269b4b;
            background: #effaf2;
        }
        .orders-page .s-delivered .sbadge-dot {
            background: #269b4b;
        }


        /* Processing */
        .orders-page .s-processing {
            color: #1677ff;
            background: #edf4ff;
        }
        .orders-page .s-processing .sbadge-dot {
            background: #1677ff;
        }
        /* Processing */
        .orders-page .s-shipping {
            color: #16e0ee;
            background: #edf4ff;
        }
        .orders-page .s-shipping .sbadge-dot {
            background: #16e0ee;
        }

         /* Processing */
        .orders-page .s-return {
            color: #e7f706;
            background: #edf4ff;
        }
        .orders-page .s-return .sbadge-dot {
            background: #e7f706;
        }


        /* Cancelled */
        .orders-page .s-cancelled {
            color: #e60000;
            background: #fff0f0;
        }


        /* =========================================================
           ACTION BUTTONS
           ========================================================= */

        .orders-page .act-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .orders-page .act-btn {
            width: 26px;
            height: 26px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            background: #fff;
            font-size: 11px;
            text-decoration: none;
            cursor: pointer;
            transition: .15s ease;
        }
        .orders-page .a-view {
            border: 1px solid #00a651;
            color: #00a651;
        }
        .orders-page .a-view:hover {
            background: #00a651;
            color: #fff;
        }
        .orders-page .a-del {
            border: 1px solid #e60000;
            color: #e60000;
        }
        .orders-page .a-del:hover {
            background: #e60000;
            color: #fff;
        }
        /* =========================================================
           PAGINATION
           ========================================================= */
        .orders-page .pg-footer {
            margin-top: 12px;
        }
        .orders-page .pagination {
            gap: 3px;
        }
        .orders-page .pagination .page-link {
            border: 1px solid #ddd;
            color: #555;
            font-size: 11px;
            padding: 5px 9px;
            border-radius: 4px;
        }
        .orders-page .pagination .page-item.active .page-link {
            background: #e60000;
            border-color: #e60000;
            color: #fff;
        }
        /* =========================================================
           RESPONSIVE
           ========================================================= */
        @media (max-width: 1000px) {
            .orders-page .stat-row {
                grid-template-columns: repeat(4, 1fr);
            }
            .orders-page .tbl-card {
                overflow-x: auto;
            }
            .orders-page .tbl-card table {
                min-width: 850px;
            }
        }
        @media (max-width: 700px) {
            .orders-page .stat-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .orders-page .pg-header {
                margin-bottom: 12px;
            }
            .orders-page .pg-title {
                font-size: 14px;
            }
        }
        @media (max-width: 450px) {
            .orders-page .stat-card {
                min-height: 52px;
            }
            .orders-page .o-date {
                display: none;
            }
        }
    </style>
@endpush


@section('content')

    <div class="dash-shell header_margin ">

        {{-- Sidebar --}}
        <aside class="col-sm-12 col-md-4 col-lg-2 hidden-xs" id="column-right">
            @include('front.partials.cus_sidebar')
        </aside>


        {{-- Main Content --}}
        <main class="dash-main p-3">
            <div class="orders-page">
                <div class="pg-header">
                    <div class="pg-title">
                        <span class="pg-title-bar"></span>
                        My Orders
                    </div>
                    <div class="o-date">
                        {{ date('d M Y') }}
                    </div>
                </div>
                <div class="stat-row">
                    <!-- Total -->
                    <a href="{{ route('customer.all.order', ['status' => 'all']) }}"
                        class="stat-card {{ request('status') === 'all' ? ' s-active' : '' }}">
                        <div class="stat-ico ico-total">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div>
                            <div class="stat-v">{{ $total_order ?? 0 }}</div>
                            <div class="stat-l">Total</div>
                        </div>
                    </a>
                    <a href="{{ route('customer.all.order', ['status' => 'pending']) }}"
                        class="stat-card {{ request('status') === 'pending' ? ' s-active' : '' }}">
                        <div class="stat-ico ico-pending">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <div class="stat-v">{{ $p_orders ?? 0 }}</div>
                            <div class="stat-l">Pending</div>
                        </div>
                    </a>
                    <!-- Processing -->
                    <a href="{{ route('customer.all.order', ['status' => 'processing']) }}"
                        class="stat-card {{ request('status') === 'processing' ? ' s-active' : '' }}">
                        <div class="stat-ico ico-process">
                            <i class="fa-solid fa-spinner"></i>
                        </div>
                        <div>
                            <div class="stat-v">{{ $pr_orders ?? 0 }}</div>
                            <div class="stat-l">Processing</div>
                        </div>
                    </a> 

                    <!-- Processing -->
                    <a href="{{ route('customer.all.order', ['status' => 'shipping']) }}"
                        class="stat-card {{ request('status') === 'shipping' ? ' s-active' : '' }}">
                        <div class="stat-ico ico-process">
                            <i class="fa-solid fa-truck"></i>
                        </div>
                        <div>
                            <div class="stat-v">{{ $sip_orders ?? 0 }}</div>
                            <div class="stat-l">Shipping</div>
                        </div>
                    </a>

                    <!-- Delivered -->
                    <a href="{{ route('customer.all.order', ['status' => 'confirmed']) }}"
                        class="stat-card {{ request('status') === 'confirmed' ? ' s-active' : '' }}">
                        <div class="stat-ico ico-complete">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="stat-v">{{ $a_orders ?? 0 }}</div>
                            <div class="stat-l">Confirmed</div>
                        </div>
                    </a>
                    <!-- Cancelled -->
                    <a href="{{ route('customer.all.order', ['status' => 'cancel']) }}"
                        class="stat-card {{ request('status') === 'cancel' ? ' s-active' : '' }}">
                        <div class="stat-ico ico-cancel">
                            <i class="fa-solid fa-arrow-rotate-left"></i>
                        </div>
                        <div>
                            <div class="stat-v">{{ $c_orders ?? 0 }}</div>
                            <div class="stat-l">Cancelled</div>
                        </div>
                    </a>
                </div>
                <!-- =========================
                         ORDERS TABLE
                    ========================== -->

                <div class="tbl-card">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($allorders as $order)
                                <!-- Order 1 -->
                                <tr>
                                    <td>
                                        <span class="o-code">
                                            {{ $order->SaleMaster_InvoiceNo }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="o-date">
                                            <!-- Apr 25, 2026 -->
                                            {{ date_format(date_create($order->AddTime), 'd M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        ৳{{ $order->SaleMaster_TotalSaleAmount }}
                                    </td>
                                    <td>
                                        Cash on Delivery
                                    </td>
                                    <td>
                                        @if($order->status == 'p')
                                            <span class="sbadge s-pending">
                                                <span class="sbadge-dot"></span>
                                                Pending
                                            </span>
                                        @elseif($order->status == 'a')
                                            <span class="sbadge s-delivered">
                                                <span class="sbadge-dot"></span>
                                                Confirmed
                                            </span>
                                        @elseif($order->status == 'pr')
                                            <span class="sbadge s-processing">
                                                <span class="sbadge-dot"></span>
                                                Processing
                                            </span>
                                        @elseif($order->status == 's')
                                            <span class="sbadge s-shipping">
                                                <span class="sbadge-dot"></span>
                                                Shipping
                                            </span>

                                        @else
                                            <span class="sbadge s-cancelled">
                                                <span class="sbadge-dot"></span>
                                                Cancelled
                                            </span>
                                        @endif

                                    </td>
                                    <td>
                                        {{ $order->SaleMaster_Description }}
                                    </td>
                                    <td>
                                        <div class="act-wrap">
                                            <a href="{{ route('customer.order.invoice', ['id' => $order->SaleMaster_SlNo]) }}" class="act-btn a-view" title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($order->status == 'p')
                                                <button type="button"
                                                    onclick="deleteOrder('{{ route('customer.order.delete', ['id' => $order->SaleMaster_SlNo]) }}')"
                                                    class="act-btn a-del" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                            @endforeach




                        </tbody>

                    </table>

                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $allorders->links() }}
                </div>

            </div>

        </main>

    </div>

@endsection


@push('script')
    <script>
        function deleteOrder(url) {

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        method: 'post',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function (res) {
                            if (res.status) {
                                // Swal.fire({
                                //     title: "Deleted!",
                                //     text: res.message,
                                //     icon: "success"
                                // }).then(() => {
                                //     location.reload();
                                // });

                                location.reload();
                            }{
                                Swal.fire({
                                    title: "Warning!",
                                    text: res.message,
                                    icon: "success"
                                })
                            }
                        },
                        error: function (res) {
                            console.log(res);
                        }
                    });

                }

            });
        }
    </script>
@endpush