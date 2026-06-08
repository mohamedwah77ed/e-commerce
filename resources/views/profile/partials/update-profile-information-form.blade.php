<section class="profile-section">
    <header class="profile-section-header">
        <h2>
            <i class="fas fa-user-edit me-2" style="color:var(--accent)"></i>
            {{ trans_lang('معلومات الحساب', 'Profile Information') }}
        </h2>
        <p>{{ trans_lang('تحديث معلومات حسابك وبريدك الإلكتروني', "Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('user.profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="form-group">
            <label for="name">{{ trans_lang('الاسم', 'Name') }}</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name">
            @error('name')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email">{{ trans_lang('البريد الإلكتروني', 'Email') }}</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username">
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="verify-notice">
                    <i class="fas fa-exclamation-triangle me-1" style="color:#f59e0b"></i>
                    {{ trans_lang('بريدك الإلكتروني غير مفعل.', 'Your email address is unverified.') }}
                    <button form="send-verification" class="btn-verify-link">
                        {{ trans_lang('إعادة إرسال رابط التفعيل', 'Click here to re-send the verification email.') }}
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="verify-sent">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ trans_lang('تم إرسال رابط التفعيل على بريدك.', 'A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Submit --}}
        <div class="form-actions">
            <button type="submit" class="btn-save">
                <i class="fas fa-save me-2"></i>
                {{ trans_lang('حفظ التغييرات', 'Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="save-success"
                      x-data="{ show: true }"
                      x-show="show"
                      x-transition
                      x-init="setTimeout(() => show = false, 2000)">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ trans_lang('تم الحفظ!', 'Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>

<style>
.profile-section {
    background: #0e1420;
    border: 1px solid rgba(255,255,255,.07);
    border-radius: 16px;
    padding: 2rem;
}
.profile-section-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid rgba(255,255,255,.07);
}
.profile-section-header h2 {
    color: #e2e8f0;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: .4rem;
}
.profile-section-header p {
    color: #64748b;
    font-size: .88rem;
    margin: 0;
}

.profile-form { display: flex; flex-direction: column; gap: 1.25rem; }

.form-group { display: flex; flex-direction: column; gap: .5rem; }
.form-group label {
    color: #94a3b8;
    font-size: .88rem;
    font-weight: 600;
}
.form-group input {
    background: #141c2e;
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 10px;
    color: #e2e8f0;
    padding: .75rem 1rem;
    font-size: .9rem;
    font-family: 'Cairo', sans-serif;
    transition: all .2s;
    width: 100%;
}
.form-group input:focus {
    border-color: rgba(0,212,255,.3);
    background: #1a2438;
    box-shadow: 0 0 0 3px rgba(0,212,255,.1);
    outline: none;
    color: #e2e8f0;
}
.form-error {
    color: #ef4444;
    font-size: .8rem;
}

.verify-notice {
    background: rgba(245,158,11,.08);
    border: 1px solid rgba(245,158,11,.2);
    border-radius: 8px;
    padding: .75rem 1rem;
    color: #94a3b8;
    font-size: .85rem;
    margin-top: .5rem;
}
.btn-verify-link {
    background: none;
    border: none;
    color: #00d4ff;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: underline;
    padding: 0;
    font-family: 'Cairo', sans-serif;
}
.verify-sent {
    color: #10b981;
    font-size: .82rem;
    margin-top: .4rem;
    margin-bottom: 0;
}

.form-actions { display: flex; align-items: center; gap: 1rem; margin-top: .5rem; }
.btn-save {
    background: linear-gradient(135deg, #00d4ff, #7c3aed);
    border: none;
    border-radius: 10px;
    color: #000;
    font-weight: 700;
    padding: .7rem 1.75rem;
    font-size: .9rem;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: opacity .2s;
}
.btn-save:hover { opacity: .9; }
.save-success {
    color: #10b981;
    font-size: .88rem;
    font-weight: 600;
}
</style>
