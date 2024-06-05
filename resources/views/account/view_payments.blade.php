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
                                        ID: #{{$quote->id}}
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
                                    Dates
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span> #{{$quote->id}}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Date range:</span> {{ $quote->start_date.' to '.$quote->end_date }}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Number of days:</span> {{$quote->number_of_days}}</div>
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
                                $quote_product_arr = [];
                            @endphp
                            @foreach ($quote->quote_products as $val)
                            @php
                               $quote_product_arr[] = $val->id; 
                            @endphp
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
                        @if ($quote->status == 2)
                        
                        <h2 class="accordion-header" id="flush-headingTwo">

                            Pay with Credit Card

                        </h2>

                        <form action="{{ route('getQuoteOrder') }}" method="POST" id="order-place">
                            @csrf

                            @php 
                                $user_name = $quote->first_name . ' ' . $quote->last_name; 
                                $quote_prod_ids = implode(',', $quote_product_arr);
                            @endphp
                            <input type="hidden" name="payment_id" value="" />
                            <input type="hidden" name="payer_id" value="" />
                            <input type="hidden" name="payment_status" value="" />
                            <input type="hidden" name="order_total" id="order_total" value="{{ $total }}" />
                            <input type="hidden" id="f-name" name="first_name" value="{{ $user_name }}">
                            <input type="hidden" id="phone_no" name="phone_no" value="{{ $quote->phone }}">
                            <input type="hidden" id="email" name="email" value="{{ $quote->email }}">
                            {{-- <input type="hidden" id="product_id" name="product_id" value="{{ $quote->product }}">
                            <input type="hidden" id="quantity" name="quantity" value="{{ $quote->quantity }}"> --}}
                            <input type="hidden" id="order_id" name="order_id" value="{{ $quote->id }}">
                            <input type="hidden" id="quote_prod_ids" name="quote_prod_ids" value="{{ $quote_prod_ids }}">

                            <div class="stripe-form-wrapper require-validation"
                                data-stripe-publishable-key="{{ config('services.stripe.stripekey') }}"
                                data-cc-on-file="false">
                                <div id="card-element"></div>
                                <div id="card-errors" role="alert"></div>
                                <div class="form-group">
                                    <button class="btn btn-red btn-block blue-custom" type="button"
                                        id="stripe-submit">Pay Now</button>
                                </div>
                            </div>
                        </form>
                        @elseif($quote->status == 0)
                        <h2 class="accordion-header" id="flush-headingTwo">

                            Wait for approval from admin

                        </h2>
                        @else
                        <h2 class="accordion-header" id="flush-headingTwo">

                            Already Paid

                        </h2>
                        @endif
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

button#stripe-submit {
    background: linear-gradient(45deg, #18b4fd, #0285CB);
    border: #0b98df;
    font-size: 18px;
}


</style>
@endsection
@section('js')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">

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

</script>

@endsection
