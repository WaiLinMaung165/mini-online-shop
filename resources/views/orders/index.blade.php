@extends('layouts.shop')

@section('title', 'My Orders - Ruiz Watches')

@section('content')
    <div class="container py-5" style="margin-top: 40px; font-family: 'Domine', serif;">
        <h2 class="fw-bold text-dark mb-4">
            <i class="fa-solid fa-box-archive me-2 text-warning"></i> My Order History
        </h2>

        @forelse($orders as $order)
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-5 bg-white position-relative overflow-hidden"
                style="border-left: 5px solid
                    @if ($order->status == 'Pending') #ffc107
                    @elseif($order->status == 'Approved') #0dcaf0
                    @elseif($order->status == 'Shipped') #0d6efd
                    @elseif($order->status == 'Completed') #198754
                    @else #dc3546 @endif !important;">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 border-bottom pb-3">
                    <div>
                        <span class="fw-bold text-dark fs-5">{{ $order->order_code }}</span>
                        <span class="text-muted small ms-2">({{ $order->created_at->format('d M Y, h:i A') }})</span>
                    </div>
                    <div>
                        @if ($order->status == 'Pending')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">Pending
                                Confirmation</span>
                        @elseif($order->status == 'Approved')
                            <span class="badge bg-info text-dark px-3 py-2 rounded-pill shadow-sm">Approved</span>
                        @elseif($order->status == 'Shipped')
                            <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">Shipped</span>
                        @elseif($order->status == 'Completed')
                            <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm">Completed</span>
                        @else
                            <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">{{ $order->status }}</span>
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
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    class="rounded-3 border"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border"
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

                <!-- Phone/Address & Calculation Summary -->
                <div class="mt-3 pt-3">
                    <div class="row align-items-center">
                        <div class="col-md-7 small text-muted mb-2 mb-md-0">
                            <span><strong>Phone:</strong> {{ $order->phone }}</span> |
                            <span><strong>Address:</strong> {{ $order->shipping_address }}</span>
                        </div>
                        <div class="col-md-5">
                            @php
                                $itemSubtotal = $order->orderItems->sum(fn($i) => $i->price * $i->quantity);
                                $calculatedDiscount = $itemSubtotal - $order->total_amount;
                            @endphp

                            @if ($calculatedDiscount > 0)
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Subtotal:</span>
                                    <span class="fw-bold text-dark">${{ number_format($itemSubtotal, 2) }}</span>
                                </div>

                                <div class="d-flex justify-content-between small text-success mb-1 border-bottom">
                                    <span>Discount:</span>
                                    <span class="fw-bold">-${{ number_format($calculatedDiscount, 2) }}</span>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center pt-1">
                                <span class="text-muted small fw-semibold">Grand Total:</span>
                                <h5 class="fw-bold text-success mb-0">${{ number_format($order->total_amount, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Row (Placed Below Total Amount) -->
                <div class="d-flex justify-content-end align-items-center gap-2 mt-3 pt-2">
                    {{-- PDF Invoice Download Button --}}
                    @if (!($order->status == 'Pending'))
                        <a href="{{ route('order.invoice', $order->id) }}" target="_self"
                            class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="fa-solid fa-file-pdf me-1 text-danger"></i> Invoice Download
                        </a>
                    @endif

                    {{-- Order Received Button (Shows only when Shipped) --}}
                    @if ($order->status == 'Shipped')
                        <form id="receive-form-{{ $order->id }}" action="{{ route('order.received', $order->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            <button type="button"
                                class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-semibold shadow-sm"
                                onclick="confirmReceive({{ $order->id }})">
                                <i class="fa-solid fa-check-circle me-1"></i> Order Received
                            </button>
                        </form>
                    @endif
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

    <script>
        function confirmReceive(orderId) {
            Swal.setItem ? null : null;
            Swal.fire({
                title: 'Are you sure?',
                text: "Have you received the item yet? Please confirm.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, I received it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('receive-form-' + orderId).submit();
                }
            });
        }
    </script>
@endsection
