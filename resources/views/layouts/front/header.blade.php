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
            'taxes' => $item['taxes'],
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
    // dd($new_cart['items']);
    // dd(Session::get('daterange'));
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
                                  $pro_total = 0;
                                  $totalCartPrice = 0;
                                  $env_check = 0;
                                  $taxes_check = 0;
                            ?>
                            @if ($cart != null)
                                @foreach ($new_cart['items'] as $key => $value)
                                    @php
                                        $prod_image = App\Product::where('id', $value['id'])->first();
                                        $date_start = Session::get('daterange') ? $date_start : now(); // Define date_start if not already defined
                                        $day = (Session::get('daterange') != null) ? $date_start->diffInDays($date_from) : 1;
                                        $qty = intval($value['qty']);
                                        $pricePerDay = $value['price_per_day'];
                                        $pricePerWeek = $value['price_per_week'];
                                        $pricePerMonth = $value['price_per_month'];
                                        $envFee = $value['env_fee'];
                                        $taxes = $value['taxes'];

                                        $daysInMonth = 30;
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
                                        $itemTotalPrice = $totalPrice * $qty;

                                        $envFeeFinal = ($envFee / 100) * $itemTotalPrice;
                                        $taxFinal = ($taxes / 100) * $itemTotalPrice;

                                        $total_price = number_format($itemTotalPrice, 2, '.', '');
                                        $env_fee_final = number_format($envFeeFinal, 2, '.', '');
                                        $tax_final = number_format($taxFinal, 2, '.', '');

                                        $totalCartPrice += $total_price;

                                        $env_check += $env_fee_final;
                                        $tax_check += $tax_final;
                                    @endphp
                                    <div class="row cart-items">
                                        <div class="col-md-12 delete-cart">
                                            <a href="javascript:void(0)"
                                                onclick="window.location.href='{{ route('remove_cart', ['id' => $value['id']]) }}'"
                                                class="remove"><i class="fas fa-times"></i></a>
                                        </div>
                                        <div class="col-md-6 image">
                                            <img src="{{ asset($prod_image->image) }}" alt=""
                                                class="img-responsive">
                                        </div>
                                        <div class="col-md-6 text">
                                            <h3>{{ $value['name'] }}</h3>
                                            <p class="days">
                                                $<span id="cart-price-{{ $value['id'] }}">{{ $total_price }}</span>
                                            </p>
                                            {{-- <p>Environmental Fee:</p><p>$<span id="envsub{{ $value['id'] }}">{{ $env_fee_final }}</span></p>
                                            <p>Taxes:</p><p>$<span id="taxessub{{ $value['id'] }}">{{ $tax_final }}</span></p> --}}
                                            <p class="days">
                                                Quantity: <input type="number" min="1" value="{{ $value['qty'] }}" name="qty[{{ $value['id'] }}]" class="input_qty form-control" id="qty{{ $value['id'] }}" style="width: 41% !important; margin-top: 10px;" data-product-id="{{ $value['id'] }}" disabled>
                                            </p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $value['id'] }}">
                                @endforeach

                                @php
                                    $otherFees = App\Http\Traits\HelperTrait::returnFlag(1977);
                                    $rentalProtection = App\Http\Traits\HelperTrait::returnFlag(1975);
                                    $deliveryFee = App\Http\Traits\HelperTrait::returnFlag(1974);

                                    $otherFees_final = ($otherFees / 100) * $totalCartPrice;
                                    $rentalProtection_final = ($rentalProtection / 100) * $totalCartPrice;
                                @endphp

                                <ul class="total-row">
                                    <li>
                                        <p>Taxes and fees will be calculated before rental confirmation.</p>
                                    </li>
                                    <li>
                                        <p>Rental subtotal:</p><p>$<span id="rsub">{{ number_format($totalCartPrice, 2) }}</span></p>
                                    </li>
                                    <li>
                                        <p>Round-trip delivery:</p><p>$<span id="roundsub">{{ number_format($deliveryFee, 2) }}</span></p>
                                    </li>
                                    <li>
                                        <p>Rental protection plan:</p><p>$<span id="rensub">{{ number_format($rentalProtection_final, 2) }}</span></p>
                                    </li>
                                    <li>
                                        <p>Environmental Services Fee:</p><p>$<span id="envsersub">{{ number_format($env_check, 2) }}</span></p>
                                    </li>
                                    <li>
                                        <p>Other fees:</p><p>$<span id="othsub">{{ number_format($otherFees_final, 2) }}</span></p>
                                    </li>
                                    <li>
                                        <p>Taxes:</p><p>$<span id="taxsub">{{ number_format($tax_check, 2) }}</span></p>
                                    </li>
                                    @php
                                        $estimatedSubtotal = $totalCartPrice + $rentalProtection_final + $otherFees_final + $deliveryFee + $env_check + $tax_check;
                                    @endphp
                                    <li>
                                        <input type="hidden" name="esubs" id="esubs" value="{{ number_format($totalCartPrice, 2) }}">
                                        <p>Total:</p><p>$<span id="esub">{{ number_format($estimatedSubtotal, 2) }}</span></p>
                                    </li>
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
    var updatedCartData;

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
            const productId = $(this).data('product-id');
            date_rent_end_close($(this), productId);
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

        const date_rent_end_close = (qty_element, productId) => {
            let cart = JSON.parse('{!! json_encode($new_cart) !!}');

            let endDate = parseDate($('#date-rent-end').val());
            let endDay = endDate.getDate();
            let days = datediff(parseDate($('#date-rent-start').val()), parseDate($('#date-rent-end').val()));
            $('#days').text(days)
            console.log(days);

            const updatedCart = cart.items.map(item => {
                if (item.id == productId) {
                    item.qty = qty_element.val();
                }
                return item;
            });

            cart.items = updatedCart;

            updatedCartData = calculateTotalCost(cart, days, qty_element);
            calculateRentalPrice(days);
            console.log('Total Price:', updatedCartData);

            $('.total').slideDown()
            $('#daterange').val(`[${$('#date-rent-start').val()},${$('#date-rent-end').val()}]`)
            checkDatesAndToggleQty();
        };
    });


    const daysInMonth = 30;
    const daysInWeek = 7;

    // Calculate total cost function
    function calculateTotalCost(cart, n, qty_element) {
        let totalCartPrice = 0;
        let envCheck = 0;
        let taxesCheck = 0;

        cart.items.forEach(item => {
            const qty = parseFloat($(`#qty${item.id}`).val());
            const pricePerDay = item.price_per_day;
            const pricePerWeek = item.price_per_week;
            const pricePerMonth = item.price_per_month;
            const envFee = item.env_fee;
            const taxes = item.taxes;

            // Calculate the number of months, weeks, and days
            const months = Math.floor(n / daysInMonth);
            let remainingDays = n % daysInMonth;
            const weeks = Math.floor(remainingDays / daysInWeek);
            remainingDays = remainingDays % daysInWeek;
            const days = remainingDays;

            // Calculate total price for the current item
            const totalPriceTemp = (months * pricePerMonth) + (weeks * pricePerWeek) + (days * pricePerDay);
            // Optionally, find the minimum cost if it would be cheaper to use weekly or monthly rates
            const totalWeeks = Math.ceil(n / daysInWeek);
            const totalMonths = Math.ceil(n / daysInMonth);
            const priceByWeeks = totalWeeks * pricePerWeek;
            const priceByMonths = totalMonths * pricePerMonth;

            const totalPrice = Math.min(totalPriceTemp, priceByWeeks, priceByMonths);

            // console.log('Months:', months, 'Weeks:', weeks, 'Days:', days);
            // console.log(totalPriceTemp, priceByWeeks, priceByMonths);
            // console.log('Total Price:', totalPriceTemp);
            // console.log('Minimum Price:', totalPrice);

            const itemTotalPrice = totalPrice * qty; // Multiply by quantity

            // Calculate the environmental fee
            const envFeeFinal = (envFee / 100) * itemTotalPrice;

            // Calculate Taxes
            const taxFinal = (taxes / 100) * itemTotalPrice;

            // Update cart item with calculated values
            item.total_price = parseFloat(itemTotalPrice.toFixed(2));
            item.env_fee_final = parseFloat(envFeeFinal.toFixed(2));
            item.tax_final = parseFloat(taxFinal.toFixed(2));
            item.qty = qty;

            // Add to total cart price
            totalCartPrice += item.total_price;

            envCheck += item.env_fee_final;
            taxesCheck += item.tax_final;
        });

        // Calculate other fees
        let otherFees = '{{ $otherFees }}';
        otherFees = otherFees.trim() === '' ? 0 : parseFloat(otherFees);
        otherFees = isNaN(otherFees) ? 0 : otherFees;
        let otherFees_final = (otherFees / 100) * parseFloat(totalCartPrice);

        // Calculate rental protection
        let rentalProtection = '{{ $rentalProtection }}';
        rentalProtection = rentalProtection.trim() === '' ? 0 : parseFloat(rentalProtection);
        rentalProtection = isNaN(rentalProtection) ? 0 : rentalProtection;
        let rentalProtection_final = (rentalProtection / 100) * parseFloat(totalCartPrice);

        // Update cart object with final values
        cart.total_cart_price = parseFloat(totalCartPrice.toFixed(2));
        cart.other_fees_final = parseFloat(otherFees_final.toFixed(2));
        cart.rental_protection_final = parseFloat(rentalProtection_final.toFixed(2));
        cart.env_check = parseFloat(envCheck.toFixed(2));
        cart.tax_check = parseFloat(taxesCheck.toFixed(2));

        updateCartHTML(cart);

        return cart;
    }


    function updateCartHTML(cart) {

        let deliveryCharges = parseFloat(cart.delivery_charges);
        // Update item prices
        cart.items.forEach(item => {
            const itemPriceSpan = document.querySelector(`#cart-price-${item.id}`);
            if (itemPriceSpan) {
                itemPriceSpan.textContent = item.total_price.toFixed(2);
            }

            // const envFeeSpan = document.querySelector(`#envsub${item.id}`);
            // if (envFeeSpan) {
            //     envFeeSpan.textContent = item.env_fee_final.toFixed(2);
            // }

            // const taxSpan = document.querySelector(`#taxessub${item.id}`);
            // if (taxSpan) {
            //     taxSpan.textContent = item.tax_final.toFixed(2);
            // }
        });

        // Update total prices
        const rsubSpan = document.querySelector('#rsub');
        if (rsubSpan) {
            rsubSpan.textContent = cart.total_cart_price.toFixed(2);
        }

        const roundsubSpan = document.querySelector('#roundsub');
        if (roundsubSpan) {
            roundsubSpan.textContent = deliveryCharges.toFixed(2);
        }

        const rensubSpan = document.querySelector('#rensub');
        if (rensubSpan) {
            rensubSpan.textContent = cart.rental_protection_final.toFixed(2);
        }

        const envserSpan = document.querySelector('#envsersub');
        if (envserSpan) {
            envserSpan.textContent = cart.env_check.toFixed(2);
        }

        const othsubSpan = document.querySelector('#othsub');
        if (othsubSpan) {
            othsubSpan.textContent = cart.other_fees_final.toFixed(2);
        }

        const taxSpan = document.querySelector('#taxsub');
        if (taxSpan) {
            taxSpan.textContent = cart.tax_check.toFixed(2);
        }

        const esubSpan = document.querySelector('#esub');
        if (esubSpan) {
            esubSpan.textContent = (cart.total_cart_price + cart.other_fees_final + deliveryCharges + cart.rental_protection_final + cart.env_check + cart.tax_check).toFixed(2);
        }
    }

    function calculateRentalPrice(n) {
        const dailyRate = 35;
        const weeklyRate = 145;
        const monthlyRate = 438;
        const daysInMonth = 30;
        const daysInWeek = 7;

        // Calculate the number of months and remaining days
        const months = Math.floor(n / daysInMonth);
        let remainingDays = n % daysInMonth;

        // Calculate the number of weeks and remaining days
        const weeks = Math.floor(remainingDays / daysInWeek);
        remainingDays = remainingDays % daysInWeek;

        // Calculate the total price based on months, weeks, and days
        const totalPrice = (months * monthlyRate) + (weeks * weeklyRate) + (remainingDays * dailyRate);

        // Calculate alternative prices
        const totalWeeks = Math.ceil(n / daysInWeek);
        const priceByWeeks = totalWeeks * weeklyRate;

        const totalMonths = Math.ceil(n / daysInMonth);
        const priceByMonths = totalMonths * monthlyRate;

        // Find the minimum price among different options
        let minimumPrice = Math.min(totalPrice, priceByWeeks, priceByMonths);

        // if(n > 30){
        //     minimumPrice += dailyRate;
        //     if(minimumPrice < monthlyRate * 2){
        //         minimumPrice = monthlyRate;
        //     }
        // }

        console.log('Months:', months, 'Weeks:', weeks, 'Days:', remainingDays);
        console.log('Total Price:', totalPrice);
        console.log('Price by Weeks:', priceByWeeks);
        console.log('Price by Months:', priceByMonths);
        console.log('Minimum Price:', minimumPrice);
    }


</script>
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
