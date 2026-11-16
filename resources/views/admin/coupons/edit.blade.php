@extends('layouts.admin')
@section('title', 'Edit Coupon - Admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-pen-to-square me-2 text-primary"></i> Edit Coupon
                    </h2>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Coupon Code -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Coupon Code</label>
                            <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="form-control @error('code') is-invalid @enderror" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Discount Type -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Discount Type</label>
                            <select name="type" class="form-select">
                                <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                            </select>
                        </div>

                        <!-- Value -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Value</label>
                            <input type="number" step="0.01" name="value" value="{{ old('value', $coupon->value) }}" class="form-control @error('value') is-invalid @enderror" required>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Minimum Spend -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Minimum Spend (Optional)</label>
                            <input type="number" step="0.01" name="min_spend" value="{{ old('min_spend', $coupon->min_spend) }}" class="form-control">
                        </div>

                        <!-- Expiry Date -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Expiry Date (Optional)</label>
                            <input type="datetime-local" name="expires_at" value="{{ old('expires_at', $coupon->expires_at ? date('Y-m-d\TH:i', strtotime($coupon->expires_at)) : '') }}" class="form-control">
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light px-4 rounded-pill">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm">
                                <i class="fa-solid fa-sync me-1"></i> Update Coupon
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
