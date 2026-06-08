@extends('layouts.main')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card auth-card">
            <div class="card-body">

                <div class="auth-header">
                    <i class="bi bi-key fs-1 text-primary mb-2"></i>
                    <h3>{{ trans_lang('نسيت كلمة المرور؟', 'Forgot Password?') }}</h3>
                    <p>{{ trans_lang('سنرسل لك رابط إعادة التعيين', 'We\'ll send you a reset link') }}</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
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

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-send me-2"></i>{{ trans_lang('إرسال رابط التعيين', 'Send Reset Link') }}
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="auth-link">
                            <i class="bi bi-arrow-left me-1"></i>{{ trans_lang('العودة لتسجيل الدخول', 'Back to Login') }}
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
