@extends('layouts.shop')

@section('title', 'My Orders - Ruiz Watches')

@section('content')
    <div class="container py-5" style="margin-top: 40px; font-family: 'Domine', serif;">
        <h2 class="fw-bold text-dark mb-4">
            <i class="fa-solid fa-box-archive me-2 text-warning"></i> My Order History
        </h2>

        @forelse($orders as $order)
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 border-bottom pb-3">
                    <div>
                        <span class="fw-bold text-dark fs-6">{{ $order->order_code }}</span>
                        <span class="text-muted small ms-2">({{ $order->created_at->format('d M Y, h:i A') }})</span>
                    </div>
                    <div>
                        @if ($order->status == 'Pending')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending Confirmation</span>
                        @elseif($order->status == 'Approved')
                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill">Approved</span>
                        @elseif($order->status == 'Completed')
                            <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill">{{ $order->status }}</span>
                        @endif
                    </div>
                </div>

                <!-- Order Items List -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="rounded-3"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fa-solid fa-image"></i>
                                                </div>
                                            @endif
                                            <span
                                                class="fw-semibold text-dark">{{ $item->product->name ?? 'Product Deleted' }}</span>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold">${{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <div class="small text-muted">
                        <span><strong>Phone:</strong> {{ $order->phone }}</span> |
                        <span><strong>Address:</strong> {{ $order->shipping_address }}</span>
                    </div>
                    <div class="text-end">
                        <span class="text-muted small me-2">Total Amount:</span>
                        <h5 class="fw-bold text-success mb-0 d-inline-block">${{ number_format($order->total_amount, 2) }}
                        </h5>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-4 shadow-sm p-5">
                <i class="fa-solid fa-box-open fs-1 text-secondary opacity-50 mb-3 d-block"></i>
                <h4 class="fw-bold text-dark">No orders found</h4>
                <p class="text-muted small mb-4">You haven't placed any orders yet.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold">
                    Start Shopping
                </a>
            </div>
        @endforelse
    </div>
@endsection
