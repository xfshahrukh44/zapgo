@section('title','Register')
@extends('layouts.main')
@section('css')
<style>
.form-container.sign-in-container.col-md-6 {
    margin: 0 auto;
}
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
  height: 365px !important;
  align-items: center;
}

.equipment h1 span {
    margin-top: 179px;
}

.btn-yellow{
    background: var(--blue-color);
    padding: 15px 32px;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 500;
    color: var(--white-color) !important;
    font-family: Proxima-Nova-Font;
    /* margin-left: 300px; */
    margin-top: 15px;
}


.custom input{
    height: 55px;
    border-radius: 10px;
    margin-bottom: 10px;
}

#footer-form,#feedback-form {
    display: none;
}




</style>
@endsection
@section('content')
<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Sign In</span></h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="account">
    <div class="container" id="from-wrapper">
        <div class="form-container sign-in-container col-md-6">
            <div class="sec-text-form-free-acc">
                @php
                    // Retrieve the 'redirect' parameter from the request
                    $redirect = request()->query('redirect');
                @endphp
                <h4>
                    Sign In to your ZapGO Rentals Account
                </h4>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="redirect" value="{{ $redirect ?? '' }}">
                {{-- <h1>Login</h1> --}}
                <div class="form-group custom">
                    <label>Email</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                    <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('email') }}</small>
                    @endif
                </div>
                <div class="form-group custom">
                    <label>password</label>
                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                    @if ($errors->has('password'))
                    <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('password') }}</small>
                    @endif
                </div>
                <div class="form-group">
                    {{-- <label class="remember"><input type="checkbox"> Remember me </label> --}}
                    <a href="{{ url('password/reset') }}" class="pull-right forg_text">Forgot password?</a>
                </div>
                <div style=" display: flex; justify-content: center; gap: 25px;">
                    <button class="btn btn-yellow" type="submit">Sign in</button>
                    <a href="{{ url('signup') }}" class="btn btn-yellow" type="button">Sign up</a>
                </div>
                <!-- <span>or</span>
                <div class="social-group">
                    <button class="loginBtn loginBtn--facebook">Login with Facebook</button>
                    <button class="loginBtn loginBtn--google">Login with Google</button>
                </div> -->
            </form>
        </div>

    </div>
</section>

@endsection
@section('js')
<script>
    $("#phone").on("keypress keyup blur",function (event) {
       $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
</script>
@endsection
