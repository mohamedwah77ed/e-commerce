<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'لوحة التحكم') | {{ config('app.name', 'Admin Panel') }}</title>

    {{-- Bootstrap 5.3 RTL CSS --}}
{{-- Bootstrap 5.3 CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap{{ app()->getLocale() == 'ar' ? '.rtl' : '' }}.min.css">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- Custom Backend CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/master.css') }}">

    {{-- Additional Styles --}}
    @stack('styles')
    @yield('styles')
</head>
<body class="bg-light">

    <div class="d-flex flex-column min-vh-100">

        {{-- Header --}}
        @include('backend.layouts.header')

        {{-- Page Content --}}
        <main class="flex-grow-1 p-4">
            {{-- Breadcrumb --}}
            @hasSection('breadcrumb')
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house-door"></i> الرئيسية
                            </a>
                        </li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            @endif


            {{-- Main Page Content --}}
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('backend.layouts.footer')

    </div>

    {{-- Bootstrap 5.3 JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Custom Backend JS --}}
    <script src="{{ asset('backend/js/master.js') }}"></script>

    {{-- Additional Scripts --}}
    @stack('scripts')
    @yield('scripts')
</body>
</html>
