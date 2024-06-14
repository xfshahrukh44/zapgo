@extends('layouts.main')
@section('title', 'Order')
@section('content')

<?php $segment = Request::segments(); ?>


<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Feedback</span></h1>
                </div>
            </div>

        </div>
    </div>
</section>


<main class="my-cart">

 <!-- my account wrapper start -->
    <div class="my-account-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            @include('account.sidebar')
                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="quote" role="#">
                                        <div class="myaccount-content">
                                            <div class="section-heading">
                                                <h2>Feedback</h2>
                                            </div>

                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>User Name</th>
                                                            <th>Message</th>
                                                            <th>Type</th>
                                                            {{-- <th>Action</th> --}}
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    @if($feedback)
                                                        @foreach($feedback as $val)
                                                            <tr>
                                                              <td>{{ $val->id }}</td>

                                                              <td>{{ $val->users->name .' '. $val->users->last_name }}</td>
                                                              <td>{{ $val->message }}</td>
                                                              <td>{{ $val->type }}</td>

                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->


                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->


<!-- main content end -->
</main
>

@endsection
@section('css')
<style type="text/css">
#footer-form, #feedback-form{
    display: none;
}

thead.thead-light {
    background: var(--blue-color);
}
</style>
@endsection
@section('js')

@endsection
