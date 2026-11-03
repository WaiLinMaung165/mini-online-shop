@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- Header & Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">Add New Category</h4>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold px-3 py-2">
            <i class="fa-solid fa-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <!-- Validation Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm py-2" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>Please fix the following errors:
            <ul class="mb-0 mt-1 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <!-- Category Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold text-secondary">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Luxury Watches" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold text-secondary">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning fw-semibold px-4">
                        <i class="fa-solid fa-save me-1"></i>Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
