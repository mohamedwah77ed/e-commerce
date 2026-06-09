<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app()->getLocale() == 'ar' ? 'متجرنا' : 'Our Store')</title>

    {{-- Bootstrap 5 (RTL or LTR based on locale) --}}
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    @endif

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Google Fonts - Conditional based on locale --}}
    @if(app()->getLocale() == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @endif

    {{-- ═══════════════════════════════════════
         CSS VARIABLES (Dubai Phone Theme)
       ═══════════════════════════════════════ --}}
    <style>
        :root {
            --accent: #00d4ff;
            --accent2: #7c3aed;
            --bg: #0a0e1a;
            --surface: #141c2e;
            --surface2: #1a2332;
            --border: rgba(255,255,255,.08);
            --text: #e2e8f0;
            --muted: #64748b;
            --green: #10b981;
            --red: #ef4444;
        }
        body {
            font-family: {{ app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', 'Segoe UI', sans-serif" }};
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ════ SCROLL TO TOP BUTTON ════ */
        #scrollTopBtn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            color: #000;
            font-size: 1rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all .3s ease;
            z-index: 9999;
            box-shadow: 0 4px 15px rgba(0,212,255,.3);
        }
        [dir="rtl"] #scrollTopBtn { right: auto; left: 24px; }
        #scrollTopBtn.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        #scrollTopBtn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,212,255,.4);
        }

        /* ════ FLASH MESSAGES ════ */
        .flash-area { margin-top: 1rem; }
        .flash-area .alert {
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px;
            font-weight: 600;
            font-size: .9rem;
        }
        .flash-area .alert-success {
            background: rgba(16,185,129,.1);
            color: #34d399;
        }
        .flash-area .alert-danger {
            background: rgba(239,68,68,.1);
            color: #f87171;
        }
        .flash-area .alert-warning {
            background: rgba(245,158,11,.1);
            color: #fbbf24;
        }
        .flash-area .btn-close {
            filter: invert(1);
            opacity: .6;
        }

        /* ════ TOPBAR ════ */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: .5rem 0;
            font-size: .82rem;
            color: var(--muted);
        }
        .topbar a {
            color: var(--muted);
            text-decoration: none;
            transition: color .2s;
        }
        .topbar a:hover { color: var(--accent); }
        .topbar .badge-free {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #000;
            font-size: .7rem;
            font-weight: 800;
            padding: .15rem .5rem;
            border-radius: 6px;
        }

        /* ════ MAIN NAVBAR ════ */
        .main-nav {
            background: rgba(10,14,26,.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: .75rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: transform .3s ease;
        }
        .main-nav.hide-nav { transform: translateY(-100%); }
        .main-nav.show-nav { transform: translateY(0); }

        .nav-logo {
            font-size: 1.5rem;
            font-weight: 900;
            color: #fff;
            text-decoration: none;
            white-space: nowrap;
        }
        .nav-logo span {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Search */
        .search-wrap {
            position: relative;
            flex: 1;
            max-width: 500px;
            margin: 0 1rem;
        }
        .search-wrap .form-control,
        .search-wrap-mobile .form-control {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: .6rem 1rem;
            padding-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 2.8rem;
            color: var(--text);
            font-size: .9rem;
            transition: all .3s;
        }
        .search-wrap .form-control:focus,
        .search-wrap-mobile .form-control:focus {
            background: var(--surface);
            border-color: rgba(0,212,255,.3);
            box-shadow: 0 0 0 3px rgba(0,212,255,.1);
            color: var(--text);
        }
        .search-wrap .form-control::placeholder,
        .search-wrap-mobile .form-control::placeholder { color: var(--muted); }
        .search-wrap .btn-search,
        .search-wrap-mobile .btn-search {
            position: absolute;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 6px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border: none;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: .8rem;
            cursor: pointer;
            transition: all .2s;
        }
        .search-wrap .btn-search:hover,
        .search-wrap-mobile .btn-search:hover {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 2px 10px rgba(0,212,255,.3);
        }

        /* Icon Buttons (Cart, Wishlist) */
        .icon-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--surface);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text);
            text-decoration: none;
            transition: all .25s;
            font-size: 1rem;
        }
        .icon-btn:hover {
            background: rgba(0,212,255,.1);
            border-color: rgba(0,212,255,.2);
            color: var(--accent);
            transform: translateY(-2px);
        }
        .icon-btn .dot {
            position: absolute;
            top: -4px;
            {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: -4px;
            background: var(--red);
            color: #fff;
            font-size: .65rem;
            font-weight: 800;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--bg);
        }

        /* Auth Links */
        .auth-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: .85rem;
            font-weight: 600;
            transition: color .2s;
        }
        .auth-links a:hover { color: var(--accent); }

        /* Language Dropdown */
        .language-dropdown .btn-lang-toggle {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: .5rem .9rem;
            color: var(--text);
            font-size: .85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: .4rem;
            transition: all .25s;
        }
        .language-dropdown .btn-lang-toggle:hover {
            border-color: rgba(0,212,255,.3);
            color: var(--accent);
        }
        .language-dropdown .dropdown-menu {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: .5rem;
            min-width: 160px;
            box-shadow: 0 10px 30px rgba(0,0,0,.5);
        }
        .language-dropdown .dropdown-item {
            color: var(--text);
            font-size: .85rem;
            font-weight: 600;
            padding: .5rem .75rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all .2s;
        }
        .language-dropdown .dropdown-item:hover,
        .language-dropdown .dropdown-item.active {
            background: rgba(0,212,255,.1);
            color: var(--accent);
        }

        /* User Dropdown */
        .user-dropdown .btn-user-toggle {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: .4rem .8rem;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: .5rem;
            transition: all .25s;
        }
        .user-dropdown .btn-user-toggle:hover {
            border-color: rgba(0,212,255,.3);
        }
        .user-dropdown .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #000;
            font-weight: 800;
            font-size: .85rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .user-dropdown .user-name {
            font-size: .85rem;
            font-weight: 600;
            max-width: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .user-dropdown .dropdown-menu {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: .5rem;
            min-width: 220px;
            box-shadow: 0 10px 30px rgba(0,0,0,.5);
        }
        .user-dropdown .dropdown-header {
            padding: .75rem;
            border-bottom: 1px solid var(--border);
        }
        .user-dropdown .dropdown-user-name {
            font-weight: 700;
            color: var(--text);
            font-size: .9rem;
        }
        .user-dropdown .dropdown-user-email {
            font-size: .75rem;
            color: var(--muted);
            margin-top: .2rem;
        }
        .user-dropdown .dropdown-divider {
            border-color: var(--border);
            margin: .4rem .75rem;
        }
        .user-dropdown .dropdown-item {
            color: var(--text);
            font-size: .85rem;
            font-weight: 600;
            padding: .55rem .75rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all .2s;
        }
        .user-dropdown .dropdown-item:hover {
            background: rgba(0,212,255,.08);
            color: var(--accent);
        }
        .user-dropdown .dropdown-item.text-danger:hover {
            background: rgba(239,68,68,.1);
            color: #f87171;
        }

        /* Mobile Nav */
        .mobile-nav-menu {
            background: var(--surface);
            border-radius: 0 0 16px 16px;
            padding: 1rem;
            border-top: 1px solid var(--border);
        }
        .search-wrap-mobile {
            position: relative;
            width: 100%;
        }
        .mobile-nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .mobile-nav-links li {
            border-bottom: 1px solid var(--border);
        }
        .mobile-nav-links li:last-child { border-bottom: none; }
        .mobile-nav-links a {
            display: flex;
            align-items: center;
            padding: .75rem .5rem;
            color: var(--text);
            text-decoration: none;
            font-weight: 600;
            font-size: .9rem;
            transition: all .2s;
            border-radius: 8px;
        }
        .mobile-nav-links a:hover {
            background: rgba(0,212,255,.08);
            color: var(--accent);
            padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1rem;
        }

        /* ════ MAIN CONTENT ════ */
        .content { flex: 1; }

        /* ════ GLOBAL IMAGE FIX (Home-safe) ════ */
        img:not(.dp-hero-slide img):not(.nf-promo-banner img) {
            max-width: 100%;
            height: auto;
            object-fit: contain;
            image-rendering: -webkit-optimize-contrast;
        }
        /* ============================================
   CART BADGE ANIMATIONS
   ============================================ */

@keyframes pulse-badge {
    0% { transform: scale(1); }
    50% { transform: scale(1.4); }
    100% { transform: scale(1); }
}

@keyframes bounce-cart {
    0%, 100% { transform: translateY(0); }
    25% { transform: translateY(-5px); }
    75% { transform: translateY(3px); }
}

/* Badge styles */
.icon-btn .dot {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--red);
    color: #fff;
    font-size: .65rem;
    font-weight: 800;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--bg);
    transition: transform 0.2s ease;
}

