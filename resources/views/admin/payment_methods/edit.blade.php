@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4">Edit Payment Method</h3>

    <div class="row justify-content-center">
        <div class="card border-0 shadow-sm rounded-4 col-md-8">
            <div class="card-body p-4">
                <form action="{{ route('admin.payment_methods.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Payment Name -->
                    <div class="mb-3">
                        <label class="form-label">Payment Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $paymentMethod->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Account Name -->
                    <div class="mb-3">
                        <label class="form-label">Account Name</label>
                        <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror" value="{{ old('account_name', $paymentMethod->account_name) }}" required>
                        @error('account_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Account Number / Phone -->
                    <div class="mb-3">
                        <label class="form-label">Account Number / Phone</label>
                        <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" value="{{ old('account_number', $paymentMethod->account_number) }}" required>
                        @error('account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- QR Code Image -->
                    <div class="mb-3">
                        <label class="form-label">QR Code Image</label>
                        @if($paymentMethod->qr_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $paymentMethod->qr_image) }}" alt="QR" width="80" class="rounded shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="qr_image" class="form-control @error('qr_image') is-invalid @enderror">
                        @error('qr_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Active Checkbox -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Is Active</label>
                    </div>

                    <!-- Buttons -->
                    <button type="submit" class="btn btn-primary px-4">Update Payment Method</button>
                    <a href="{{ route('admin.payment_methods.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
