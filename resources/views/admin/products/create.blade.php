@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- Header & Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">Add New Product</h4>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold px-3 py-2">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to List
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
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12 mb-3 text-center">
                        <img id="imagePreview" src="#" alt="Preview" class="rounded shadow-sm d-none border p-1 bg-white mx-auto" style="width: 300px; height: 300px; object-fit: cover;">
                    </div>

                    <!-- Row 1: Product Name & Product Image -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-semibold text-secondary">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Rolex Submariner" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label fw-semibold text-secondary">Product Image</label>
                        <span class="form-text text-muted small">Allowed formats: jpeg, png, jpg, webp (Max: 2MB)</span>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Row 3: Category Selection -->
                    <div class="col-md-12 mb-3">
                        <label for="category_id" class="form-label fw-semibold text-secondary">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="" selected disabled>Select Category</option>
                            {{-- @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach --}}
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Row 3: Price & Stock Quantity -->
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label fw-semibold text-secondary">Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="stock_quantity" class="form-label fw-semibold text-secondary">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" placeholder="0" required>
                        @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Row 4: Description -->
                    <div class="col-md-12 mb-4">
                        <label for="description" class="form-label fw-semibold text-secondary">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter watch features, movement type, strap material, etc.">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning fw-semibold px-4">
                        <i class="fa-solid fa-save me-1"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function previewImage(event){
        const reader = new FileReader();
        const imagePreview = document.getElementById('imagePreview');

        reader.onload = function(){
            imagePreview.src = reader.result;
            imagePreview.classList.remove('d-none');
        }
        if(event.target.files[0]){
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
