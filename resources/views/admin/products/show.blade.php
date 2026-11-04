@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- Header & Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">Product Details</h4>
        <div class="d-flex gap-2">
            <!-- Slug ဖြင့် Edit သို့ သွားရန် -->
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm fw-semibold px-3 py-2 text-dark">
                <i class="fa-solid fa-pen-to-square me-1"></i> Edit Product
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold px-3 py-2">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Details Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <!-- Product Image Column -->
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded shadow-sm border p-2 bg-white img-fluid" style="max-height: 350px; width: 100%; object-fit: cover;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="height: 300px;">
                            <span class="text-muted"><i class="fa-solid fa-image fa-2x mb-2"></i><br>No Image Available</span>
                        </div>
                    @endif
                </div>

                <!-- Product Information Column -->
                <div class="col-md-8">
                    <div class="d-flex gap-2 mb-2">
                        <span class="badge bg-info text-dark bg-opacity-10 text-info fw-semibold px-3 py-1">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>

                        @if($product->gender == 'men')
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 fw-semibold">Men</span>
                        @elseif($product->gender == 'women')
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-1 fw-semibold">Women</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 fw-semibold">Unisex</span>
                        @endif
                    </div>

                    <h2 class="fw-bold text-dark mb-3">{{ $product->name }}</h2>

                    <h3 class="text-success fw-bold mb-3">${{ number_format($product->price, 2) }}</h3>

                    <div class="mb-3">
                        <span class="fw-semibold text-secondary">Stock Status: </span>
                        @php
                            $stock = $product->inventory->stock_quantity ?? 0;
                        @endphp

                        @if ($stock == 0)
                            <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Out of Stock</span>
                        @elseif ($stock < 3)
                            <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">{{ $stock }} left stock</span>
                        @else
                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">{{ $stock }} in stock</span>
                        @endif
                    </div>

                    <hr class="text-muted opacity-25">

                    <div class="mb-4">
                        <h5 class="fw-semibold text-dark mb-2">Description</h5>
                        <p class="text-muted" style="line-height: 1.7;">
                            {{ $product->description ?? 'No description provided for this product.' }}
                        </p>
                    </div>

                    <div class="text-muted small">
                        <p class="mb-1"><i class="fa-regular fa-clock me-1"></i> Created At: {{ $product->created_at->format('M d, Y - h:i A') }}</p>
                        <p class="mb-0"><i class="fa-solid fa-rotate me-1"></i> Last Updated: {{ $product->updated_at->format('M d, Y - h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
