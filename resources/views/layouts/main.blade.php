<!doctype html>
<html lang="{{ app()->getLocale() == 'ar' ? 'ar' : 'en' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? trans_lang('متجري', 'My Shop') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .auth-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            background: #fff;
        }
        .auth-card .card-body {
            padding: 2.5rem;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e9ecef;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }
        .btn-primary {
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 500;
        }
        .auth-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        .auth-link:hover {
            text-decoration: underline;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .auth-header h3 {
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        .auth-header p {
            color: #6c757d;
            margin-bottom: 0;
        }
        .invalid-feedback {
            font-size: 0.875rem;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>
<body>

    @include('layouts.navbar')

    <div class="container py-5 flex-grow-1">
        @yield('content')
    </div>

    <footer class="text-center py-4 text-muted">
        <small>&copy; {{ date('Y') }} {{ trans_lang('متجري. جميع الحقوق محفوظة.', 'My Shop. All rights reserved.') }}</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
