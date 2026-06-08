@extends('layouts.main')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card auth-card">
            <div class="card-body">

                <div class="auth-header">
                    <i class="bi bi-envelope-check fs-1 text-primary mb-2"></i>
                    <h3>{{ trans_lang('تفعيل البريد الإلكتروني', 'Verify Email') }}</h3>
                    <p>{{ trans_lang('خطوة أخيرة', 'One more step to go') }}</p>
                </div>

                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <div>{{ trans_lang('شكراً للتسجيل! يرجى تفعيل بريدك الإلكتروني بالضغط على الرابط المرسل.', 'Thanks for signing up! Please verify your email by clicking the link we sent you.') }}</div>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ trans_lang('تم إرسال رابط تفعيل جديد إلى بريدك الإلكتروني.', 'A new verification link has been sent to your email.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="d-grid gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-send me-2"></i>{{ trans_lang('إعادة إرسال رابط التفعيل', 'Resend Verification Email') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-box-arrow-right me-2"></i>{{ trans_lang('تسجيل الخروج', 'Log Out') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
