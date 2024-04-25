@extends('layouts.main')
@section('content')
    <!-- ============================================================== -->
    <!-- BODY START HERE -->
    <!-- ============================================================== -->

    <section class="rent-sec about-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="equipment">
                        <h1><span class="d-block">{{ $product_detail->product_title }} </span></h1>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <section class="inner-to-inner">
        <div class="container">
            <div class="row">

                <div class="col-lg-6">
                    <div class="inner-to-slides">
                        <div class="inner-slides owl-carousel owl-theme">
                            
                            <div class="item">
                                    
                                    <div class="cleaner-inner-img">
                                        <figure>
                                            <img src="{{ asset($product_detail->image) }}">
                                        </figure>
                                    </div>
                                </div>
                            @foreach ($productimages as $items)
                            
                                <div class="item">
                                    
                                    <div class="cleaner-inner-img">
                                        <figure>
                                            <img src="{{ asset($items->image) }}" alt="">
                                        </figure>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>



                <div class="col-lg-6">
                    <div class="side-details">
                        <form method="POST" action="{{ route('save_cart') }}" id="add-cart">
                            @csrf
                            {{-- <input type="hidden" name="daterange" id="daterange">
                            <input type="hidden" name="totalamount" id="totalamount"> --}}
                            {{-- <input type="hidden" name="variation"> --}}
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product_detail->id }}">

                            <div class="week-and-day">
                                <h2>{{ $product_detail->product_title }}</h2>
                                <!--<h4>Price: ${{ $product_detail->price }}</h4>-->
                                {{-- <p>select one:</p> --}}
                                <ul class="input-attr">
                                    @php
                                        $att_model = App\ProductAttribute::groupBy('attribute_id')
                                            ->where('product_id', $product_detail->id)
                                            ->get();
                                        $att_id = DB::table('product_attributes')
                                            ->where('product_id', $product_detail->id)
                                            ->get();
                                    @endphp

                                    @foreach ($att_model as $att_models)
                                        <li>

                                            <!--<input type="radio" value="{{ $att_models->id }}" name="variation" id="" required {{ $loop->first ? 'checked' : '' }}>-->
                                            <h5>${{ $att_models->price }}<span>
                                                    Per {{ $att_models->attributesValues->value }}</span></h5>
                                        </li>
                                    @endforeach
                                </ul>







                                <div class="stock"><strong>Stock Available:</strong> {{ $product_detail->stock_inventory }}</div>
                                <div class="cart-btn">
                                    <div class="quantity qty">
                                        <span class="minus  minus-1">-</span>
                                        <input type="text" id="qty" class="count" name="qty" value="1">
                                        <span class="plus bg-dark plus-1">+</span>
                                    </div>
                                    @if($product_detail->stock_inventory > 0)
                                        <button href="javascript:void(0)" class="btn blue-custom" id="addCart">Add to cart </button>
                                    @else
                                        <button href="javascript:void(0)" class="btn blue-custom disabled" id="outofstock">Out of Stock </button>
                                    @endif

                                </div>

                            </div>


                            {!! $product_detail->description !!}
                        </form>
                    </div>

                </div>




            </div>
        </div>

    </section>




    <!-- ============================================================== -->
    <!-- BODY END HERE -->
    <!-- ============================================================== -->
