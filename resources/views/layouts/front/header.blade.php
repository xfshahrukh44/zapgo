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
        $delivery_fee_config = App\Http\Traits\HelperTrait::returnFlag(1974);
        $new_cart ['items'] []= [
            'id' => $product_id,
            'name' => $product->product_title,
            'qty' => $item['qty'],
            'delivery_charges' => $delivery_fee_config,
            'price_per_day' => $price_per_day,
            'price_per_week' => $price_per_week,
            'price_per_month' => $price_per_month,
            'env_fee' => $item['env_fee'],
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

    if ($days > 27) {
        $price_key = 'price_per_month';
    } elseif ($days > 6) {
        $price_key = 'price_per_week';
    } else {
        $price_key = 'price_per_day';
    }

    $rental_subtotal = 0.0;
    $envFee_total = 0.0;

    foreach ($new_cart['items'] as $cart_item) {
        $day_value = $day_values[$price_key];
        $multiplier_value = $days / $day_value;
        $multiplier_value_temp = $days - $day_value;

        if ($price_key == 'price_per_month') {
            if ($days == 28) {
                $product_total = floatval($cart_item[$price_key]);
            } elseif ($days > 28) {
                $month_count = floor($days / 28);
                $extra_days = $days % 28;

                $product_total =
                    floatval($cart_item['price_per_month']) * $month_count +
                    floatval($cart_item['price_per_day']) * $extra_days;

                for ($i = 1; $i <= $month_count; $i++) {
                    if (
                        $product_total > floatval($cart_item['price_per_month']) * ($i + 1) &&
                        $days <= 28 * ($i + 1)
                    ) {
                        $product_total = floatval($cart_item['price_per_month']) * ($i + 1);
                    }
                }
                if (
                    $product_total >
                        floatval($cart_item['price_per_month']) + floatval($cart_item['price_per_week']) &&
                    $days <= 28 + 7
                ) {
                    $product_total =
                        floatval($cart_item['price_per_month']) + floatval($cart_item['price_per_week']);
                }
            }
        } elseif ($price_key == 'price_per_week') {
            if ($days == 7) {
                $product_total = floatval($cart_item[$price_key]);
            } elseif ($days > 7) {
                $product_total =
                    floatval($cart_item['price_per_week']) +
                    floatval($cart_item['price_per_day']) * $multiplier_value_temp;
                if ($product_total > floatval($cart_item['price_per_month'])) {
                    $product_total = floatval($cart_item['price_per_month']);
                }
            }
        } else {
            $product_total = floatval($cart_item[$price_key]) * $multiplier_value;
            if ($product_total > floatval($cart_item['price_per_week'])) {
                $product_total = floatval($cart_item['price_per_week']);
            }
        }

        $env_fee = $cart_item['env_fee'] ?? 0;
        $envFee_final = ($env_fee / 100) * $product_total;

        $product_total = $product_total * floatval($cart_item['qty']);
        $envFee_total += $envFee_final;
        $rental_subtotal += $product_total;

        $cart_item['total'] = $product_total;
    }

    $rental_subtotal = $rental_subtotal + $envFee_total;
    $new_cart['sub_total'] = $rental_subtotal + $envFee_total;
@endphp
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Zap Go</title>
</head>
<style>

</style>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <a class="navbar-brand" id="logo-main" href="{{ route('home') }}"><img
                                    src="{{ asset($logo->img_path) }}" class="img-fluid" alt=""></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                    {{-- <li class="nav-item active">
                                        <a class="nav-link active" aria-current="page"
                                            href="{{ route('home') }}">Home</a>
                                    </li> --}}

                                    <div class="search-start">
                                        <!--<form action="{{ route('shop') }}" method="GET"-->
                                        <!--    onsubmit="return validateSearch()">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <input type="text" name="search" class="form-control"-->
                                        <!--            id="searchInput" placeholder="Search...">-->
                                        <!--        <button type="submit"><i-->
                                        <!--                class="fa-solid fa-magnifying-glass"></i></button>-->
                                        <!--    </div>-->
                                        <!--</form>-->
                                    </div>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('/') }}"> Home</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('category') }}"> All Products</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('contact') }}">
                                            Contact Us
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                                    </li>
                                </ul>
                                <form class="d-flex custom-c">
                                    @if (Auth::check())
                                        @if (Auth::user()->role == '1')
                                            <a class="btn blue-custom black-btn"
                                                href="{{ URL('admin/dashboard') }}">Admin</a>
                                            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" class="cart_icons">
                                                <span class="cart_counts">{{ (Session::get('cart') != null) ? count(Session::get('cart')) : 0 }}</span>
                                                <img src="{{ asset('images/12.png') }}" class="img-fluid" alt="">
                                            </a>
                                            {{-- User is already signed in --}}
                                            {{-- You can display a different message or redirect the user if needed --}}
                                            {{-- <a href="{{ route('cart') }}"><img src="{{asset('images/12.png')}}" class="img-fluid" alt=""></a> --}}

                                            {{-- <a href="{{ route('account') }}" class="btn1"><p class="text">Welcome, {{ auth()->user()->name }}!</p></a> --}}
                                        @elseif (Auth::user()->role == '2' || Auth::user()->role == '3')
                                            <a class="btn blue-custom black-btn"
                                                href="{{route('account')}}"
                                                style="margin-left: 20px !important;">Hi, {{ Auth::user()->name.' '.Auth::user()->last_name }}</a>
                                        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" class="cart_icons">
                                            <span class="cart_counts">{{ (Session::get('cart') != null) ? count(Session::get('cart')) : 0 }}</span>
                                            <img src="{{ asset('images/12.png') }}" class="img-fluid" alt="">
                                        </a>
                                        @endif
                                    @else
                                        {{-- User is not signed in, show the Sign in and Sign up buttons --}}

                                        <a class="btn blue-custom black-btn" href="{{ route('signin') }}">Sign
                                            in</a>
                                        <a class="btn blue-custom" href="{{ route('signup') }}">Sign up</a>
                                        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" class="cart_icons">
                                            <span class="cart_counts">{{ (Session::get('cart') != null) ? count(Session::get('cart')) : 0 }}</span>
                                            <img src="{{ asset('images/12.png') }}" class="img-fluid" alt="">
                                        </a>
                                    @endif
                                </form>

                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
        id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" aria-hidden="true"
        style="visibility: hidden;">
        <div class="offcanvas-header">
            <h3>SHOPPING CART</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        </div>

        <div class="offcanvas-body">
            <section class="modal-sec">
                <div class="container">
                    <div class="row">
                        @php
                        if(Session::get('daterange') != null){
                            $getdate = Session::get('daterange');

                            $string = str_replace(['[', ']'], '', $getdate);

                            $date_array = explode(', ', $string);

                            $date_start = Carbon\Carbon::createFromFormat('m-d-Y', $date_array[0]);
                            $date_from = Carbon\Carbon::createFromFormat('m-d-Y', $date_array[1]);
                        }
                        @endphp
                        <form action="{{ route('update_cart') }}" method="POST" id="update-cart">
                            @csrf
                            <div class="date-row">
                                <div class="form-group col-6">

                                    <input type="text" name="daterange_start" id="date-rent-start" class="form-control"
                                        placeholder="Start Date*"  value="{{ (Session::get('daterange') != null) ? $date_start->format('m-d-Y') : ''}}" required>
                                </div>
                                <div class="form-group col-6">
                                    <input type="text" name="daterange_end" id="date-rent-end" class="form-control"
                                        placeholder="End Date*"  value="{{ (Session::get('daterange') != null) ? $date_from->format('m-d-Y'): '' }}" required>
                                </div>
                            </div>


                            @php



                                $cart = Session::get('cart');
                            @endphp
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
                                integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
                                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                            <?php //$subtotal1 = 0;
                                  $pro_total = 0;?>
                            @if ($cart != null)
                                @foreach ($cart as $key => $value)
                                    <?php
                                    if ($key == 'shipping') {
                                        //continue;
                                    }
                                    $prod_image = App\Product::where('id', $value['id'])->first();


                                    ?>

                                    <div class="row cart-items">
                                        <div class="col-md-12 delete-cart">
                                            <a href="javascript:void(0)"
                                                onclick="window.location.href='{{ route('remove_cart', [$key]) }}'"
                                                class="remove"><i class="fas fa-times"></i></a>
                                        </div>
                                        <div class="col-md-6 image">
                                            <img src="{{ asset($prod_image->image) }}" alt=""
                                                class="img-responsive">
                                        </div>
                                        <div class="col-md-6 text">
                                            <h3>{{ $value['name'] }}</h3>
                                        <?php
                                        $day = (Session::get('daterange') != null) ? $date_start->diffInDays($date_from) : 1;

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
                                            $pro_total = $monthProductAttribute->price * $monthCount;

                                            // If there are remaining days, calculate additional daily rate
                                            if ($remainingDays > 0) {
                                                // If there's a day price, add it
                                                $dailyAttributeValue = App\AttributeValue::where('value', 'Day')->first();
                                                if ($dailyAttributeValue) {
                                                    $dailyProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])
                                                                                                ->where('attribute_id', $dailyAttributeValue->attribute_id)
                                                                                                ->first();

                                                    // Add additional daily rate for remaining days
                                                    $pro_total += $dailyProductAttribute->price * $remainingDays;
                                                }
                                            }
                                        } elseif ($day >= 7) {
                                                $weekCount = floor($day / 7); // Calculate number of weeks
                                                $remainingDays = $day % 7; // Calculate remaining days after whole weeks

                                                // Calculate subtotal for whole weeks
                                                $pro_total = $weekProductAttribute->price * $weekCount;

                                                // If there are remaining days, calculate additional daily rate
                                                if ($remainingDays > 0) {
                                                    // If there's a day price, add it
                                                    $dailyAttributeValue = App\AttributeValue::where('value', 'Day')->first();
                                                    if ($dailyAttributeValue) {
                                                        $dailyProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])
                                                                                                    ->where('attribute_id', $dailyAttributeValue->attribute_id)
                                                                                                    ->first();

                                                        // Add additional daily rate for remaining days
                                                        $pro_total += $dailyProductAttribute->price * $remainingDays;
                                                    }
                                                }

                                        }else {
                                            // For rentals less than 7 days, use the standard daily rate
                                            $pro_total = $value['price'] * $value['qty'] * $day;
                                        }

                                        if ($day < 7 && $pro_total >= $per_week_price) {
                                            $pro_total = $per_week_price;
                                        }elseif ($day < 28 && $pro_total >= $per_month_price) {
                                            $pro_total = $per_month_price;
                                        }

                                        $pro_total = $pro_total * $value['qty'];

                                        ?>
                                            {{-- @dump($day) --}}
                                            <p style="display: none;">
                                                <strong>days: </strong>
                                                <span id="days">1</span>
                                            </p>
                                            <p class="days">

                                                $<span id="cart-price-{{ $key }}">{{ $pro_total }}</span>
                                            </p>
                                            <?php
                                            if(!empty($prod_image->env_fee)){
                                                $envFee_final = ($prod_image->env_fee / 100) * $pro_total;
                                            }
                                            //$subtotal1 += $pro_total;
                                            ?>
                                            @if(!empty($prod_image->env_fee))
                                                <p>Environmental Fee:</p><p>$<span id="envsub{{ $prod_image->id }}">{{ number_format($envFee_final, 2) }}</p>
                                            @endif
                                            <p class="days">

                                                Quantity: <input type="number" min="1" value="{{$value['qty']}}" name="qty" class="input_qty form-control" style="width: 41% !important; margin-top: 10px;" disabled>
                                            </p>

                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id" id="" value="<?php echo $value['id']; ?>">
                                @endforeach

                                <div class="Rentals-bottom" id="main-box-layout">


                                </div>

                                <ul class="total-row">
                                    <li>
                                        <p>Taxes and fees will be calculated before rental confirmation.</p>
                                    </li>
                                    <li>
{{--                                        <input type="hidden" name="subs" id="subs" value="{{ number_format($subtotal1, 2) }}">--}}
{{--                                        <p>Rental subtotal:</p><p>$<span id="rsub">{{ number_format($subtotal1, 2) }}</span></p>--}}
                                        <input type="hidden" name="subs" id="subs" value="{{ number_format($rental_subtotal, 2) }}">
                                        <p>Rental subtotal:</p><p>$<span id="rsub">{{ number_format($rental_subtotal, 2) }}</span><span id="xdays" style=" font-size: 11px; "></span></p>
                                    </li>
                                    @php
                                        $tax = App\Http\Traits\HelperTrait::returnFlag(1973);
                                        $otherFees = App\Http\Traits\HelperTrait::returnFlag(1977);
                                        $envFee = App\Http\Traits\HelperTrait::returnFlag(1976);
                                        $rentalProtection = App\Http\Traits\HelperTrait::returnFlag(1975);
                                        $deliveryFee = App\Http\Traits\HelperTrait::returnFlag(1974);

                                        $tax_final = ($tax / 100) * $rental_subtotal;
                                        $otherFees_final = ($otherFees / 100) * $rental_subtotal;
                                        $rentalProtection_final = ($rentalProtection / 100) * $rental_subtotal;
                                    @endphp
                                    {{-- <li>
                                        <p>Purchases subtotal: </p><p>-</p>
                                    </li> --}}
                                    <!--<li>-->
                                    <!--    <p>In-store pickup:</p><p><strong>Free</strong></p>-->
                                    <!--</li>-->
                                    <li>
                                        <p>Round-trip delivery: </p><p>$<span id="roundsub">{!! number_format($deliveryFee, 2) !!}</p>
                                    </li>
                                    <li>
                                        <p>Rental protection plan:</p><p>$<span id="rensub">{{ number_format($rentalProtection_final, 2) }}</p>
                                    </li>
                                    {{-- <li>
                                        <p>Prepay Fuel Option:</p><p>-</p>
                                    </li> --}}

                                    <li>
                                        <p>Other fees:</p><p>$<span id="othsub">{{ number_format($otherFees_final, 2) }}</p>
                                    </li>

                                    <li>
                                        <p>Taxes:</p><p>$<span id="taxsub">{{ number_format($tax_final, 2) }}</p>
                                    </li>
                                    @php
                                        $estimatedSubtotal = ($rental_subtotal+$rentalProtection_final+$otherFees_final+$tax_final+$deliveryFee);
                                    @endphp
                                    <li>
                                        <input type="hidden" name="esubs" id="esubs" value="{{ number_format($rental_subtotal, 2) }}">
                                        <p>Estimated subtotal:</p><p>$<span id="esub">{{ number_format($estimatedSubtotal, 2) }}</span></p>
                                    </li>




                                    {{-- <li>
                            <p>Other fees <span>$86.10</span></p>
                        </li> --}}
                                    {{-- <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <p>Subtotal<span>$2,849.56</span></p>
                        </li>
                        <li>
                            p>Taxes<span>$252.90</span></p>
                        </li><

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <p><span>Estimated total</span><span>$3,102.46</span></p>
                        </li> --}}
                                </ul>
                                @if ($cart != null)
                                <a href="javascript:void(0)" class="updateCart btn blue-custom" id="updateCartCheck">Proceed to Checkout</a>
                                @else
                                <a href="{{ route('category') }}" class="updateCart btn blue-custom">Explore Rentals</a>
                                @endif
                                {{-- <button type="submit" class="btn blue-custom">Checkout
                                </button> --}}
                                {{-- <a href="{{ route('checkout') }}" class="updateCart btn blue-custom">Proceed to Checkout</a> --}}
                            @else
                                <div class="col-lg-12">
                                    <div class="gallery-img">
                                        <div class="col-lg-12">
                                            <div class="madal-logo">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </div>
                                        </div>
                                        <h5>NO PRODUCTS IN THE CART.</h5>

                                    </div>
                                </div>
                            @endif


                        </form>
                    </div>
            </section>
        </div>
    </div>
