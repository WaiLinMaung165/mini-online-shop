@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Payment Methods Management</h3>
        <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Add New Payment Method
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Account Name</th>
                            <th>Account Number</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paymentMethods as $method)
                        <tr>
                            <td class="fw-bold">{{ $method->name }}</td>
                            <td>{{ $method->account_name }}</td>
                            <td>{{ $method->account_number }}</td>
                            <td>
                                @if($method->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.payment-methods.edit', $method->id) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No payment methods found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $paymentMethods->links() }}
        </div>
    </div>
</div>
@endsection
