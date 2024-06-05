@extends('layouts.main')
@section('content')

<?php $segment = Request::segments(); ?>


<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">View Product Details</span></h1>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="quotes">
    <div class="page-content container">
        <div class="container px-0">
            <div class="row">
                <div class="col-12 col-lg-10 offset-lg-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-150">
                                <div class="section-heading dark-color">
                                    <h3>Quotes
                                    <small class="page-info">
                                        <i class="fa fa-angle-double-right text-80"></i>
                                        ID: #{{$bulkOrders->id}}
                                    </small></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .row -->

                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                    <div class="row">
                        <div class="col-sm-4">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">Name:</span>
                                <span class="text-600 text-110 text-blue align-middle">{{$quote->first_name}} {{$quote->last_name}}</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    <i class="fa fa-envelope fa-flip-horizontal text-secondary"></i>
                                    <b class="text-600">{{$quote->email}}</b>
                                </div>
                                <div class="my-1">
                                    <i class="fa fa-phone fa-flip-horizontal text-secondary"></i>
                                    <b class="text-600">{{$quote->phone}}</b>
                                </div>
                                <div class="my-1">
                                    <i class="fa fa-building fa-flip-horizontal text-secondary"></i>
                                    <b class="text-600">{{$quote->company}}</b>
                                </div>
                                <div class="my-1">
                                    <i class="fa fa-address-card fa-flip-horizontal text-secondary"></i>
                                    <b class="text-600">{{$quote->address}}</b>
                                </div>
                                <div class="my-1">
                                    <i class="fa fa-map-marker  fa-flip-horizontal text-secondary"></i>
                                    <b class="text-600">{{$quote->city.', '.$quote->state}}</b>
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

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span> #{{$bulkOrders->id}}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Order Date:</span> {{date('d F, Y h:i a',strtotime($bulkOrders->created_at))}}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Transaction:</span> {{$bulkOrders->transaction_id}}</div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="mt-4">
                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                            <div class="d-none d-sm-block col-1">#</div>
                            <div class="col-9 col-sm-5">Item Name</div>
                            <div class="d-none d-sm-block col-4 col-sm-2">Item Price</div>
                            <div class="d-none d-sm-block col-sm-2">Quantity</div>
                            <div class="col-2">Total</div>
                        </div>

                        <div class="text-95 text-secondary-d3">
                            @php
                                $subtotal  = 0;
                                $count = 1;
                                // if(!empty($quote->quote_prod_ids)){
                                //     $quote_product_arr = explode(',', $quote->quote_prod_ids);
                                // }
                            @endphp
                            @foreach ($quote->quote_products as $val)
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count }}</div>
                                <div class="col-9 col-sm-5">{{$val->product_title}}</div>
                                <div class="d-none d-sm-block col-2">${{$val->item_price}}</div>
                                <div class="d-none d-sm-block col-2 text-95">{{$val->quantity}}</div>
                                <div class="col-2 text-secondary-d2">${{$val->price}}</div>
                            </div>
                            @php 
                                $subtotal+= $val->item_price * $val->quantity;
                                $count++;
                            @endphp
                            @endforeach
                            @php
                                $deliveryFee = App\Http\Traits\HelperTrait::returnFlag(1974);
                                $rentalProtection = App\Http\Traits\HelperTrait::returnFlag(1975);
                                if($quote->discount != null)
                                {
                                    $rental_price = $quote->discount;
                                }else{
                                    $rental_price = $subtotal;
                                }
                                $rentalProtection_final = ($rentalProtection / 100) * $rental_price;
                            @endphp
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count }}</div>
                                <div class="col-9 col-sm-5">Delivery Fee</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2 text-95">---</div>
                                <div class="col-2 text-secondary-d2">${!! number_format($deliveryFee, 2) !!}</div>
                            </div>
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">{{ $count + 1 }}</div>
                                <div class="col-9 col-sm-5">Rental protection plan</div>
                                <div class="d-none d-sm-block col-2">---</div>
                                <div class="d-none d-sm-block col-2 text-95">---</div>
                                <div class="col-2 text-secondary-d2">${!! number_format($rentalProtection_final, 2) !!}</div>
                            </div>
                        </div>
                        

                        <div class="row border-b-2 brc-default-l2"></div>

                        <div class="row mt-3">
                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                {{-- {{$quote->order_notes}} --}}
                            </div>
                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        SubTotal
                                    </div>
                                    <div class="col-5">
                                        <span class="text-120 text-secondary-d1">${!! number_format($subtotal, 2) !!}</span>
                                    </div>
                                </div>
                                @if($quote->discount != null)
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Admin Price
                                    </div>
                                    <div class="col-5">
                                        <span class="text-110 text-secondary-d1">${!! number_format($quote->discount, 2) !!}</span>
                                    </div>
                                </div>
                                @endif
                                {{-- @if($quote->bulk_status == 1)
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Bulk Amount
                                    </div>
                                    <div class="col-5">
                                        <span class="text-110 text-secondary-d1">${{$quote->bulk_amount}}</span>
                                    </div>
                                </div>
                                @php
                                    $total = $quote->bulk_amount;
                                @endphp
                                @else
                                @php
                                    $total = $subtotal;
                                @endphp
                                @endif --}}

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right">
                                        Total Amount
                                    </div>
                                    @php
                                        if($quote->discount != null)
                                        {
                                            $total = $quote->discount;
                                        }else{
                                            $total = $subtotal;
                                        }
                                        $total = $total + $deliveryFee + $rentalProtection_final;
                                    @endphp
                                    <div class="col-5">
                                        <span class="text-150 text-success-d3 opacity-2">${!! number_format($total, 2) !!}</span>
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

#footer-form{
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


</style>
@endsection
@section('js')
<script type="text/javascript">


</script>

@endsection
