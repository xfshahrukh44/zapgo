@extends('layouts.main')
@section('content')
    <section class="rent-sec about-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="equipment">
                        <h1><span class="d-block">{{ $page->page_name ?? 'Get A Qoute' }} </span></h1>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="home-ab about-pg-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="modal-body">
                        <div class="main-form-news">
                            <form action="{{ route('quoteStore') }} " method="POST">
                                @csrf
                                <input type="hidden" id="date-range-days" value="0">
                                <input type="hidden" id="amount-date" value="1">
                                
                                <div class="date-row">
                                    <div class="form-group col-6" style=" margin-left: 12px; ">
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
                                    <div class="form-group col-6">
                                        <input type="email" name="email" class="form-control" placeholder="Email Name*"
                                            required="">
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="text" name="phone" class="form-control"
                                            placeholder="Phone Number*" required="">
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="text" name="company" class="form-control" placeholder="Company*"
                                            required="">
                                    </div>
                                    <div class="form-group col-6">
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

                                    <!-- Container for product rows -->
                                    <div id="product-container">
                                        <div class="form-row product-row">
                                            <div class="form-group col-6">
                                                <input type="hidden" id="item-price-0" name="item_price[]" value="0">
                                                @php
                                                $product = App\Product::all();
                                                @endphp
                                                <select class="form-select product" name="product[]"
                                                    aria-label="Default select example" id="product-0">
                                                    <option selected disabled>Select Product</option>
                                                    @foreach ($product as $items)
                                                    @php
                                                        $price_per_day = (\App\ProductAttribute::where(['product_id' => $items->id, 'attribute_id' => 14])->first()->price) ?? 0.00;
                                                        $price_per_week = (\App\ProductAttribute::where(['product_id' => $items->id, 'attribute_id' => 15])->first()->price) ?? 0.00;
                                                        $price_per_month = (\App\ProductAttribute::where(['product_id' => $items->id, 'attribute_id' => 16])->first()->price) ?? 0.00;
                                                    @endphp 
                                                        <option value="{{ $items->id }}" data-price="{{ $items->price }}" data-price-per-day="{{ $price_per_day }}" data-price-per-week="{{ $price_per_week }}" data-price-per-month="{{ $price_per_month }}">{{ $items->product_title }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            {{-- <div class="form-group col-3">
                                                <div class="quantity">
                                                    <span class="minus-0 q-minus-1">-</span>
                                                    <input name="quantity[]" id="quantity-0" type="text"
                                                        class="quantity__input input-1 count" readonly value="0">
                                                    <span class="plus-0 q-plus-1">+</span>
                                                </div>
                                            </div> --}}
                                            <div class="form-group col-1">
                                                <select name="quantity[]" id="quantity-0" class="form-select quantity" style="background: transparent !important; padding: 11px;">
                                                    <option value="" selected disabled>Quantity</option>
                                                    @for ($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="form-group col-5">
                                                <input type="text" name="price[]" id="price-0" class="form-control getAmount" value="0"
                                                 required readonly>
                                            </div>
                                            <div class="form-group col-1">
                                                <button class="btn btn-danger remove-row">X</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <input type="button" class="form-control" id="add-more" style="width: unset;" value="Add More">
                                    </div>

                                    <div class="form-group col-6">
                                        <input type="text" name="" id="total_amount" class="form-control" placeholder="Total Amount*" readonly>
                                    </div>
                                    <div class="form-group col-6">
                                        <input type="text" name="bulk_amount" class="form-control" placeholder="Bulk Amount*">
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
    </section>
@endsection
@section('css')
    <style>
        .rent-sec {
            background-image: url('http://127.0.0.1:8000/images/2.png') !important;
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
        .Zebra_DatePicker_Icon_Wrapper {
            width: 99% !important;
        } 
        
        .Zebra_DatePicker_Icon_Wrapper .date-rent-start,
        .Zebra_DatePicker_Icon_Wrapper .date-rent-end {
            max-width: 98.5% !important;
            width: inherit !important;
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.date-rent-start').Zebra_DatePicker({
                direction: true,
                format: 'm-d-Y',
                pair: $('.date-rent-end'),
                onClose: function(view, elements) {
                    var datepicker = $('.date-rent-end').data('Zebra_DatePicker');
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
                    var datepicker = $('.date-rent-end').data('Zebra_DatePicker');
                    if (datepicker) {
                        var startDate = new Date($('.date-rent-start').val());
                        var endDate = new Date($('.date-rent-end').val());
                        if (endDate < startDate) {
                            $('.date-rent-end').val($('.date-rent-start').val());
                            datepicker.update();
                        }
                        updateDateRange(startDate, endDate);
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

            function updateDateRange(startDate, endDate) {
                var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                console.log(diffDays + ' days');
                let price_key;
                let day_value;
                let multiplier_value;
                if (diffDays > 30) {
                    price_key = 'price_per_month';
                    day_value = 30;
                    multiplier_value = diffDays - day_value;
                } else if (diffDays == 30) {
                    price_key = 'price_per_week';
                    day_value = 30;
                    multiplier_value = 1;
                } else if (diffDays > 7) {
                    price_key = 'price_per_week';
                    day_value = 7;
                    multiplier_value = diffDays - day_value;
                } else if (diffDays == 7) {
                    price_key = 'price_per_week';
                    day_value = 7;
                    multiplier_value = 1;
                } else {
                    price_key = 'price_per_day';
                    day_value = 1;
                    multiplier_value = diffDays / day_value;
                }
                $('#date-range-days').val(diffDays);
                $('#amount-date').val(multiplier_value);
            }

        });

        $(document).ready(function() {
            // Counter for unique IDs
            var counter = 1;

            // Function to clone the product row template
            function cloneProductRow() {
                var clonedRow = $(".product-row").first().clone();
                clonedRow.appendTo("#product-container");

                var rowCounter = counter; 
                clonedRow.find("select.product").attr("id", "product-" + rowCounter);
                clonedRow.find("select.quantity").attr("id", "quantity-" + rowCounter);
                // clonedRow.find("input[name='quantity[]']").attr("id", "quantity-" + rowCounter);
                clonedRow.find("input[name='item_price[]']").attr("id", "item-price-" + rowCounter);
                clonedRow.find("input[name='price[]']").attr("id", "price-" + rowCounter);
                clonedRow.find(".minus-0").removeClass("minus-0").addClass("minus-" + rowCounter);
                clonedRow.find(".plus-0").removeClass("plus-0").addClass("plus-" + rowCounter);

                // clonedRow.find(".plus-" + rowCounter).click(function() {
                //     var inputField = $(this).siblings(".quantity__input");
                //     var currentValue = parseInt(inputField.val());
                //     inputField.val(currentValue + 1);
                //     updatePrice(rowCounter);
                //     updateTotal();
                // });

                // clonedRow.find(".minus-" + rowCounter).click(function() {
                //     var inputField = $(this).siblings(".quantity__input");
                //     var currentValue = parseInt(inputField.val());
                //     if (currentValue > 0) {
                //         inputField.val(currentValue - 1);
                //         updatePrice(rowCounter);
                //         updateTotal();
                //     }
                // });

                counter++;
                clonedRow.find(".remove-row").show();
                updatePrice(rowCounter);
                updateTotal();
            }

            function updatePrice(rowCounter) {
                var productSelector = $("#product-" + rowCounter);
                var quantitySelect = $("#quantity-" + rowCounter);
                var quantity = quantitySelect.val();
                var selectedOption = productSelector.find("option:selected");
                console.log(quantity);
                
                
                var amount_date = $('#amount-date').val();
                var days = $('#date-range-days').val();
                var per_day_price = parseFloat(selectedOption.data("price-per-day"));
                var price_value;
                var price;
                if (days == 30) {
                    price_value = parseFloat(selectedOption.data("price-per-month"));
                    price = parseFloat(price_value);
                } else if (days > 30) {
                    price_value = parseFloat(selectedOption.data("price-per-month"));
                    price = parseFloat(price_value + per_day_price * amount_date);
                } else if (days == 7) {
                    price_value = parseFloat(selectedOption.data("price-per-week"));
                    price = parseFloat(price_value);
                } else if (days > 7) {
                    price_value = parseFloat(selectedOption.data("price-per-week"));
                    price = parseFloat(price_value + per_day_price * amount_date);
                } else{
                    price_value = parseFloat(selectedOption.data("price"));
                    price = parseFloat(price_value * amount_date);
                }

                $('#item-price-'+ rowCounter).val(price.toFixed(2));

                // var quantity = parseInt($("#quantity-" + rowCounter).val());
                var totalPrice = price * quantity;
                
                if (!isNaN(totalPrice)) {
                    $("#price-" + rowCounter).val(totalPrice.toFixed(2));
                } else {
                    $("#price-" + rowCounter).val(0);
                }
                // $("#price-" + rowCounter).val(totalPrice.toFixed(2));
            }

            function updateTotal() {
                var totalAmount = 0;
                $("input[name='price[]']").each(function() {
                    totalAmount += parseFloat($(this).val());
                });
                $("#total_amount").val(totalAmount.toFixed(2));
            }

            $("#add-more").click(function() {
                cloneProductRow();
            });

            $(document).on("click", ".remove-row", function() {
                $(this).closest(".product-row").remove();
                updateTotal();
            });

            $(".product-row:first .remove-row").hide();

            $(".product-row").each(function(index) {
                updatePrice(index + 1);
            });

            $(document).on("change", "select.product", function() {
                var rowCounter = $(this).attr("id").split("-")[1];
                updatePrice(rowCounter);
                updateTotal();
            });

            $(document).on("change", "select.quantity", function() {
                var rowCounter = $(this).attr("id").split("-")[1];
                updatePrice(rowCounter);
                updateTotal();
            });

            $(document).on("keyup", "input[name='price[]']", function() {
                updateTotal();
            });
            
            function updateAmountOnDateChange() {
                var startDate = new Date($('.date-rent-start').val());
                var endDate = new Date($('.date-rent-end').val());
                updateDateRange1(startDate, endDate);
                
                var rowCount = $(".product-row").length;
                console.log(rowCount);
                
                if(rowCount != 1){
                    $(".product-row").each(function(index) {
                        updatePrice(index + 1);
                    });}
                // }else{
                    $(".product-row").each(function(index) {
                        updatePrice(index);
                    });
                // }
                updateTotal();
            }
    
            function isProductAndQuantitySelected() {
                var isProductSelected = false;
                var isQuantitySelected = false;
                
                $("select.product, select.quantity").each(function() {
                    if ($(this).hasClass('product') && $(this).val() !== "") {
                        isProductSelected = true;
                    } else if ($(this).hasClass('quantity') && $(this).val() !== "") {
                        isQuantitySelected = true;
                    }
                });
            
                return isProductSelected && isQuantitySelected;
            }
            
             $('.date-rent-start').Zebra_DatePicker({
                direction: 1,
                format: 'm-d-Y',
                onSelect: function(view, elements) {
                    if (isProductAndQuantitySelected()) {
                        updateAmountOnDateChange();
                    }
                }
            });
            $('.date-rent-start').Zebra_DatePicker({
                direction: true,
                format: 'm-d-Y',
                pair: $('.date-rent-end'),
                onSelect: function(view, elements) {
                    var datepicker = $('.date-rent-end').data('Zebra_DatePicker');
                    if (datepicker) {
                        var startDate = new Date($('.date-rent-start').val());
                        var endDate = new Date($('.date-rent-end').val());
                        if (endDate < startDate) {
                            $('.date-rent-end').val($('.date-rent-start').val());
                            datepicker.update();
                        }
                        if (isProductAndQuantitySelected()) {
                            updateAmountOnDateChange();
                        }
                    }
                }
            });
            
            $('.date-rent-end').Zebra_DatePicker({
                direction: 1,
                format: 'm-d-Y',
                onSelect: function(view, elements) {
                    if (isProductAndQuantitySelected()) {
                        updateAmountOnDateChange();
                    }
                }
            });
            
            // $('.date-rent-end').Zebra_DatePicker({
            //     direction: true,
            //     format: 'm-d-Y',
            //     onSelect: function(view, elements) {
            //         if (isProductAndQuantitySelected()) {
            //             updateAmountOnDateChange();
            //         }
            //     }
            // });
            
            function updateDateRange1(startDate, endDate) {
                var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                console.log(diffDays + ' days');
                let price_key;
                let day_value;
                let multiplier_value;
                if (diffDays > 30) {
                    price_key = 'price_per_month';
                    day_value = 30;
                    multiplier_value = diffDays - day_value;
                } else if (diffDays == 30) {
                    price_key = 'price_per_week';
                    day_value = 30;
                    multiplier_value = 1;
                } else if (diffDays > 7) {
                    price_key = 'price_per_week';
                    day_value = 7;
                    multiplier_value = diffDays - day_value;
                } else if (diffDays == 7) {
                    price_key = 'price_per_week';
                    day_value = 7;
                    multiplier_value = 1;
                } else {
                    price_key = 'price_per_day';
                    day_value = 1;
                    multiplier_value = diffDays / day_value;
                }
                $('#date-range-days').val(diffDays);
                $('#amount-date').val(multiplier_value);
            }
            
        });
        
        



        // $(document).on("click", ".plus-0", function() {
        //     var inputField = $(this).siblings('.quantity__input');
        //     var currentValue = parseInt(inputField.val());
        //     inputField.val(currentValue + 1);

        //     var productSelector = $("#product-0");
        //     var selectedOption = productSelector.find("option:selected");
            
        //     var amount_date = $('#amount-date').val();
        //     var days = $('#date-range-days').val();
        //     var per_day_price = parseFloat(selectedOption.data("price-per-day"));
        //     var price_value;
        //     var price;
        //     if (days == 30) {
        //         price_value = parseFloat(selectedOption.data("price-per-month"));
        //         price = parseFloat(price_value);
        //     } else if (days > 30) {
        //         price_value = parseFloat(selectedOption.data("price-per-month"));
        //         price = parseFloat(price_value + per_day_price * amount_date);
        //     } else if (days == 7) {
        //         price_value = parseFloat(selectedOption.data("price-per-week"));
        //         price = parseFloat(price_value);
        //     } else if (days > 7) {
        //         price_value = parseFloat(selectedOption.data("price-per-week"));
        //         price = parseFloat(price_value + per_day_price * amount_date);
        //     } else{
        //         price_value = parseFloat(selectedOption.data("price"));
        //         price = parseFloat(price_value * amount_date);
        //     }

        //     $('#item-price-0').val(price.toFixed(2));
        //     var quantity = parseInt($("#quantity-0").val());
        //     var totalPrice = price * quantity;
        //     $("#price-0")   .val(totalPrice.toFixed(2));
        // });

        // Decrement quantity
        // $(document).on("click", ".minus-0", function() {
        //     var inputField = $(this).siblings('.quantity__input');
        //     var currentValue = parseInt(inputField.val());
        //     if (currentValue > 0) {
        //         inputField.val(currentValue - 1);
        //     }

        //     var productSelector = $("#product-0");
        //     var selectedOption = productSelector.find("option:selected");
        //     var amount_date = parseFloat($('#amount-date').val());
        //     var days = $('#date-range-days').val();
        //     var per_day_price = parseFloat(selectedOption.data("price-per-day"));
        //     var price_value;
        //     var price;
        //     if (days == 30) {
        //         price_value = parseFloat(selectedOption.data("price-per-month"));
        //         price = parseFloat(price_value);
        //     } else if (days > 30) {
        //         price_value = parseFloat(selectedOption.data("price-per-month"));
        //         price = parseFloat(price_value + per_day_price * amount_date);
        //     } else if (days == 7) {
        //         price_value = parseFloat(selectedOption.data("price-per-week"));
        //         price = parseFloat(price_value);
        //     } else if (days > 7) {
        //         price_value = parseFloat(selectedOption.data("price-per-week"));
        //         price = parseFloat(price_value + per_day_price * amount_date);
        //     } else{
        //         price_value = parseFloat(selectedOption.data("price"));
        //         price = parseFloat(price_value * amount_date);
        //     }
        //     $('#item-price-0').val(price.toFixed(2));
        //     var quantity = parseInt($("#quantity-0").val());
        //     var totalPrice = price * quantity;
        //     $("#price-0").val(totalPrice.toFixed(2));
        // });

    </script>
@endsection