/* Hide badge when 0 */
.icon-btn .dot:empty,
.icon-btn .dot[data-count="0"] {
    display: none;
}

/* RTL support */
[dir="rtl"] .icon-btn .dot {
    right: auto;
    left: -4px;
}

/* ════════════════════════════════════════
   PAGINATION STYLING - GLOBAL
   ════════════════════════════════════════ */

/* Wrapper */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
    flex-direction: column;
    align-items: center;
}

/* الـ pagination container */
.pagination {
    gap: 6px;
    justify-content: center;
    margin-bottom: 0.5rem;
    flex-wrap: wrap;
}

/* كل الـ items */
.pagination .page-item {
    list-style: none;
}

.pagination .page-item .page-link {
    background-color: #1e293b;
    color: #e2e8f0;
    border: 1px solid #334155;
    border-radius: 10px;
    padding: 10px 16px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    min-width: 45px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

/* hover */
.pagination .page-item .page-link:hover {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

/* active page */
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-color: #2563eb;
    color: #fff;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
}

/* ════════ الأسهم (Previous & Next) ════════ */

/* إخفاء أي SVG أو background images أو أيقونات Bootstrap */
.pagination .page-item .page-link svg,
.pagination .page-item .page-link [aria-hidden="true"],
.pagination .page-item .page-link i,
.pagination .page-item .page-link .visually-hidden {
    display: none !important;
}

/* تنسيق الـ Previous & Next */
.pagination .page-item:first-child .page-link,
.pagination .page-item:last-child .page-link {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    border: none;
    font-weight: 700;
    min-width: 100px;
    font-size: 13px;
}

/* نص "السابق" */
.pagination .page-item:first-child .page-link::before {
    content: "← السابق";
    display: inline;
}

/* نص "التالي" */
.pagination .page-item:last-child .page-link::after {
    content: "التالي →";
    display: inline;
}

/* hover للأسهم */
.pagination .page-item:first-child .page-link:hover,
.pagination .page-item:last-child .page-link:hover {
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
}

/* disabled state */
.pagination .page-item.disabled .page-link {
    background-color: #334155 !important;
    color: #64748b !important;
    border-color: #475569 !important;
    cursor: not-allowed;
    opacity: 0.5;
    transform: none !important;
    box-shadow: none !important;
}

/* ════════ info text (عرض 13 إلى 16 من 16 نتيجة) ════════ */
.pagination-wrapper .text-muted,
.pagination-wrapper small,
.pagination-info {
    color: #94a3b8 !important;
    text-align: center;
    font-size: 13px;
    margin-top: 8px;
}

/* ════════ Responsive ════════ */
@media (max-width: 576px) {
    .pagination .page-item .page-link {
        padding: 8px 12px;
        font-size: 12px;
        min-width: 35px;
    }

    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        min-width: 80px;
        font-size: 12px;
    }
}
/* تنسيق التاب */
.nf-tab {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 12px 20px;
    border: none;
    background: #f8f9fa;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 90px;
    color: #6c757d;
}

