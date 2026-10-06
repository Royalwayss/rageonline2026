<?php
    use App\ExchangeRequest;
    use App\Order;
    use App\Product;
    use App\OrderProduct;
    use App\CustomFunction;
    use App\ReturnRequest;

    // Status grouping shared by both the list and the detail view below.
    $status_groups = [
        'captured'  => ['Successful', 'Payment Captured'],
        'confirmed' => ['COD Confirmed'],
        'pending'   => ['Pending', 'Shipped'],
        'cancelled' => ['Cancelled', 'Payment Failure', 'Payment Refunded', 'Abandoned'],
    ];

    function order_status_group($status, $status_groups)
    {
        foreach ($status_groups as $group => $values) {
            if (in_array($status, $values)) {
                return $group;
            }
        }
        return '';
    }

    $status_class_map = ['captured' => 'success', 'confirmed' => 'success', 'pending' => 'pending', 'cancelled' => 'cancelled'];
    $status_icon_map = ['success' => 'fa-solid fa-circle-check', 'pending' => 'fa-solid fa-clock', 'cancelled' => 'fa-solid fa-circle-xmark', 'neutral' => 'fa-solid fa-circle'];

    // Same page handles both the list and a single order's detail, toggled
    // by ?order_id= - scoped to the logged-in user so nobody can view an
    // order that isn't theirs by guessing an id in the URL.
    $viewOrder = null;
    if (isset($_GET['order_id']) && !empty($_GET['order_id'])) {
       
		$viewOrder = Order::withCount(['order_products as total_items'=>function($query){
                $query->select(DB::raw('sum(product_qty)'));
            }])->with(['order_address','getuser','order_products'])->where('user_id',Auth::user()->id)->where('id',$_GET['order_id'])->firstorfail();
    }
?>

