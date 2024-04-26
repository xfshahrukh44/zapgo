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
                                        @elseif (Auth::user()->role == '2')
                                            <a class="btn blue-custom black-btn"
                                                href="{{route('account')}}"
                                                style="margin-left: 20px !important;">Hi, {{ Auth::user()->name }}</a>
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
                            <?php $subtotal1 = 0;
                                  $pro_total = 0;?>
                            @if ($cart != null)
                                @foreach ($cart as $key => $value)
                                    <?php
                                    if ($key == 'shipping') {
                                        //continue;
                                    }
                                    $prod_image = App\Product::where('id', $value['id'])->first();


                                    ?>



                                    <script>
                                        function datediff(first, second) {
                                            return Math.round((second - first) / (1000 * 60 * 60 * 24));
                                        }

                                        function parseDate(str) {
                                            var mdy = str.split('-');
                                            return new Date(mdy[2], mdy[0] - 1, mdy[1]);
                                        }

                                        $(document).ready(function() {
                                            $('#date-rent-start').Zebra_DatePicker({
                                                direction: true,
                                                format: 'm-d-Y',
                                                pair: $('#date-rent-end'),
                                                onClose: function(view, elements) {
                                                    var datepicker = $('#date-rent-end').data('Zebra_DatePicker');
                                                    datepicker.clear_date();
                                                    $('.total').slideUp()

                                                }
                                            });

                                            $('#date-rent-end').Zebra_DatePicker({
                                                direction: 1,
                                                format: 'm-d-Y',
                                                onClose: function(view, elements) {
                                                    let days = datediff(parseDate($('#date-rent-start').val()), parseDate($(
                                                        '#date-rent-end').val()));
                                                    let totalBill = '{{ $product_detail->price }}' * $('#qty').val() * days;
                                                    {{--let totalBill = '{{ $product_detail->price }}' * {{ $value['qty'] }} * days;--}}
                                                    $('#days').text(days)
                                                    var price = $('#cart-price-{{ $key }}').text()
                                                    var prices = 0;
                                                    @php
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
                                                    @endphp
                                                    if (days >= 28) {
                                                    // Fetch the price for a month
                                                    @php
                                                    $monthAttributeValue = App\AttributeValue::where('value', 'Month')->first();
                                                    $monthProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])->where('attribute_id', $monthAttributeValue->attribute_id)->first();
                                                    @endphp
                                                    var months = Math.floor(days / 28);
                                                    var remainingDays = days % 28;
                                                    prices = months * {{ $monthProductAttribute->price }}; // Price per month
                                                        if (remainingDays > 0) {
                                                            @php
                                                            // If there's a day price, add it
                                                            $dailyAttributeValue = App\AttributeValue::where('value', 'Day')->first();
                                                            if ($dailyAttributeValue) {
                                                            $dailyProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])->where('attribute_id', $dailyAttributeValue->attribute_id)->first();
                                                            @endphp
                                                            prices += remainingDays * {{ $dailyProductAttribute->price }}; // Additional daily rate

                                                            @php
                                                        }
                                                            @endphp
                                                        }
                                                    }else if (days >= 7) {
                                                    @php
                                                    $weekAttributeValue = App\AttributeValue::where('value', 'Week')->first();
                                                    $weekProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])->where('attribute_id', $weekAttributeValue->attribute_id)->first();
                                                    @endphp
                                                    var weeks = Math.floor(days / 7);
                                                    var remainingDays = days % 7;
                                                    prices = weeks * {{ $weekProductAttribute->price }}; // Price per week
                                                    if (remainingDays > 0) {
                                                        @php
                                                        // If there's a day price, add it
                                                        $dailyAttributeValue = App\AttributeValue::where('value', 'Day')->first();
                                                        if ($dailyAttributeValue) {
                                                        $dailyProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])->where('attribute_id', $dailyAttributeValue->attribute_id)->first();
                                                        @endphp
                                                        prices += remainingDays * {{ $dailyProductAttribute->price }}; // Additional daily rate
                                                        @php
                                                        }
                                                        @endphp
                                                        }
                                                    }else {
                                                        @php
                                                        // If there's a day price, add it
                                                        $dailyAttributeValue = App\AttributeValue::where('value', 'Day')->first();
                                                        if ($dailyAttributeValue) {
                                                        $dailyProductAttribute = App\ProductAttribute::where('product_id', $prod_image['id'])->where('attribute_id', $dailyAttributeValue->attribute_id)->first();
                                                        @endphp
                                                        prices = days * {{ $dailyProductAttribute->price }}; // Price per day
                                                        @php
                                                        }
                                                        @endphp
                                                    }

                                                    if (days < 7 && prices >= {{ $per_week_price }}) {
                                                        prices = {{ $per_week_price }};
                                                    }else if(days < 28 && prices >= {{ $per_month_price }}) {
                                                        prices = {{ $per_month_price }};
                                                    }

                                                    prices = prices * {{$value['qty']}};

                                                    var product_price = parseFloat(prices)
                                                    var rsub = parseFloat(prices)
                                                    var esub = parseFloat(prices)
                                                    var roundsub = parseFloat($('#roundsub').text())
                                                    var rensub = parseFloat($('#rensub').text())
                                                    var envsub = parseFloat($('#envsub').text())
                                                    var othsub = parseFloat($('#othsub').text())
                                                    var taxsub = parseFloat($('#taxsub').text())


                                                    $('#rsub').text(rsub)
                                                    $('#esub').text((esub + roundsub + rensub + envsub + othsub + taxsub).toFixed(2));
                                                    $('#cart-price-{{ $key }}').text(product_price)
                                                    $('#total_amount').text('$ ' + totalBill)
                                                    $('.total').slideDown()
                                                    $('#daterange').val(`[${$('#date-rent-start').val()},${$('#date-rent-end').val()}]`)
                                                    // alert($('#daterange').val())
                                                    //    $('#totalamount').val(totalBill)
                                                }
                                            })
                                        });
                                    </script>



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
                                            <p class="days">

                                                Quantity: <input type="number" min="1" value="{{$value['qty']}}" name="qty" class="input_qty form-control">
                                            </p>
                                            <?php
                                            $subtotal1 += $pro_total;
                                            ?>
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
                                        <input type="hidden" name="subs" id="subs" value="{{ number_format($subtotal1, 2) }}">
                                        <p>Rental subtotal:</p><p>$<span id="rsub">{{ number_format($subtotal1, 2) }}</span></p>
                                    </li>
                                    @php
                                        $tax = App\Http\Traits\HelperTrait::returnFlag(1973);
                                        $otherFees = App\Http\Traits\HelperTrait::returnFlag(1977);
                                        $envFee = App\Http\Traits\HelperTrait::returnFlag(1976);
                                        $rentalProtection = App\Http\Traits\HelperTrait::returnFlag(1975);
                                        $deliveryFee = App\Http\Traits\HelperTrait::returnFlag(1974);

                                        $tax_final = ($tax / 100) * $subtotal1;
                                        $otherFees_final = ($otherFees / 100) * $subtotal1;
                                        $envFee_final = ($envFee / 100) * $subtotal1;
                                        $rentalProtection_final = ($rentalProtection / 100) * $subtotal1;
                                    @endphp
                                    <li>
                                        <p>Purchases subtotal: </p><p>-</p>
                                    </li>
                                    <!--<li>-->
                                    <!--    <p>In-store pickup:</p><p><strong>Free</strong></p>-->
                                    <!--</li>-->
                                    <li>
                                        <p>Round-trip delivery: </p><p>$<span id="roundsub">{!! number_format($deliveryFee, 2) !!}</p>
                                    </li>
                                    <li>
                                        <p>Rental protection plan:</p><p>$<span id="rensub">{{ number_format($rentalProtection_final, 2) }}</p>
                                    </li>
                                    <li>
                                        <p>Prepay Fuel Option:</p><p>-</p>
                                    </li>
                                    <li>
                                        <p>Environmental Service Fee:</p><p>$<span id="envsub">{{ number_format($envFee_final, 2) }}</p>
                                    </li>
                                    <li>
                                        <p>Other fees:</p><p>$<span id="othsub">{{ number_format($otherFees_final, 2) }}</p>
                                    </li>

                                    <li>
                                        <p>Taxes:</p><p>$<span id="taxsub">{{ number_format($tax_final, 2) }}</p>
                                    </li>
                                    @php
                                        $estimatedSubtotal = ($subtotal1+$rentalProtection_final+$envFee_final+$otherFees_final+$tax_final+$deliveryFee);
                                    @endphp
                                    <li>
                                        <input type="hidden" name="esubs" id="esubs" value="{{ number_format($subtotal1, 2) }}">
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
