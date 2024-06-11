@extends('layouts.main')
@section('title', 'Account')
@section('css')

@endsection


@section('content')

<?php $segment = Request::segments(); ?>

<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Account</span></h1>
                </div>
            </div>

        </div>
    </div>
</section>



<main class="my-cart">
    <div class="my-account-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-page-wrapper">
                        <div class="row">
                            @include('account.sidebar')
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad">
                                        <div class="myaccount-content">
                                            <div class="section-heading">
                                                <h2>Dashboard</h2>

                                                <div class="welcome">

                                                    <p>Hello, <strong>{{ Auth::user()->name }}</strong> (If Not <strong>{{ Auth::user()->name }} !</strong><a href="{{ url('signout') }}" class="logout"> Logout</a>)</p>
                                                </div>

                                                <p class="mb-0">From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
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
</main>

@endsection

<style>
    #footer-form,#feedback-form {
        display: none;
    }


</style>
@section('js')
<script type="text/javascript">
     $(document).on('click', ".btn1", function(e){
            // alert('it works');
            $('.loginForm').submit();
     });
</script>
@endsection
