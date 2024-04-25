@extends('layouts.main')
@section('title', 'Account Details')
@section('content')

<?php $segment = Request::segments(); ?>


<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Account Details</span></h1>
                </div>
            </div>

        </div>
    </div>
</section>


<main class="my-cart">
    <!-- banner start -->
    <!-- banner end -->

<!-- main content start -->

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
                                    <div class="tab-pane active" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <div class="section-heading">
                                                <h2>Account Details</h2>
                                            </div>

                                            <div class="account-details-form">
                                               <form action="{{ route('update.account') }}" method="post" enctype="multipart/form-data" id="accountForm">
                                                @csrf
                                                    <div class="row">

                                                        <div class="col-lg-12">
                                                            <div class="single-input-item">
                                                                <label for="last-name" class="required">Name</label>
                                                                <input type="text" id="last-name" name="uname" placeholder="Last Name" value="<?php echo Auth::user()->name; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="email" class="required">Email Addres</label>
                                                        <input type="email" id="email" placeholder="Email Address" name="email" value="<?php echo Auth::user()->email; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label for="phone" class="required">Phone</label>
                                                        <input type="text" id="phone" placeholder="Phone Number" name="phone" value="<?php echo Auth::user()->phone; ?>">
                                                    </div>
                                                </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="single-input-item">
                                                            <label for="company" class="required">Comapany Name</label>
                                                            <input type="text" id="company" placeholder="Company Name" name="company_name" value="<?php echo Auth::user()->company_name; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div class="single-input-item">
                                                            <label for="address" class="required">Address</label>
                                                            <input type="text" id="address" placeholder="Address" name="address" value="<?php echo Auth::user()->address; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="single-input-item">
                                                            <label for="address" class="required">State</label>
                                                            <select name="state" id="">
                                                                <option value="New York" <?php echo (Auth::user()->state == 'New York') ? 'selected' : ''; ?>>New York</option>
                                                                <option value="New Jersey" <?php echo (Auth::user()->state == 'New Jersey') ? 'selected' : ''; ?>>New Jersey</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label for="city" class="required">City</label>
                                                            <input type="text" id="city" placeholder="City" name="city" value="<?php echo Auth::user()->city; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="single-input-item">
                                                            <label for="zip" class="required">Zip</label>
                                                            <input type="text" id="zip" placeholder="Zip Code" name="zip" value="<?php echo Auth::user()->zip; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label for="license_state" class="required">License State</label>
                                                            <input type="text" id="license_state" placeholder="License State" name="license_state" value="<?php echo Auth::user()->license_state; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label for="license_no" class="required">License Number</label>
                                                            <input type="text" id="license_no" placeholder="License Number" name="license_no" value="<?php echo Auth::user()->license_no;?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row radio">
                                                    <label class="form-label">Are you 18+</label>
                                                    <div class="form-check">
                                                        <input type="radio" name="age" id="yes" <?php echo (Auth::user()->age == 'Yes') ? 'checked' : ''; ?> value="Yes" required>
                                                        <label for="yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" name="age" id="no" <?php echo (Auth::user()->age == 'No') ? 'checked' : ''; ?> value="No" required>
                                                        <label for="no">No</label>
                                                    </div>
                                                </div>

                                                    <fieldset>
                                                        <legend>Password change</legend>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="new-pwd" class="required">New Password</label>
                                                                    <input type="password" id="new-pwd" placeholder="New Password" name="password">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="single-input-item">
                                                                    <label for="confirm-pwd" class="required">Confirm Password</label>
                                                                    <input type="password" id="confirm-pwd" placeholder="Confirm Password" name="password_confirmation">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>

                                                    <div class="single-input-item">
                                                        <button class="check-btn sqr-btn btn btn-red" id="updateProfile">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->


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
@section('css')
<style type="text/css">
#footer-form{
    display: none;
}

.radio {
    font-size: 16px;
    font-weight: bold;
}



</style>
@endsection
@section('js')

<script type="text/javascript">

 $(document).on('click', "#updateProfile", function(e){
        $('#accountForm').submit();
  });

</script>

@endsection
