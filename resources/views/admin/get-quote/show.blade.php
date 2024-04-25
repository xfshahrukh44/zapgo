@extends('layouts.app')

@section('content')
    <div class="container-fluid bg-white mt-5">
        <!-- .row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box card">
                    <div class="card-body">
                        <h3 class="box-title pull-left">Quote Orders</h3>

                        <a class="btn btn-success pull-right" href="{{ url('/admin/get-quote') }}">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> Back</a>

                        <div class="clearfix"></div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $getquote->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> First Name </th>
                                        <td> {{ $getquote->first_name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Last Name </th>
                                        <td> {{ $getquote->last_name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Email </th>
                                        <td> {{ $getquote->email }} </td>
                                    </tr>
                                    <tr>
                                        <th> Phone </th>
                                        <td> {{ $getquote->phone }} </td>
                                    </tr>
                                    <tr>
                                        <th> Company </th>
                                        <td> {{ $getquote->company }} </td>
                                    </tr>
                                    <tr>
                                        <th> Address </th>
                                        <td> {{ $getquote->address }} </td>
                                    </tr>
                                    <tr>
                                        <th> City </th>
                                        <td> {{ $getquote->city }} </td>
                                    </tr>
                                    <tr>
                                        <th> State </th>
                                        <td> {{ $getquote->state }} </td>
                                    </tr>
                                    <tr>
                                        <th> Selected Product </th>
                                        <td> {{ $getquote->productss->product_title }} </td>
                                    </tr>
                                    <tr>
                                        <th> Quantity </th>
                                        <td> {{ $getquote->quantity }} </td>
                                    </tr>
                                    <tr>
                                        <th> Additional Information </th>
                                        <td> {{ $getquote->message }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @if ($getquote->status == 0)
                            <div class="white-box card">
                                <div class="card-body">
                                    <div class="order-detail">
                                        @php
                                            $subtotal = $getquote->productss->price * $getquote->quantity;
                                        @endphp
                                        <h3>Order Detail</h3>
                                        <div class="order-box">
                                            <div class="pname item">
                                                <h4>Item Name: </h4>
                                                <h4>{{ $getquote->productss->product_title }}</h4>
                                            </div>
                                            <div class="pname item">
                                                <h4>Item Price: </h4>
                                                <h4>$<span id="price">{{ number_format($getquote->productss->price) }}</span></h4>
                                            </div>
                                            <div class="quantity item">
                                                <h5>Quantity: </h4>
                                                    <h4>
                                                        <div class="quantity">
                                                            <span class="minus  minus-1">-</span>
                                                            <input name="quantity" id="qty" type="text"
                                                                class="quantity__input input-1 count" readonly=""
                                                                value="{{ $getquote->quantity }}">
                                                            <span class="plus plus-1">+</span>
                                                        </div>
                                                </h5>
                                            </div>
                                            <div class="price item">
                                                <h5>Total: </h5>
                                                    <h4>$<span id="total">{{ $getquote->productss->price * $getquote->quantity }}</span></h4>


                                            </div>
                                        </div>

                                        <h2 class="accordion-header" id="flush-headingTwo">

                                            Pay with Credit Card

                                        </h2>

                                        <form action="{{ route('getQuoteOrder') }}" method="POST" id="order-place">
                                            @csrf

                                            <?php $user_name = $getquote->first_name . ' ' . $getquote->last_name; ?>
                                            <input type="hidden" name="payment_id" value="" />
                                            <input type="hidden" name="payer_id" value="" />
                                            <input type="hidden" name="payment_status" value="" />
                                            <input type="hidden" name="order_total" id="order_total" value="{{ $subtotal }}" />
                                            <input type="hidden" id="f-name" name="first_name" value="{{ $user_name }}">
                                            <input type="hidden" id="phone_no" name="phone_no" value="{{ $getquote->phone }}">
                                            <input type="hidden" id="email" name="email" value="{{ $getquote->email }}">
                                            <input type="hidden" id="product_id" name="product_id" value="{{ $getquote->product }}">
                                            <input type="hidden" id="quantity" name="quantity" value="{{ $getquote->quantity }}">
                                            <input type="hidden" id="order_id" name="order_id" value="{{ $getquote->id }}">

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
                                    </div>
                                </div>

                            </div>
                        @else
                            <div class="bg-success card succes-box">
                                <div class="card-body">
                                    <h2 m-0>Payment Completed Successfully</h2>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <style>
            .item h4,
            .item h5 {
                margin: 0px !important;
            }

            .item {
                margin-bottom: 10px;
                border-bottom: 1px solid #e3ebf3;
                padding: 5px;
                display: flex;
                align-items: center;
                justify-content: space-between;
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

            .succes-box h2 {
                margin: 0;
                color: #fff;
            }

            .quantity .minus {
                cursor: pointer;
                display: inline-block;
                vertical-align: top;
                color: white;
                width: 30px;
                height: 30px;
                font: 30px/1 Arial, sans-serif;
                text-align: center;
                /* border-radius: 50%; */
                background: #0489d0;
                background-clip: padding-box;
            }

            .quantity .plus {
                cursor: pointer;
                display: inline-block;
                vertical-align: top;
                color: white;
                width: 30px;
                height: 30px;
                font: 30px/1 Arial, sans-serif;
                text-align: center;
                /* border-radius: 50%; */
                background: #0489d0;
            }


            .quantity input {
                text-align: center;
                height: 30px;
            }
        </style>

        <script src="{{ asset('plugins/vendors/jquery/jquery.min.js') }}"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
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
        {{-- @include('layouts.admin.footer') --}}
    </div>
@endsection
