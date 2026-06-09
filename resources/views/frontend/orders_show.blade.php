@extends('frontend.layouts.master')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ trans_lang('تفاصيل الطلب', 'Order Details') }} <span class="text-muted">#{{ $order->order_number }}</span></h2>
        <a href="{{ route('orders.my') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-right me-1"></i> {{ trans_lang('رجوع للطلبات', 'Back to Orders') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <!-- معلومات الطلب -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-bag me-2 text-primary"></i>{{ trans_lang('المنتجات', 'Products') }}</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    @foreach($order->cart_info as $item)
                        <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="flex-shrink-0">
                                <img src="{{ $item->product->photo ? asset('uploads/' . $item->product->photo) : asset('uploads/default.png') }}"
                                        alt="" class="rounded-3" width="80" height="80" style="object-fit: cover;">
                            </div>
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-1 fw-semibold">{{ $item->product->title ?? trans_lang('منتج', 'Product') }}</h6>
                                <p class="text-muted mb-0 small">{{ trans_lang('الكمية', 'Qty') }}: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-end flex-shrink-0">
                                <span class="fw-bold fs-6">{{ number_format($item->amount, 2) }} {{ trans_lang('ج.م', 'EGP') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>{{ trans_lang('معلومات الشحن', 'Shipping Info') }}</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">{{ trans_lang('الاسم', 'Name') }}</label>
                            <p class="mb-0 fw-bold">{{ $order->first_name }} {{ $order->last_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">{{ trans_lang('البريد الإلكتروني', 'Email') }}</label>
                            <p class="mb-0 fw-bold">{{ $order->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">{{ trans_lang('الهاتف', 'Phone') }}</label>
                            <p class="mb-0 fw-bold">{{ $order->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">{{ trans_lang('الدولة', 'Country') }}</label>
                            <p class="mb-0 fw-bold">{{ $order->country }}</p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small mb-1">{{ trans_lang('العنوان', 'Address') }}</label>
                            <p class="mb-0 fw-bold">{{ $order->address1 }}</p>
                            @if($order->address2)
                                <p class="mb-0 text-muted">{{ $order->address2 }}</p>
                            @endif
                        </div>
                        @if($order->post_code)
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">{{ trans_lang('الرمز البريدي', 'Postal Code') }}</label>
                                <p class="mb-0 fw-bold">{{ $order->post_code }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- ملخص الطلب -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-white border-0 pt-4 pb-2 px-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>{{ trans_lang('ملخص الطلب', 'Order Summary') }}</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">{{ trans_lang('رقم الطلب', 'Order #') }}</span>
                        <span class="fw-bold">{{ $order->order_number }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">{{ trans_lang('التاريخ', 'Date') }}</span>
                        <span>{{ $order->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">{{ trans_lang('الحالة', 'Status') }}</span>
                        @php
                            $statusLabels = [
                                'new' => trans_lang('جديد', 'New'),
                                'pending' => trans_lang('معلق', 'Pending'),
                                'processing' => trans_lang('قيد التجهيز', 'Processing'),
                                'shipped' => trans_lang('تم الشحن', 'Shipped'),
                                'delivered' => trans_lang('تم التوصيل', 'Delivered'),
                                'cancelled' => trans_lang('ملغي', 'Cancelled'),
                                'refunded' => trans_lang('مسترجع', 'Refunded')
                            ];
                            $statusBadgeClass = [
                                'new' => 'bg-primary',
                                'pending' => 'bg-warning text-dark',
                                'processing' => 'bg-info text-dark',
                                'shipped' => 'bg-secondary',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                'refunded' => 'bg-dark'
                            ];
                        @endphp
                        <span class="badge {{ $statusBadgeClass[$order->status] ?? 'bg-primary' }} rounded-pill px-3 py-2">
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ trans_lang('المجموع الفرعي', 'Subtotal') }}</span>
                        <span>{{ number_format($order->sub_total, 2) }} {{ trans_lang('ج.م', 'EGP') }}</span>
                    </div>
                    @if($order->coupon > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>{{ trans_lang('خصم الكوبون', 'Coupon Discount') }}</span>
                            <span>-{{ number_format($order->coupon, 2) }} {{ trans_lang('ج.م', 'EGP') }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ trans_lang('الشحن', 'Shipping') }}</span>
                        <span class="text-success fw-semibold">{{ trans_lang('مجاني', 'Free') }}</span>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-6">{{ trans_lang('الإجمالي', 'Total') }}</span>
                        <span class="fw-bold fs-4 text-primary">{{ number_format($order->total_amount, 2) }} {{ trans_lang('ج.م', 'EGP') }}</span>
                    </div>

                    @if($order->canBeCancelled())
                        <hr class="my-3">
                        <button type="button" class="btn btn-outline-danger w-100 rounded-pill py-2" data-bs-toggle="modal" data-bs-target="#cancelModal">
                            <i class="bi bi-x-circle me-1"></i> {{ trans_lang('إلغاء الطلب', 'Cancel Order') }}
                        </button>

                        <div class="modal fade" id="cancelModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold">{{ trans_lang('إلغاء الطلب', 'Cancel Order') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-muted">{{ trans_lang('متأكد إنك عاوز تلغي الطلب', 'Are you sure you want to cancel order') }} #{{ $order->order_number }}؟</p>
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">{{ trans_lang('سبب الإلغاء (اختياري)', 'Cancellation Reason (Optional)') }}</label>
                                                <textarea name="reason" class="form-control rounded-3" rows="2" placeholder="{{ trans_lang('اكتب سبب الإلغاء...', 'Write cancellation reason...') }}"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 pt-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ trans_lang('تراجع', 'Back') }}</button>
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">{{ trans_lang('تأكيد الإلغاء', 'Confirm Cancel') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif($order->status == 'cancelled')
                        <div class="alert alert-danger rounded-3 mt-3 mb-0">
                            <i class="bi bi-x-circle-fill me-1"></i> {{ trans_lang('تم إلغاء هذا الطلب', 'This order has been cancelled') }}
                            @if($order->cancellation_reason)
                                <br><small>{{ trans_lang('السبب', 'Reason') }}: {{ $order->cancellation_reason }}</small>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
