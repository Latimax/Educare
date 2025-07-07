@extends('student.auth.app')

@section('title', 'Login')

@section('content')

    <div class="sign_in_up_bg">
        <div class="container">
            <div class="row justify-content-lg-center justify-content-md-center">
                <div class="col-lg-12">
                    <div class="text-center p-4" id="logo">
                        @php
                            $imgpath = 'storage/front/images/';
                        @endphp

                        <img src="{{ asset($imgpath . 'logo.png') }}" alt="site logo" class="light-logo">
                        <img src="{{ asset($imgpath . 'white-logo.png') }}" alt="site logo" class="logo-inverse">

                    </div>
                </div>

                <div class="col-lg-6 col-md-8">
                    <div class="sign_form">
                        <h2>Welcome Back</h2>
                        <p>Log In to Your Student Portal Account!</p>
                        @if (session('status'))
                            <div class="alert alert-success mb-3">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('student.login.submit') }}">
                            @csrf
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh95">
                                    <input class="prompt srch_explore @error('studentId') is-invalid @enderror" type="text"
                                        name="studentId" value="{{ old('studentId') }}" id="id_studentId" required maxlength="64"
                                        placeholder="Registration No" autofocus>
                                    <i class="fas fa-envelope icon icon2"></i>
                                </div>
                                @error('studentId')
                                    <div class="text-danger mb-16">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="ui search focus mt-15">
                                <div class="ui left icon input swdh95">
                                    <input class="prompt srch_explore @error('password') is-invalid @enderror"
                                        type="password" name="password" value="" id="id_password" required
                                        maxlength="64" placeholder="Password">
                                    <i class="fas fa-key icon icon2"></i>
                                </div>
                                @error('password')
                                    <div class="text-danger mb-16">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="login-btn" type="submit">Sign In</button>
                        </form>
                        <p class="sgntrm145">Or <a href="{{ route('student.forgot-password') }}">Forgot Password</a>.
                        </p>
                    </div>
                    <div class="sign_footer"><img src="{{ asset('studentpage/images/sign_logo.png') }}" alt="">©
                        {{ date('Y') }} {{ $schoolinfo->school_name }}<strong> Student Portal</strong>. All Rights
                        Reserved.</div>
                </div>
            </div>
        </div>
    </div>



@endsection