<script>
    $(document).on('click', ".updateCart", function(e) {
        // alert($('#date-rent-start').val());
        if($('#date-rent-start').val() != '' || $('#date-rent-end').val() != ''){
            $('#type').val($(this).attr('data-attr'));

            $('#update-cart').submit();
        }else{
            $('#updateCartCheck').text('Select Date First');
        }
    });

</script>
<script>

    function datediff(first, second) {
        return Math.round((second - first) / (1000 * 60 * 60 * 24));
    }

    function parseDate(str) {
        var mdy = str.split('-');
        return new Date(mdy[2], mdy[0] - 1, mdy[1]);
    }

    function checkDatesAndToggleQty() {
        if ($('#date-rent-start').val() != '' && $('#date-rent-end').val() != '') {
            $('.input_qty').prop('disabled', false);
        } else {
            $('.input_qty').prop('disabled', true);
        }
    }

    $(document).ready(function() {
        $('.input_qty').on('change', function () {
            date_rent_end_close($(this));
        });

        $('#date-rent-start').Zebra_DatePicker({
            direction: true,
            format: 'm-d-Y',
            pair: $('#date-rent-end'),
            onClose: function(view, elements) {
                var datepicker = $('#date-rent-end').data('Zebra_DatePicker');
                datepicker.clear_date();
                $('.total').slideUp();
                checkDatesAndToggleQty();

            }
        });

        $('#date-rent-end').Zebra_DatePicker({
            direction: 1,
            format: 'm-d-Y',
            onClose: function(view, elements) {
                date_rent_end_close();
                checkDatesAndToggleQty();
            }
        })

        const date_rent_end_close = (qty_element) => {
            let cart = JSON.parse('{!! json_encode($new_cart) !!}');

            let endDate = parseDate($('#date-rent-end').val());
            let endDay = endDate.getDate();
            let days = datediff(parseDate($('#date-rent-start').val()), parseDate($('#date-rent-end').val()));
            $('#days').text(days)

            let price_key = '';
            let day_values = {
                price_per_month: 28,
                price_per_week: 7,
                price_per_day: 1,
            };

            if (days > 27) {
                price_key = 'price_per_month'
            } else if (days > 6) {
                price_key = 'price_per_week'
            } else {
                price_key = 'price_per_day'
            }

            // console.log(days,price_key);
            let sub_total = 0.00;
            let envFee_total = 0.00;

            let rental_sub = $('#rsub').text();
            var xday ='';

            for (const item of cart.items) {
                let day_value = day_values[price_key];
                let multiplier_value = days / day_value;
                let multiplier_value_temp = days - day_value;
                let product_total;
                let env_fee = item['env_fee'] || 0;
                // console.log(days);

                if(price_key == 'price_per_month' && days == 28) {
                    product_total = (parseFloat(item[price_key]));
                } else if(price_key == 'price_per_month' && days > 28) {
                    let month_count = Math.floor(days / 28);
                    let extra_days = days % 28;
                    product_total = (parseFloat(item['price_per_month']) * month_count + parseFloat(item['price_per_day']) * extra_days);


                    for (let i = 1; i <= month_count; i++) {
                        if (product_total > (item['price_per_month'] * (i + 1)) && days <= 28 * (i + 1)) {
                            product_total = parseFloat(item['price_per_month'] * (i + 1));
                        }
                    }
                    if (product_total > parseFloat(item['price_per_month']) + parseFloat(item['price_per_week']) && days <= 28 + 7) {
                        product_total = parseFloat(item['price_per_month']) + parseFloat(item['price_per_week']);
                    }

                    if(days <= 30 + 1){
                        if (endDay == 30) {
                            xday = '(x1day)';
                        }else if(endDay == 31){
                            xday = '(x2day)';
                        }else{
                            xday = '';
                        }
                    }
                } else if(price_key == 'price_per_week' && days == 7) {
                    product_total = (parseFloat(item[price_key]));
                } else if(price_key == 'price_per_week' && days > 7) {
                    product_total = (parseFloat(item['price_per_week']) + parseFloat(item['price_per_day']) * multiplier_value_temp);
                    if (product_total > item['price_per_month']) {
                        product_total = parseFloat(item['price_per_month']);
                    }
                } else {
                    product_total = (parseFloat(item[price_key]) * parseFloat(multiplier_value));
                    if (product_total > item['price_per_week']) {
                        product_total = parseFloat(item['price_per_week']);
                    }
                }
                // var pt = product_total;
                // let envFee_final2 = (env_fee / 100) * pt;

                product_total = product_total * (qty_element ? qty_element.val() : parseInt(item['qty']));

                let envFee_final = (env_fee / 100) * product_total;
                $('#envsub'+item['id']).text(envFee_final);

                sub_total += product_total;

                envFee_total += envFee_final;

                item['total'] = product_total;

            }

            sub_total = sub_total + envFee_total;


            cart['total'] = sub_total + envFee_total;

            let tax = '{{ $tax }}';
            let otherFees = '{{ $otherFees }}';

            let rentalProtection = '{{ $rentalProtection }}';

            // Check for empty strings and convert them to 0
            tax = tax.trim() === '' ? 0 : parseFloat(tax);
            otherFees = otherFees.trim() === '' ? 0 : parseFloat(otherFees);

            rentalProtection = rentalProtection.trim() === '' ? 0 : parseFloat(rentalProtection);

            // Check if variables are NaN and convert them to 0
            tax = isNaN(tax) ? 0 : tax;
            otherFees = isNaN(otherFees) ? 0 : otherFees;

            rentalProtection = isNaN(rentalProtection) ? 0 : rentalProtection;

            let tax_final = (tax / 100) * sub_total;
            let otherFees_final = (otherFees / 100) * sub_total;

            let rentalProtection_final = (rentalProtection / 100) * sub_total;

            // console.log(rentalProtection_final,envFee_final,otherFees_final,tax_final);

            function formatValue(value) {
                return parseFloat(value).toFixed(2);
            }

            $('#rensub').text(formatValue(rentalProtection_final));

            $('#othsub').text(formatValue(otherFees_final));
            $('#taxsub').text(formatValue(tax_final));


            $('#rsub').text(sub_total.toString());
            $('#xdays').text(xday);
            $('#roundsub').text(cart['delivery_charges'].toString());
            let grand_total = sub_total + parseFloat($('#roundsub').text().replaceAll('$', '')) + parseFloat($('#rensub').text().replaceAll('$', '')) + parseFloat($('#othsub').text().replaceAll('$', '')) + parseFloat($('#taxsub').text().replaceAll('$', ''));
            $('#esub').text(grand_total.toFixed(2).toString());
            $('.total').slideDown()
            $('#daterange').val(`[${$('#date-rent-start').val()},${$('#date-rent-end').val()}]`)
            checkDatesAndToggleQty();
            // alert($('#daterange').val())
            //    $('#totalamount').val(totalBill)
        };
    });
</script>
