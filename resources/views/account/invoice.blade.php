@extends('layouts.main')
@section('content')
<?php $segment = Request::segments(); ?>


<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Invoice</span></h1>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="invoice">
    <div class="page-content container">
        <div class="container px-0">
            <div class="row">
                <div class="col-12 col-lg-10 offset-lg-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-150">
                                <div class="section-heading dark-color">
                                    <h3>Invoice
                                    <small class="page-info">
                                        <i class="fa fa-angle-double-right text-80"></i>
                                        ID: #{{$order->invoice_number}}
                                    </small></h3>
                                    <span ><a href="{{ $order->invoice_url }}" class="btn btn-primary" target="_blank">View Slip</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .row -->

                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                    <div class="row">
                        <div class="col-sm-4">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">To:</span>
                                <span class="text-600 text-110 text-blue align-middle">{{$order->delivery_first_name}} {{$order->delivery_last_name}}</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    {{$order->delivery_address_1}}
                                </div>
                                <div class="my-1">
                                    {{$order->delivery_address_2}}
                                </div>
                                <div class="my-1">
                                    {{$order->delivery_country}} {{$order->delivery_city}}, {{$order->area}}, {{$order->landmark}}
                                </div>
                                <div class="my-1">
                                    <i class="fa fa-envelope fa-flip-horizontal text-secondary"></i>
                                    <b class="text-600">{{Auth::user()->email}}</b>
                                </div>
                                <div class="my-1">
                                    <i class="fa fa-phone fa-flip-horizontal text-secondary"></i>
                                    <b class="text-600">{{Auth::user()->phone}}</b>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="text-95 col-sm-4 offset-sm-4 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                    Invoice
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span> #{{$order->invoice_number}}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Order Date:</span> {{date('d F, Y',strtotime($order->created_at))}}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Status:</span> <span>{{$order->order_status}}</span></div>
                                @if($order->transaction_id != '')
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Transaction ID:</span> {{$order->transaction_id}}</div>
                                @endif
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="mt-4 invoice_table">
                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                            <div class="d-none d-sm-block col-1">#</div>
                            <div class="col-8 col-sm-5">Description</div>
                            <div class="d-none d-sm-block col-2 col-sm-1">Qty</div>
                            <div class="d-none d-sm-block col-sm-1">Unit Price</div>
                            {{-- <div class="d-none d-sm-block col-2 col-sm-1">Envt. Fee</div>
                            <div class="d-none d-sm-block col-2 col-sm-1">Taxes</div> --}}
                            <div class="col-2">Amount</div>
                        </div>

                        <div class="text-95 text-secondary-d3">
                            @php
                                $subtotal  = 0;
                                $count = 1;
                                $env_check = 0;
                                $taxes_check = 0;
                            @endphp
                            @foreach($order_products as $order_product)
                                @php
                                    $product = App\Product::where('id', $order_product->order_products_product_id)->first();
                                    $order = App\orders::where('id', $order_product->orders_id)->first();
                                    $envFee = (float)$product->env_fee;
                                    $taxes = (float)$product->taxes;

                                    $start = new DateTime($order->start_date);
                                    $end = new DateTime($order->end_date);
                                    $interval = $start->diff($end);
                                    $day = $interval->days;

                                    $pricePerDay = (\App\ProductAttribute::where(['product_id' => $order_product->order_products_product_id, 'attribute_id' => 14])->first()->price) ?? 0.00;
                                    $pricePerWeek = (\App\ProductAttribute::where(['product_id' => $order_product->order_products_product_id, 'attribute_id' => 15])->first()->price) ?? 0.00;
                                    $pricePerMonth = (\App\ProductAttribute::where(['product_id' => $order_product->order_products_product_id, 'attribute_id' => 16])->first()->price) ?? 0.00;
                                    $priceFor35Days = (float)$pricePerMonth + (float)$pricePerWeek;
                                    $priceFor42Days = (float)$pricePerMonth + (float)$pricePerWeek * 2;
                                    $priceFor49Days = (float)$pricePerMonth + (float)$pricePerWeek * 3;
                                    $daysInMonth = 28;
                                    $daysInWeek = 7;
                                    $months = floor($day / $daysInMonth);
                                    $remainingDays = $day % $daysInMonth;
                                    $weeks = floor($remainingDays / $daysInWeek);
                                    $remainingDays = $remainingDays % $daysInWeek;
                                    $days = $remainingDays;

                                    $totalPriceTemp = ($months * $pricePerMonth) + ($weeks * $pricePerWeek) + ($days * $pricePerDay);

                                    $totalWeeks = ceil($day / $daysInWeek);
                                    $totalMonths = ceil($day / $daysInMonth);

                                    $priceByWeeks = $totalWeeks * $pricePerWeek;
                                    $priceByMonths = $totalMonths * $pricePerMonth;

                                    $totalPrice = min($totalPriceTemp, $priceByWeeks, $priceByMonths);

                                    if ($day > 30 && $day <= 35) {
                                        $totalPrice = min($totalPrice, $priceFor35Days);
                                        if ($totalPrice > $pricePerMonth * 2) {
                                            $totalPrice = $pricePerMonth * 2;
                                        }
                                    } elseif ($day > 35 && $day <= 42) {
                                        $totalPrice = min($totalPrice, $priceFor42Days);
                                        if ($totalPrice > $pricePerMonth * 2) {
                                            $totalPrice = $pricePerMonth * 2;
                                        }
                                    } elseif ($day > 42 && $day <= 49) {
                                        $totalPrice = min($totalPrice, $priceFor49Days);
                                        if ($totalPrice > $pricePerMonth * 2) {
                                            $totalPrice = $pricePerMonth * 2;
                                        }
                                    }


                                    $itemTotalPrice = $totalPrice * $order_product->order_products_qty;

                                    $envFeeFinal = ($envFee / 100) * $itemTotalPrice;
                                    $taxFinal = ($taxes / 100) * $itemTotalPrice;

                                    $total_price = number_format($itemTotalPrice, 2, '.', '');
                                    $env_fee_final = number_format($envFeeFinal, 2, '.', '');
                                    $tax_final = number_format($taxFinal, 2, '.', '');
                                @endphp
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count }}</div>
                                <div class="col-8 col-sm-5">{{$order_product->order_products_name}}</div>
                                <div class="d-none d-sm-block col-2">{{$order_product->order_products_qty}}</div>
                                <div class="d-none d-sm-block col-2">${{ number_format($order_product->order_products_price, 2) }}</div>
                                {{-- <div class="d-none d-sm-block col-2">${{ number_format($envFeeFinal, 2) }}</div>
                                <div class="d-none d-sm-block col-2">${{ number_format($taxFinal, 2) }}</div> --}}
                                <div class="col-2 text-secondary-d2">${{ number_format($itemTotalPrice, 2) }}</div>

                            </div>
                            @php
                                $subtotal += $total_price + $env_fee_final + $tax_final;
                                $env_check += $env_fee_final;
                                $tax_check += $tax_final;
                                $count++;
                            @endphp
                            @endforeach
                            @php
                                $otherFees = App\Http\Traits\HelperTrait::returnFlag(1977);
                                $rentalProtection = App\Http\Traits\HelperTrait::returnFlag(1975);
                                $deliveryFee = App\Http\Traits\HelperTrait::returnFlag(1974);

                                $otherFees_final = ($otherFees / 100) * $subtotal;
                                $rentalProtection_final = ($rentalProtection / 100) * $subtotal;
                            @endphp
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count }}</div>
                                <div class="col-8 col-sm-5">Round-trip delivery</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                {{-- <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div> --}}
                                <div class="col-2 text-secondary-d2">${!! number_format($deliveryFee, 2) !!}</div>
                            </div>
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count + 1 }}</div>
                                <div class="col-8 col-sm-5">Rental protection plan</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                {{-- <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div> --}}
                                <div class="col-2 text-secondary-d2">${!! number_format($env_check, 2) !!}</div>
                            </div>
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count + 1 }}</div>
                                <div class="col-8 col-sm-5">Environmental Service Fee</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                {{-- <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div> --}}
                                <div class="col-2 text-secondary-d2">${!! number_format($rentalProtection_final, 2) !!}</div>
                            </div>
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count + 2 }}</div>
                                <div class="col-8 col-sm-5">Other fees</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                {{-- <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div> --}}
                                <div class="col-2 text-secondary-d2">${!! number_format($otherFees_final, 2) !!}</div>
                            </div>
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count + 1 }}</div>
                                <div class="col-8 col-sm-5">Taxes</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                {{-- <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2">---</div> --}}
                                <div class="col-2 text-secondary-d2">${!! number_format($tax_check, 2) !!}</div>
                            </div>
                            @php
                                $estimatedSubtotal = ($subtotal + $rentalProtection_final + $otherFees_final + $deliveryFee);
                            @endphp
                        </div>

                        <div class="row border-b-2 brc-default-l2"></div>

                        <div class="row mt-3">
                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                {{$order->order_notes}}
                            </div>

                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        SubTotal
                                    </div>
                                    <div class="col-5">
                                        <span class="text-120 text-secondary-d1">${!! number_format($estimatedSubtotal, 2) !!}</span>
                                    </div>
                                </div>
                                @if($order->order_shipping)
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Shipping
                                    </div>
                                    <div class="col-5">
                                        <span class="text-110 text-secondary-d1">${!! number_format($order->order_shipping, 2) !!}</span>
                                    </div>
                                </div>
                                @endif

                                {{-- <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Discount
                                    </div>
                                    <div class="col-5">
                                        <span class="text-110 text-secondary-d1">${!! number_format($order->discount) !!}</span>
                                    </div>
                                </div> --}}

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right">
                                        Total Amount
                                    </div>
                                    <div class="col-5">
                                        <?php
                                            $shipping = $order->order_shipping ;
                                        ?>
                                        <span class="text-150 text-success-d3 opacity-2">${!! number_format($estimatedSubtotal + $shipping, 2) !!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('css')
<style type="text/css">
.text-secondary-d1 {
    color: black;
}
section.invoice {
    margin: 60px;
}

#footer-form,#feedback-form {
    display: none;
}

.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: black;
    font-family: HelveticaNeueLTStd-Lts;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #c91d22;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {background: var(--blue-color);}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.text-95.text-secondary-d3 {
    font-family: HelveticaNeueLTStd-Lts;
    font-weight: BOLD;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color:#11A4EC;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}

.section-heading.dark-color {
    position: relative;
    z-index: 0;
}

.section-heading.dark-color span {
    position: absolute;
    top: 0;
    right: 0;
}
.mt-4.invoice_table .col-2 {
    width: 8.33333333% !important;
}
</style>
@endsection
@section('js')

<script type="text/javascript">



</script>

@endsection
