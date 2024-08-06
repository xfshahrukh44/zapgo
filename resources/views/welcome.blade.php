@extends('layouts.main')

@section('content')
    <section class="rent-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="equipment">
                        {!! $page->content !!}
                        <div class="top-btn">
                            {{-- <a class="btn blue-custom" href="#" type="submit" data-bs-toggle="modal" data-bs-target="#news-modal">Get A Quote</a> --}}
                            <a class="btn blue-custom" href="{{ route('get_a_qoute') }}">Get A Quote</a>
                            <a class="btn blue-custom black-btn" href="{{ route('category') }}">All Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="from-mid">
                        <form action="{{ route('shop') }}" method="GET" onsubmit="return validateSearch()">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <img src="{{ asset('images/13.png') }}" class="img-fluid" alt="">

                                        <select name="search" id="" class="form-control">
                                            @foreach ($location as $items)
                                                <option value="{{ $items->id }}" <?php if ($items->id == $_GET['search']) {
                                                    echo 'selected';
                                                } ?>>{{ $items->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <input type="text" name="search" class="form-control" id="searchInput"
                                            placeholder="Search...">
                                        <!--<img src="images/14.png" class="img-fluid" alt="">-->
                                        <!--<input type="text" name="date" class="form-control" placeholder="Tue Sep 5 - Wed Sep 6">-->
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn blue-custom">Start Your Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <section class="product-slides">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="range-slides">
                        {!! $section[0]->value !!}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product-slider owl-carousel owl-theme">
                        @foreach ($get_product as $items)
                            <div class="item">
                                <div class="main-center product_category">
                                    <div class="purification">
                                        <a href="{{ route('shopDetail', ['id' => $items->id]) }}"><img
                                                src="{{ asset($items->image) }}" class="img-fluid" alt=""></a>
                                    </div>
                                    <div class="mid-slides">
                                        <a href="{{ route('shopDetail', ['id' => $items->id]) }}">
                                            <h3>{{ $items->product_title }}</h3>
                                        </a>
                                        {!! \Illuminate\Support\Str::limit($items->short_desc, 100, $end = '...') !!}

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="text-center mt-5">
                        <a href="{{ route('category') }}" class="btn blue-custom">View More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="product-slides recently_viewed">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="range-slides">
                        {!! $section[1]->value !!}
                    </div>
                </div>
                @php
                    $isSunday = \Carbon\Carbon::now()->isSunday();
                    $isRoleThree = Auth::user()->role == 3;
                @endphp
                @foreach ($randomproducts as $key => $items)
                    <div class="col-lg-3">
                        <div class="main-center random-products">
                            <div class="purification">
                                <img src="{{ asset($items->image) }}" class="img-fluid" alt="">
                            </div>
                            <div class="mid-slides">
                                <h3>{{ $items->product_title }}</h3>
                                <p>{!! \Illuminate\Support\Str::limit($items->description, 150, $end = '...') !!}</p>
                            </div>

                            <div class="add-btn">
                                <button type="button" class="btn blue-custom addCart" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrops-{{ $key }}"
                                    style="{{ $isRoleThree ? 'cursor: not-allowed;' : '' }}"
                                    {{ $isRoleThree || $isSunday ? 'disabled' : '' }}>
                                    Add To Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </section>


    <section class="local-town">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="range-slides blue-line">
                        {!! $section[2]->value !!}
                    </div>
                </div>
                @foreach ($banner as $items)
                    <div class="col-lg-4">
                        <div class="f-tour" data-aos="{{ $items->aos }}" data-aos-duration="2000">
                            <img src="{{ asset($items->image) }}" class="img-fluid" alt="">
                            <h5>{{ $items->title }}</h5>
                        </div>
                    </div>
                @endforeach

                <div class="col-lg-12">
                    {{-- <div class="search-start-1" data-aos="fade-up" data-aos-duration="2000"> --}}
                    {{-- <form>
                             <div class="form-group">
                                  <input type="text" name="search" class="form-control" id="" placeholder="Don't see your city? Search for rental companies near you:">
                                  <button type="submit" class="btn blue-custom">Start Your Search</button>
                             </div>
                        </form> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </section>



    <!--About Section -->


    <section class="home-ab">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="why-we-best">
                        {!! $section[3]->value !!}

                    </div>
                    <div class="third-one">
                        <div class="bulb-div" data-aos="flip-up" data-aos-duration="2000">
                            <figure>
                                <img src="{{ asset('images/17.png') }}" class="img-fluid" alt="">
                            </figure>
                            <div class="blub-h">
                                <h6>Exceptional Service</h6>
                                <p>We place a high priority on customer satisfaction and make every effort to exceed
                                    your expectations. Our team specialists is always ready for your assistance.
                                </p>
                            </div>
                        </div>
                        <div class="bulb-div" data-aos="flip-up" data-aos-duration="2000">
                            <figure>
                                <img src="{{ asset('images/18.png') }}" class="img-fluid" alt="">

                            </figure>
                            <div class="blub-h">
                                <h6>Efficiency and Cost Savings</h6>
                                <p> We believe in the power of efficiency and cost-effectiveness. Our solutions are
                                    designed to reduce administrative costs and streamline processes.</p>
                            </div>
                        </div>
                        <div class="bulb-div" data-aos="flip-up" data-aos-duration="2000">
                            <figure>
                                <img src="{{ asset('images/19.png') }}" class="img-fluid" alt="">

                            </figure>
                            <div class="blub-h">
                                <h6>Rapid Response</h6>
                                <p>Time is crucial in the equipment rental industry. We offer fast delivery and support to
                                    ensure you can start your projects promptly.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="camera-back">
                        <figure data-aos="fade-down" data-aos-duration="2000">
                            <img src="{{ asset($section[4]->value) }}" class="img-fluid" alt="">
                        </figure>
                        <img src="{{ asset($section[5]->value) }}" class="img-fluid machine-img" alt=""
                            data-aos="fade-up">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--About Section End -->

    <section class="helping-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="commited">
                        {!! $section[6]->value !!}
                        <div class="mt-5">
                            <a href="{{ route('contact') }}" class="btn blue-custom">Contact Us</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="eleven" data-aos="fade-down" data-aos-duration="2000">
                        <figure>
                            <img src="{{ asset('images/11.png') }}" class="img-fluid" alt="">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="customer-say">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="client-r">
                        <h3 class="animate-charcter">Testimonials</h3>
                        <div class="slides-main">
                            <div class="client-review owl-carousel owl-theme">
                                @foreach ($testimonial as $items)
                                    <div class="item">
                                        <div class="on-para">
                                            {!! $items->comments !!}
                                            <div class="john-doe">
                                                <h5>{{ $items->name }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- scd model -->
    <div class="modal fade" id="news-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="main-h-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Get A Quote </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="main-form-news">
                        <form action="{{ route('quoteStore') }} " method="POST">
                            @csrf
                            <div class="date-row">
                                <div class="form-group col-6">
                                    <input style="max-width: 210px;" type="text" class="date-rent-start form-control"
                                        name="start_date" id="daterange_start" placeholder="Start date" required>
                                </div>
                                <div class="form-group col-6">
                                    <input style="max-width: 210px;" type="text" class="date-rent-end form-control"
                                        name="end_date" id="daterange_end" placeholder="End date" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <input type="text" name="first_name" class="form-control"
                                        placeholder="First Name*" required="">
                                </div>
                                <div class="form-group col-6">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name*"
                                        required="">
                                </div>
                                <div class="form-group col-12">
                                    <input type="email" name="email" class="form-control" placeholder="Email Name*"
                                        required="">
                                </div>
                                <div class="form-group col-12">
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="Phone Number*" required="">
                                </div>
                                <div class="form-group col-12">
                                    <input type="text" name="company" class="form-control" placeholder="Company*"
                                        required="">
                                </div>
                                <div class="form-group col-12">
                                    <input type="text" name="address" class="form-control" placeholder="Address*"
                                        required="">
                                </div>
                                <div class="form-group col-6">
                                    <input type="text" name="city" class="form-control" placeholder="City*"
                                        required="">
                                </div>
                                <div class="form-group col-6">
                                    @php
                                        $state = DB::table('states')->get();
                                    @endphp
                                    <select class="form-select" id="state" name="state" required>
                                        <!-- Add your state options here -->
                                        <option value="" selected>Choose State</option>
                                        @foreach ($state as $value)
                                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                                        @endforeach

                                    </select>

                                </div>
                                <div class="form-group col-12">
                                    <select class="form-select" name="product" aria-label="Default select example">
                                        <?php
                                        $product = App\Product::all(); ?>
                                        <option selected>Select Product</option>
                                        @foreach ($product as $items)
                                            <option value="{{ $items->id }}">{{ $items->product_title }}</option>
                                        @endforeach
                                        {{-- <option value="1">Dehumidifiers</option>
  <option value="2">Air Movers</option>
  <option value="3">Air Purification</option>
  <option value="3">Water Pumps</option> --}}
                                    </select>
                                </div>

                                <div class="form-group col-12">
                                    <label>
                                        Quantity
                                    </label>
                                    <div class="quantity">
                                        <span class="minus  minus-1">-</span>
                                        <input name="quantity" type="text" class="quantity__input input-1 count"
                                            readonly="" value="0">
                                        <span class="plus plus-1">+</span>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>
                                        Additional Information
                                    </label>
                                    <textarea class="form-control" name="message" id="textarea" placeholder="" row="5"></textarea>
                                </div>

                            </div>
                            <div class="btn-from-last">
                                <button type="submit" class="btn blue-custom black-btn">Submit</button>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @foreach ($randomproducts as $key => $items)
        <div class="modal fade staticBackdrop" id="staticBackdrops-{{ $key }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">checkout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('save_cart') }}" id="add-cart">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id" value="{{ $items->id }}">
                            <div class="week-and-day">
                                <div class="h-p">
                                    <div>
                                        <img src="{{ asset($items->image) }}" class="img-fluid" alt="">
                                        <p> {{ $items->product_title }} </p>
                                    </div>
                                    <div class="in_stock">
                                        <p>{{ $items->stock_inventory > 0 ? 'In-Stock' : 'Out of Stock' }}</p>
                                    </div>

                                    <!-- <div class="quantity qty">-->
                                    <!--       <span class="minus  minus-1">-</span>-->
                                    <!--<input type="text" id="addcount" class="count" name="qty" value="1">-->
                                    <!--   <span class="plus bg-dark plus-1">+</span>-->
                                    <!--</div>-->
                                </div>

                                <ul class="input-attr">
                                    @php
                                        $att_model = App\ProductAttribute::groupBy('attribute_id')
                                            ->where('product_id', $items->id)
                                            ->get();
                                        $att_id = DB::table('product_attributes')->where('product_id', $id)->get();
                                    @endphp

                                    @foreach ($att_model as $att_models)
                                        <li>

                                            <!--<input type="radio" value="{{ $att_models->id }}" name="variation" id="" required {{ $loop->first ? 'checked' : '' }}>-->
                                            <h5>${{ $att_models->price }}<span> Per
                                                    {{ $att_models->attributesValues->value }}</span></h5>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                    </div>
                    <div class="modal-footer">
                        @if ($items->stock_inventory > 0)
                            <button href="javascript:void(0)" class="btn blue-custom" id="addCart">Add to cart
                            </button>
                        @else
                            <button href="javascript:void(0)" class="btn blue-custom disabled" id="outofstock">Out of
                                Stock </button>
                        @endif

                        </form>
                        {{-- <a href="{{ route('category') }}" class="btn blue-custom">Keep Shopping</a>  --}}
                        <button type="button" class="btn blue-custom  but-cs" data-bs-dismiss="modal"
                            aria-label="Close">Keep Shopping</button>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@section('css')
    <style>
        .rent-sec {
            background-image: url({{ asset($page->image) }}) !important;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 800px;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 0;
        }


        h2.animate-charcter {
            font-size: 35px;
        }

        .random-products {
            height: 520px;
        }

        .random-products .mid-slides {
            height: 230px;
        }

        .main-center.product_category {
            height: 400px;
        }

        .qty .minus {
            cursor: pointer;
            display: inline-block;
            vertical-align: top;
            color: white;
            width: 30px;
            height: 30px;
            font: 30px/1 Arial, sans-serif;
            text-align: center;
            border-radius: 50%;
            background-clip: padding-box;
        }

        .qty .plus {
            cursor: pointer;
            display: inline-block;
            vertical-align: top;
            color: white;
            width: 30px;
            height: 30px;
            font: 30px/1 Arial, sans-serif;
            text-align: center;
            border-radius: 50%;
        }


        .quantity input {
            text-align: center;
        }

        .modal-body .week-and-day ul li.active {
            background: transparent;
            border: 1px solid black;
        }

        .modal-body .week-and-day ul li.active h5 {
            color: black !important;
        }

        .modal-body .week-and-day ul li h5 span {
            font-size: 14px;
            line-height: unset;
            font-weight: 600;
            color: var(--white-color);
        }

        #addCart {
            border: none;
            color: #0285c4 !important;
            font-weight: 700;
            font-size: 20px;
            background: transparent;
        }

        .in_stock {
            padding: 5px 10px;
        }

        .equipment p {
            color: var(--white-color) !important;
        }

        .rent-sec:before {
            position: absolute;
            z-index: -1;
            content: "";
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            background: #00000087;
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript">
        //  $(document).ready(function() {
        //     $('ul.input-attr li:first-child').addClass('active');

        //     $('ul.input-attr li').click(function() {
        //         $(this).find('input').prop("checked", true);
        //         $('ul.input-attr li').removeClass('active');
        //         $(this).addClass('active');
        //     });


        //     $('ul.input-attr input').change(function() {
        //         $('ul.input-attr li').removeClass('active');
        //         $(this).parent().addClass('active');
        //     });

        // });
        $(document).ready(function() {
            $('.date-rent-start').Zebra_DatePicker({
                direction: true,
                format: 'm-d-Y',
                pair: $('#date-rent-end'),
                onClose: function(view, elements) {
                    var datepicker = $('#date-rent-end').data('Zebra_DatePicker');
                    if (datepicker) {
                        var startDate = new Date($('.date-rent-start').val());
                        var endDate = new Date($('.date-rent-end').val());
                        if (endDate < startDate) {
                            $('.date-rent-end').val($('.date-rent-start').val());
                            datepicker.update();
                        }
                    }
                }
            });
            $('.date-rent-start').css('width', 'max-content');

            $('.date-rent-end').Zebra_DatePicker({
                direction: 1,
                format: 'm-d-Y',
                onClose: function(view, elements) {
                    var datepicker = $('#date-rent-end').data('Zebra_DatePicker');
                    if (datepicker) {
                        var startDate = new Date($('.date-rent-start').val());
                        var endDate = new Date($('.date-rent-end').val());
                        if (endDate < startDate) {
                            $('.date-rent-end').val($('.date-rent-start').val());
                            datepicker.update();
                        }
                    }
                }
            });
            $('.date-rent-end').css('width', 'max-content');

            // $('ul.input-attr li:first-child').addClass('active');

            // $('ul.input-attr li').click(function() {
            //     $(this).find('input').prop("checked", true);
            //     $('ul.input-attr li').removeClass('active');
            //     $(this).addClass('active');
            // });


            // $('ul.input-attr input').change(function() {
            //     $('ul.input-attr li').removeClass('active');
            //     $(this).parent().addClass('active');
            // });

        });
    </script>
@endsection
