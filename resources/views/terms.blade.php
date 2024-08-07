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

<section class="content-main">
    <div class="container">
         <div class="row">
              <div class="col-lg-12">
                <div class="content-image">
                    <img src="{{ asset($logo->img_path) }}" class="img-fluid" alt="">
                </div>
                  {!! $page->content !!}
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
  height: 400px;
  align-items: center;
}

section.content-main {
    padding: 50px 0px;
}

div#footer-form,#feedback-form {
    display: none;
}
</style>
@endsection

@section('js')
<script type="text/javascript"></script>
@endsection
