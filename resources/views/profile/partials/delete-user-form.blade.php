<section class="profile-section">
    <header class="profile-section-header">
        <h2>
            <i class="fas fa-trash-alt me-2" style="color:#ef4444"></i>
            {{ trans_lang('حذف الحساب', 'Delete Account') }}
        </h2>
        <p>{{ trans_lang('بمجرد حذف حسابك، سيتم حذف جميع بياناتك نهائياً ولا يمكن التراجع.', 'Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
    </header>

    <button class="btn-delete-account"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        <i class="fas fa-trash-alt me-2"></i>
        {{ trans_lang('حذف الحساب', 'Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('user.profile.destroy') }}" class="delete-modal-form">
            @csrf
            @method('delete')

            <h2>
                <i class="fas fa-exclamation-triangle me-2" style="color:#f59e0b"></i>
                {{ trans_lang('هل أنت متأكد من حذف حسابك؟', 'Are you sure you want to delete your account?') }}
            </h2>
            <p>{{ trans_lang('سيتم حذف جميع بياناتك نهائياً. أدخل كلمة المرور للتأكيد.', 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}</p>

            <div class="form-group">
                <label for="delete_password">{{ trans_lang('كلمة المرور', 'Password') }}</label>
                <input id="delete_password" name="password" type="password"
                       placeholder="{{ trans_lang('أدخل كلمة المرور', 'Enter your password') }}">
                @error('password', 'userDeletion')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="delete-modal-actions">
                <button type="button" class="btn-cancel" x-on:click="$dispatch('close')">
                    <i class="fas fa-times me-2"></i>
                    {{ trans_lang('إلغاء', 'Cancel') }}
                </button>
                <button type="submit" class="btn-confirm-delete">
                    <i class="fas fa-trash-alt me-2"></i>
                    {{ trans_lang('تأكيد الحذف', 'Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>

<style>
.btn-delete-account {
    background: rgba(239,68,68,.1);
    border: 1px solid rgba(239,68,68,.3);
    color: #ef4444;
    border-radius: 10px;
    padding: .7rem 1.75rem;
    font-size: .9rem;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: all .2s;
}
.btn-delete-account:hover {
    background: rgba(239,68,68,.2);
    border-color: #ef4444;
}

.delete-modal-form {
    background: #0e1420;
    border-radius: 16px;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.delete-modal-form h2 {
    color: #e2e8f0;
    font-size: 1.05rem;
    font-weight: 700;
    margin: 0;
}
.delete-modal-form p {
    color: #64748b;
    font-size: .88rem;
    margin: 0;
}

.delete-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: .75rem;
    margin-top: .5rem;
}
.btn-cancel {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.1);
    color: #94a3b8;
    border-radius: 10px;
    padding: .7rem 1.25rem;
    font-size: .88rem;
    font-weight: 600;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: all .2s;
}
.btn-cancel:hover {
    background: rgba(255,255,255,.1);
    color: #e2e8f0;
}
.btn-confirm-delete {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: #fff;
    border-radius: 10px;
    padding: .7rem 1.5rem;
    font-size: .88rem;
    font-weight: 700;
    font-family: 'Cairo', sans-serif;
    cursor: pointer;
    transition: opacity .2s;
}
.btn-confirm-delete:hover { opacity: .9; }
</style>
