@extends('layouts.main')
@section('content')
@section('css')
<style>
.about-inner {
  height: 365px !important;
  align-items: center;
}
.equipment h1 span {
    margin-top: 48px;
}
</style>
<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Create a Free Account</span></h1>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="top-prog-sec top-prog-sec2 contact-sec">
   <section class="inpage featurePro">
  <div class="container">
    <div class="row">



      {{-- <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2"> --}}
        <div class="account_form">
          <div class="form_head mb-3">
            <h3> Register </h3>
            {{-- <p> If you have a registered account, you can login below. </p> --}}
          </div>

          @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="f_name" value="{{ old('f_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="l_name" value="{{ old('l_name') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <p>Your password must contain at least one uppercase letter (A-Z), one lowercase letter (a-z), one number (0-9), be at least eight characters long and can’t contain your first name, last name, or email.</p>
                </div>

                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name* why do we need your company name? ZapGO Rentals only provides. equipment rental to other Business.</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone#</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                </div>

                <div class="mb-3">
                    <h5>Address Information:</h5>
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="state" class="form-label">State</label>
                        @php
                            $state = DB::table('states')->get();
                        @endphp
                        <select class="form-select" id="user_state" name="state" required>
                            <option value="" selected>Choose State</option>
                            @foreach ($state as $value)
                                <option value="{{ $value->name }}" {{ old('state') == $value->name ? 'selected' : '' }}>{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="zip" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Are you 18+</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="age" id="yes" value="Yes" {{ old('age') == 'Yes' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="age" id="no" value="No" {{ old('age') == 'No' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="no">No</label>
                    </div>
                </div>

                <div class="mb-3">
                    <h5>State ID/ Driver’s License*</h5>
                    <p>Why do you need my ID information? For safety and security, you must be 18 years or older and have a valid state issued ID or Driver’s License to accept ZapGO Rentals equipment.</p>
                    <label for="choose_id" class="form-label">Chose State ID/ Driver’s License state*</label>
                    <select class="form-select" id="choose_id" name="license_state" required>
                        <option value="" selected>Choose State</option>
                        @foreach ($state as $value)
                            <option value="{{ $value->name }}" {{ old('license_state') == $value->name ? 'selected' : '' }}>{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="state_id" class="form-label">State ID/ Driver’s License number*</label>
                    <input type="text" class="form-control" id="state_id" name="license_no" value="{{ old('license_no') }}" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Choose Role*</label>
                    @php
                        $roles = App\Role::where('id', '!=', 1)->get();
                    @endphp
                    <select class="form-select" id="role" name="role" required>
                        <option value="" selected>Choose Role</option>
                        @foreach ($roles as $value)
                            <option value="{{ $value->id }}" {{ old('role') == $value->id ? 'selected' : '' }}>{{ ucfirst($value->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="terms_conditions" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="terms_conditions">I agree to the Terms and Conditions</label>
                </div>

                <div class="mb-3 text-center">
                    <input type="submit" class="log submit-btn btn1 blue-custom" value="Register"/>
                </div>

            </form>

        </div>
      {{-- </div> --}}
    </div>
  </div>
</section>



<!-- END: Checkout Section -->
    </div>
    <!-- product page end-->




@endsection
@section('css')
<style type="text/css">

	.account_form {
		margin: 70px 0px;
	}

	/* input.log.submit-btn {
	background: var(--blue-color);
    padding: 15px 32px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 500;
    color: var(--white-color) !important;
    font-family: Proxima-Nova-Font;
    border: none;
} */

    .rent-sec {
  background-image: url({{ asset('images/2.png') }}) !important;
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


#footer-form,#feedback-form {
    display: none;
}

form input,select {
    width: 100%;
    height: 55px;

}

form p,h5 {
    font-size: larger;
    margin-top: 5px;
    margin-bottom: 5px;
}

input.blue-custom {
    width: 10%;
}

input.log.submit-btn {
    border: none;
}

</style>
@endsection
@section('js')
<script type="text/javascript">
// 	 $(document).on('click', ".btn1", function(e){
// 			$('.loginForm').submit();
// 	 });
</script>
@endsection
