@extends('layouts.admin')
@section('title', 'Manage Coupons - Admin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">
                <i class="fa-solid fa-gift me-2 text-primary"></i> Manage Coupons
            </h2>

            <!-- Add New Coupon Button -->
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Add New Coupon
            </a>
        </div>

        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}

        <!-- Coupons Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Min Spend</th>
                            <th>Expires At</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr>
                                <td class="fw-bold text-dark">{{ $coupon->code }}</td>
                                <td class="capitalize">{{ $coupon->type }}</td>
                                <td class="fw-bold text-success">
                                    {{ $coupon->type == 'percent' ? $coupon->value . '%' : '$' . number_format($coupon->value, 2) }}
                                </td>
                                <td>
                                    {{ $coupon->min_spend ? '$' . number_format($coupon->min_spend, 2) : '-' }}
                                </td>
                                <td class="small">
                                    @if ($coupon->expires_at)
                                        @if (\Carbon\Carbon::now()->greaterThan($coupon->expires_at))
                                            <span class="text-danger fw-bold">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> Expired
                                                <span class="text-muted d-block"
                                                    style="font-size: 11px;">({{ $coupon->expires_at->format('d M Y, h:i A') }})</span>
                                            </span>
                                        @else
                                            <span class="text-dark">{{ $coupon->expires_at->format('d M Y, h:i A') }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">Never</span>
                                    @endif
                                </td>
                                <td class="text-end space-x-1">
                                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="fa-solid fa-pen-to-square me-1"></i>
                                    </a>

                                    <!-- Delete Form with SweetAlert -->
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)"
                                            class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fa-solid fa-trash me-1"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No coupons found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $coupons->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Delete Confirmation Alert
        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }
    </script>
@endsection
