@extends('backend.layouts.master')

@section('title', 'Orders')

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Orders</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search / Filter --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 mb-4">
        <div class="col-sm-4">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Search by name, email, phone, order no..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-sm-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="new"        {{ request('status') == 'new'        ? 'selected' : '' }}>New</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped"    {{ request('status') == 'shipped'    ? 'selected' : '' }}>Shipped</option>
                <option value="delivered"  {{ request('status') == 'delivered'  ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled"  {{ request('status') == 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-sm-2">
            <select name="payment_status" class="form-select form-select-sm">
                <option value="">All Payments</option>
                <option value="pending"  {{ request('payment_status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                <option value="paid"     {{ request('payment_status') == 'paid'     ? 'selected' : '' }}>Paid</option>
                <option value="failed"   {{ request('payment_status') == 'failed'   ? 'selected' : '' }}>Failed</option>
                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>

                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ number_format($order->total_amount, 2) }} EGP</td>
                    <td>
                        @if($order->payment_status === 'paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif($order->payment_status === 'failed')
                            <span class="badge bg-danger">Failed</span>
                        @elseif($order->payment_status === 'refunded')
                            <span class="badge bg-info text-dark">Refunded</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'new'        => 'bg-info text-dark',
                                'processing' => 'bg-primary',
                                'shipped'    => 'bg-secondary',
                                'delivered'  => 'bg-success',
                                'cancelled'  => 'bg-danger',
                            ];
                        @endphp
                        <span class="badge {{ $statusMap[$order->status] ?? 'bg-secondary' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.edit', $order->id) }}"
                           class="btn btn-sm btn-outline-primary">Edit</a>
                             <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="btn btn-sm btn-outline-primary">view</a>

                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this order?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center text-muted py-4">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>

</div>

@endsection
