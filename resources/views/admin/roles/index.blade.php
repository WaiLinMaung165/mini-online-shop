@extends('layouts.admin')

@section('title', 'Roles Management - Ruiz Admin')

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- Page Header -->
        <div class="mb-4">
            <h4 class="fw-bold text-dark mb-1">Roles Management</h4>
            <p class="text-muted small mb-0">Create and manage system roles.</p>
        </div>

        <!-- Success & Error Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm py-2" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm py-2" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Side: Create or Edit Role Form -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold text-dark mb-0 fs-6">
                            @isset($roleToEdit)
                                <i class="fa-solid fa-pen-to-square me-1 text-primary"></i> Edit Role
                            @else
                                <i class="fa-solid fa-plus-circle me-1 text-warning"></i> Add New Role
                            @endisset
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form
                            action="{{ isset($roleToEdit) ? route('admin.roles.update', $roleToEdit->id) : route('admin.roles.store') }}"
                            method="POST">
                            @csrf
                            @isset($roleToEdit)
                                @method('PUT')
                            @endisset

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold text-secondary small">Role Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $roleToEdit->name ?? '') }}"
                                    placeholder="e.g. manager, cashier" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                @isset($roleToEdit)
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-light w-50 py-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary fw-semibold w-50 py-2">
                                        <i class="fa-solid fa-sync me-1"></i> Update
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-warning fw-semibold text-dark w-100 py-2">
                                        <i class="fa-solid fa-save me-1"></i> Save Role
                                    </button>
                                @endisset
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Side: Roles Table List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold text-dark mb-0 fs-6">
                            <i class="fa-solid fa-list me-1 text-primary"></i> Roles List
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-secondary small text-uppercase">
                                    <tr>
                                        <th class="py-3">Role Name</th>
                                        <th class="py-3">Guard</th>
                                        <th class="py-3 text-end pe-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $role)
                                        <tr>
                                            <td>
                                                <span
                                                    class="badge bg-light text-dark border px-3 py-2 fw-bold text-uppercase">
                                                    {{ $role->name }}
                                                </span>
                                                @if ($role->name === 'admin')
                                                    <span class="badge bg-danger text-white ms-1 small">Protected</span>
                                                @endif
                                            </td>
                                            <td class="text-muted small">{{ $role->guard_name }}</td>
                                            <td class="text-end pe-3">
                                                @if ($role->name !== 'admin' && $role->name !== 'customer')
                                                    <div class="d-flex justify-content-end gap-1">
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                            class="btn btn-sm btn-outline-primary px-2 py-1"
                                                            title="Edit Role">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>

                                                        <!-- Delete Button with Global Modal Trigger -->
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger px-2 py-1 delete-btn"
                                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                            data-url="{{ route('admin.roles.destroy', $role->id) }}"
                                                            title="Delete Role">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-muted small fst-italic">Protected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted fst-italic">
                                                No roles found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
