@extends('layouts.main')
@section('content')

<section class="rent-sec about-inner">
    <div class="container">
         <div class="row">
              <div class="col-lg-12">
                   <div class="equipment">
                        <h1><span class="d-block typed-text-two cursor">{{ $page->page_name }} </span></h1>
                   </div>
              </div>

         </div>
    </div>
</section>




<section class="home-ab about-pg-sec">
    <div class="container">
         <div class="row">
              <div class="col-lg-6">
                   <div class="why-we-best">
                       {!! $page->content !!}


                   </div>
                   <div class="third-one">
                        <div class="bulb-div" data-aos="flip-up" data-aos-duration="2000">
                             <figure>
                                  <img src="{{ asset('images/17.png') }}" class="img-fluid" alt="">
                             </figure>
                             <div class="blub-h">
                                  <h6>Our Mission</h6>
                                  <p>Our mission is clear: to assist businesses, particularly small and medium-sized companies, by offering reliable and efficient equipment rentals. We understand the urgency and challenges associated withowningequipment, which is why we are committed to delivering the highest quality equipment and services.
                                  </p>
                             </div>
                        </div>
                        <div class="bulb-div" data-aos="flip-up" data-aos-duration="2000">
                             <figure>
                                  <img src="{{ asset('images/18.png') }}" class="img-fluid" alt="">

                             </figure>
                             <div class="blub-h">
                                  <h6>What Sets Us Apart</h6>
                                  <p> <span>Exceptional Service:</span>We place a high priority on customer satisfaction andmake every effort to exceed your expectations. Our team of specialists isalways ready for your assistance.</p>
                                  <p> <span>Efficiency and Cost Savings: </span>We believe in the power of efficiency andcost-effectiveness. Our solutions are designed to reduce administrative costs
                                       and streamline processes.</p>
                                  <p> <span>Rapid Response:</span> Time is crucialin anyindustry. We offer fast delivery andsupport to ensure you can start your projects promptly.</p>
                             </div>
                        </div>
                        <div class="bulb-div" data-aos="flip-up" data-aos-duration="2000">
                             <figure>
                                  <img src="{{ asset('images/19.png') }}" class="img-fluid" alt="">

                             </figure>
                             <div class="blub-h">
                                  <h6>Our Vision</h6>
                                  <p>As we continue to expand and serve more cities across the United States, we remain focused on innovation and growth. We aim to become the go-to partner for businesses in need of equipment and solutions. We are committed to providing
                                       excellent service, responsive support, and a consistently growing inventory to meet your evolving needs.</p>
                                  <p>Thank you for considering ZapGO Rentals as your trusted partner. Join us in makingamore efficient, cost-effective, andgo to solutionsfor your business.</p>
                             </div>
                        </div>
                   </div>
              </div>
              <div class="col-lg-6">
                   <div class="camera-back">
                        <figure data-aos="fade-down" data-aos-duration="2000">
                             <img src="{{ asset($section[0]->value) }}" class="img-fluid" alt="">
                        </figure>
                        <img src="{{ asset($section[1]->value) }}" class="img-fluid machine-img" alt="" data-aos="fade-up" data-aos-duration="2000">
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
}

</style>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endsection
