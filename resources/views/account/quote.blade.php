@extends('layouts.main')
@section('title', 'Order')
@section('content')

<?php $segment = Request::segments(); ?>


<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Quote</span></h1>
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
                                                <h2>Quote</h2>
                                            </div>

                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>

                                                    @if($quote)
                                                        @foreach($quote as $val)
                                                            <tr>
                                                              <td>{{ $val->id }}</td>

                                                              <td>{{ $val->first_name .' '. $val->last_name }}</td>
                                                              <td>{{ $val->email }}</td>
                                                              @if ($val->status == 0)
                                                                <td><button type="button" class="btn btn-danger">Not Approved</button></td>
                                                                <td class="viewbtn"><a href="#">...</a></td>
                                                              @elseif($val->status == 1)
                                                                <td><button type="button" class="btn btn-success">Paid</button></td>
                                                                <td class="viewbtn"><a href="{{ route('view.quotes',[$val->id]) }}">View</a></td>
                                                              @else
                                                                <td><button type="button" class="btn btn-success" onclick="window.location.href='{{ route('view.payment', ['id' => $val->id]) }}'">Approved & Unpaid</button></td>
                                                                <td class="viewbtn"><a href="#">...</a></td>
                                                              @endif

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
<script type="text/javascript">
     $(document).on('click', ".btn1", function(e){
            // alert('it works');
            $('.loginForm').submit();
     });
</script>
@endsection
