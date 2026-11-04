@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- Header & Add Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark mb-0">Manage Products</h4>
            @can('products.create')
                <a href="{{ route('admin.products.create') }}" class="btn btn-warning fw-semibold px-3 py-2">
                    <i class="fa-solid fa-plus me-1"></i> Add Product
                </a>
            @endcan
        </div>

        <!-- Products Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-7">
                            <tr>
                                <th class="py-3" style="width: 12%;">Image</th>
                                <th class="py-3" style="width: 22%;">Product Name</th>
                                <th class="py-3" style="width: 15%;">Category</th>
                                <th class="py-3" style="width: 12%;">Gender</th>
                                <th class="py-3" style="width: 12%;">Price</th>
                                <th class="py-3" style="width: 12%;">Stock</th>
                                <th class="py-3 text-center" style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $key => $product)
                                <tr>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                                class="rounded shadow-sm"
                                                style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <span class="badge bg-light text-secondary border px-2 py-2">No Image</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">
                                        {{ $product->name }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark bg-opacity-10 text-info fw-semibold px-2 py-1">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($product->gender == 'men')
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">Men</span>
                                        @elseif($product->gender == 'women')
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Women</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">Unisex</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-success">
                                        ${{ number_format($product->price, 2) }}
                                    </td>
                                    <td>
                                        @php
                                            $stock = $product->inventory->stock_quantity ?? 0;
                                        @endphp

                                        @if ($stock == 0)
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">
                                                Out of Stock
                                            </span>
                                        @elseif ($stock < 3)
                                            <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">
                                                {{ $stock }} left stock
                                            </span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">
                                                {{ $stock }} in stock
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- View Button (Slug based) -->
                                            <a href="{{ route('admin.products.show', $product) }}"
                                                class="btn btn-sm btn-outline-info px-2 py-1" title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <!-- Edit Button (Slug based) -->
                                            @can('products.edit')
                                                <a href="{{ route('admin.products.edit', $product) }}"
                                                    class="btn btn-sm btn-outline-primary px-2 py-1" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endcan

                                            <!-- Delete Button (Slug based) -->
                                            @can('products.delete')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger px-2 py-1 delete-btn"
                                                    data-url="{{ route('admin.products.destroy', $product) }}"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-box-open fs-3 mb-2 d-block text-secondary opacity-50"></i>
                                        No products found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Links (Bootstrap 5) -->
            @if ($products->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>
@endsection
