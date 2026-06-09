{{-- ════ TOPBAR ════ --}}
<div class="topbar d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <span><i class="fas fa-phone-alt me-1"></i><a href="tel:{{ $settings['phone'] ?? '' }}">{{ $settings['phone'] ?? '' }}</a></span>
            <span>|</span>
            <span><i class="fas fa-envelope me-1"></i><a href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '' }}</a></span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-truck me-1"></i>
            <span>{{ trans_lang('شحن مجاني للطلبات فوق 500 جنيه', 'Free shipping on orders over 500 EGP') }}</span>
            <span class="badge-free me-2">{{ trans_lang('مجاناً', 'Free') }}</span>
        </div>
    </div>
</div>

{{-- ════ MAIN NAVBAR ════ --}}
{{-- ════ MAIN NAVBAR ════ --}}
<nav class="main-nav" id="mainNav">
    <div class="container d-flex align-items-center gap-3">
        {{-- Logo Text --}}
        <a class="nav-logo" href="{{ route('products.home') }}">
            <span class="logo-text">2D</span>
        </a>

        {{-- Search --}}
        <form class="search-wrap d-none d-lg-flex" action="{{ route('search') }}" method="GET">
            <input class="form-control" type="search" name="q"
                   placeholder="{{ trans_lang('ابحث عن منتج...', 'Search for a product...') }}"
                   value="{{ request('q') }}">
            <button class="btn-search" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        {{-- Right Side: Icons + Language + Mobile Toggle --}}
        <div class="d-flex align-items-center gap-2 ms-auto">


            {{-- Cart --}}
           {{-- Cart --}}
<a href="{{ route('cart.index') }}" class="icon-btn" id="cartBtn" title="{{ trans_lang('السلة', 'Cart') }}">
    <i class="fas fa-shopping-cart"></i>
    <span class="dot" id="cartBadge">0</span>
</a>

            {{-- Language Switcher --}}
            @php
                $supportedLocales = config('locales.supported', []);
                $currentLocale = app()->getLocale();
                $currentLocaleName = $supportedLocales[$currentLocale]['name'] ?? strtoupper($currentLocale);
            @endphp

            <div class="dropdown language-dropdown">
                <button class="btn-lang-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-globe"></i>
                    <span class="d-none d-md-inline">{{ $currentLocaleName }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    @foreach(config('locales.supported') as $code => $name)
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == $code ? 'active' : '' }}"
                               href="{{ route('lang.switch', $code) }}">
                                {{ $name }}
                                @if(app()->getLocale() == $code)
                                    <i class="fas fa-check ms-auto"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @guest
                <div class="d-flex align-items-center gap-2 auth-links">
                    <a href="{{ route('login') }}">{{ trans_lang('تسجيل الدخول', 'Login') }}</a>
                    <span class="text-muted">/</span>
                    <a href="{{ route('register') }}">{{ trans_lang('إنشاء حساب', 'Register') }}</a>
                </div>
            @else
                {{-- User Dropdown --}}
                <div class="dropdown user-dropdown">
                    <button class="btn-user-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        <span class="d-none d-md-inline user-name">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down ms-1" style="font-size:.7rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header">
                            <div class="dropdown-user-name">{{ Auth::user()->name }}</div>
                            <div class="dropdown-user-email">{{ Auth::user()->email }}</div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('orders.my') }}">
                                <i class="fas fa-box me-2"></i>
                                {{ trans_lang('طلباتي', 'My Orders') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i>
                                {{ trans_lang('تعديل الحساب', 'Edit Profile') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile.edit') }}">
                                <i class="fas fa-lock me-2"></i>
                                {{ trans_lang('تغيير كلمة المرور', 'Change Password') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                               onclick="event.preventDefault(); if(confirm('{{ trans_lang('هل أنت متأكد من حذف حسابك؟ لا يمكن التراجع!', 'Are you sure? This cannot be undone!') }}')) { document.getElementById('delete-account-form').submit(); }">
                                <i class="fas fa-trash-alt me-2"></i>
                                {{ trans_lang('حذف الحساب', 'Delete Account') }}
                            </a>
                            <form id="delete-account-form" action="{{ route('user.profile.destroy') }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('topbar-logout').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                {{ trans_lang('تسجيل الخروج', 'Logout') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <form id="topbar-logout" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            @endguest

            {{-- Hamburger (Mobile) --}}
            <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#siteNav" style="background:transparent;">
                <i class="fas fa-bars fs-5" style="color:#e2e8f0;"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="collapse navbar-collapse d-lg-none" id="siteNav">
        <div class="container mobile-nav-menu">
            <form class="search-wrap-mobile mb-3" action="{{ route('search') }}" method="GET">
                <input class="form-control" type="search" name="q"
                       placeholder="{{ trans_lang('ابحث عن منتج...', 'Search for a product...') }}"
                       value="{{ request('q') }}">
                <button class="btn-search" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <ul class="mobile-nav-links">
                <li><a href="{{ route('products.home') }}"><i class="fas fa-home me-2"></i>{{ trans_lang('الرئيسية', 'Home') }}</a></li>
                <li><a href="{{ url('/products') }}"><i class="fas fa-box me-2"></i>{{ trans_lang('المنتجات', 'Products') }}</a></li>
                <li><a href="{{ url('/categories') }}"><i class="fas fa-th-large me-2"></i>{{ trans_lang('الفئات', 'Categories') }}</a></li>
                <li><a href="{{ url('/offers') }}"><i class="fas fa-percent me-2"></i>{{ trans_lang('العروض', 'Offers') }}</a></li>
                <li><a href="{{ url('/about') }}"><i class="fas fa-info-circle me-2"></i>{{ trans_lang('من نحن', 'About Us') }}</a></li>
                <li><a href="{{ url('/contact') }}"><i class="fas fa-envelope me-2"></i>{{ trans_lang('تواصل معنا', 'Contact Us') }}</a></li>
            </ul>
        </div>
    </div>
</nav>
