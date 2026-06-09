{{-- Sidebar --}}
<aside class="sidebar bg-dark text-white" id="sidebar">
    <div class="sidebar-header p-3 border-bottom border-secondary">
        <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none d-flex align-items-center">
            <i class="bi bi-speedometer2 fs-4 me-2"></i>
            <span class="fs-5 fw-bold sidebar-text">لوحة التحكم</span>
        </a>
        {{-- Toggle Button for Mobile --}}
        <button class="btn btn-link text-white d-lg-none position-absolute start-0 top-0 m-2" id="sidebarToggle">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>
    
    <nav class="sidebar-nav flex-grow-1 overflow-auto py-3">
        <ul class="nav flex-column">
            
            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door"></i>
                    <span class="sidebar-text">الرئيسية</span>
                </a>
            </li>
            
            {{-- Users Management --}}
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                   href="#usersMenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}">
                    <span>
                        <i class="bi bi-people"></i>
                        <span class="sidebar-text">المستخدمين</span>
                    </span>
                    <i class="bi bi-chevron-down small"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="usersMenu">
                    <ul class="nav flex-column ps-4">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" 
                               href="{{ route('admin.users.index') }}">
                                <i class="bi bi-list-ul"></i> قائمة المستخدمين
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">
                                <i class="bi bi-person-plus"></i> إضافة مستخدم
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            {{-- Products --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span class="sidebar-text">المنتجات</span>
                </a>
            </li>
            
            {{-- Orders --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                   href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-cart3"></i>
                    <span class="sidebar-text">الطلبات</span>
                    @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
                        <span class="badge bg-danger ms-auto">{{ $pendingOrdersCount }}</span>
                    @endif
                </a>
            </li>
            
            {{-- Categories --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                   href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags"></i>
                    <span class="sidebar-text">التصنيفات</span>
                </a>
            </li>
            
            {{-- Divider --}}
            <li class="nav-item mt-3">
                <span class="nav-link text-muted small text-uppercase sidebar-text">الإعدادات</span>
            </li>
            
            {{-- Settings --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                   href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-gear"></i>
                    <span class="sidebar-text">الإعدادات العامة</span>
                </a>
            </li>
            
            {{-- Profile --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" 
                   href="{{ route('admin.profile') }}">
                    <i class="bi bi-person-circle"></i>
                    <span class="sidebar-text">الملف الشخصي</span>
                </a>
            </li>
            
        </ul>
    </nav>
    
    {{-- Sidebar Footer --}}
    <div class="sidebar-footer p-3 border-top border-secondary mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i>
                <span class="sidebar-text">تسجيل الخروج</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Overlay --}}
<div class="sidebar-overlay d-lg-none" id="sidebarOverlay"></div>