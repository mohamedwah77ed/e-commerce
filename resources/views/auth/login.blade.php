@extends('layouts.main')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card auth-card">
            <div class="card-body">

                <div class="auth-header">
                    <i class="bi bi-box-arrow-in-right fs-1 text-primary mb-2"></i>
                    <h3>{{ trans_lang('تسجيل الدخول', 'Sign In') }}</h3>
                    <p>{{ trans_lang('مرحباً بعودتك', 'Welcome Back') }}</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ trans_lang('البريد الإلكتروني', 'Email Address') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="{{ trans_lang('name@example.com', 'name@example.com') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ trans_lang('كلمة المرور', 'Password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-muted" for="remember">{{ trans_lang('تذكرني', 'Remember Me') }}</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-link small">{{ trans_lang('نسيت كلمة المرور؟', 'Forgot Password?') }}</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>{{ trans_lang('تسجيل الدخول', 'Sign In') }}
                    </button>

                    @if (Route::has('register'))
                        <div class="text-center">
                            <span class="text-muted">{{ trans_lang('ليس لديك حساب؟', 'Don\'t have an account?') }}</span>
                            <a href="{{ route('register') }}" class="auth-link">{{ trans_lang('سجل الآن', 'Register') }}</a>
                        </div>
                    @endif
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
