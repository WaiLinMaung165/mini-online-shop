@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- Header & Add Category Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark mb-0">Categories Management</h4>
            @can('categories.create')
                <a href="{{ route('admin.categories.create') }}" class="btn btn-warning btn-sm fw-semibold px-3 py-2">
                    <i class="fa-solid fa-plus-circle me-1"></i>Add Category
                </a>
            @endcan
        </div>

        <!-- Success Alert Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm py-2" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Categories Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary fw-semibold">
                            <tr>
                                <th class="py-3 ps-4">Category Name</th>
                                <th class="py-3">URL Slug</th>
                                <th class="py-3">Description</th>
                                <th class="py-3">Created At</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <!-- Category Name -->
                                    <td class="ps-4 fw-bold text-dark">
                                        {{ $category->name }}
                                    </td>

                                    <!-- URL Slug -->
                                    <td>
                                        <code class="text-primary bg-light px-2 py-1 rounded">{{ $category->slug }}</code>
                                    </td>

                                    <!-- Description -->
                                    <td class="text-muted text-truncate" style="max-width: 250px;">
                                        {{ Str::limit($category->description, 35) ?? '-' }}
                                    </td>

                                    <!-- Created At -->
                                    <td class="text-muted small">
                                        {{ $category->created_at->format('M d, Y') }}
                                    </td>

                                    <!-- Action Icons (View, Edit, Delete) -->
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <!-- View Detail Icon -->
                                            <a href="{{ route('admin.categories.show', $category->id) }}"
                                                class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <!-- Edit Icon -->
                                            @can('categories.edit')
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Edit Category">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endcan

                                            <!-- Delete Form & Icon -->
                                            @can('categories.delete')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger px-2 py-1 delete-btn"
                                                    data-url="{{ route('admin.categories.destroy', $category->id) }}"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary opacity-50"></i>
                                        <p class="mb-1">No categories found.</p>
                                        <a href="{{ route('admin.categories.create') }}"
                                            class="btn btn-sm btn-warning mt-2">Create First Category</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Footer -->
            @if ($categories->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>
@endsection
