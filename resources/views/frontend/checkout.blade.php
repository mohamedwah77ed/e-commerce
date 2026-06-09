<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ is_rtl() ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans_lang('إتمام الطلب - متجرنا', 'Checkout - Our Store') }}</title>

    {{-- Bootstrap RTL/LTR --}}
    @if(is_rtl())
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* ════════════════════════════════
           CHECKOUT PAGE - CLEAN & WHITE
           ════════════════════════════════ */
        :root {
            --primary:    #1a56db;
            --primary-dark: #1e429f;
            --success:    #059669;
            --danger:     #dc2626;
            --warning:    #d97706;
            --text:       #1f2937;
            --text-light: #6b7280;
            --border:     #e5e7eb;
            --bg:         #f9fafb;
            --white:      #ffffff;
            --radius:     12px;
            --shadow:     0 1px 3px rgba(0,0,0,.08), 0 4px 12px rgba(0,0,0,.05);
            --shadow-lg:  0 10px 40px rgba(0,0,0,.08);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
            min-height: 100vh;
        }

        /* ════════ HEADER ════════ */
        .checkout-header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .checkout-header .logo {
            font-weight: 900;
            font-size: 1.5rem;
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .checkout-header .logo i { color: var(--primary); font-size: 1.3rem; }
        .checkout-header .secure-badge {
            display: flex;
            align-items: center;
            gap: .5rem;
            color: var(--success);
            font-size: .85rem;
            font-weight: 600;
        }

        /* ════════ LANG SWITCHER ════════ */
        .lang-switcher {
            display: flex;
            align-items: center;
            gap: .4rem;
        }
        .lang-switcher a {
            padding: .3rem .7rem;
            border-radius: 6px;
            font-size: .85rem;
            font-weight: 700;
            text-decoration: none;
            border: 1.5px solid var(--border);
            color: var(--text-light);
            transition: all .2s;
        }
        .lang-switcher a.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }
        .lang-switcher a:hover:not(.active) {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* ════════ PROGRESS STEPS ════════ */
        .progress-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            padding: 2rem 0;
        }
        .step {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .9rem;
            font-weight: 600;
            color: var(--text-light);
        }
        .step.active  { color: var(--primary); }
        .step.completed { color: var(--success); }
        .step-num {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: #f3f4f6;
            border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; font-weight: 800;
        }
        .step.active .step-num    { background: var(--primary); border-color: var(--primary); color: #fff; }
        .step.completed .step-num { background: var(--success); border-color: var(--success); color: #fff; }
        .step-line { width: 60px; height: 2px; background: var(--border); margin: 0 .5rem; }
        .step-line.completed { background: var(--success); }

        /* ════════ CARDS ════════ */
        .checkout-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .checkout-card .card-title {
            font-size: 1.15rem; font-weight: 800;
            padding: 1.5rem; border-bottom: 1px solid var(--border);
            margin: 0; display: flex; align-items: center; gap: .75rem;
        }
        .checkout-card .card-title i { color: var(--primary); }
        .checkout-card .card-body { padding: 1.5rem; }

        /* ════════ FORM ════════ */
        .form-label { font-weight: 700; font-size: .9rem; color: var(--text); margin-bottom: .4rem; display: block; }
        .form-label .optional { font-weight: 400; color: var(--text-light); font-size: .8rem; }
        .form-control {
            border: 2px solid var(--border); border-radius: 10px;
            padding: .85rem 1rem; font-size: 1rem;
            font-family: 'Cairo', sans-serif; transition: all .2s;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(26,86,219,.1); outline: none; }
        .form-control.is-invalid { border-color: var(--danger); background: #fef2f2; }
        .invalid-feedback { color: var(--danger); font-size: .85rem; font-weight: 600; margin-top: .3rem; }
        .form-select { border: 2px solid var(--border); border-radius: 10px; padding: .85rem 1rem; font-size: 1rem; font-family: 'Cairo', sans-serif; }

        /* ════════ SUMMARY ════════ */
        .summary-card {
            background: var(--white); border-radius: var(--radius);
            box-shadow: var(--shadow); border: 1px solid var(--border);
            overflow: hidden; position: sticky; top: 100px;
        }
        .summary-card .card-title {
            font-size: 1.1rem; font-weight: 800;
            padding: 1.25rem; border-bottom: 1px solid var(--border);
            margin: 0; display: flex; align-items: center; gap: .5rem;
        }
        .summary-card .card-title i { color: var(--primary); }
        .summary-list { padding: 1rem 1.25rem; }
        .summary-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: .75rem 0; border-bottom: 1px solid #f3f4f6;
        }
        .summary-item:last-child { border-bottom: none; }
        .item-name { font-weight: 700; font-size: .9rem; }
        .item-qty  { font-size: .8rem; color: var(--text-light); }
        .item-price { font-weight: 800; font-size: .95rem; }
        .summary-divider { height: 2px; background: var(--border); margin: .5rem 0; }
        .summary-total {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1rem 1.25rem; background: #f9fafb; border-top: 2px solid var(--border);
        }
        .total-label { font-weight: 800; font-size: 1.1rem; }
        .total-value { font-weight: 900; font-size: 1.3rem; color: var(--primary); }

        /* ════════ GUEST BADGE ════════ */
        .guest-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .4rem .8rem;
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            color: #92400e;
            font-size: .8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .guest-badge i { font-size: .9rem; }

        /* ════════ SUBMIT ════════ */
        .btn-submit {
            display: flex; align-items: center; justify-content: center; gap: .75rem;
            width: 100%; padding: 1rem; border-radius: 12px;
            background: var(--primary); color: #fff;
            font-size: 1.1rem; font-weight: 800; border: none; cursor: pointer;
            transition: all .2s; font-family: 'Cairo', sans-serif; margin-top: 1rem;
        }
        .btn-submit:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 8px 25px rgba(26,86,219,.25); }
        .back-link {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            color: var(--text-light); text-decoration: none; font-size: .9rem;
            font-weight: 600; margin-top: 1rem; transition: color .2s;
        }
        .back-link:hover { color: var(--primary); }

        /* ════════ ALERTS ════════ */
        .checkout-alert {
            display: flex; align-items: center; gap: .75rem;
            padding: 1rem 1.25rem; border-radius: 10px;
            margin-bottom: 1.5rem; font-weight: 600; font-size: .9rem;
        }
        .checkout-alert.alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: var(--success); }
        .checkout-alert.alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: var(--danger); }

        /* ════════ TRUST FOOTER ════════ */
        .trust-footer {
            display: flex; justify-content: center; gap: 2rem;
            padding: 2rem 0; margin-top: 2rem;
            border-top: 1px solid var(--border); flex-wrap: wrap;
        }
        .trust-item { display: flex; align-items: center; gap: .5rem; color: var(--text-light); font-size: .85rem; font-weight: 600; }
        .trust-item i { color: var(--success); font-size: 1.1rem; }

        @media (max-width: 991px) {
            .progress-steps { padding: 1.5rem 0; }
            .step-line { width: 30px; }
            .summary-card { position: static; margin-top: 1.5rem; }
        }
        @media (max-width: 576px) {
            .step { font-size: .8rem; }
            .step-num { width: 28px; height: 28px; font-size: .75rem; }
            .step-line { width: 20px; }
        }
    </style>
