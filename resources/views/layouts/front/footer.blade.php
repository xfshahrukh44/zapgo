<style>
    .quantity input {


        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        width: 40px;
        height: 40px;
        border-radius: 120px;
    }

    ul.footer-menu {
        display: flex;
        gap: 15px;
    }

    ul.footer-menu li a {
        text-decoration: none;
        color: #fff;
        font-size: 13px; 
    }

    .ratings-container {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .rating {
        flex: 1;
        width: 100px;
        height: 100px;
        cursor: pointer;
        padding: 20px;
        margin: 15px 20px;
    }

    .rating i {
        font-size: 3rem;
        border-radius: 50%;
        color: #b4b4b4;
        transition: 0.3s ease;
    }

    .rating:hover i,
    .rating.active i {
        color: #fddc81;
        background: radial-gradient(circle,
                rgb(97, 97, 114) 0%,
                rgba(97, 97, 114) 55%,
                rgba(255, 255, 255, 0) 56%);
        font-size: 3.5rem;
    }

    .rating small {
        display: inline-block;
        font-weight: 900;
        margin: 10px 0 0;
        color: #b4b4b4;
    }

    .rating:hover small,
    .rating.active small {
        color: #555;
    }

    .media {
        display: flex;
        gap: 10px;
    }

    .media a {
        text-decoration: none !important;
        border: none !important;
    }

    .media a i {
        color: white;
        border: 1px solid white;
        padding: 10px 10px;
        border-radius: 30px;
    }

    .media a i:hover {
        color: black;
        background-color: white;
    }

    .media a i.fa-brands.fa-facebook-f {
        padding: 11px 14px;
    }
</style>
<footer>
    <div class="container" id="footer-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-h">
                    <h6>contact us</h6>
                    <h2>Get in touch with us</h2>
                    <p>Reach out today for expert support and equipment inquiries.</p>
                </div>
                <div class="calls">
                    <h5>call us</h5>
                    <div class="office-call">
                        <span>Office :</span>
                        <a href="tel:+{!! App\Http\Traits\HelperTrait::returnFlag(218) !!}

                            ">{!! App\Http\Traits\HelperTrait::returnFlag(59) !!}</a>
                    </div>
                </div>
                <div class="calls">
                    <h5>Address</h5>
                    <div class="office-call">
                        <p>{!! App\Http\Traits\HelperTrait::returnFlag(519) !!}

                        </p>
                    </div>
                </div>
                <div class="calls">
                    <h5>Email</h5>
                    <div class="office-call">
                        <a href="mailto:{!! App\Http\Traits\HelperTrait::returnFlag(218) !!}

                            ">{!! App\Http\Traits\HelperTrait::returnFlag(218) !!}

                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="side-form">
                    <form id="contactform">
                        @csrf
                        <input type="hidden" name="form_name" value="contact">
                        <div class="row">
                            <div class="form-group">
                                <label>Your Name (*)</label>
                                <input type="text" name="name" class="form-control" id="" required="">
                            </div>
                            <div class="form-group">
                                <label>Your Email (*)</label>
                                <input type="email" name="email" class="form-control" id="" required="">
                            </div>
                            <div class="form-group">
                                <label>Phone Number (*)</label>
                                <input type="number" name="phone" class="form-control" id="" required="">
                            </div>

                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" id=""
                                    required="">
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" name="subject" class="form-control" id="" required="">
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="message" id="textarea" class="form-control" cols="30" rows="8" required=""></textarea>
                            </div>
                            <button class="btn blue-custom" type="submit">send message</button>
                            <div id="contactformsresult">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- @if (Auth::check() && Auth::user()->role == 2) --}}
        <div class="container" id="feedback-form" style="margin-top: 61px;">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-h">
                        <h6>Feedback form</h6>
                        <h2>Give us feedback</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="side-form">
                        <form id="feedbackform">
                            @csrf
                            <input type="hidden" name="form_name" value="feedback">
                            {{-- <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}"> --}}
                            <div class="row">
                                <div class="form-group">
                                    <label>How was your experience with ZapGo Rentals?</label>
                                    <input type="hidden" id="type" name="type" value="Neutral">
                                </div>
                                <div class="ratings-container">
                                    <div class="rating">
                                        <i class="fa-solid fa-face-sad-tear"></i>
                                        <small>Unhappy</small>
                                    </div>

                                    <div class="rating active">
                                        <i class="fa-solid fa-face-meh"></i>
                                        <small>Neutral</small>
                                    </div>

                                    <div class="rating">
                                        <i class="fa-solid fa-face-grin-beam"></i>
                                        <small>Satisfied</small>
                                    </div>
                                </div>
                                @if (Auth::check())
                                @php
                                    $name = Auth::user()->name.' '.Auth::user()->last_name;
                                @endphp
                                @endif
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" id="name" value="{{ $name }}" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label>Put the feedback message</label>
                                    <textarea name="message" id="message" class="form-control" cols="30" rows="8" required=""
                                        style="height: 130px;"></textarea>
                                </div>
                                <button class="btn blue-custom" type="submit">Send Feedback</button>
                                <div id="feedbackformsresult"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- @endif --}}




    <div class="modal fade" id="sign_tabs_poppup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Sign In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="pickup-main">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="inputAddress">Email</label>
                                <input type="email"
                                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email" value="{{ old('email') }}" required id="inputAddress">
                                @if ($errors->has('email'))
                                    <small
                                        class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('email') }}</small>
                                @endif
                            </div>


                            <div class="form-group">
                                <label for="inputAddress">password</label>
                                <input type="password"
                                    class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" id="inputAddress">
                                @if ($errors->has('password'))
                                    <small
                                        class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('password') }}</small>
                                @endif
                            </div>



                            <div class="form-check">
                                <div class="form-group">
                                    <label><a href="{{ url('password/reset') }}">Forgot Password?</a> </label>
                                </div>

                                <div class="acc-free-sign-up-button">
                                    <button class="btn blue-custom" type="submit">Sign in</button>
                                </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>



