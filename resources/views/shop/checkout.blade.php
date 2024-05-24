@extends('layouts.main')
@section('title', 'Checkout')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
        integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .payment-accordion img {
            display: inline-block;
            margin-left: 10px;
            background-color: white;
        }

        form#order-place .form-control {
            border-width: 1px;
            border-color: rgb(150, 163, 218);
            border-style: solid;
            border-radius: 8px;
            background-color: transparent;
            height: 54px;
            padding-left: 15px;
            color: black;
        }

        form#order-place textarea.form-control {
            height: auto !important;
        }

        #footer-form {
            display: none;
        }

        .checkoutPage {
            padding: 50px 0px;
        }

        .checkoutPage .section-heading h3 {
            margin-bottom: 30px;
        }

        .YouOrder {
            background: var(--blue-color);
            color: white;
            padding: 25px;
            padding-bottom: 2px;
            min-height: 300px;
            border-radius: 3px;
            margin-bottom: 20px;
        }

        .amount-wrapper {
            padding-top: 12px;
            border-top: 2px solid white;
            text-align: left;
            margin-top: 90px;
        }

        .amount-wrapper h2 {
            font-size: 20px;
            display: flex;
            justify-content: space-between;
        }

        .amount-wrapper h3 {
            display: FLEX;
            justify-content: SPACE-BETWEEN;
            font-size: 22px;
            border-top: 2px solid white;
            padding-top: 10px;
            margin-top: 14px;
        }

        .checkoutPage span.invalid-feedback strong {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            display: block;
            width: 100%;
            font-size: 15px;
            padding: 5px 15px;
            border-radius: 6px;
        }

        .payment-accordion .btn-link {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px 19px;
            color: black;
        }

        .payment-accordion .card-header {
            padding: 0px !important;
        }

        .payment-accordion .card-header:first-child {
            border-radius: 0px;
        }

        .payment-accordion .card {
            border-radius: 0px;
        }

        .form-group.hide {
            display: none;
        }

        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
            border-width: 1px;
            border-color: rgb(150, 163, 218);
            border-style: solid;
            margin-bottom: 10px;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        div#card-errors {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            display: block;
            width: 100%;

            font-size: 15px;
            padding: 5px 15px;
            border-radius: 6px;
            display: none;
            margin-bottom: 10px;
        }

        .rent-sec {
            background-image: url('{{ asset('/images/2.png') }}') !important;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 800px;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 0;
        }

        .about-inner {
            height: 400px;
            align-items: end;
        }



        /* #stripe-submit {
                margin-left: 315px;

            } */

        .tabs-sign {
            position: relative;
        }

        .radio {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .radio-1 {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tabs-sign input[type="radio"],
        .tabs-sign input[type="checkbox"] {
            position: absolute;
            opacity: 0;
        }


        .radio.active {
            background: var(--blue-color);
            width: 100%;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: white !important;
        }

        .radio-1.active {
            background: var(--blue-color);
            width: 100%;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: white !important;
        }

        .radio-1.active label {
            color: white;
            margin-bottom: 10px;
        }

        .radio-1.active label {
            position: relative;
        }





        .radio.active label {
            color: white;
            margin-bottom: 10px;
        }

        .cardss {
            float: right;
            margin-top: 12px;
        }

        .cardss img {
            width: 240px;
        }

        a.cart_icons {
            pointer-events: none;
        }
    </style>
@endsection
@section('content')
    @php
        $new_cart = [
            "items" => [],
        ];
        foreach ((session()->get('cart') ?? []) as $product_id => $item) {
            $product = \App\Product::find($product_id);
            $qty = $item['qty'];
            $price = floatval($item['price']);
            $price_per_day = (\App\ProductAttribute::where(['product_id' => $product_id, 'attribute_id' => 14])->first()->price) ?? 0.00;
            $price_per_week = (\App\ProductAttribute::where(['product_id' => $product_id, 'attribute_id' => 15])->first()->price) ?? 0.00;
            $price_per_month = (\App\ProductAttribute::where(['product_id' => $product_id, 'attribute_id' => 16])->first()->price) ?? 0.00;
            $new_cart ['items'] []= [
                'id' => $product_id,
                'name' => $product->product_title,
                'qty' => $item['qty'],
                'delivery_charges' => $item['delivery_charges'],
                'price_per_day' => $price_per_day,
                'price_per_week' => $price_per_week,
                'price_per_month' => $price_per_month,
            ];
        }
        $new_cart['delivery_charges'] = $new_cart['items'][0]['delivery_charges'];

        //first calculation
        $rental_subtotal = 0.00;
        $round_trip_delivery = 0.00;
        $rental_protection_plan = 0.00;
        $environmental_service_fee = 0.00;
        $other_fees = 0.00;
        $taxes = 0.00;
        $estimated_subtotal = 0.00;

        if(Session::get('daterange') != null){
            $date_array = explode(', ', str_replace(['[', ']'], '', Session::get('daterange')));
            $date_start = Carbon\Carbon::createFromFormat('m-d-Y', $date_array[0]);
            $date_from = Carbon\Carbon::createFromFormat('m-d-Y', $date_array[1]);

            $days = $date_start->diffInDays($date_from);
        } else {
            $days = 1;
        }

        $price_key = '';
        $day_values = [
            'price_per_month' => 28,
            'price_per_week' => 7,
            'price_per_day' => 1,
        ];

        if ($days > 28) {
            $price_key = 'price_per_month';
        } else if ($days > 7) {
            $price_key = 'price_per_week';
        } else {
            $price_key = 'price_per_day';
        }

        foreach ($new_cart['items'] as $cart_item) {
            $day_value = $day_values[$price_key];
            $multiplier_value = $days / $day_value;
            $product_total = (floatval($cart_item[$price_key]) * floatval($multiplier_value)) * ($cart_item['qty']);
            $rental_subtotal += $product_total;

            $cart_item['total'] = $product_total;
        }

        $new_cart['sub_total'] = $rental_subtotal;
    @endphp

    @php

        $getdate = Session::get('daterange');
        if (Session::has('daterange')) {
            $string = str_replace(['[', ']'], '', $getdate);

            $date_array = explode(', ', $string);
            // dd($date_array);
            $date_start = Carbon\Carbon::createFromFormat('m-d-Y', $date_array[0]);
            $date_from = Carbon\Carbon::createFromFormat('m-d-Y', $date_array[1]);
        } else {
            $date_start = Carbon\Carbon::now();
            $date_from = Carbon\Carbon::now();
        }
    @endphp
    {{-- @dump($date_start)
                            @dump($date_from) --}}
    <section class="rent-sec about-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="equipment">
                        <h1><span class="d-block">checkout</span></h1>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="check-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="check-form-s">
                        <div class="check-form-p">
                            <h1>Checkout</h1>
                        </div>
                        <form action="{{ route('order.place') }}" method="POST" id="order-place">
                            @csrf

                            <?php $_getUser = DB::table('users')
                                ->where('id', '=', Auth::user()->id)
                                ->first(); ?>
                            <input type="hidden" name="payment_id" value="" />
                            <input type="hidden" name="payer_id" value="" />
                            <input type="hidden" name="payment_status" value="" />
                            <input type="hidden" name="order_total" id="order_total" value="" />
                            <input type="hidden" name="payment_method" id="payment_method" value="paypal" />
                            <input type="hidden" id="f-name" name="first_name" value="<?php echo Auth::user()->name; ?>">


                            <div class="main-check-one">
                                <div class="order-check" id="order_detail">
                                    <span>1</span>
                                    <h4>Order details</h4>
                                </div>

                                <div class="tabs-sign" id="order_detail_box">
                                    <ul id="myTabs" class="nav nav-pills nav-justified" role="tablist" data-tabs="tabs">
                                        <li>

                                            <label for="trip" class="radio-1" id="tripLabel">Round-trip delivery</label>
                                            <input type="radio" name="round_trip" value="1" id="trip" required>

                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade fade in active" id="Videos">
                                            <div class="pickup-main">

                                                @if (Auth::check())
                                                @else
                                                    <div class="second-menu">
                                                        <p>Delivery is only available with a ZapGo Rentals account.</p>
                                                        <a href="#" class="btn blue-custom" data-bs-toggle="modal"
                                                            data-bs-target="#sign_tabs_poppup">Sign in</a>
                                                        <a href="#" class="btn blue-custom" data-bs-toggle="modal"
                                                            data-bs-target="#sign-UP_tabs_poppup">Create a free accounts</a>
                                                    </div>
                                                @endif

                                                <div class="btn-last">
                                                    @if (Auth::check())
                                                        <a id="order_detail_save" class="btn blue-custom">Save and continue
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                    </div>






                    <div class="main-check-one">
                        <div class="order-check" id="get_order">
                            <span>2</span>
                            <h4>How To Get Your Order</h4>

                        </div>
                        <div class="pickup-main" id="get_order_box">

                            <div class="row">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">Start Date</label>
                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ $date_start->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">End Date</label>
                                        <input type="date" class="form-control" name="end_date"
                                            value="{{ $date_from->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label>Address</label>
                                    <input type="text" name="delivery_address_1" class="form-control"
                                        placeholder="2 Stasen place" required>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('delivery_address_1') }}</strong>
                                    </span>
                                </div>

                                <div class="form-group col-12">
                                    <label>Address Line 2</label>
                                    <input type="text" name="delivery_address_2" class="form-control"
                                        placeholder="Optional">
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('delivery_address_2') }}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-12">
                                    <label>City</label>
                                    <input type="text" name="delivery_city" class="form-control"
                                        placeholder="Zionsvilla" required>
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('delivery_city') }}</strong>
                                    </span>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">State</label>
                                        @php
                                            $state = DB::table('states')->get();
                                        @endphp
                                        <select class="form-control" id="exampleFormControlSelect1" name="delivery_state"
                                            required>
                                            <option value="" selected>Choose State</option>
                                            @foreach ($state as $value)
                                                <option value="{{ $value->name }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <span class="invalid-feedback">
                                        <strong>{{ $errors->first('delivery_state') }}</strong>
                                        </span> --}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Zip Code</label>
                                        <input type="number" placeholder="46077" class="form-control"
                                            name="delivery_zip_code" required>
                                        {{-- <span class="invalid-feedback">
                                                <strong>{{ $errors->first('delivery_zip_code') }}</strong>
                                              </span> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="btn-last">
                                <a id="get_order_save" class="btn blue-custom">Save and continue </a>
                            </div>
                        </div>
                    </div>
                    <div class="main-check-one">
                        <div class="main-chck-two" id="recovery_time">
                            <span>3</span>
                            <h4>Select Delivery And Recovery Time</h4>
                        </div>
                        <div class="pickup-main" id="recovery_time_box">
                            <div class="f-h">
                                <h4>Delivery and Recovery time</h4>
                                <p>A driver from ZapGo Rental will drop off and Recover your equipment</p>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <p>Rental start : {{ $date_start->format('M d, Y') }}</p>
                                        <label for="inputEmail4">Delivery Time</label>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"
                                            name="delivery_time" required>
                                            <option value="Available All Time" selected>Available All Time</option>
                                            <option value="07:00 AM - 09:00 AM">07:00 AM - 09:00 AM</option>
                                            <option value="09:00 AM - 11:00 PM">09:00 AM - 11:00 AM</option>
                                            <option value="01:00 PM - 03:00 PM">01:00 PM - 03:00 PM</option>
                                        </select>
                                        {{-- <span class="invalid-feedback">
                                            <strong>{{ $errors->first('delivery_time') }}</strong>
                                          </span> --}}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <p>Rental end : {{ $date_from->format('M d, Y') }}</p>
                                        <label for="inputPassword4">Recovery Time</label>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect"
                                            name="pickup_time" required>
                                            <option value="Available All Time" selected>Available All Time</option>
                                            <option value="07:00 AM - 09:00 AM">07:00 AM - 09:00 AM</option>
                                            <option value="09:00 AM - 11:00 PM">09:00 AM - 11:00 AM</option>
                                            <option value="01:00 PM - 03:00 PM">01:00 PM - 03:00 PM</option>
                                        </select>
                                        {{-- <span class="invalid-feedback">
                                            <strong>{{ $errors->first('pickup_time') }}</strong>
                                          </span> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="btn-last">
                                <a id="recovery_time_save" class="btn blue-custom">Save and continue </a>
                            </div>
                        </div>
                    </div>
                    <div class="main-check-one">
                        <div class="main-chck-two" id="recieving_order">
                            <span>4</span>
                            <h4>Who's Receiving The Order?</h4>
                        </div>
                        <div class="pickup-main" id="recieving_order_box">
                            <div class="second-menu">
                                <p>Who will be receiving the order?</p>

                                <div class="tabs-sign">
                                    <ul id="myTabs" class="nav nav-pills nav-justified" role="tablist"
                                        data-tabs="tabs">

                                        <li>
                                            {{-- <a data-toggle="tab" href="#Video">Me</a> --}}
                                            <div class="radio" id="radio_btn">
                                                <label for="me">ME</label>
                                                <input type="radio" id="me" name="delivery_pickup"
                                                    data-toggle="tab" value="ME">
                                            </div>
                                        </li>

                                        <li id="radio2_btn">
                                            {{-- <a href="#Video" data-toggle="tab">Someone else</a> --}}
                                            <a href="#Video" data-toggle="tab">Someone else</a>
                                        </li>


                                    </ul>
                                    <p>
                                        Anyone taking possession of ZapGo Rentals equipment, you must be 18 years or
                                        older
                                        and provide valid Government/state issued identification.
                                    </p>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade" id="Video">
                                            <div class="pickup-main">
                                                <div class="second-menu" id="someoneElseContent">
                                                    <p>
                                                        Please provide that the relevant person: </p>

                                                    <div class="form-group">
                                                        <label for="inputAddress">First Name</label>
                                                        <input type="text" class="form-control" id="inputAddress"
                                                            fdprocessedid="83rau" name="picker_fname">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputAddress">Last Name</label>
                                                        <input type="text" class="form-control" id="inputAddress"
                                                            fdprocessedid="83rau" name="picker_lname">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputAddress">Phone No: </label>
                                                        <input type="tel" class="form-control" id="inputAddress"
                                                            fdprocessedid="83rau" name="picker_idcard">
                                                    </div>


                                                </div>

                                            </div>

                                        </div>

                                    </div>





                                </div>

                            </div>
                            <div class="btn-last">
                                <a id="recieving_order_save" class="btn blue-custom">Save and continue </a>
                            </div>


                        </div>
                    </div>


                    </form>


                </div>



                <div class="col-lg-6">
                    <div class="side-summary">
                        <div class="summary-main">
                            <h2>Order summary</h2>
                        </div>
                        <div class="drop-menu" id="main-layout">
                            <div class="itme-main">
                                <div class="main-box">
                                    <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                        class="cmp-RentalReviewList__rentalreviewlist__cartIconStyle"
                                        data-testid="checkout_itemscounts_label">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.382 14H8.764L7.127 8h12.255l-3 6Zm4.701-7.052A1.986 1.986 0 0 0 19.382 6h-12.8l-.617-2.263A1 1 0 0 0 5 3H2a1 1 0 1 0 0 2h2.236l2.799 10.263A1 1 0 0 0 8 16h9c.379 0 .725-.214.895-.553l3.276-6.553a1.986 1.986 0 0 0-.088-1.946ZM7.75 17.5a1.75 1.75 0 1 0 0 3.5 1.75 1.75 0 0 0 0-3.5ZM16 19.25a1.75 1.75 0 1 1 3.5 0 1.75 1.75 0 0 1-3.5 0Z"
                                            fill="#0B3E21"></path>
                                    </svg>
                                    <p>items</p>
                                </div>
                                <span><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                            <div class="Rentals-bottom" id="main-box-layout">

                                <h6>Rentals</h6>
                                <?php
                                $cart = Session::get('cart');
                                // dd($cart);
                                $subtotal = 0;
                                $addon_total = 0;
                                $variation = 0; ?>
                                @foreach ($cart as $key => $value)
                                    <?php // $subtotal += $value['price'] * $value['qty'];
                                    $prod_image = App\Product::where('id', $value['id'])->first();
                                    $day = Session::get('daterange') != null ? $date_start->diffInDays($date_from) : 1;

                                    // Fetch the per week price
                                    $weekAttributeValue = App\AttributeValue::where('value', 'Week')->first();
                                    $weekProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])
                                        ->where('attribute_id', $weekAttributeValue->attribute_id)
                                        ->first();
                                    $per_week_price = $weekProductAttribute->price; // Calculate per week price
                                    // Fetch the per month price
                                    $monthAttributeValue = App\AttributeValue::where('value', 'Month')->first();
                                    $monthProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])
                                        ->where('attribute_id', $monthAttributeValue->attribute_id)
                                        ->first();
                                    $per_month_price = $monthProductAttribute->price; // Calculate per month price

                                    if ($day >= 28) {
                                        $monthCount = floor($day / 28); // Calculate number of months (each month is 28 days)
                                        $remainingDays = $day % 28; // Calculate remaining days after whole months

                                        // Fetch the price for a month
                                        $monthAttributeValue = App\AttributeValue::where('value', 'Month')->first();
                                        $monthProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])
                                            ->where('attribute_id', $monthAttributeValue->attribute_id)
                                            ->first();

                                        // Calculate subtotal for whole months
                                        $subtotal = $monthProductAttribute->price * $monthCount;

                                        // If there are remaining days, calculate additional daily rate
                                        if ($remainingDays > 0) {
                                            // If there's a day price, add it
                                            $dailyAttributeValue = App\AttributeValue::where('value', 'Day')->first();
                                            if ($dailyAttributeValue) {
                                                $dailyProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])
                                                    ->where('attribute_id', $dailyAttributeValue->attribute_id)
                                                    ->first();

                                                // Add additional daily rate for remaining days
                                                $subtotal += $dailyProductAttribute->price * $remainingDays;
                                            }
                                        }
                                    } elseif ($day >= 7) {
                                        $weekCount = floor($day / 7); // Calculate number of weeks
                                        $remainingDays = $day % 7; // Calculate remaining days after whole weeks

                                        // Calculate subtotal for whole weeks
                                        $subtotal = $weekProductAttribute->price * $weekCount;

                                        // If there are remaining days, calculate additional daily rate
                                        if ($remainingDays > 0) {
                                            // If there's a day price, add it
                                            $dailyAttributeValue = App\AttributeValue::where('value', 'Day')->first();
                                            if ($dailyAttributeValue) {
                                                $dailyProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])
                                                    ->where('attribute_id', $dailyAttributeValue->attribute_id)
                                                    ->first();

                                                // Add additional daily rate for remaining days
                                                $subtotal += $dailyProductAttribute->price * $remainingDays;
                                            }
                                        }
                                    } else {
                                        // For rentals less than 7 days, use the standard daily rate
                                        $subtotal = $value['price'] * $value['qty'] * $day;
                                        // dump($subtotal);
                                    }

                                    if ($day < 7 && $subtotal >= $per_week_price) {
                                        $subtotal = $per_week_price;
                                    } elseif ($day < 28 && $subtotal >= $per_month_price) {
                                        $subtotal = $per_month_price;
                                    }
                                    ?>
                                    <h5>{{ $value['name'] }} <span>${{ $value['price'] * $value['qty'] }} x
                                            {{ $day }} Day = ${{ $subtotal }}</span>
                                    </h5>
                                    <hr>
                                @endforeach


                                <p class="date-range">
                                    <span class="date-start">From: {{ $date_start->format('d F, Y') }}</span> -
                                    <span class="date-end">Till: {{ $date_from->format('d F, Y') }}</span>

                                </p>
                                <p class="days">
                                    {{ $date_start->diffInDays($date_from) }} Days
                                </p>
                            </div>
                            <?php $day = $date_start->diffInDays($date_from);

                            // dd($subtotal);

                            ?>

                        </div>
                        <?php

                        $tax = App\Http\Traits\HelperTrait::returnFlag(1973);
                        $otherFees = App\Http\Traits\HelperTrait::returnFlag(1977);
                        $envFee = App\Http\Traits\HelperTrait::returnFlag(1976);
                        $rentalProtection = App\Http\Traits\HelperTrait::returnFlag(1975);
                        $deliveryFee = App\Http\Traits\HelperTrait::returnFlag(1974);

                        $tax_final = ($tax / 100) * $rental_subtotal;
                        $otherFees_final = ($otherFees / 100) * $rental_subtotal;
                        $envFee_final = ($envFee / 100) * $rental_subtotal;
                        $rentalProtection_final = ($rentalProtection / 100) * $rental_subtotal;

                        ?>
                        <ul class="total-row">
                            <li>
                                <p>Taxes and fees will be calculated before rental confirmation.</p>
                            </li>
                            <li>
                                <p>Rental subtotal:</p>
                                <p>${{ number_format($rental_subtotal, 2) }}</p>
                            </li>
                            <li>
                                <p>Purchases subtotal: </p>
                                <p>-</p>
                            </li>
                            <!--<li>-->
                            <!--    <p>In-store pickup:</p><p><strong>Free</strong></p>-->
                            <!--</li>-->
                            <li>
                                <p>Round-trip delivery: </p>
                                <p>${!! number_format($deliveryFee, 2) !!}</p>
                            </li>
                            <li>
                                <p>Rental protection plan:</p>
                                <p>${{ number_format($rentalProtection_final, 2) }}</p>
                            </li>
                            <li>
                                <p>Prepay Fuel Option:</p>
                                <p>-</p>
                            </li>
                            <li>
                                <p>Environmental Service Fee:</p>
                                <p>${{ number_format($envFee_final, 2) }}</p>
                            </li>
                            <li>
                                <p>Other fees:</p>
                                <p>${{ number_format($otherFees_final, 2) }}</p>
                            </li>

                            <li>
                                <p>Taxes:</p>
                                <p>${{ number_format($tax_final, 2) }}</p>
                            </li>
                            @php
                                $estimatedSubtotal = ($rental_subtotal+$rentalProtection_final+$envFee_final+$otherFees_final+$tax_final+$deliveryFee);
                            @endphp
                            <li>
                                <p>Estimated subtotal:</p>
                                <p>${{ number_format($estimatedSubtotal, 2) }}</p>
                            </li>
                        </ul>


                        <div class="summary-main" id="payments_obox">
                            <h2 class="mb-3">Payment</h2>
                            <div class="accordion accordion-flush" id="order_payment_box">
                                <!--<div class="accordion-item">-->
                                <!--    <h2 class="accordion-header" id="flush-headingOne">-->
                                <!--        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"-->
                                <!--            data-bs-target="#flush-collapseOne" aria-expanded="false"-->
                                <!--            aria-controls="flush-collapseOne">-->
                                <!--            Pay with Paypal-->
                                <!--        </button>-->
                                <!--    </h2>-->
                                <!--    <div id="flush-collapseOne" class="accordion-collapse collapse"-->
                                <!--        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">-->
                                <!--        <div class="accordion-body">-->
                                <!--            <div class="card-body">-->

                                <!--                <input type="hidden" name="product_id" value="" />-->
                                <!--                <input type="hidden" name="price" value="{{ $subtotal }}" />-->
                                <!--                <input type="hidden" name="qty" value="value['qty']" />-->
                                <!--                <div id="paypal-button-container-popup"></div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                            aria-expanded="false" aria-controls="flush-collapseTwo">
                                            Pay with Credit Card
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">

                                            <div class="stripe-form-wrapper require-validation"
                                                data-stripe-publishable-key="{{ config('services.stripe.stripekey') }}"
                                                data-cc-on-file="false">
                                                <div id="card-element"></div>
                                                <div id="card-errors" role="alert"></div>
                                                <div class="form-group">
                                                    <button class="btn btn-red btn-block blue-custom" type="button"
                                                        id="stripe-submit">Pay Now
                                                        ${{ number_format($estimatedSubtotal) }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="cardss"><img src="{{ asset('images/cards.png') }}" alt=""></div>
                            <button type="submit" class="hvr-wobble-skew" style="display:none">place order</button>

                        </div>

                    </div>
                </div>
            </div>



    </section>



    <div class="modal fade" id="sign-UP_tabs_poppup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Sign Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="pickup-main">
                        <form class="loginForm" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">First Name</label>
                                    <input type="text" class="form-control" name="f_name" id="inputEmail4"
                                        fdprocessedid="psjzpg">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Last Name </label>
                                    <input type="text" class="form-control" name="l_name" id="inputPassword4"
                                        fdprocessedid="sivb2d">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputAddress">Email</label>
                                <input type="email" class="form-control"
                                    {{ $errors->has('email') ? ' is-invalid' : '' }} name="email" id="inputAddress"
                                    fdprocessedid="2uhckb">
                            </div>


                            <div class="form-group">
                                <label for="inputAddress">password</label>
                                <input type="password" class="form-control"
                                    {{ $errors->has('password') ? ' is-invalid' : '' }} name="password" id="inputAddress"
                                    fdprocessedid="3qd7yj">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="para-text-form">
                                <!--<p>Your password must contain at least one uppercase letter (A-Z), one lowercase letter-->
                                <!--    (a-z), one number (0-9), be at least eight characters long and can’t contain your-->
                                <!--    first name, last name, or email.-->
                                <!--</p>-->

                            </div>

                            <div class="form-group">
                                <label for="inputAddress">Company Name* why do we need your company name? ZapGO Rentals
                                    only provides.
                                    equipment rental to other Business.</label>
                                <input type="text" class="form-control" id="inputAddress" name="company_name"
                                    fdprocessedid="gmd40g">
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Phone #</label>
                                <input type="text" class="form-control" name="phone" id="inputAddress"
                                    fdprocessedid="buh3ho">
                            </div>

                            <div class="para-text">
                                <p>Address Information:
                                </p>

                            </div>

                            <div class="form-group">
                                <label for="inputAddress">Address</label>
                                <input type="text" class="form-control" name="address" id="inputAddress"
                                    fdprocessedid="p54q">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">City</label>
                                    <input type="text" class="form-control" name="city" id="inputCity"
                                        fdprocessedid="zzebrw">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">State</label>
                                    @php
                                        $state = DB::table('states')->get();
                                    @endphp

                                    <select id="inputState" name="state" class="form-control" fdprocessedid="p062zx">

                                        <option value="">Choose State</option>
                                        @foreach ($state as $value)
                                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputZip">Zip</label>
                                    <input type="text" name="zip" class="form-control" id="inputZip"
                                        fdprocessedid="pu5s1p">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <p class="age">Are You 18 +</p>
                                    <label for="blankRadio1">Yes</label>
                                    <input class="form-check-input position-static" type="radio" name="age"
                                        id="blankRadio1" value="Yes" aria-label="...">
                                </div>
                                <div class="form-check">
                                    <label for="blankRadio2">No</label>
                                    <input class="form-check-input position-static" type="radio" name="age"
                                        id="blankRadio2" value="No" aria-label="...">
                                </div>
                            </div>

                            <div class="para-text-form">
                                <p>State ID/ Driver’s License*
                                </p>

                                <!--<p>-->
                                <!--    Why do you need my ID information? For safety and security, you must be 18 years or-->
                                <!--    older and have a valid state issued ID or Driver’s License to accept ZapGO Rentals-->
                                <!--    equipment.-->
                                <!--</p>-->
                            </div>

                            <div class="form-group">
                                <label for="inputAddress">Chose State ID/ Driver’s License state*</label>
                                <input type="text" class="form-control" name="license_state" id="inputAddress"
                                    fdprocessedid="4r0x3i">
                            </div>

                            <div class="form-group">
                                <label for="inputAddress">State ID/ Driver’s License number*</label>
                                <input type="text" class="form-control" name="license_no" id="inputAddress"
                                    fdprocessedid="ovvet9">
                            </div>

                            <div class="form-check">
                                <label for="blankCheckbox">I agree to the Terms and Conditions</label>
                                <input class="form-check-input position-static" name="terms" type="checkbox"
                                    id="blankCheckbox" aria-label="...">
                            </div>

                            <div class="acc-free-sign-up-button">

                                <button class="btn blue-custom" type="submit" fdprocessedid="f5nq7f">Register</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // $(document).on('click', ".btn", function(e){
        //   $('#order-place').submit();
        // });

        $('#accordion .btn-link').on('click', function(e) {
            if (!$(this).hasClass('collapsed')) {
                e.stopPropagation();
            }
            $('#payment_method').val($(this).attr('data-payment'));
        });

        $('.bttn').on('change', function() {
            var count = 0;
            if ($(this).prop("checked") == true) {
                if ($('#f-name').val() == "") {
                    $('.fname').text('first name is required field');
                } else {
                    $('.fname').text("");
                    count++;
                }
                if ($('#l-name').val() == "") {
                    $('.lname').text('last name is required field');
                } else {
                    $('.lname').text("");
                    count++;
                }

                if (count == 2) {
                    $('#paypal-button-container-popup').show();
                } else {
                    $(this).prop("checked", false);

                    $.toast({
                        heading: 'Alert!',
                        position: 'bottom-right',
                        text: 'Please fill the required fields before proceeding to pay',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 5000,
                        stack: 6
                    });

                    return false;

                }

            } else {
                $('#paypal-button-container-popup').hide();
                // $('.btn').show();
            }

            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
            //$(this).siblings('input[type="checkbox"]').prop('checked', false);
        });

        paypal.Button.render({
            env: 'sandbox', //production

            style: {
                label: 'checkout',
                size: 'responsive',
                shape: 'rect',
                color: 'gold'
            },
            client: {
                sandbox: 'AV06KMdIerC8pd6_i1gQQlyVoIwV8e_1UZaJKj9-aELaeNXIGMbdR32kDDEWS4gRsAis6SRpUVYC9Jmf',
                // production:'ARIYLCFJIoObVCUxQjohmqLeFQcHKmQ7haI-4kNxHaSwEEALdWABiLwYbJAwAoHSvdHwKJnnOL3Jlzje',
            },
            validate: function(actions) {
                actions.disable();
                paypalActions = actions;
            },

            onClick: function(e) {
                var errorCount = checkEmptyFileds();

                if (errorCount == 1) {
                    $.toast({
                        heading: 'Alert!',
                        position: 'bottom-right',
                        text: 'Please fill the required fields before proceeding to pay',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 5000,
                        stack: 6
                    });
                    paypalActions.disable();
                } else {
                    paypalActions.enable();
                }
            },
            payment: function(data, actions) {
                return actions.payment.create({
                    payment: {
                        transactions: [{
                            amount: {
                                total: {{ number_format(((float) $subtotal), 2, '.', '') }},
                                currency: 'USD'
                            }
                        }]
                    }
                });
            },
            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function() {
                    // generateNotification('success','Payment Authorized');

                    $.toast({
                        heading: 'Success!',
                        position: 'bottom-right',
                        text: 'Payment Authorized',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 1000,
                        stack: 6
                    });

                    var params = {
                        payment_status: 'Completed',
                        paymentID: data.paymentID,
                        payerID: data.payerID
                    };

                    // console.log(data.paymentID);
                    // return false;
                    $('input[name="payment_status"]').val('Completed');
                    $('input[name="payment_id"]').val(data.paymentID);
                    $('input[name="payer_id"]').val(data.payerID);
                    $('input[name="payment_method"]').val('paypal');
                    $('#order-place').submit();
                });
            },
            onCancel: function(data, actions) {
                var params = {
                    payment_status: 'Failed',
                    paymentID: data.paymentID
                };
                $('input[name="payment_status"]').val('Failed');
                $('input[name="payment_id"]').val(data.paymentID);
                $('input[name="payer_id"]').val('');
                $('input[name="payment_method"]').val('paypal');
            }
        }, '#paypal-button-container-popup');


        var stripe = Stripe('{{ config('services.stripe.stripekey') }}');

        // Create an instance of Elements.
        var elements = stripe.elements();
        var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        var card = elements.create('card', {
            style: style
        });
        card.mount('#card-element');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                $(displayError).show();
                displayError.textContent = event.error.message;
            } else {
                $(displayError).hide();
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('order-place');

        $('#stripe-submit').click(function() {
            $('#order_total').val({{ $subtotal }});
            stripe.createToken(card).then(function(result) {
                var errorCount = checkEmptyFileds();
                if ((result.error) || (errorCount == 1)) {
                    // Inform the user if there was an error.
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        $(errorElement).show();
                        errorElement.textContent = result.error.message;
                    } else {
                        $.toast({
                            heading: 'Alert!',
                            position: 'bottom-right',
                            text: 'Please fill the required fields before proceeding to pay',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 5000,
                            stack: 6
                        });
                    }
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('order-place');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            $('#payment_method').val('stripe');
            form.appendChild(hiddenInput);
            form.submit();
        }


        function checkEmptyFileds() {
            var errorCount = 0;
            $('form#order-place').find('.form-control').each(function() {
                if ($(this).prop('required')) {
                    if (!$(this).val()) {
                        $(this).parent().find('.invalid-feedback').addClass('d-block');
                        $(this).parent().find('.invalid-feedback strong').html('Field is Required');
                        errorCount = 1;
                    }
                }
            });
            return errorCount;
        }



        $(document).ready(function() {
            $('#myTabs a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            $('#radio_btn').click(function() {
                $('#Video').slideUp();
            });

            $('#radio2_btn').click(function() {
                $('#Video').slideDown();
            });

        });




        //     $(document).ready(function() {
        //     $('.radio input[type="radio"]').click(function() {
        //         var radio = $(this);

        //         // Check the radio button if it's not already checked
        //         if (!radio.prop("checked")) {
        //             radio.prop("checked", true);
        //         }

        //         // Remove 'active' class from all radio containers
        //         $('.radio').removeClass('active');

        //         // Add 'active' class for the clicked div
        //         radio.closest('.radio').addClass('active');

        //         // Toggle the visibility of the second menu based on the selected radio button
        //         var someoneElseContent = $('#someoneElseContent');
        //         if (radio.val() === 'SomeoneElse') {
        //             someoneElseContent.show();
        //         } else {
        //             someoneElseContent.hide();
        //         }
        //     });
        // });

        //     $(document).ready(function() {
        //     $('.radio').click(function() {
        //         var radio = $(this).find('input');

        //         // Check the radio button if it's not already checked
        //         if (!radio.prop("checked")) {
        //             radio.prop("checked", true);
        //         }

        //         // Remove 'active' class from all radio containers
        //         $('.radio').removeClass('active');

        //         // Add 'active' class for the clicked div
        //         $(this).addClass('active');
        //     });
        // });

        // $(document).ready(function() {
        //         // Hide the someoneElseContent initially
        //         $('#someoneElseContent').hide();

        //         // Handle radio button change event
        //         $('input[name="delivery_pickup"]').on('change', function() {
        //             var selectedValue = $(this).val();

        //             // Check if the selected radio button is for "SOMEONE ELSE"
        //             if (selectedValue === "SomeoneElse") {
        //                 $('#someoneElseContent').show();
        //             } else {
        //                 $('#someoneElseContent').hide();
        //             }
        //         });
        //     });


        $(document).ready(function() {
            $('.radio').click(function() {
                var radio = $(this).find('input');

                // Toggle the checked state of the clicked checkbox
                radio.prop("checked", !radio.prop("checked"));

                // Toggle the 'active' class for the clicked div
                $(this).toggleClass('active');
            });
        });

        $(document).ready(function() {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href"); // activated tab
                if (target === "#Video") {
                    // If "Someone else" tab is activated, remove the "active" class from the "Me" tab
                    $('ul.nav-tabs li.active').removeClass('active');
                } else {
                    // If "Me" tab is activated, remove the "active" class from the "Someone else" tab
                    $('ul.nav-tabs li:contains("Someone else")').removeClass('active');
                }
            });

            $('.radio-1').click(function() {
                var radio1 = $(this).find('input');

                // Toggle the checked state of the clicked checkbox
                radio1.prop("checked", !radio1.prop("checked"));

                // Toggle the 'active' class for the clicked div
                $(this).toggleClass('active');
            });


            $('#order_detail').click(function() {
                $('#order_detail_box').slideToggle();
            });


            $('#order_detail_save').click(function() {
                if (!$('input[name="round_trip"]:checked').val()) {
                    alert('Please select Field.');
                } else {
                    $('#order_detail_box').slideUp();
                    $('#get_order_box').slideDown();
                }
            });

            $('#get_order').click(function() {
                if (!$('input[name="round_trip"]:checked').val()) {
                    alert('Please Check the above details first.');
                } else {
                    @if (Auth::check())
                        $('#get_order_box').slideToggle();
                    @endif
                }
            });


            $('#get_order_save').click(function() {
                if ($('input[name="start_date"]').val() == '' || $('input[name="end_date"]').val() == '' ||
                    $('input[name="delivery_address_1"]').val() == '' || $('input[name="delivery_city"]')
                    .val() == '' || $('input[name="delivery_state"]').val() == '' || $(
                        'input[name="delivery_zip_code"]').val() == '') {
                    alert('Please fill in all fields.');
                } else {
                    $('#get_order_box').slideUp();
                    $('#recovery_time_box').slideDown();
                }
            });

            $('#recovery_time').click(function() {
                if ($('input[name="start_date"]').val() == '' || $('input[name="end_date"]').val() == '' ||
                    $('input[name="delivery_address_1"]').val() == '' || $('input[name="delivery_city"]')
                    .val() == '' || $('input[name="delivery_state"]').val() == '' || $(
                        'input[name="delivery_zip_code"]').val() == '') {
                    alert('Please fill in all fields.');
                } else {
                    $('#recovery_time_box').slideToggle();
                }
            });


            $('#recovery_time_save').click(function() {
                if ($('input[name="delivery_time"]').val() == '' || $('input[name="pickup_time"]').val() ==
                    '') {
                    alert('Please fill in all fields.');
                } else {
                    $('#recovery_time_box').slideUp();
                    $('#recieving_order_box').slideDown();
                }
            });


            $('#receiving_order').click(function() {
                if ($('input[name="delivery_time"]').val() == '' || $('input[name="pickup_time"]').val() ==
                    '') {
                    alert('Please fill in all fields.');
                } else {
                    $('#receiving_order_box').slideToggle();
                }
            });


            $('#recieving_order_save').click(function() {
                $('#recieving_order_box').slideUp();
                $('#order_payment_box').slideDown();
            });

            $('#order_payment').click(function() {
                $('#order_payment_box').slideToggle();
            });


            $('#recieving_order_save').click(function() {
                $('#payments_obox').slideDown();
            })




        });


        // Define the URL of the checkout page
        var checkoutPageUrl = "https://democustom-html.com/custom-backend/zapgo/public/checkout";

        // Check if the page has already been redirected
        if (!sessionStorage.getItem('redirected')) {
            // Set a flag in sessionStorage to indicate redirection
            sessionStorage.setItem('redirected', 'true');

            // Redirect to the checkout page after 1 second
            setTimeout(function() {
                window.location.href = checkoutPageUrl;
            }, 1000); // 1000 milliseconds = 1 second
        }
    </script>

@endsection
