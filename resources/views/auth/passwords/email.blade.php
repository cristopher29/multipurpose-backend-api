@extends('layouts.simple')

@section('content')

    <!-- Page Content -->
    <div class="hero-static d-flex align-items-center">
        <div class="w-100">
            <!-- Reminder Section -->
            <div class="content content-full bg-white">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4 py-4">
                        <!-- Header -->
                        <div class="text-center">
                            <p class="mb-2">
                                <i class="fa fa-2x fa-circle-notch text-primary"></i>
                            </p>
                            <h1 class="h4 mb-1">
                                {{ __('Reset Password') }}
                            </h1>
                            <h2 class="h6 font-w400 text-muted mb-3">
                                Please provide your account’s email.
                            </h2>
                        </div>
                        <!-- END Header -->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <!-- Reminder Form -->
                        <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _es6/pages/op_auth_reminder.js) -->
                        <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form class="js-validation-reminder" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group py-3">
                                <input type="email" class="form-control form-control-lg form-control-alt {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6 col-xl-8">
                                    <button type="submit" class="btn btn-block btn-primary">
                                        <i class="fa fa-fw fa-envelope mr-1"></i> {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END Reminder Form -->

                        <div class="text-center">
                            <a class="font-size-sm" href="{{ route('login') }}">Login?</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Reminder Section -->
        </div>
    </div>
    <!-- END Page Content -->
@endsection
