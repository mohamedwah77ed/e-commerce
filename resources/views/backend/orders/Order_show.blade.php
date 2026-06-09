@extends('backend.layouts.master')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Order <span class="text-primary">#{{ $order->order_number }}</span></h4>
            <small class="text-muted">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Edit Order
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- Order Items --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-bag me-2 text-primary"></i>Order Items</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Unit Price</th>
                                    <th class="text-end pe-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->cart_info as $item)
                                <tr>
                                    <td class="ps-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($item->product && $item->product->image)
                                                <img src="{{ asset($item->product->image) }}"
                                                     alt="{{ $item->product->name ?? 'Product' }}"
                                                     class="rounded"
                                                     style="width:48px;height:48px;object-fit:cover;">
                                            @else
                                                <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                     style="width:48px;height:48px;">
                                                    <i class="bi bi-box text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-medium">{{ $item->product->name ?? 'N/A' }}</div>
                                                @if (!empty($item->size))
                                                    <small class="text-muted">Size: {{ $item->size }}</small>
                                                @endif
                                                @if (!empty($item->color))
                                                    <small class="text-muted ms-2">Color: {{ $item->color }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-end pe-3 fw-medium">${{ number_format($item->quantity * $item->price, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No items found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Totals --}}
                <div class="card-footer bg-white border-top">
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Subtotal</span>
                                <span>${{ number_format($order->sub_total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Shipping</span>
                                <span>
                                    @if ($order->shipping)
                                        ${{ number_format($order->shipping->price ?? 0, 2) }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold fs-6">
                                <span>Total</span>
                                <span class="text-primary">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-geo-alt me-2 text-primary"></i>Shipping Address</h6>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                        {{ $order->address1 }}<br>
                        @if ($order->address2)
                            {{ $order->address2 }}<br>
                        @endif
                        {{ $order->country }}
                        @if ($order->post_code)
                            &mdash; {{ $order->post_code }}
                        @endif
                    </address>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">

            {{-- Status Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-info-circle me-2 text-primary"></i>Order Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Order Status</label><br>
                        @php
                            $statusColors = [
                                'new'        => 'primary',
                                'processing' => 'warning',
                                'delivered'  => 'success',
                                'cancelled'  => 'danger',
                            ];
                            $statusColor = $statusColors[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} border border-{{ $statusColor }}-subtle px-3 py-2 rounded-pill fs-6">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Payment Status</label><br>
                        @php
                            $payColor = $order->payment_status === 'paid' ? 'success' : 'danger';
                        @endphp
                        <span class="badge bg-{{ $payColor }}-subtle text-{{ $payColor }} border border-{{ $payColor }}-subtle px-3 py-2 rounded-pill fs-6">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Payment Method</label><br>
                        <span class="fw-medium text-capitalize">
                            <i class="bi bi-{{ $order->payment_method === 'paypal' ? 'paypal' : 'cash-coin' }} me-1"></i>
                            {{ strtoupper($order->payment_method) }}
                        </span>
                    </div>
                    @if ($order->paymob_order_id)
                    <div>
                        <label class="form-label text-muted small mb-1">Paymob Order ID</label><br>
                        <code class="small">{{ $order->paymob_order_id }}</code>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-primary"></i>Customer</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                             style="width:44px;height:44px;flex-shrink:0;">
                            <span class="fw-bold text-primary">
                                {{ strtoupper(substr($order->first_name, 0, 1)) }}{{ strtoupper(substr($order->last_name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $order->first_name }} {{ $order->last_name }}</div>
                            @if ($order->user)
                                <small class="text-muted">Registered User</small>
                            @else
                                <small class="text-muted">Guest</small>
                            @endif
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="bi bi-envelope me-2 text-muted"></i>
                            <a href="mailto:{{ $order->email }}" class="text-decoration-none text-dark">{{ $order->email }}</a>
                        </li>
                        <li>
                            <i class="bi bi-telephone me-2 text-muted"></i>
                            <a href="tel:{{ $order->phone }}" class="text-decoration-none text-dark">{{ $order->phone }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Shipping Method --}}
            @if ($order->shipping)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-truck me-2 text-primary"></i>Shipping Method</h6>
                </div>
                <div class="card-body">
                    <div class="fw-medium">{{ $order->shipping->type ?? 'Standard' }}</div>
                    <div class="text-muted small">
                        Estimated: {{ $order->shipping->delivery_time ?? 'N/A' }}
                    </div>
                    <div class="mt-2 fw-semibold text-primary">
                        ${{ number_format($order->shipping->price ?? 0, 2) }}
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
