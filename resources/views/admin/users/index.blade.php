@extends('layouts.admin')

@section('title', 'Users Management - Ruiz Admin')

@section('content')
    <div class="container-fluid px-4 py-3">

        <!-- Page Header & Add User Button -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-dark mb-1">Users Management</h4>
                <p class="text-muted small mb-0">Manage system users and their assigned roles.</p>
            </div>
            {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-warning fw-semibold text-dark px-3 py-2 shadow-sm">
                <i class="fa-solid fa-user-plus me-1"></i> Add New User
            </a> --}}
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm py-2" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Users Table List Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-dark mb-0 fs-6">
                    <i class="fa-solid fa-users me-1 text-primary"></i> System Users List
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="py-3">Name</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Role</th>
                                <th class="py-3 text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="py-3 fw-semibold text-dark">{{ $user->name }}</td>
                                    <td class="py-3 text-muted">{{ $user->email }}</td>
                                    <td class="py-3">
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-light text-dark border px-3 py-2 fw-bold text-uppercase">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="text-end pe-3 py-3">
                                        <div class="d-flex justify-content-end gap-1">
                                            <!-- Edit Button -->
                                            @if ($user->id !== 1)
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-outline-primary px-2 py-1" title="Edit User">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endif
                                            <!-- Delete Button -->
                                            @if ($user->id !== auth()->id())
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger px-2 py-1 delete-btn"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                    data-url="{{ route('admin.users.destroy', $user->id) }}"
                                                    title="Delete User">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted fst-italic">
                                        No users found.
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
