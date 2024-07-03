@extends('layouts.main')
@section('content')


<section class="rent-sec about-inner">
    <div class="container">
         <div class="row">
              <div class="col-lg-12">
                   <div class="equipment">
                        <h1><span class="d-block">{{ $page->page_name }} </span></h1>
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
                                  <a href="{{ route('category') }}"><i class="fa-solid fa-arrow-right"></i> All products </a>
                                  {{-- <div class="menu-drop">
                                    @foreach ($category as $items)
                                    <a href="{{ route('product_category',['id'=> $items->id]) }}"><i class="fa-solid fa-arrow-right"></i>{{ $items->name }}</a>
                                    @endforeach

                                  </div> --}}
                             </li>
                             {{-- <li class="click-li">
                                  <a href="" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-arrow-right"></i> Dehumidifie </a>
                                  <div class="menu-drop">
                                       <a href="commercial-dehumidifier.php"><i class="fa-solid fa-arrow-right"></i> Commercial Dehumidifier</a>
                                       <a href="ton-portable-air-conditioner.php"><i class="fa-solid fa-arrow-right"></i>1 Ton Portable Air Conditioner /Dehumidifier.</a>

                                  </div>
                             </li>
                             <li class="click-li">
                                  <a href=""role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-arrow-right"></i>Air Purification </a>
                                  <div class="menu-drop">
                                       <a href="heppa-air-scrubber.php"><i class="fa-solid fa-arrow-right"></i> Heppa Air Scrubber</a>
                                  </div>
                             </li>
                             <li class="click-li">
                                  <a href="air-movers.php"><i class="fa-solid fa-arrow-right"></i> Air Movers </a>
                                  <div class="menu-drop">
                                       <a href="carpet-blower.php"><i class="fa-solid fa-arrow-right"></i> Carpet Blower</a>
                                       <a href="low-profile-air-mover.php"><i class="fa-solid fa-arrow-right"></i> Low profile Air Movers</a>
                                       <a href="axil-fan.php"><i class="fa-solid fa-arrow-right"></i> Axil Fan</a>
                                  </div>
                             </li>
                             <li class="click-li">
                                  <a href="water-pump.php"></i><i class="fa-solid fa-arrow-right"></i> Water Pumps </a>
                                  <div class="menu-drop">
                                       <a href="2-inch-trash-water-pumps.php"><i class="fa-solid fa-arrow-right"></i> 3 Inch Trash Water Pumps</a>
                                       <a href="3-inch-trash-water-pumps.php"><i class="fa-solid fa-arrow-right"></i> 2 Inch Trash Water Pumps</a>
                                  </div>
                             </li> --}}
                             @foreach ($category as $cat)
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
                    @foreach ($mainproduct as $items)

                    <div class="col-lg-3">
                        <div class="main-pro-details" data-aos="fade-down" data-aos-duration="2000">
                             <div class="img-slides">
                                  <div class="product-img owl-carousel owl-theme">
                                       <div class="item">
                                            <div class="cleaner-img">
                                                 <a href="{{ route('shopDetail',['id' => $items->id]) }}">
                                                      <img src="{{ url($items->image) }}" class="img-fluid" alt="">
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

                    @endforeach

                   </div>
              </div>
         </div>
    </div>
</section>


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

.about-inner {
  height: 500px !important;
  align-items: center;
}


.about-inner .equipment h1 {
    /* margin-top: -360px !important; */
    color:#fff !important;
}

</style>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endsection