@endsection
@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/zebra_datepicker.min.css') }}"> --}}
    <style>
        .rent-sec {
            background-image: url('/images/2.png');
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


        .cart-btn {
            padding-top: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-bottom: 20px;
        }

        .price {
            font-size: 30px;
        }

        h1.red {
            font-size: 70px;
        }

        section.main-pro-dtail {
            padding: 100px 0px;
        }

        .variation h2 {
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .variation {
            padding: 0px 0px 20px 0px;
        }

        .wunty-check h1 {
            width: 100%;
            font-size: 18px;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .variation select {
            width: 100%;
            height: 36px;
            padding: 0px 10px;
            text-transform: capitalize;
            font-weight: 400;
        }

        /*
                .qty .count {
                    color: #000;
                    display: inline-block;
                    vertical-align: top;
                    font-size: 25px;
                    font-weight: 700;
                    line-height: 30px;
                    padding: 0 2px;
                    min-width: 35px;
                    text-align: center;
                } */

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

        .qty {
            text-align: center;
        }

        .btnDonate {
            background-color: #cb0618;
            width: 100%;
            color: white;

        }

        .btnDonate:hover {
            background-color: white;
            width: 100%;
            color: #cb0618;
            border: 1px solid #cb0618;


        }

        .special-bo-info hr {
            margin: 4px 0px 5px;
            width: 90%;
        }

        .product-details-content hr {
            border-top: 2px solid rgba(0, 0, 0, .1);
            border-style: dashed;
            margin: 8px 0px;
        }

        /* .minus:hover {
                    background-image: -webkit-linear-gradient(-180deg, rgb(254, 109, 14) 0%, rgb(253, 66, 23) 100%);
                }

                .plus:hover {
                    background-image: -webkit-linear-gradient(-180deg, rgb(254, 109, 14) 0%, rgb(253, 66, 23) 100%);
                } */

        input.count {
            border: 0;
            width: 40px;
            height: 40px;
            border-radius: 120px;
            text-align: center;
        }

        .variation h2 {
            text-align: left;
        }

        .w-100 {
            width: 570px;
        }

        .slider-thumb {
            border: 2px solid black;

        }

        /* Slider */
        .slick-slider {
            position: relative;

            display: block;
            box-sizing: border-box;

            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

            -webkit-touch-callout: none;
            -khtml-user-select: none;
            -ms-touch-action: pan-y;
            touch-action: pan-y;
            -webkit-tap-highlight-color: transparent;
        }

        .slick-list {
            position: relative;

            display: block;
            overflow: hidden;

            margin: 0;
            padding: 0;
        }

        .slick-list:focus {
            outline: none;
        }

        .slick-list.dragging {
            cursor: pointer;
            cursor: hand;
        }

        .slick-slider .slick-track,
        .slick-slider .slick-list {
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }

        .slick-track {
            position: relative;
            top: 0;
            left: 0;

            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .slick-track:before,
        .slick-track:after {
            display: table;

            content: '';
        }

        .slick-track:after {
            clear: both;
        }

        .slick-loading .slick-track {
            visibility: hidden;
        }

        .slick-slide {
            display: none;
            float: left;

            height: 100%;
            min-height: 1px;
        }

        [dir='rtl'] .slick-slide {
            float: right;
        }

        .slick-slide img {
            display: block;
        }

        .slick-slide.slick-loading img {
            display: none;
        }

        .slick-slide.dragging img {
            pointer-events: none;
        }

        .slick-initialized .slick-slide {
            display: block;
        }

        .slick-loading .slick-slide {
            visibility: hidden;
        }

        .slick-vertical .slick-slide {
            display: block;

            height: auto;

            border: 1px solid transparent;
        }

        .slick-arrow.slick-hidden {
            display: none;
        }

        .product-img--main__image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: contain;
            background-position: center;

            background-repeat: no-repeat;
            -webkit-transition: -webkit-transform .5s ease-out;
            transition: -webkit-transform .5s ease-out;
            transition: transform .5s ease-out;
            transition: transform .5s ease-out, -webkit-transform .5s ease-out;
        }

        .product-img--main {

            position: relative;
            overflow: hidden;
            height: 500px;
            width: 100%;
        }

        .flux-button-ab {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 10px;
            padding-left: 110px;
            gap: 0px;

        }

        .week-and-day .input-attr {
            width: 75%;
        }
        
        .cleaner-inner-img figure {
            height: 400px;
            width: 600px;
        }
        
        .cleaner-inner-img figure img {
            width: 100% !important;
            height: 100%;
            object-fit: contain;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('js/zebra_datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.input_qty').on('change', function () {
                $('#update-cart').submit();
            });
        });
        // $('ul.input-attr li').click(function(){
        //         $(this).find('input').prop("checked", true);
        //         $('ul.input-attr li').removeClass('active')
        //         $(this).addClass('active')

        // })

        // $('ul.input-attr input').change(function(){
        //     $('ul.input-attr li').removeClass('active')
        //     $(this).parent().addClass('active')

        // })
        /* $(document).ready(function() {
             $('ul.input-attr li:first-child').addClass('active');

             $('ul.input-attr li').click(function() {
                 $(this).find('input').prop("checked", true);
                 $('ul.input-attr li').removeClass('active');
                 $(this).addClass('active');
             });


             $('ul.input-attr input').change(function() {
                 $('ul.input-attr li').removeClass('active');
                 $(this).parent().addClass('active');
             });

         });*/




        // $(document).on('click', "#addCart", function(e) {
        //     if ($('ul.input-attr input[name="variation"]:checked').length === 0) {
        //         e.preventDefault();
        //         alert('Please select a variation before adding to cart.');
        //     } else {
        //         console.log($('#addcount').val());
        //         $('#add-cart').submit();
        //     }
        // });

        $(document).on('keydown keyup', ".qty", function(e) {
            if ($(this).val() <= 1) {
                e.preventDefault();
                $(this).val(1);
            }
        });
        // $(document).ready(function() {
        //     $(document).on('click', '.plus', function() {
        //         $('.count').val(parseInt($('.count').val()) + 1);
        //     });
        //     $(document).on('click', '.minus', function() {
        //         $('.count').val(parseInt($('.count').val()) - 1);
        //         if ($('.count').val() == 0) {
        //             $('.count').val(1);
        //         }
        //     });
        // });

        //        $(document).ready(function() {
        //     $(document).on('click', '.plus', function() {
        //         // Increase the quantity by 1
        //         var currentQuantity = parseInt($('.count').val()) || 0;
        //         $('.count').val(currentQuantity + 1);
        //     });

        //     $(document).on('click', '.minus', function() {
        //         // Decrease the quantity by 1, ensuring it doesn't go below 1
        //         var currentQuantity = parseInt($('.count').val()) || 0;
        //         $('.count').val(currentQuantity > 1 ? currentQuantity - 1 : 1);
        //     });
        // });

        $('.product-img--main')
            // tile mouse actions
            .on('mouseover', function() {
                $(this).children('.product-img--main__image').css({
                    'transform': 'scale(' + $(this).attr('data-scale') + ')'
                });
            })
            .on('mouseout', function() {
                $(this).children('.product-img--main__image').css({
                    'transform': 'scale(1)'
                });
            })
            .on('mousemove', function(e) {
                $(this).children('.product-img--main__image').css({
                    'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e
                        .pageY - $(this).offset().top) / $(this).height()) * 100 + '%'
                });
            })
            // tiles set up
            .each(function() {
                $(this)
                    // add a image container
                    .append('<div class="product-img--main__image"></div>')
                    // set up a background image for each tile based on data-image attribute
                    .children('.product-img--main__image').css({
                        'background-image': 'url(' + $(this).attr('data-image') + ')'
                    });
            });
    </script>
@endsection
