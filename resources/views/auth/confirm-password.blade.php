@extends('layouts.main')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card auth-card">
            <div class="card-body">

                <div class="auth-header">
                    <i class="bi bi-shield-check fs-1 text-primary mb-2"></i>
                    <h3>{{ trans_lang('تأكيد كلمة المرور', 'Confirm Password') }}</h3>
                    <p>{{ trans_lang('يرجى التحقق من هويتك', 'Please verify your identity') }}</p>
                </div>

                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <div>{{ trans_lang('هذه منطقة آمنة. يرجى تأكيد كلمة المرور قبل المتابعة.', 'This is a secure area. Please confirm your password before continuing.') }}</div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label">{{ trans_lang('كلمة المرور', 'Password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock text-muted"></i>
                            </span>
                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>{{ trans_lang('تأكيد', 'Confirm') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
