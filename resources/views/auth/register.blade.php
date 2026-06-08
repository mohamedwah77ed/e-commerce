@extends('layouts.main')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card auth-card">
            <div class="card-body">

                <div class="auth-header">
                    <i class="bi bi-person-plus fs-1 text-primary mb-2"></i>
                    <h3>{{ trans_lang('إنشاء حساب', 'Create Account') }}</h3>
                    <p>{{ trans_lang('انضم إلينا اليوم', 'Join us today') }}</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ trans_lang('الاسم الكامل', 'Name') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-person text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="{{ trans_lang('محمد أحمد', 'John Doe') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ trans_lang('البريد الإلكتروني', 'Email Address') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="{{ trans_lang('name@example.com', 'name@example.com') }}" required>
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
                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="{{ trans_lang('8 أحرف على الأقل', 'Min. 8 characters') }}" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">{{ trans_lang('تأكيد كلمة المرور', 'Confirm Password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock-fill text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" placeholder="{{ trans_lang('أعد كتابة كلمة المرور', 'Repeat password') }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="bi bi-person-plus me-2"></i>{{ trans_lang('إنشاء حساب', 'Sign Up') }}
                    </button>

                    <div class="text-center">
                        <span class="text-muted">{{ trans_lang('لديك حساب بالفعل؟', 'Already have an account?') }}</span>
                        <a href="{{ route('login') }}" class="auth-link">{{ trans_lang('تسجيل الدخول', 'Sign In') }}</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
