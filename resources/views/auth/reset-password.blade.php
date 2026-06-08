@extends('layouts.main')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card auth-card">
            <div class="card-body">

                <div class="auth-header">
                    <i class="bi bi-shield-lock fs-1 text-primary mb-2"></i>
                    <h3>{{ trans_lang('إعادة تعيين كلمة المرور', 'Reset Password') }}</h3>
                    <p>{{ trans_lang('أنشئ كلمة مرور جديدة آمنة', 'Create a new secure password') }}</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ trans_lang('البريد الإلكتروني', 'Email Address') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}" required readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ trans_lang('كلمة المرور الجديدة', 'New Password') }}</label>
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

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>{{ trans_lang('تعيين كلمة المرور', 'Reset Password') }}
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
