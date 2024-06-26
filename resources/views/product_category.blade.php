@extends('layouts.main')
@section('content')

<section class="rent-sec about-inner">
    <div class="container">
         <div class="row">
              <div class="col-lg-12">
                   <div class="equipment">
                        <h1><span class="d-block">{{ $category->name }} </span></h1>
                   </div>
              </div>

         </div>
    </div>
</section>

<section class="products-sec">
    <div class="contaiber-fluid">
         <div class="row">
              <div class="col-lg-3">
                   <div class="side-bar">
                        <h4>Home <i class="fa-solid fa-chevron-right"></i> Product <i class="fa-solid fa-chevron-right"></i> <span>Page 1 of 1</span> </h4>
                        <h3>SHOP BY CATEGORIES</h3>
                   </div>
                   <div class="list-products">
                        <ul>
                             <li class="click-li">
                                  <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-arrow-right"></i> All products </a>
                                  <div class="menu-drop">
                                      @foreach ($categories as $items)
                                      <a href="{{ route('product_category',['id' => $items->id]) }}"><i class="fa-solid fa-arrow-right"></i> {{ $items->name }}</a>
                                      @endforeach
                                  </div>
                             </li>
                             @foreach ($categories as $cat)
                             <li class="click-li">
                                 <a href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="fa-solid fa-arrow-right"></i> {{ $cat->name }}
                                 </a>
                                 <div class="menu-drop">
                                     @forelse ($cat->listings as $product)
                                         <a href="{{ route('shopDetail', $product->id) }}">
                                             <i class="fa-solid fa-arrow-right"></i> {{ $product->product_title }}
                                         </a>
                                     @empty
                                         <p>No products available for this category.</p>
                                     @endforelse
                                 </div>
                             </li>
                         @endforeach
                        </ul>
                   </div>
              </div>
              <div class="col-lg-9">
                   <div class="row">
                    @php
                    $sortedListings = $category->listings->sortBy('product_title');
                    @endphp
                    @foreach ($sortedListings as $key => $items)

                    <div class="col-lg-4">
                        <div class="main-pro-details" data-aos="fade-down" data-aos-duration="2000">
                             <div class="img-slides">
                                  <div class="product-img owl-carousel owl-theme">
                                       <div class="item">
                                            <div class="cleaner-img">
                                                 <a href="{{ route('shopDetail',['id'=> $items->id]) }}">
                                                      <img src="{{ asset($items->image) }}" class="img-fluid" alt="">
                                                 </a>
                                            </div>
                                       </div>
                                  </div>
                             </div>
                             <div class="card-plus">
                                  <div class="dehum">
                                       <a href="{{ route('shopDetail',['id'=> $items->id]) }}">
                                            <h4>{{ $items->product_title }}</h4>
                                       </a>
                                  </div>
                                  {{-- <div class="quantity">
                                       <a href="#" class=" minus-1"><span>-</span></a>
                                       <input name="quantity" type="text" class="quantity__input input-1" readonly="" value="0">
                                       <a href="#" class=" plus-1"><span>+</span></a>
                                  </div> --}}
                             </div>
                              <div class="dollar-btn">
                                    @php
                                        $att_model = App\ProductAttribute::groupBy('attribute_id')->where('product_id', $items->id)->get();
        		                        $att_id = DB::table('product_attributes')->where('product_id', $id)->get();
                                    @endphp

                                    @foreach ($att_model as $att_models)
                                      <a href="#" class="btn blue-custom">${{ $att_models->price }} <span class="d-block">Per {{ $att_models->attributesValues->value }}</span></a>
                                    @endforeach
                             </div>

                             <div class="review-star">
                                  <div class="side-star">
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                       <i class="fa-solid fa-star"></i>
                                  </div>
                             </div>
                             <div class="add-btn">
                                {{-- <a href="{{ route('shopDetail',['id'=> $items->id]) }}"> --}}
                                   @php
                                   $isSunday = \Carbon\Carbon::now()->isSunday();
                                   $isRoleThree = Auth::user()->role == 3;
                                   @endphp

                                   <button type="button" class="btn blue-custom" data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $key }}"
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
         </div>
    </div>
</section>
<!-- Modal -->

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
                        <div class="h-p ">
                             <div>
                                  <img src="{{ asset($items->image) }}" class="img-fluid" alt="">
                                  <p> {{ $items->product_title }} </p>
                             </div>
                               <div class="in_stock">
                                 <p>{{ ($items->stock_inventory > 0) ? 'In-Stock' : 'Out of Stock' }}</p>
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

                                    <!--<input type="radio" value="{{ $att_models->id }}" name="variation" id="" required {{ $loop->first ? 'checked' : '' }}>-->
                                    <h5>${{ $att_models->price }}<span> Per {{ $att_models->attributesValues->value }}</span></h5>
                                </li>

                            @endforeach
                        </ul>
                   </div>
                    <div class="row mt-5 m-auto">
                        <label style="margin-left: -8px;">
                            <b>Select quantity</b>
                        </label>
                        <input class="form-control" type="number" placeholder="Quantity" name="qty" value="1" min="1" max="{{$items->stock_inventory}}" style="width: 29% !important; margin-top: 10px;" required>
                    </div>
              </div>
              <div class="modal-footer">
                @if($items->stock_inventory > 0)
                    <button href="javascript:void(0)" class="btn blue-custom" id="addCart">Add to cart </button>
                @else
                    <button href="javascript:void(0)" class="btn blue-custom disabled" id="outofstock">Out of Stock </button>
                @endif

              </form>
                    {{-- <a href="{{ route('category') }}" class="btn blue-custom">Keep Shopping</a> --}}
                    <button type="button" class="btn blue-custom but-cs" data-bs-dismiss="modal" aria-label="Close">Keep Shopping</button>

              </div>
         </div>
    </div>
</div>
@endforeach


@endsection
@section('css')
<style>
.rent-sec {
  background-image: url('{{ asset($page->image) }}') !important;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  height: 800px;
  display: flex;
  align-items: center;
  position: relative;
  z-index: 0;
}

#addCart{
    border:none;
    color: #0285c4 !important;
    font-weight: 700;
    font-size: 20px;
    background: transparent;
}


.quantity input{
    text-align: center;
}


.about-inner {
  height: 400px;
  align-items: end;
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

</style>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function() {

});

$(document).on('keydown keyup', ".qty", function(e) {
            if ($(this).val() <= 1) {
                e.preventDefault();
                $(this).val(1);
            }
    });



</script>
@endsection
