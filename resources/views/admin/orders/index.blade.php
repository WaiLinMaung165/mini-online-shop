@extends('layouts.admin')
@section('title', 'Manage Orders - Admin')

@section('content')
    <div class="container-fluid py-4">
        <h2 class="fw-bold text-dark mb-4">
            <i class="fa-solid fa-clipboard-list me-2 text-warning"></i> Customer Orders Management
        </h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Phone / Address</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="fw-bold text-dark">{{ $order->order_code }}</td>
                                <td>{{ $order->user->name ?? 'Guest' }}</td>
                                <td>
                                    <span class="d-block small">{{ $order->phone }}</span>
                                    <span class="text-muted small text-truncate d-inline-block" style="max-width: 150px;">{{ $order->shipping_address }}</span>
                                </td>
                                <td class="fw-bold text-success">${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @if($order->status == 'Pending')
                                        <span class="badge bg-warning text-dark px-2 py-1">Pending</span>
                                    @elseif($order->status == 'Approved')
                                        <span class="badge bg-info text-dark px-2 py-1">Approved</span>
                                    @elseif($order->status == 'Completed')
                                        <span class="badge bg-success px-2 py-1">Completed</span>
                                    @else
                                        <span class="badge bg-danger px-2 py-1">Cancelled</span>
                                    @endif
                                </td>
                                <td class="small text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        <i class="fa-solid fa-eye me-1"></i> Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
