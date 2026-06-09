@extends('frontend.layouts.master')

@section('content')
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-box-seam me-2"></i>{{ trans_lang('طلباتي', 'My Orders') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="mt-3 text-muted">{{ trans_lang('ما عندكش طلبات لسه', 'You have no orders yet') }}</p>
            <a href="{{ route('products.home') }}" class="btn btn-primary">{{ trans_lang('تسوق دلوقتي', 'Shop Now') }}</a>
        </div>
    @else
        <div class="table-responsive shadow-sm rounded-3 border-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-semibold text-muted">{{ trans_lang('رقم الطلب', 'Order #') }}</th>
                        <th class="py-3 text-uppercase small fw-semibold text-muted">{{ trans_lang('التاريخ', 'Date') }}</th>
                        <th class="py-3 text-uppercase small fw-semibold text-muted">{{ trans_lang('المنتجات', 'Items') }}</th>
                        <th class="py-3 text-uppercase small fw-semibold text-muted">{{ trans_lang('الإجمالي', 'Total') }}</th>
                        <th class="py-3 text-uppercase small fw-semibold text-muted">{{ trans_lang('الحالة', 'Status') }}</th>
                        <th class="py-3 text-uppercase small fw-semibold text-muted">{{ trans_lang('الدفع', 'Payment') }}</th>
                        <th class="pe-4 py-3 text-uppercase small fw-semibold text-muted text-end">{{ trans_lang('إجراءات', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        @php
                            $statusColors = [
                                'new'        => 'bg-primary',
                                'pending'    => 'bg-warning text-dark',
                                'processing' => 'bg-info text-dark',
                                'shipped'    => 'bg-secondary',
                                'delivered'  => 'bg-success',
                                'cancelled'  => 'bg-danger',
                                'refunded'   => 'bg-dark',
                            ];
                            $statusLabels = [
                                'new'        => trans_lang('جديد', 'New'),
                                'pending'    => trans_lang('معلق', 'Pending'),
                                'processing' => trans_lang('قيد التجهيز', 'Processing'),
                                'shipped'    => trans_lang('تم الشحن', 'Shipped'),
                                'delivered'  => trans_lang('تم التوصيل', 'Delivered'),
                                'cancelled'  => trans_lang('ملغي', 'Cancelled'),
                                'refunded'   => trans_lang('مسترجع', 'Refunded'),
                            ];
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <a href="{{ route('orders.show', $order->id) }}" class="fw-bold text-decoration-none text-primary">
                                    #{{ $order->order_number }}
                                </a>
                            </td>
                            <td class="text-muted small">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $order->quantity }} {{ trans_lang('منتج', 'Items') }}
                                </span>
                            </td>
                            <td class="fw-semibold">{{ number_format($order->total_amount, 2) }} {{ trans_lang('ج.م', 'EGP') }}</td>
                            <td>
                                <span class="badge {{ $statusColors[$order->status] ?? 'bg-secondary' }} rounded-pill px-3 py-2">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning text-dark' }} rounded-pill px-3 py-2">
                                    {{ $order->payment_status == 'paid' ? trans_lang('مدفوع', 'Paid') : trans_lang('معلق', 'Pending') }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-eye me-1"></i> {{ trans_lang('التفاصيل', 'Details') }}
                                </a>

                                @if($order->canBeCancelled())
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 ms-1"
                                            data-bs-toggle="modal" data-bs-target="#cancelModal{{ $order->id }}">
                                        <i class="bi bi-x-circle me-1"></i> {{ trans_lang('إلغاء', 'Cancel') }}
                                    </button>

                                    <!-- Modal إلغاء الطلب -->
                                    <div class="modal fade" id="cancelModal{{ $order->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold">{{ trans_lang('إلغاء الطلب', 'Cancel Order') }} #{{ $order->order_number }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-muted">{{ trans_lang('متأكد إنك عاوز تلغي الطلب؟', 'Are you sure you want to cancel this order?') }}</p>
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
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
