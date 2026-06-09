{{-- Top Header --}}
<header class="top-header bg-white border-bottom shadow-sm">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between py-2">

            {{-- Left Side: Logo & Navigation --}}
            <div class="d-flex align-items-center">
                {{-- Logo --}}
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none d-flex align-items-center me-4">
                    <i class="bi bi-speedometer2 fs-4 text-primary me-2"></i>
                    <span class="fs-5 fw-bold text-dark d-none d-md-block">{{ trans_lang('لوحة التحكم', 'Dashboard') }}</span>
                </a>

                {{-- Navigation Links (Desktop) --}}
                <nav class="d-none d-lg-flex gap-1">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-header {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-door"></i> {{ trans_lang('الرئيسية', 'Home') }}
                    </a>

                    <div class="dropdown">
                        <a href="#" class="nav-link-header dropdown-toggle {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-bs-toggle="dropdown">
                            <i class="bi bi-people"></i> {{ trans_lang('المستخدمين', 'Users') }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">{{ trans_lang('قائمة المستخدمين', 'Users List') }}</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">{{ trans_lang('إضافة مستخدم', 'Add User') }}</a></li>
                        </ul>
                    </div>

                    <a href="{{ route('admin.products.index') }}" class="nav-link-header {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> {{ trans_lang('المنتجات', 'Products') }}
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="nav-link-header {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-bag-check"></i> {{ trans_lang('الطلبات', 'Orders') }}
                    </a>

                    <a href="{{ route('admin.brand.index') }}" class="nav-link-header {{ request()->routeIs('admin.brand.*') ? 'active' : '' }}">
                        <i class="bi bi-award"></i> {{ trans_lang('البراندات', 'Brands') }}
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="nav-link-header {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i> {{ trans_lang('تصنيفات', 'Categories') }}
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="nav-link-header {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i> {{ trans_lang('الإعدادات', 'Settings') }}
                    </a>
                </nav>
            </div>

            {{-- Right Side: Actions & Profile --}}
            <div class="d-flex align-items-center gap-2">

                {{-- زرار تبديل اللغة --}}
                @if(app()->getLocale() === 'ar')
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                       title="Switch to English">
                        <i class="bi bi-translate"></i>
                        <span class="d-none d-md-inline">EN</span>
                    </a>
                @else
                    <a href="{{ route('lang.switch', 'ar') }}"
                       class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                       title="التبديل للعربية">
                        <i class="bi bi-translate"></i>
                        <span class="d-none d-md-inline">عربي</span>
                    </a>
                @endif

                {{-- User Profile Dropdown --}}
                <div class="dropdown">
                    <button class="btn btn-link text-dark text-decoration-none d-flex align-items-center gap-2"
                            type="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                            style="width:36px; height:36px;">
                             <span class="text-white fw-bold small">
                                  {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                             </span>
                        </div>
                        <div class="text-start d-none d-md-block">
                            <div class="fw-medium small">{{ auth()->user()->name ?? trans_lang('المدير', 'Admin') }}</div>
                            <div class="text-muted smaller">{{ auth()->user()->role ?? trans_lang('مدير', 'Admin') }}</div>
                        </div>
                        <i class="bi bi-chevron-down small d-none d-md-block"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> {{ trans_lang('تسجيل الخروج', 'Logout') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                {{-- Mobile Menu Toggle --}}
                <button class="btn btn-link text-dark d-lg-none" id="mobileMenuToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>

            </div>
        </div>
    </div>
</header>

{{-- Mobile Navigation Menu --}}
<div class="mobile-menu d-lg-none" id="mobileMenu">
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
    <div class="mobile-menu-content bg-white">
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="mb-0 fw-bold">{{ trans_lang('القائمة', 'Menu') }}</h5>
            <button class="btn btn-link text-dark" id="mobileMenuClose">
                <i class="bi bi-x-lg fs-5"></i>
            </button>
        </div>
        <nav class="p-3">
            <ul class="nav flex-column gap-1">
                <li class="nav-item">
                    <a class="nav-link-mobile {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-house-door me-2"></i> {{ trans_lang('الرئيسية', 'Home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-mobile d-flex justify-content-between align-items-center {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#mobileUsersMenu" role="button"
                       aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}">
                        <span><i class="bi bi-people me-2"></i> {{ trans_lang('المستخدمين', 'Users') }}</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="mobileUsersMenu">
                        <ul class="nav flex-column ps-4 mt-1">
                            <li class="nav-item">
                                <a class="nav-link-mobile {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                                   href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-list-ul me-2"></i> {{ trans_lang('قائمة المستخدمين', 'Users List') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link-mobile {{ request()->routeIs('admin.users.create') ? 'active' : '' }}"
                                   href="{{ route('admin.users.create') }}">
                                    <i class="bi bi-person-plus me-2"></i> {{ trans_lang('إضافة مستخدم', 'Add User') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link-mobile {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                       href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box-seam me-2"></i> {{ trans_lang('المنتجات', 'Products') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-mobile {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                       href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-cart3 me-2"></i> {{ trans_lang('الطلبات', 'Orders') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-mobile {{ request()->routeIs('admin.brand.*') ? 'active' : '' }}"
                       href="{{ route('admin.brand.index') }}">
                        <i class="bi bi-award me-2"></i> {{ trans_lang('البراندات', 'Brands') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-mobile {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                       href="{{ route('admin.settings.index') }}">
                        <i class="bi bi-gear me-2"></i> {{ trans_lang('الإعدادات', 'Settings') }}
                    </a>
                </li>

                {{-- زرار اللغة في الموبايل --}}
                <li class="nav-item mt-2 border-top pt-2">
                    @if(app()->getLocale() === 'ar')
                        <a href="{{ route('lang.switch', 'en') }}" class="nav-link-mobile">
                            <i class="bi bi-translate me-2"></i> Switch to English
                        </a>
                    @else
                        <a href="{{ route('lang.switch', 'ar') }}" class="nav-link-mobile">
                            <i class="bi bi-translate me-2"></i> التبديل للعربية
                        </a>
                    @endif
                </li>

                <li class="nav-item mt-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-box-arrow-right me-2"></i> {{ trans_lang('تسجيل الخروج', 'Logout') }}
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</div>
