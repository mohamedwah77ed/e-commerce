<section class="profile-section">
    <header class="profile-section-header">
        <h2>
            <i class="fas fa-lock me-2" style="color:var(--accent)"></i>
            {{ trans_lang('تغيير كلمة المرور', 'Update Password') }}
        </h2>
        <p>{{ trans_lang('استخدم كلمة مرور طويلة وعشوائية لحماية حسابك.', 'Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="profile-form">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password">{{ trans_lang('كلمة المرور الحالية', 'Current Password') }}</label>
            <input id="current_password" name="current_password" type="password" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">{{ trans_lang('كلمة المرور الجديدة', 'New Password') }}</label>
            <input id="password" name="password" type="password" autocomplete="new-password">
            @error('password', 'updatePassword')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">{{ trans_lang('تأكيد كلمة المرور', 'Confirm Password') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <i class="fas fa-save me-2"></i>
                {{ trans_lang('حفظ', 'Save') }}
            </button>

            @if (session('status') === 'password-updated')
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
