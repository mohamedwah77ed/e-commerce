@extends('backend.layouts.master')

@section('title', 'Edit Order')

@section('content')

<div class="container py-4" style="max-width: 720px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Edit Order <span class="text-muted fs-6">{{ $order->order_number }}</span></h4>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Order Status & Payment --}}
        <div class="card border mb-3">
            <div class="card-body">
                <h6 class="card-title mb-3">Order Status & Payment</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-select">
                            <option value="new" {{ $order->status == 'new'        ? 'selected' : '' }}>New</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered"  {{ $order->status == 'delivered'  ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled"  {{ $order->status == 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                             <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid"   {{ $order->payment_status == 'paid'   ? 'selected' : '' }}>Paid</option>
                         </select>
                    </div>


                </div>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="card border mb-3">
            <div class="card-body">
                <h6 class="card-title mb-3">Customer Info</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $order->first_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $order->last_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $order->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $order->phone) }}" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="card border mb-3">
            <div class="card-body">
                <h6 class="card-title mb-3">Shipping Address</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="address1" class="form-control" value="{{ old('address1', $order->address1) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" name="address2" class="form-control" value="{{ old('address2', $order->address2) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', $order->country) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="post_code" class="form-control" value="{{ old('post_code', $order->post_code) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Amounts --}}
        <div class="card border mb-3">
            <div class="card-body">
                <h6 class="card-title mb-3">Order Amounts</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Sub Total <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="sub_total" class="form-control" value="{{ old('sub_total', $order->sub_total) }}" required>
                            <span class="input-group-text">EGP</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Total Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="total_amount" class="form-control" value="{{ old('total_amount', $order->total_amount) }}" required>
                            <span class="input-group-text">EGP</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $order->quantity) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Meta Info (Read Only) --}}
        <div class="card border mb-4">
            <div class="card-body">
                <h6 class="card-title mb-3">Meta Info</h6>
                <table class="table table-borderless mb-0">
                    <tr>
                        <th class="text-muted" width="40%">Order Number</th>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">User ID</th>
                        <td>{{ $order->user_id ?? 'Guest' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Date</th>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Last Updated</th>
                        <td>{{ $order->updated_at->format('d M Y, h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i> Save Changes
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>

</div>

@endsection