@if(Session::has('flash_message_error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error! </strong> {!! session('flash_message_error') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(Session::has('flash_message_success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success! </strong> {!! session('flash_message_success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<style>

.return-exchange-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff;
    border: 1px solid #d8d0c5;
    color: #4a4038;
    font-size: 13px;
    font-weight: 500;
    padding: 6px 14px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.return-exchange-btn i {
    font-size: 12px;
}
.return-exchange-btn:hover {
    background: #8e313c;
    border-color: #8e313c;
    color: #fff;
}
 #action-buttons .order-actions-cell {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-start;
        gap: 8px;
    }
    #action-buttons .order-view-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin: 0;
        white-space: nowrap;
        flex: 0 0 auto;
    }

    @media (max-width: 767px) {
        #action-buttons .order-actions-cell {
            justify-content: flex-start;
        }
    }
</style>

@if($viewOrder)

    <?php
        $order = $viewOrder;

        if ($order->payment_method == 'bank_deposit') {
            $payment_method = 'Bank deposit';
        } else {
            $payment_method = $order->payment_method;
        }

        if (@$order->order_address->shipping_state == 'Punjab') {
            $own_state = 'yes';
        } else {
            $own_state = 'no';
        }

        $order_products_summery = order_products_summery($order);

        $product_gst_array = $priceArr = [];
        $total_gst_ = 0;

        foreach ($order_products_summery['products'] as $p) {
            $priceArr[] = $p['subtotal'];
            $product_gst_array[] = $p['product_gst'];
        }

        $shipping_gst = '0';
        $shipping_charges = '0';
        $shipping_gst_amt = '0';
        if (!empty($product_gst_array)) {
            $shipping_gst = in_array('18', $product_gst_array) ? '18' : '5';
        }
        if (!empty($order['shipping_charges'])) {
            $igstcalculate = igstcalculate($order['shipping_charges'], $shipping_gst);
            $shipping_gst_amt = round($igstcalculate);
            $shipping_charges = AmountFormat($order['shipping_charges']);
        }

        $status_group = order_status_group($order->order_status, $status_groups);
        $status_class = $status_class_map[$status_group] ?? 'neutral';
        $status_icon = $status_icon_map[$status_class];

        $step_placed = true;
        $step_payment = in_array($order->order_status, ['Successful', 'Payment Captured', 'COD Confirmed']);
        $step_packed = in_array($order->order_status, ['Shipped', 'Delivered']);
        $step_transit = in_array($order->order_status, ['Shipped', 'Delivered']);
        $step_delivered = ($order->order_status == 'Delivered');
        $is_cancelled = in_array($order->order_status, ['Cancelled', 'Payment Failure', 'Payment Refunded', 'Abandoned']);
    ?>

    <div class="account-content-grid">
        <div class="luxury-card order-detail-master-card">

            <!-- TOP BAR -->
            <div class="order-detail-header-bar">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <a href="{{ url('account/orders') }}" class="back-orders-link">
                        <i class="fa-solid fa-arrow-left-long"></i>
                        <span>All Orders</span>
                    </a>
                    <span class="header-sep">/</span>
                    <h2 class="order-id-title">Order #{{ $order->id }}</h2>
                    <span class="order-status {{ $status_class }}">
                        <i class="{{ $status_icon }}"></i> {{ ucwords($order->order_status) }}
                    </span>
                </div>
                <?php /*
                <div class="order-detail-actions">
                    <button type="button" class="luxury-action-btn" onclick="window.print();">
                        <i class="fa-solid fa-print"></i>
                        <span>Print Receipt</span>
                    </button> 
                    
                    <a href="{{url('/account/order-invoice-print/'.$order->id)}}" target="_blank" class="luxury-action-btn primary">
                        <i class="fa-solid fa-download"></i>
                        <span>Download Invoice</span>
                    </a>
                </div> */ ?>
            </div>
             <?php /*
            <!-- SHIPMENT STEPPER (driven by real order_status only) -->
            @if(!$is_cancelled)
            <div class="shipment-stepper-box mt-4">
                <div class="stepper-title-row">
                    <div>
                        <h3>Shipment Timeline</h3>
                        <p>Payment Method: <strong>{{ CustomFunction::get_payment_method($order->payment_method) }}</strong></p>
                    </div>
                    <a href="https://wa.me/917986158756?text={{ urlencode('Track Order #'.$order->id) }}" target="_blank" class="live-track-btn">
                        <i class="fa-brands fa-whatsapp"></i> Live Tracking Support
                    </a>
                </div>

                <div class="luxury-stepper">
                    <div class="step-item completed">
                        <div class="step-icon"><i class="fa-solid fa-cart-check"></i></div>
                        <div class="step-content">
                            <strong>Order Placed</strong>
                            <span>{{ date('d M Y, h:i A', strtotime($order->created_at)) }}</span>
                        </div>
                    </div>

                    <div class="step-connector {{ $step_payment ? 'completed' : '' }}"></div>

                    <div class="step-item {{ $step_payment ? 'completed' : ($step_placed ? 'current' : '') }}">
                        <div class="step-icon"><i class="fa-solid fa-credit-card"></i></div>
                        <div class="step-content">
                            <strong>Payment Verified</strong>
                            <span>{{ ucwords($order->order_status) }}</span>
                        </div>
                    </div>

                    <div class="step-connector {{ $step_packed ? 'completed' : '' }}"></div>

                    <div class="step-item {{ $step_packed ? 'completed' : ($step_payment ? 'current' : '') }}">
                        <div class="step-icon"><i class="fa-solid fa-box-open"></i></div>
                        <div class="step-content">
                            <strong>Packed</strong>
                        </div>
                    </div>

                    <div class="step-connector {{ $step_transit ? 'completed' : '' }}"></div>

                    <div class="step-item {{ $step_delivered ? 'completed' : ($step_transit ? 'current' : '') }}">
                        <div class="step-icon"><i class="fa-solid fa-truck-fast"></i></div>
                        <div class="step-content">
                            <strong>In Transit</strong>
                        </div>
                    </div>

                    <div class="step-connector {{ $step_delivered ? 'completed' : '' }}"></div>

                    <div class="step-item {{ $step_delivered ? 'completed' : '' }}">
                        <div class="step-icon"><i class="fa-solid fa-house-chimney"></i></div>
                        <div class="step-content">
                            <strong>Delivered</strong>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            */ ?>
            <!-- PURCHASED ITEMS -->
            <div class="order-items-container mt-4">
                <h3 class="section-subhead">Purchased Item{{ count($order_products_summery['products']) > 1 ? 's' : '' }}</h3>

                @foreach($order_products_summery['products'] as $order_product_summery)
                    <?php
                        $unit_price = $order_product_summery['subtotal'] / $order_product_summery['product_qty'];
                        $check_returnrequest = ReturnRequest::where('order_product_id', $order_product_summery['id'])->first();
                    ?>
                    <div class="order-product-card">
                        <div class="order-prod-img">
                            <a href="{{ $order_product_summery['product_link'] }}">
                                @if(isset($order_product_summery['image']))
                                    <img src="{{ asset('images/ProductImages/medium/'.$order_product_summery['image']) }}" alt="{{ $order_product_summery['product_name'] }}">
                                @else
                                    <img src="{{ asset('images/no-image-found.jpg') }}" alt="{{ $order_product_summery['product_name'] }}">
                                @endif
                            </a>
                        </div>

                        <div class="order-prod-info">
                            <h4>
                                <a target="_blank" href="{{ $order_product_summery['product_link'] }}">{{ $order_product_summery['product_name'] }}</a>
                            </h4>
                            <div class="prod-specs-grid">
                                <div class="spec-chip">
                                    <span class="lbl">Code:</span>
                                    <strong class="val">{{ $order_product_summery['product_code'] }}</strong>
                                </div>
                                <div class="spec-chip">
                                    <span class="lbl">Category:</span>
                                    <strong class="val">{{ $order_product_summery['category_name'] }}</strong>
                                </div>
                                <div class="spec-chip">
                                    <span class="lbl">SKU:</span>
                                    <strong class="val">{{ $order_product_summery['product_sku'] }}</strong>
                                </div>
                                <div class="spec-chip">
                                    <span class="lbl">Size:</span>
                                    <strong class="val">{{ $order_product_summery['product_size'] }}</strong>
                                </div>
                            </div>

                            @if(!empty($check_returnrequest))
                            <div class="return-status-note">
                                {{ $check_returnrequest->action }} Request Status:
                                @if(empty($check_returnrequest->reply_status))
                                    <span class="text-success">Request in processing</span>
                                @else
                                    <span class="{{ $check_returnrequest->reply_status == 'Request Rejected' ? 'text-danger' : 'text-success' }}">{{ $check_returnrequest->reply_status }}</span>
                                @endif
                            </div>
                            @else
                                
							    @if(Auth::user()->country == 'India' && $order->order_status == 'Delivered')
							    <button type="button" class="return-exchange-btn returnItem mt-2" data-orderproid="{{ $order_product_summery['id'] }}" data-sku="{{ $order_product_summery['product_sku'] }}">
                                    <i class="fa-solid fa-rotate-left"></i> Request Exchange / Return
                                </button>
								@endif
								
                            @endif
                        </div>

                        <div class="order-prod-pricing">
                            <div class="price-col">
                                <span class="lbl">MRP</span>
                                <strong class="val">{{ AmountFormat($order_product_summery['mrp']) }}</strong>
                            </div>
                            <div class="price-col">
                                <span class="lbl">Discount</span>
                                <strong class="val">{{ AmountFormat($order_product_summery['product_discount']) }}</strong>
                            </div>
                            <div class="price-col">
                                <span class="lbl">Unit Price</span>
                                <strong class="val">{{ AmountFormat($unit_price) }}</strong>
                            </div>
                            <div class="price-col">
                                <span class="lbl">Taxable Value</span>
                                <strong class="val">{{ AmountFormat($order_product_summery['taxable_value']) }}</strong>
                            </div>
                            <div class="price-col">
                                <span class="lbl">GST</span>
                                <strong class="val">
                                    <?php
                                        $product_gst = $order_product_summery['product_gst'];
                                        $gst_amount = $order_product_summery['product_gst_amount'];
                                        $total_gst_ += $gst_amount;
                                    ?>
                                    @if($own_state == 'no')
                                        {{ AmountFormat($order_product_summery['IGST']) }}<br>
                                        <small>IGST - {{ $gst_amount }} ({{ $product_gst }}%)</small>
                                    @else
                                        {{ AmountFormat($gst_amount) }}<br>
                                        <small>CGST - {{ $order_product_summery['CGST'] }} ({{ $product_gst/2 }}%)<br>
                                        SGST - {{ $order_product_summery['SGST'] }} ({{ $product_gst/2 }}%)</small>
                                    @endif
                                </strong>
                            </div>
                            <div class="price-col">
                                <span class="lbl">Qty</span>
                                <strong class="val">{{ $order_product_summery['product_qty'] }}</strong>
                            </div>
                            <div class="price-col text-end">
                                <span class="lbl">Subtotal</span>
                                <strong class="val total">{{ AmountFormat($order_product_summery['sub_total']) }}</strong>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- DESTINATION & BILLING BREAKDOWN -->
            <div class="order-summary-grid mt-4">
                <div class="row g-4">

                    <!-- BILLING ADDRESS -->
                    <div class="col-lg-4 col-12">
                        <div class="order-card-box">
                            <div class="box-head">
                                <i class="fa-solid fa-file-invoice"></i>
                                <h4>Billing Address</h4>
                            </div>
                            <div class="box-content">
                                <strong class="recipient">{{ @$order->order_address->billing_name }}</strong>
                                <p class="address-text">
                                    {{ @$order->order_address->billing_address }}<br>
                                    {{ @$order->order_address->billing_city }}, {{ @$order->order_address->billing_state }} - {{ @$order->order_address->billing_postcode }}<br>
                                    {{ @$order->order_address->billing_country }}
                                </p>
                                <div class="meta-row">
                                    <span><i class="fa-solid fa-phone"></i> {{ @$order->order_address->billing_mobile }}</span>
                                    @if(!empty($order->order_address->billing_alternative_number))
                                    <span><i class="fa-solid fa-phone"></i> {{ $order->order_address->billing_alternative_number }} (Alt)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SHIPPING ADDRESS -->
                    <div class="col-lg-4 col-12">
                        <div class="order-card-box">
                            <div class="box-head">
                                <i class="fa-solid fa-location-dot"></i>
                                <h4>Delivery Destination</h4>
                            </div>
                            <div class="box-content">
                                <strong class="recipient">{{ @$order->order_address->shipping_name }}</strong>
                                <p class="address-text">
                                    {{ @$order->order_address->shipping_address }}<br>
                                    {{ @$order->order_address->shipping_city }}, {{ @$order->order_address->shipping_state }} - {{ @$order->order_address->shipping_postcode }}<br>
                                    {{ @$order->order_address->shipping_country }}
                                </p>
                                <div class="meta-row">
                                    <span><i class="fa-solid fa-phone"></i> {{ @$order->order_address->shipping_mobile }}</span>
                                    @if(!empty($order->order_address->shipping_alternative_number))
                                    <span><i class="fa-solid fa-phone"></i> {{ $order->order_address->shipping_alternative_number }} (Alt)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FINANCIAL BREAKDOWN -->
                    <div class="col-lg-4 col-12">
                        <div class="order-card-box payment-summary-box">
                            <div class="box-head">
                                <i class="fa-solid fa-receipt"></i>
                                <h4>Payment Breakdown</h4>
                            </div>
                            <div class="box-content">

                                <div class="breakdown-row">
                                    <span>Total Amount</span>
                                    <strong>{{ AmountFormat($order_products_summery['total_amount']) }}</strong>
                                </div>

                                @if(!empty($order_products_summery['discount']))
                                <div class="breakdown-row">
                                    <span>Discount</span>
                                    <strong>{{ AmountFormat($order_products_summery['discount']) }}</strong>
                                </div>
                                @endif

                                <div class="breakdown-row">
                                    <span>Subtotal</span>
                                    <strong>{{ AmountFormat($order_products_summery['subtotal']) }}</strong>
                                </div>

                                <div class="breakdown-row">
                                    <span>Taxable Value</span>
                                    <strong>{{ AmountFormat($order_products_summery['taxable_value']) }}</strong>
                                </div>

                                <div class="breakdown-row">
                                    <span>GST</span>
                                    <strong>{{ AmountFormat($order_products_summery['total_product_gst_amount'] + $shipping_gst_amt) }}</strong>
                                </div>

                                @if(!empty($order->shipping_charges))
                                <div class="breakdown-row">
                                    <span>Shipping Amount <br><small>(Including {{ $shipping_gst }}% GST)</small></span>
                                    <strong>{{ AmountFormat($order->shipping_charges) }}</strong>
                                </div>
                                @endif

                                @if(!empty($order->prepaid_discount))
                                <div class="breakdown-row">
                                    <span>Prepaid Discount (5%)</span>
                                    <strong>{{ AmountFormat($order->prepaid_discount) }}</strong>
                                </div>
                                @endif

                                @if(!empty($order->amount_redeemed))
                                <div class="breakdown-row">
                                    <span>Amount Redeemed <br><small>(by {{ $order->points_redeemed }} Points)</small></span>
                                    <strong>{{ AmountFormat($order->amount_redeemed) }}</strong>
                                </div>
                                @endif

                                @if(isset($order_products_summery['round_of']) && !empty($order_products_summery['round_of']))
                                <div class="breakdown-row">
                                    <span>Total</span>
                                    <strong>{{ AmountFormat($order->grand_total_without_round_of) }}</strong>
                                </div>
                                <div class="breakdown-row">
                                    <span>Round Of</span>
                                    <strong>{{ $order_products_summery['round_of'] }}</strong>
                                </div>
                                @endif

                                @if(!empty($order->coupon_code))
                                <div class="breakdown-row">
                                    <span>Applied Coupon Code</span>
                                    <strong>{{ $order->coupon_code }}</strong>
                                </div>
                                @endif

                                <div class="breakdown-row grand-total">
                                    <span>Grand Total</span>
                                    <strong>{{ AmountFormat($order->grand_total) }}</strong>
                                </div>

                                <div class="payment-method-footer mt-3">
                                    <span class="lbl">Payment Mode:</span>
                                    <span class="val"><i class="fa-solid fa-credit-card"></i> {{ CustomFunction::get_payment_method($order->payment_method) }}</span>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@else

    <?php
        $status_counts_by_group = ['captured' => 0, 'confirmed' => 0, 'pending' => 0, 'cancelled' => 0];
        foreach ($orders as $order) {
            $grp = order_status_group($order->order_status, $status_groups);
            if ($grp != '') {
                $status_counts_by_group[$grp]++;
            }
        }
    ?>

    <div class="account-content-grid">
        <div class="luxury-card orders-manager-card">

            <div class="luxury-card-head d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="head-icon">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div>
                        <h2>Order History & Tracking</h2>
                        <p>Track shipments, review past invoices and request returns</p>
                    </div>
                </div>
                <div class="order-summary-badge">
                    <span>Total Orders:</span>
                    <strong>{{ count($orders) }} {{ count($orders) == 1 ? 'Purchase' : 'Purchases' }}</strong>
                </div>
            </div>

            <!-- FILTER TABS -->
            <div class="order-filter-tabs mt-4">
                <button type="button" class="filter-pill active" onclick="filterOrders('all', this);">
                    All Orders <span class="count">{{ count($orders) }}</span>
                </button>
                <button type="button" class="filter-pill" onclick="filterOrders('captured', this);">
                    Captured / Paid <span class="count">{{ $status_counts_by_group['captured'] }}</span>
                </button>
                <button type="button" class="filter-pill" onclick="filterOrders('confirmed', this);">
                    COD Confirmed <span class="count">{{ $status_counts_by_group['confirmed'] }}</span>
                </button>
                <button type="button" class="filter-pill" onclick="filterOrders('pending', this);">
                    Processing <span class="count">{{ $status_counts_by_group['pending'] }}</span>
                </button>
                <button type="button" class="filter-pill" onclick="filterOrders('cancelled', this);">
                    Cancelled <span class="count">{{ $status_counts_by_group['cancelled'] }}</span>
                </button>
            </div>

            <!-- ORDERS TABLE -->
            <div class="orders-table-wrap mt-4">
                <table class="orders-table luxury-table">
                    <thead>
                        <tr>
                            <th>Order ID & Item</th>
                            <th>Payment</th>
                            <th>Date Placed</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(count($orders) > 0)
                        @foreach($orders as $order)
                            <?php
                                $payment_method = ($order->payment_method == 'bank_deposit') ? 'Bank deposit' : $order->payment_method;
                                $check_order_return_exchange = Order::check_order_return_exchange($order->id);

                                $pay_icon = 'fa-solid fa-credit-card';
                                if (strtolower($order->payment_method) == 'cod') {
                                    $pay_icon = 'fa-solid fa-money-bill-wave';
                                }

                                $row_status_group = order_status_group($order->order_status, $status_groups);
                                $row_status_class = $status_class_map[$row_status_group] ?? 'neutral';
                                $row_status_icon = $status_icon_map[$row_status_class];
                            ?>
                            <tr class="order-row" data-status="{{ $row_status_group }}">
                                <td data-label="Order ID & Item">

                                    <div class="order-item-cell">
                                        <div class="order-item-info">
                                            <a href="{{ url('account/orders').'?order_id='.$order->id }}" class="order-num-link">
                                                <strong>#{{ $order->id }}</strong>
                                            </a>
                                        </div>
                                    </div>

                                    @foreach($order->order_products as $order_product)
                                    <div class="order-item-cell mb-10">
                                        <div class="order-thumb">
                                            @if(isset($order_product['productdetail']['product_image']))
                                                <img src="{{ asset('images/ProductImages/small/'.$order_product['productdetail']['product_image']['image']) }}">
                                            @else
                                                <img src="{{ asset('images/no-image-found.jpg') }}">
                                            @endif
                                        </div>
                                        <div class="order-item-info">
                                            <span class="order-item-title">{{ $order_product['product_name'] }}</span>
                                            <small class="order-sku">{{ $order_product['product_qty'] }} Item • Size: {{ $order_product['product_size'] }}</small>
                                        </div>
                                    </div>
                                    @endforeach

                                </td>
                                <td data-label="Payment">
                                    <span class="pay-method-badge">
                                        <i class="{{ $pay_icon }}"></i> {{ ucwords($payment_method) }}
                                    </span>
                                </td>
                                <td data-label="Date">
                                    <div class="order-date-cell">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span>{{ date('d M Y', strtotime($order->created_at)) }}</span>
                                    </div>
                                </td>
                                <td data-label="Amount">
                                    <strong class="order-price-val">INR {{ number_format($order->grand_total, 2) }}</strong>
                                </td>
                                <td data-label="Status">
                                    <span class="order-status {{ $row_status_class }}">
                                        <i class="{{ $row_status_icon }}"></i> {{ ucwords($order->order_status) }}
                                    </span>
                                </td>
                                <td data-label="Actions" class="text-end" id="action-buttons">
                                    <div class="order-actions-cell">
                                        <a href="{{ url('account/orders').'?order_id='.$order->id }}" class="order-view-btn primary">
                                            <span>View Order</span>
                                            <i class="fa-solid fa-arrow-right-long"></i>
                                        </a>

                                        @if(!empty($order['waybill']))
                                        <br><a target="_blank" href="{{ url('track-order/'.$order->id) }}" class=" order-view-btn" >
                                            <span>Track</span>
                                        </a>
                                        @endif

                                        @if($check_order_return_exchange['cancel'] == 1)
                                        <a href="{{ url('order-cancel/'.$order->id) }}" class="order-view-btn">
                                            <span>Cancel</span>
                                        </a>
                                        @endif

                                        @if($check_order_return_exchange['return'] == 1 || $check_order_return_exchange['exchange'] == 1)
                                      <?php /*  <a href="{{ url('exchange-item/'.$order->id) }}" class="order-view-btn">
                                            <span>Exchange</span>
                                        </a> */?>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center">No orders yet.</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endif


<!-- Return/Exchange Item modal (shared by both views) -->
<div class="modal fade" id="returnItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content review-modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Exchange Item</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post" action="{{ url('/return-order-item') }}" id="return-form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="review-field">
                        <label for="return_reason">Reason for Returning / Exchange</label>
                        <select name="return_reason" class="form-control return_items" required>
                            <option value="">Please Select</option>
                            <option value="Incorrect product received">Incorrect product received</option>
                            <option value="Received product is defective">Received product is defective</option>
                            <option value="A Part of the product is missing">A Part of the product is missing</option>
                            <option value="Wrong size received">Wrong size received</option>
                            <option value="Size Issue">Size Issue</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="review-field">
                        <label for="required_size">Required Size (leave blank for a return)</label>
                        <input name="required_size" placeholder="Size" class="form-control">
                    </div>

                    <div class="review-field">
                        <label for="message-text">Comments</label>
                        <input type="hidden" name="order_product_id">
                        <input type="hidden" name="sku">
                        <textarea name="reason" placeholder="Comments" class="form-control return_items" id="message-text" required></textarea>
                    </div>

                    <div class="review-field">
                        <label for="exampleFormControlFile1">Choose file (if any)</label>
                        <input type="file" class="form-control return_items" id="exampleFormControlFile1" name="file">
                        <span style="color:red">Note: Max file size is 2MB</span>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="primary-btn">Submit</button>
                    <button type="button" class="modal-cancel" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script type="text/javascript">
    function filterOrders(status, btn) {
        document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const rows = document.querySelectorAll('.order-row');
        rows.forEach(row => {
            if (status === 'all' || row.getAttribute('data-status') === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    $(document).ready(function() {
        $(document).on('click', '.returnItem', function() {
            var orderproid = $(this).data('orderproid');
            var sku = $(this).data('sku');
            $('[name=sku]').val(sku);
            $('[name=order_product_id]').val(orderproid);
            $('#returnItem').modal('show');
        });

        $('#return-form').validate({
            rules: {
                return_reason: {
                    required: true
                }
            }
        });
    });

    $(document).on('click', '.triggerOrderDetails', function() {
        $(".collapse").css("display", "block");
    });
</script>
@stop