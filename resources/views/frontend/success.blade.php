@extends('frontend.layouts.master')

@section('title', trans_lang('تم الطلب بنجاح', 'Order Confirmed'))

@push('styles')
<style>
    .success-page {
        min-height: 80vh;
        padding: 60px 0;
        background: var(--bg-dark, #0f1623);
        color: #e2e8f0;
    }

    /* ── Header ── */
    .success-header {
        text-align: center;
        margin-bottom: 48px;
    }

    .success-icon {
        width: 72px;
        height: 72px;
        background: #0f3d2e;
        border: 2px solid #22c55e;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .success-icon i {
        font-size: 28px;
        color: #22c55e;
    }

    .success-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #f1f5f9;
        margin-bottom: 8px;
    }

    .success-header p {
        color: #94a3b8;
        font-size: 0.95rem;
    }

    .order-number-badge {
        display: inline-block;
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 8px;
        padding: 6px 16px;
        font-size: 0.85rem;
        color: #94a3b8;
        margin-top: 12px;
        letter-spacing: 0.5px;
    }

    .order-number-badge span {
        color: #f1f5f9;
        font-weight: 600;
    }

    /* ── Cards ── */
    .info-card {
        background: #141c2e;
        border: 1px solid #1e293b;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .info-card-head {
        padding: 14px 20px;
        border-bottom: 1px solid #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        color: #cbd5e1;
    }

    .info-card-head i {
        color: #64748b;
        font-size: 0.85rem;
    }

    .info-card-body {
        padding: 20px;
    }

    /* ── Order Meta ── */
    .meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .meta-item label {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 4px;
    }

    .meta-item span {
        font-size: 0.9rem;
        color: #e2e8f0;
        font-weight: 500;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        background: #0f3d2e;
        color: #22c55e;
        border: 1px solid #166534;
    }

    /* ── Products ── */
    .product-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #1e293b;
    }

    .product-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .product-row:first-child {
        padding-top: 0;
    }

    .product-thumb {
        width: 52px;
        height: 52px;
        border-radius: 8px;
        object-fit: cover;
        background: #1e293b;
        flex-shrink: 0;
    }

    .product-name {
        flex: 1;
        font-size: 0.88rem;
        color: #e2e8f0;
        font-weight: 500;
        line-height: 1.4;
    }

    .product-qty {
        font-size: 0.8rem;
        color: #64748b;
        margin-top: 2px;
    }

    .product-price {
        font-size: 0.9rem;
        font-weight: 600;
        color: #f1f5f9;
        white-space: nowrap;
    }

    /* ── Summary ── */
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-size: 0.88rem;
        color: #94a3b8;
        border-bottom: 1px solid #1e293b;
    }

    .summary-row:last-of-type {
        border-bottom: none;
    }

    .summary-row.total {
        padding-top: 14px;
        margin-top: 4px;
        border-top: 1px solid #334155;
        font-size: 1rem;
        font-weight: 700;
        color: #f1f5f9;
    }

    .summary-row .val {
        color: #e2e8f0;
        font-weight: 500;
    }

    .free-tag {
        color: #22c55e;
        font-weight: 600;
    }

    /* ── Shipping ── */
    .shipping-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .shipping-item label {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .shipping-item span {
        font-size: 0.88rem;
        color: #e2e8f0;
    }

    /* ── Actions ── */
    .actions {
        display: flex;
        gap: 12px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .btn-primary-action {
        flex: 1;
        min-width: 140px;
        padding: 12px 20px;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-primary-action:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .btn-secondary-action {
        flex: 1;
        min-width: 140px;
        padding: 12px 20px;
        background: transparent;
        color: #94a3b8;
        border: 1px solid #334155;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-secondary-action:hover {
        border-color: #64748b;
        color: #e2e8f0;
    }

    @media (max-width: 576px) {
        .meta-grid,
        .shipping-grid { grid-template-columns: 1fr; }
        .success-header h1 { font-size: 1.4rem; }
    }
</style>
@endpush

@section('content')
<div class="success-page">
    <div class="container" style="max-width: 680px;">

        {{-- ── Header ── --}}
        <div class="success-header">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h1>{{ trans_lang('تم تأكيد طلبك!', 'Order Confirmed!') }}</h1>
            <p>{{ trans_lang('شكراً لك، سيتم معالجة طلبك في أقرب وقت.', 'Thank you! Your order is being processed.') }}</p>
            <div class="order-number-badge">
                {{ trans_lang('رقم الطلب', 'Order') }}:
                <span>#{{ $order->order_number }}</span>
                &nbsp;·&nbsp;
                {{ $order->created_at->format('d M Y') }}
            </div>
        </div>

        {{-- ── Products ── --}}
        <div class="info-card">
            <div class="info-card-head">
                <i class="fas fa-box"></i>
                {{ trans_lang('المنتجات', 'Items Ordered') }}
                <span style="color:#64748b; font-weight:400; margin-{{ trans_lang('right','left') }}: auto;">
                    {{ $order->cart_info->sum('quantity') }} {{ trans_lang('قطعة', 'pcs') }}
                </span>
            </div>
            <div class="info-card-body">
                @foreach($order->cart_info as $item)
                <div class="product-row">
                    @php $img = $item->product?->images?->first() @endphp
                    <img class="product-thumb"
                         src="{{ $img ? asset('uploads/' . $img->image) : asset('images/no-image.png') }}"
                         alt="{{ $item->product?->title }}"
                         onerror="this.src='https://placehold.co/52x52/1e293b/64748b?text=...'">
                    <div class="product-name">
                        {{ $item->product?->title ?? trans_lang('منتج', 'Product') }}
                        <div class="product-qty">× {{ $item->quantity }}</div>
                    </div>
                    <div class="product-price">
                        {{ number_format($item->amount, 0) }} {{ trans_lang('جنيه', 'EGP') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── Summary + Shipping (side by side on desktop) ── --}}
        <div class="row g-3">

            {{-- Payment Summary --}}
            <div class="col-md-6">
                <div class="info-card h-100">
                    <div class="info-card-head">
                        <i class="fas fa-receipt"></i>
                        {{ trans_lang('ملخص الدفع', 'Payment Summary') }}
                    </div>
                    <div class="info-card-body">
                        <div class="summary-row">
                            <span>{{ trans_lang('المجموع الفرعي', 'Subtotal') }}</span>
                            <span class="val">{{ number_format($order->sub_total, 0) }} {{ trans_lang('جنيه', 'EGP') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>{{ trans_lang('الشحن', 'Shipping') }}</span>
                            <span class="free-tag">{{ trans_lang('مجاني', 'Free') }}</span>
                        </div>
                        @if($order->coupon > 0)
                        <div class="summary-row">
                            <span>{{ trans_lang('خصم الكوبون', 'Coupon Discount') }}</span>
                            <span style="color:#f97316;">- {{ number_format($order->coupon, 0) }} {{ trans_lang('جنيه', 'EGP') }}</span>
                        </div>
                        @endif
                        <div class="summary-row total">
                            <span>{{ trans_lang('الإجمالي', 'Total') }}</span>
                            <span>{{ number_format($order->total_amount, 0) }} {{ trans_lang('جنيه', 'EGP') }}</span>
                        </div>
                        <div style="margin-top: 16px;">
                            <div class="summary-row" style="border:none; padding:0;">
                                <span>{{ trans_lang('حالة الدفع', 'Payment') }}</span>
                                <span class="status-pill">
                                    <i class="fas fa-circle" style="font-size:6px;"></i>
                                    {{ $order->payment_status === 'paid' ? trans_lang('مدفوع', 'Paid') : trans_lang('قيد المعالجة', 'Pending') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Shipping Info --}}
            <div class="col-md-6">
                <div class="info-card h-100">
                    <div class="info-card-head">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ trans_lang('بيانات الشحن', 'Shipping Details') }}
                    </div>
                    <div class="info-card-body">
                        <div class="shipping-grid">
                            <div class="shipping-item">
                                <label>{{ trans_lang('الاسم', 'Name') }}</label>
                                <span>{{ $order->first_name }} {{ $order->last_name }}</span>
                            </div>
                            <div class="shipping-item">
                                <label>{{ trans_lang('الهاتف', 'Phone') }}</label>
                                <span>{{ $order->phone }}</span>
                            </div>
                            <div class="shipping-item">
                                <label>{{ trans_lang('البريد', 'Email') }}</label>
                                <span style="word-break:break-all;">{{ $order->email }}</span>
                            </div>

                            <div class="shipping-item" style="grid-column: 1 / -1;">
                                <label>{{ trans_lang('العنوان', 'Address') }}</label>
                                <span>{{ $order->address1 }}{{ $order->address2 ? '، ' . $order->address2 : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Actions ── --}}
        <div class="actions mt-3">
            <a href="{{ route('products.home') }}" class="btn-primary-action">
                <i class="fas fa-store me-2"></i>
                {{ trans_lang('متابعة التسوق', 'Continue Shopping') }}
            </a>
            <a href="{{ route('orders.my') }}" class="btn-secondary-action">
                <i class="fas fa-list me-2"></i>
                {{ trans_lang('طلباتي', 'My Orders') }}
            </a>
        </div>

    </div>
</div>
@endsection
