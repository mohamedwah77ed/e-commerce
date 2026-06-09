@extends('backend.layouts.master')

@section('title', trans_lang('الرئيسية', 'Dashboard'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ trans_lang('الرئيسية', 'Dashboard') }}</li>
@endsection

@section('content')
    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        {{-- Users Count --}}
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-people fs-2 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 me-3">
                            <h6 class="text-muted mb-1">{{ trans_lang('المستخدمين', 'Users') }}</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($usersCount ?? 0) }}</h3>
                            <small class="text-muted">{{ trans_lang('مستخدم فعلي', 'Active Users') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Orders Count --}}
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-cart3 fs-2 text-success"></i>
                        </div>
                        <div class="flex-grow-1 me-3">
                            <h6 class="text-muted mb-1">{{ trans_lang('الطلبات', 'Orders') }}</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($ordersCount ?? 0) }}</h3>
                            <small class="text-muted">{{ trans_lang('طلب إجمالي', 'Total Orders') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Products Count --}}
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-box-seam fs-2 text-warning"></i>
                        </div>
                        <div class="flex-grow-1 me-3">
                            <h6 class="text-muted mb-1">{{ trans_lang('المنتجات', 'Products') }}</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($productsCount ?? 0) }}</h3>
                            <small class="text-muted">{{ trans_lang('منتج متاح', 'Available Products') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-currency-dollar fs-2 text-info"></i>
                        </div>
                        <div class="flex-grow-1 me-3">
                            <h6 class="text-muted mb-1">{{ trans_lang('الإيرادات', 'Revenue') }}</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($revenue ?? 0, 2) }} {{ trans_lang('ج.م', 'EGP') }}</h3>
                            <small class="text-success">
                                <i class="bi bi-check-circle-fill small"></i> {{ trans_lang('مدفوعة', 'Paid') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Second Row: Paid vs Pending Orders --}}
    <div class="row g-4 mb-4">
        {{-- Paid Orders --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">{{ trans_lang('الطلبات المدفوعة', 'Paid Orders') }}</h6>
                            <h3 class="mb-0 fw-bold text-success">{{ number_format($paidOrdersCount ?? 0) }}</h3>
                            <small class="text-muted">{{ trans_lang('طلب تم دفعها بنجاح', 'Successfully Paid') }}</small>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">{{ trans_lang('الطلبات المعلقة', 'Pending Orders') }}</h6>
                            <h3 class="mb-0 fw-bold text-danger">{{ number_format($pendingOrders ?? 0) }}</h3>
                            <small class="text-muted">{{ trans_lang('طلب لم يتم الدفع', 'Unpaid Orders') }}</small>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-hourglass-split fs-1 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
