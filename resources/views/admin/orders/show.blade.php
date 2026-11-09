@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_code)

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">
                <i class="fa-solid fa-file-invoice me-2 text-warning"></i> Order Details: {{ $order->order_code }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Orders
            </a>
        </div>

        <div class="row g-4">
            <!-- Left: Order Items & Customer Info -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <h5 class="fw-bold mb-3 text-dark">Purchased Products</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded-3" style="width: 45px; height: 45px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px;">
                                                        <i class="fa-solid fa-image"></i>
                                                    </div>
                                                @endif
                                                <span class="fw-semibold text-dark">{{ $item->product->name ?? 'Product Deleted' }}</span>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3 border-top pt-3">
                        <span class="text-muted me-2">Grand Total:</span>
                        <h4 class="fw-bold text-success d-inline-block mb-0">${{ number_format($order->total_amount, 2) }}</h4>
                    </div>
                </div>

                <!-- Customer & Delivery Info -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3 text-dark">Customer & Shipping Information</h5>
                    <p class="mb-1"><strong>Customer Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Phone Number:</strong> {{ $order->phone }}</p>
                    <p class="mb-0"><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>

            <!-- Right: Payment Slip & Status Management -->
            <div class="col-lg-4">
                <!-- Status Update Form -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <h5 class="fw-bold mb-3 text-dark">Update Order Status</h5>
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <select name="status" class="form-select">
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Approved" {{ $order->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 rounded-pill fw-semibold">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Payment Slip Display -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3 text-dark">Payment Slip</h5>
                    @if($order->payment && $order->payment->payment_slip)
                        <div class="text-center">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-3">
                                Method: {{ $order->payment->paymentMethod->name ?? 'Bank Transfer' }}
                            </span>
                            <a href="{{ asset('storage/' . $order->payment->payment_slip) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->payment->payment_slip) }}" alt="Payment Slip" class="img-fluid rounded-3 border shadow-sm" style="max-height: 300px; object-fit: contain;">
                            </a>
                            <span class="d-block text-muted small mt-2">Click image to view full size</span>
                        </div>
                    @else
                        <p class="text-muted small text-center mb-0">No payment slip uploaded.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