</footer>

<div class="bottom-div">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <ul class="footer-menu">
                    <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                    <li><a href="{{ route('rental-agreement') }}">Rental Agreement</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="right-reserved">
                    <p>{!! App\Http\Traits\HelperTrait::returnFlag(499) !!}</p>
                </div>
            </div>
            <div class="col-lg-4">
               <div class="media">
                   @php
                       $facebookUrl = App\Http\Traits\HelperTrait::returnFlag(682);
                       $twitterUrl = App\Http\Traits\HelperTrait::returnFlag(1960);
                       $instagramUrl = App\Http\Traits\HelperTrait::returnFlag(1962);
                       $youtubeUrl = App\Http\Traits\HelperTrait::returnFlag(1964);
                   @endphp
           
                   @if($facebookUrl)
                       <a href="{{ $facebookUrl }}"><i class="fa-brands fa-facebook-f"></i></a>
                   @endif
           
                   @if($twitterUrl)
                       <a href="{{ $twitterUrl }}"><i class="fa-brands fa-twitter"></i></a>
                   @endif
           
                   @if($instagramUrl)
                       <a href="{{ $instagramUrl }}"><i class="fa-brands fa-instagram"></i></a>
                   @endif
           
                   @if($youtubeUrl)
                       <a href="{{ $youtubeUrl }}"><i class="fa-brands fa-youtube"></i></a>
                   @endif
               </div>
           </div>
           

        </div>
    </div>
</div>
@php
    $category = App\Category::find($id);

@endphp

@foreach ($category->listings as $key => $items)
    <div class="modal fade staticBackdrop" id="staticBackdrop-{{ $key }}" data-bs-backdrop="static"
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
                            <div class="h-p d-flex">
                                <div>
                                    <img src="{{ asset($items->image) }}" class="img-fluid" alt="">
                                    <p> {{ $items->product_title }} </p>
                                </div>
                                <!-- <p> Quantity. </p>-->
                                <!-- <div class="quantity qty">-->
                                <!--       <span class="minus  minus-1">-</span>-->
                                <!--   <input type="text" id="addcount" class="count" name="qty" value="1">-->
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

                                        <input type="radio" value="{{ $att_models->id }}" name="variation"
                                            id="" required {{ $loop->first ? 'checked' : '' }}>
                                        <h5>{{ $att_models->attributesValues->value }}<span>${{ $att_models->price }}
                                                Per Unit</span></h5>
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




</body>

</html>
