@extends('layouts.main')

@section('content')

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

    <section class="rent-sec about-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="equipment">
                        <h1><span class="d-block">Reset Password</span></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="account">
    <div class="container" id="from-wrapper">
        <div class="form-container sign-in-container col-md-6">
            <div class="sec-text-form-free-acc">
                <h4>Reset Password To Your Account</h4>

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

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group custom">
                        <label>Email Address</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email" required>
                        @if ($errors->has('email'))
                            <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('email') }}</small>
                        @endif
                    </div>

                    <div class="form-group custom">
                        <label>Password</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <small class="alert alert-danger w-100 d-block p-2 mt-2">{{ $errors->first('password') }}</small>
                        @endif
                    </div>

                    <div class="form-group custom">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>

                    <div style="display: flex; justify-content: center; gap: 25px;">
                        <button class="btn btn-yellow" type="submit">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </section>

@endsection
