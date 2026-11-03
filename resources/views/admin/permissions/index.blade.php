@extends('layouts.admin')

@section('title', 'Permissions Assignment - Ruiz Admin')

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- Page Header & Create Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-dark mb-1">Permissions Management</h4>
                <p class="text-muted small mb-0">Manage role-based module permissions.</p>
            </div>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-warning fw-semibold text-dark px-3 py-2 shadow-sm">
                <i class="fa-solid fa-plus-circle me-1"></i> Assign Permissions
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm py-2" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Roles & Permissions Matrix Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0 fs-6">
                    <i class="fa-solid fa-shield-halved me-1 text-primary"></i> Roles & Assigned Permissions
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="py-3 ps-3">Role Name</th>
                                <th class="py-3">Permissions Assigned</th>
                                <th class="py-3 text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td class="ps-3 py-3">
                                        <span class="badge bg-light text-dark border px-3 py-2 fw-bold text-uppercase">
                                            {{ $role->name }}
                                        </span>
                                        @if ($role->name === 'admin')
                                            <span class="badge bg-danger text-white ms-1 small">Protected</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse($role->permissions as $perm)
                                                <span class="badge bg-secondary text-white font-monospace small" style="font-size: 11px;">
                                                    {{ $perm->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted small fst-italic">No permissions assigned</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="text-end pe-3 py-3">
                                        @if ($role->name !== 'admin')
                                            <div class="d-flex justify-content-end gap-1">
                                                <a href="{{ route('admin.permissions.edit', $role->id) }}"
                                                    class="btn btn-sm btn-outline-primary px-2 py-1" title="Edit Permissions">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">Protected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted fst-italic">
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
@endsection
