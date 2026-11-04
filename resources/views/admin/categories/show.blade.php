@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- Header & Back Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark mb-0">Category Details</h4>
            <div class="d-flex gap-2">
                @can('categories.edit')
                    <a href="{{ route('admin.categories.edit', $category) }}"
                        class="btn btn-primary btn-sm fw-semibold px-3 py-2">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                    </a>
                @endcan
                <a href="{{ route('admin.categories.index') }}"
                    class="btn btn-outline-secondary btn-sm fw-semibold px-3 py-2">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Details Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- ID -->
                    {{-- <div class="col-md-12">
                    <span class="text-uppercase text-muted small fw-bold d-block mb-1">Category ID</span>
                    <h5 class="text-dark fw-semibold">#{{ $category->id }}</h5>
                </div>

                <hr class="text-secondary opacity-25 my-1"> --}}

                    <!-- Name -->
                    <div class="col-md-6">
                        <span class="text-uppercase text-muted small fw-bold d-block mb-1">Category Name</span>
                        <h4 class="text-dark fw-bold mb-0">{{ $category->name }}</h4>
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6">
                        <span class="text-uppercase text-muted small fw-bold d-block mb-1">Slug</span>
                        <code class="fs-6 text-primary bg-light px-3 py-1 rounded">{{ $category->slug }}</code>
                    </div>

                    <hr class="text-secondary opacity-25 my-1">

                    <!-- Description -->
                    <div class="col-md-12">
                        <span class="text-uppercase text-muted small fw-bold d-block mb-1">Description</span>
                        <p class="text-secondary bg-light p-3 rounded mb-0" style="min-height: 100px; line-height: 1.6;">
                            {{ $category->description ?: 'No description provided for this category.' }}
                        </p>
                    </div>

                    <hr class="text-secondary opacity-25 my-1">

                    <!-- Timestamps -->
                    <div class="col-md-6">
                        <span class="text-uppercase text-muted small fw-bold d-block mb-1">Created At</span>
                        <span class="text-dark fw-semibold">
                            <i class="fa-regular fa-calendar-days me-1 text-secondary"></i>
                            {{ $category->created_at->format('M d, Y - h:i A') }}
                        </span>
                    </div>

                    <div class="col-md-6">
                        <span class="text-uppercase text-muted small fw-bold d-block mb-1">Last Updated</span>
                        <span class="text-dark fw-semibold">
                            <i class="fa-solid fa-clock-rotate-left me-1 text-secondary"></i>
                            {{ $category->updated_at->format('M d, Y - h:i A') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
