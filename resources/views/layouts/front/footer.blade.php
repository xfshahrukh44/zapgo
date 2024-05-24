<style>
    .quantity input{


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
                                      <input type="text" name="company_name" class="form-control" id="" required="">
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
                           <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required id="inputAddress">
                           @if ($errors->has('email'))
                           <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('email') }}</small>
                           @endif
                       </div>


                       <div class="form-group">
                           <label for="inputAddress">password</label>
                           <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="inputAddress">
                           @if ($errors->has('password'))
                    <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('password') }}</small>
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
             <div class="col-lg-6">
                  <ul class="footer-menu">
                      <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                      <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                      <li><a href="{{ route('rental-agreement') }}">Rental Agreement</a></li>
                  </ul>
              </div>
                <div class="col-lg-6">
                   <div class="right-reserved">
                    <p>{!! App\Http\Traits\HelperTrait::returnFlag(499) !!}</p>
                </div>
              </div>
              
         </div>
    </div>
</div>
@php
$category = App\Category::find($id);

@endphp

@foreach ($category->listings as $key => $items)
<div class="modal fade staticBackdrop" id="staticBackdrop-{{ $key }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                $att_model = App\ProductAttribute::groupBy('attribute_id')->where('product_id', $items->id)->get();
		                        $att_id = DB::table('product_attributes')->where('product_id', $id)->get();
                            @endphp

                            @foreach ($att_model as $att_models)


                                <li>

                                    <input type="radio" value="{{ $att_models->id }}" name="variation" id="" required {{ $loop->first ? 'checked' : '' }}>
                                    <h5>{{ $att_models->attributesValues->value }}<span>${{ $att_models->price }} Per Unit</span></h5>
                                </li>

                            @endforeach
                        </ul>
                   </div>
              </div>

              <div class="modal-footer">
                @if($items->stock_inventory > 0)
                    <button href="javascript:void(0)" class="btn blue-custom" id="addCart">Add to cart </button>
                @else
                    <button href="javascript:void(0)" class="btn blue-custom disabled" id="outofstock">Out of Stock </button>
                @endif
              </form>
                    {{-- <a href="{{ route('category') }}" class="btn blue-custom">Keep Shopping</a>  --}}
                    <button type="button" class="btn blue-custom  but-cs" data-bs-dismiss="modal" aria-label="Close">Keep Shopping</button>
              </div>
         </div>
    </div>
</div>
@endforeach




</body>

</html>
