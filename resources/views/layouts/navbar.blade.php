<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
            <i class="bi bi-shop me-2"></i>MyShop
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                {{-- Language Switcher --}}
<li class="nav-item dropdown ms-lg-3">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
        @if(app()->getLocale() == 'ar')
            <span class="me-1">🇸🇦</span> العربية
        @else
            <span class="me-1">🇬🇧</span> English
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end mt-2 border-0 shadow">
        <li>
            <a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ route('lang.switch', 'ar') }}">
                <span class="me-2">🇸🇦</span> العربية
            </a>
        </li>
        <li>
            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">
                <span class="me-2">🇬🇧</span> English
            </a>
        </li>
    </ul>
</li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 14px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end mt-2 border-0 shadow">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>{{ trans_lang('الملف الشخصي', 'Profile') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ trans_lang('تسجيل الخروج', 'Logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>{{ trans_lang('تسجيل الدخول', 'Login') }}
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i>{{ trans_lang('إنشاء حساب', 'Register') }}
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
