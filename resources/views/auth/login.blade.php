@extends('layouts.simple')


@section('content')

    <!-- Page Content -->
    <div class="hero-static d-flex align-items-center">
        <div class="w-100">
            <!-- Sign In Section -->
            <div class="content content-full bg-white">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4 py-4">
                        <!-- Header -->
                        <div class="text-center">
                            <p class="mb-2">
                                <i class="fa fa-2x fa-circle-notch text-primary"></i>
                            </p>
                            <h1 class="h4 mb-1">
                                Sign In
                            </h1>
                            <h2 class="h6 font-w400 text-muted mb-3">
                                A perfect match for your project
                            </h2>
                        </div>
                        <!-- END Header -->
                        @if (session('email.verification.error'))
                            <div class="alert alert-warning">
                                {{ session('email.verification.error') }}
                            </div>
                        @endif
                        <!-- Sign In Form -->
                        <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
                        <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form class="js-validation-signin" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="py-3">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg form-control-alt {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg form-control-alt {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password" required>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="d-md-flex align-items-md-center justify-content-md-between">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                            <label class="custom-control-label font-w400" for="login-remember">Remember Me</label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <div class="py-2">
                                                <a class="font-size-sm" href="{{ route('password.request') }}">Forgot Password?</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-center mb-0">
                                <div class="col-md-6 col-xl-5">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END Sign In Form -->
                    </div>
                </div>
            </div>
            <!-- END Sign In Section -->

        </div>
    </div>
    <!-- END Page Content -->
@endsection
