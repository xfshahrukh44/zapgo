@extends('layouts.main')
@section('content')
    <!-- ============================================================== -->
    <!-- BODY START HERE -->
    <!-- ============================================================== -->
    <?php

    $categories = DB::table('categories')->get();
    use App\wishlists;

    ?>


<section class="rent-sec about-inner">
    <div class="container">
         <div class="row">
              <div class="col-lg-12">
                   <div class="equipment">
                        <h1><span class="d-block">All Products</span></h1>
                   </div>
              </div>

         </div>
    </div>
</section>

    {{-- <section class="shop">
        <div class="container">
            <div class="row">

                @foreach ($shop as $shops)
                    <div class="col-lg-3 col-lg-4 col-md-6">
                        <div class="shop-box">
                            <figure>
                                <img src="{{ asset($shops->image) }}" alt="">
                            </figure>
                            <h6>{{ $shops->product_title }}</h6>
                            <div class="stars">
                                <i class="fas fa-star checked"></i>
                                <i class="fas fa-star checked"></i>
                                <i class="fas fa-star checked"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <ul>
                                <li>
                                    <h5>${{ $shops->price }}</h5>
                                </li>
                                <li>
                                    <a href="{{ route('shopDetail', ['id' => $item->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $item->product_title)))]) }}}">Add
                                        to cart</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section> --}}

    <section class="products-sec">
        <div class="contaiber-fluid">
             <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @forelse ($products as $items)

                        <div class="col-lg-2">
                            <div class="main-pro-details" data-aos="fade-down" data-aos-duration="2000">
                                 <div class="img-slides">
                                      <div class="product-img owl-carousel owl-theme">
                                           <div class="item">
                                                <div class="cleaner-img">
                                                     <a href="{{ route('shopDetail',['id' => $items->id]) }}">
                                                          <img src="{{ $items->image }}" class="img-fluid" alt="">
                                                     </a>
                                                </div>
                                           </div>
                                      </div>
                                 </div>
                                 <div class="card-plus">
                                      <div class="dehum">
                                           <a href="{{ route('shopDetail',['id' => $items->id]) }}">
                                                <h4>{{ $items->product_title }}</h4>
                                           </a>
                                      </div>
                                 </div>

                            </div>
                       </div>
                       @empty
                       <div class="not-found">
                           
                       <p>No Products Found.</p>
                       </div>

                       @endforelse
                    </div>

                </div>
             </div>
            </div>
    </section>
@endsection
@section('css')
    <style>
        .filter_sorting ul.list-group {
            margin-right: 25px !important;
            margin-top: 15px;
        }

        .rent-sec {
  background-image: url('{{ asset($page->image) }}');
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

.main-pro-details{

    margin-top: 20px;
}

.not-found {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 40px;
}

    </style>
@endsection
@section('js')
    <script type="text/javascript">

    </script>
@endsection