</head>
<body>

    {{-- ════════ HEADER ════════ --}}
    <header class="checkout-header">
        <div class="container d-flex justify-content-between align-items-center">

            <a href="{{ route('products.home') }}" class="logo">
                <i class="fas fa-store"></i>
                {{ trans_lang('متجرنا', 'Our Store') }}
            </a>

            <div class="d-flex align-items-center gap-3">
                {{-- ════ زرار تغيير اللغة ════ --}}
                <div class="lang-switcher">
                    <a href="{{ route('lang.switch', 'ar') }}" class="{{ app()->getLocale() == 'ar' ? 'active' : '' }}">
                        🇪🇬 ع
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
                        🇬🇧 EN
                    </a>
                </div>

                <div class="secure-badge">
                    <i class="fas fa-lock"></i>
                    <span>{{ trans_lang('دفع آمن ومشفر', 'Secure & Encrypted') }}</span>
                </div>
            </div>

        </div>
    </header>

    <div class="container">

        {{-- ════════ PROGRESS STEPS ════════ --}}
        <div class="progress-steps">
            <div class="step completed">
                <span class="step-num"><i class="fas fa-check"></i></span>
                <span>{{ trans_lang('السلة', 'Cart') }}</span>
            </div>
            <div class="step-line completed"></div>
            <div class="step active">
                <span class="step-num">2</span>
                <span>{{ trans_lang('الشحن', 'Shipping') }}</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <span class="step-num">3</span>
                <span>{{ trans_lang('الدفع', 'Payment') }}</span>
            </div>
        </div>

        {{-- ════════ FLASH MESSAGES ════════ --}}
        @if(session('success'))
            <div class="checkout-alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="checkout-alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- ════════ MAIN FORM ════════ --}}
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <div class="row g-4">

                {{-- ── بيانات الشحن ── --}}
                <div class="col-lg-7">
                    <div class="checkout-card">
                        <h4 class="card-title">
                            <i class="fas fa-truck"></i>
                            {{ trans_lang('بيانات الشحن', 'Shipping Details') }}
                        </h4>
                        <div class="card-body">

                            {{-- Guest Badge --}}
                            @guest
                                <div class="guest-badge">
                                    <i class="fas fa-user-clock"></i>
                                    {{ trans_lang('أنت تطلب كـ زائر. سجل دخول لحفظ طلباتك.', 'You are ordering as a guest. Login to save your orders.') }}
                                    <a href="{{ route('login') }}?redirect={{ url()->current() }}" style="color: #92400e; text-decoration: underline; margin-{{ is_rtl() ? 'right' : 'left' }}: .5rem;">
                                        {{ trans_lang('تسجيل الدخول', 'Login') }}
                                    </a>
                                </div>
                            @endguest

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">{{ trans_lang('الاسم الأول', 'First Name') }} *</label>
                                    <input type="text" name="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name', auth()->user()->first_name ?? '') }}"
                                        placeholder="{{ trans_lang('محمد', 'John') }}">
                                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ trans_lang('الاسم الأخير', 'Last Name') }} *</label>
                                    <input type="text" name="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name', auth()->user()->last_name ?? '') }}"
                                        placeholder="{{ trans_lang('أحمد', 'Doe') }}">
                                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ trans_lang('البريد الإلكتروني', 'Email') }} *</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', auth()->user()->email ?? '') }}"
                                        placeholder="example@email.com">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ trans_lang('رقم الهاتف', 'Phone') }} *</label>
                                    <input type="tel" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                        placeholder="01xxxxxxxxx">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">{{ trans_lang('العنوان بالتفصيل', 'Address') }} *</label>
                                    <input type="text" name="address1"
                                        class="form-control @error('address1') is-invalid @enderror"
                                        value="{{ old('address1') }}"
                                        placeholder="{{ trans_lang('شارع، حي، مدينة، رقم العمارة', 'Street, District, City, Building No.') }}">
                                    @error('address1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        {{ trans_lang('عنوان إضافي', 'Address 2') }}
                                        <span class="optional">({{ trans_lang('اختياري', 'Optional') }})</span>
                                    </label>
                                    <input type="text" name="address2"
                                        class="form-control"
                                        value="{{ old('address2') }}"
                                        placeholder="{{ trans_lang('علامة مميزة، رقم شقة، إلخ', 'Landmark, Apt No., etc.') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{ trans_lang('المحافظة', 'Governorate') }} *</label>
                                    <select name="country" class="form-select @error('country') is-invalid @enderror">
                                        <option value="">{{ trans_lang('اختر المحافظة', 'Select Governorate') }}</option>
                                        <option value="cairo"    {{ old('country') == 'cairo'    ? 'selected' : '' }}>{{ trans_lang('القاهرة', 'Cairo') }}</option>
                                        <option value="alex"     {{ old('country') == 'alex'     ? 'selected' : '' }}>{{ trans_lang('الإسكندرية', 'Alexandria') }}</option>
                                        <option value="giza"     {{ old('country') == 'giza'     ? 'selected' : '' }}>{{ trans_lang('الجيزة', 'Giza') }}</option>
                                        <option value="mansoura" {{ old('country') == 'mansoura' ? 'selected' : '' }}>{{ trans_lang('المنصورة', 'Mansoura') }}</option>
                                        <option value="tanta"    {{ old('country') == 'tanta'    ? 'selected' : '' }}>{{ trans_lang('طنطا', 'Tanta') }}</option>
                                        <option value="other"    {{ old('country') == 'other'    ? 'selected' : '' }}>{{ trans_lang('أخرى', 'Other') }}</option>
                                    </select>
                                    @error('country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        {{ trans_lang('الرمز البريدي', 'Postal Code') }}
                                        <span class="optional">({{ trans_lang('اختياري', 'Optional') }})</span>
                                    </label>
                                    <input type="text" name="post_code" class="form-control"
                                        value="{{ old('post_code') }}" placeholder="xxxxx">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── ملخص الطلب ── --}}
                <div class="col-lg-5">
                    <div class="summary-card">
                        <h4 class="card-title">
                            <i class="fas fa-receipt"></i>
                            {{ trans_lang('ملخص الطلب', 'Order Summary') }}
                        </h4>

                        <div class="summary-list">
                            @php $total = 0 @endphp
                            @forelse($cartItems as $item)
                                @php
                                    $itemAmount = $item->amount ?? ($item->price * $item->quantity);
                                    $total += $itemAmount;
                                @endphp
                                <div class="summary-item">
                                    <div>
                                        <div class="item-name">{{ $item->product->title ?? $item->product_title ?? 'Product' }}</div>
                                        <div class="item-qty">{{ trans_lang('الكمية', 'Qty') }}: {{ $item->quantity }}</div>
                                    </div>
                                    <span class="item-price">{{ number_format($itemAmount, 0) }} {{ trans_lang('جنيه', 'EGP') }}</span>
                                </div>
                            @empty
                                <div class="text-center py-3 text-muted">
                                    <i class="fas fa-shopping-basket mb-2" style="font-size: 2rem;"></i>
                                    <p>{{ trans_lang('السلة فارغة', 'Cart is empty') }}</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-list">
                            <div class="summary-item">
                                <span style="color:var(--text-light);">{{ trans_lang('المجموع', 'Subtotal') }}</span>
                                <span style="font-weight:700;">{{ number_format($total, 0) }} {{ trans_lang('جنيه', 'EGP') }}</span>
                            </div>
                        </div>

                        <div class="summary-total">
                            <span class="total-label">{{ trans_lang('الإجمالي', 'Total') }}</span>
                            <span class="total-value">
                                {{ number_format($total, 0) }}
                                {{ trans_lang('جنيه', 'EGP') }}
                            </span>
                        </div>

                        {{-- Submit --}}
                        <div style="padding: 0 1.25rem 1.25rem;">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-check-circle"></i>
                                {{ trans_lang('تأكيد الطلب', 'Place Order') }}
                            </button>
                            <a href="{{ route('cart.index') }}" class="back-link">
                                <i class="fas fa-arrow-{{ is_rtl() ? 'right' : 'left' }}"></i>
                                {{ trans_lang('رجوع للسلة', 'Back to Cart') }}
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </form>

        {{-- ════════ TRUST FOOTER ════════ --}}
        <div class="trust-footer">
            <div class="trust-item"><i class="fas fa-shield-alt"></i><span>{{ trans_lang('دفع آمن', 'Secure Payment') }}</span></div>
            <div class="trust-item"><i class="fas fa-truck"></i><span>{{ trans_lang('شحن سريع', 'Fast Shipping') }}</span></div>
            <div class="trust-item"><i class="fas fa-undo-alt"></i><span>{{ trans_lang('إرجاع خلال 14 يوم', '14-Day Returns') }}</span></div>
            <div class="trust-item"><i class="fas fa-headset"></i><span>{{ trans_lang('دعم 24/7', '24/7 Support') }}</span></div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