/* الأيقونة */
.nf-tab i {
    font-size: 1.4rem;
    transition: all 0.3s ease;
}

/* النص */
.nf-tab span {
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
}

/* التاب النشط */
.nf-tab--active,
.nf-tab:hover {
    background: #0d6efd;
    color: #fff;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
    transform: translateY(-2px);
}

/* شريط التمرير الأفقي */
.nf-tabs-scroll {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding-bottom: 10px;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE */
}

.nf-tabs-scroll::-webkit-scrollbar {
    display: none; /* Chrome/Safari */
}
    </style>

    @stack('styles')
</head>
<body>

    {{-- ▸ Header --}}
    @include('frontend.layouts.header')

    {{-- ▸ Flash Messages --}}
    <div class="container flash-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center gap-2">
                <i class="fas fa-triangle-exclamation"></i> {{ session('warning') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- ▸ Page Content --}}
    <main class="content">
        <div class="container my-4">
            @yield('content')
        </div>
    </main>

    {{-- ▸ Footer --}}
    @include('frontend.layouts.footer')

    {{-- ▸ Scroll to Top --}}
    <button id="scrollTopBtn" title="{{ app()->getLocale() == 'ar' ? 'للأعلى' : 'Scroll to Top' }}">
        <i class="fas fa-arrow-up"></i>
    </button>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-dismiss alerts after 4s
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                bootstrap.Alert.getOrCreateInstance(el)?.close();
            });
        }, 4000);

        // Scroll-to-top
        const scrollBtn = document.getElementById('scrollTopBtn');
        window.addEventListener('scroll', () => {
            scrollBtn.classList.toggle('show', window.scrollY > 350);
        });
        scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // Hide navbar on scroll down, show on scroll up
        const mainNav = document.getElementById('mainNav');
        let lastScrollY = window.scrollY;
        let ticking = false;

        function updateNav() {
            const currentScrollY = window.scrollY;
            if (currentScrollY < 80) {
                mainNav.classList.remove('hide-nav');
                mainNav.classList.add('show-nav');
                lastScrollY = currentScrollY;
                ticking = false;
                return;
            }
            if (currentScrollY > lastScrollY && currentScrollY > 100) {
                mainNav.classList.add('hide-nav');
                mainNav.classList.remove('show-nav');
            } else {
                mainNav.classList.remove('hide-nav');
                mainNav.classList.add('show-nav');
            }
            lastScrollY = currentScrollY;
            ticking = false;
        }
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateNav);
                ticking = true;
            }
        }, { passive: true });
    </script>

    <script src="{{ asset('frontend/js/toast.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/cart/count')
                .then(res => res.json())
                .then(data => {
                    const badge = document.getElementById('cartBadge');
                    if (badge) badge.textContent = data.count || 0;
                })
                .catch(() => {
                    // Ignore count load failures
                });
        });
    </script>
    @stack('scripts')

</body>
</html>
