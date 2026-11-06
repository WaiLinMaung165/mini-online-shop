@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4">Add Payment Method</h3>

    <div class="card border-0 shadow-sm rounded-4 col-md-8">
        <div class="card-body p-4">
            <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Payment Name (e.g. KBZ Pay, Wave Pay)</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Account Name</label>
                    <input type="text" name="account_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Account Number / Phone</label>
                    <input type="text" name="account_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">QR Code Image (Optional)</label>
                    <input type="file" name="qr_image" class="form-control">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" checked>
                    <label class="form-check-label" for="isActive">Is Active</label>
                </div>
                <button type="submit" class="btn btn-success px-4">Save Payment Method</button>
                <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
