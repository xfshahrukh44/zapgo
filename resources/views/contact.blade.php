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
  height: 700px !important;
  align-items: end;
}


.about-inner .equipment h1 {
    margin-top: -360px !important;
}

</style>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endsection
