@extends('layouts.admin')

@section('title', 'Edit Permissions Assignment - Ruiz Admin')

@section('content')
    <div class="container-fluid px-4 py-3">

        <div class="mb-4 text-center">
            <h4 class="fw-bold text-dark mb-1">Edit Permissions for <span class="text-primary text-uppercase">{{ $role->name }}</span></h4>
            <p class="text-muted small mb-0">Update module permissions for this system role using cards.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.permissions.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Selected Role Display (Disabled) -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary small">Target Role</label>
                                <input type="text" class="form-control bg-light fw-bold text-uppercase" value="{{ $role->name }}" disabled>
                            </div>

                            <!-- Module Cards with "Select All" Checkboxes -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary small mb-3">Module Permissions (Select by Cards)</label>

                                <div class="row g-3">

                                    <!-- 1. Category Module -->
                                    <div class="col-md-6">
                                        <div class="card border shadow-sm h-100">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center fw-bold text-dark">
                                                <span><i class="fa-solid fa-folder-open me-1 text-warning"></i> Category Module</span>
                                                <div class="form-check m-0">
                                                    <input class="form-check-input select-all-module" type="checkbox" id="selectAllCategory" data-target="category-perms">
                                                    <label class="form-check-label small text-muted fw-normal" for="selectAllCategory">Select All</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach($permissions->filter(fn($p) => str_contains($p->name, 'category') || str_contains($p->name, 'categories')) as $permission)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input category-perms permission-checkbox" type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                                            {{ $role->hasPermissionTo($permission->name) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                                        <label class="form-check-label small text-dark" for="perm_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. Watch / Product Module -->
                                    <div class="col-md-6">
                                        <div class="card border shadow-sm h-100">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center fw-bold text-dark">
                                                <span><i class="fa-solid fa-clock me-1 text-primary"></i> Watch / Product Module</span>
                                                <div class="form-check m-0">
                                                    <input class="form-check-input select-all-module" type="checkbox" id="selectAllProduct" data-target="product-perms">
                                                    <label class="form-check-label small text-muted fw-normal" for="selectAllProduct">Select All</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach($permissions->filter(fn($p) => str_contains($p->name, 'product') || str_contains($p->name, 'watch')) as $permission)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input product-perms permission-checkbox" type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                                            {{ $role->hasPermissionTo($permission->name) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                                        <label class="form-check-label small text-dark" for="perm_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3. Order Module -->
                                    <div class="col-md-6">
                                        <div class="card border shadow-sm h-100">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center fw-bold text-dark">
                                                <span><i class="fa-solid fa-bag-shopping me-1 text-success"></i> Order Module</span>
                                                <div class="form-check m-0">
                                                    <input class="form-check-input select-all-module" type="checkbox" id="selectAllOrder" data-target="order-perms">
                                                    <label class="form-check-label small text-muted fw-normal" for="selectAllOrder">Select All</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach($permissions->filter(fn($p) => str_contains($p->name, 'order')) as $permission)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input order-perms permission-checkbox" type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                                            {{ $role->hasPermissionTo($permission->name) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                                        <label class="form-check-label small text-dark" for="perm_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 4. User Module -->
                                    <div class="col-md-6">
                                        <div class="card border shadow-sm h-100">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center fw-bold text-dark">
                                                <span><i class="fa-solid fa-users me-1 text-info"></i> User Module</span>
                                                <div class="form-check m-0">
                                                    <input class="form-check-input select-all-module" type="checkbox" id="selectAllUser" data-target="user-perms">
                                                    <label class="form-check-label small text-muted fw-normal" for="selectAllUser">Select All</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach($permissions->filter(fn($p) => str_contains($p->name, 'user')) as $permission)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input user-perms permission-checkbox" type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                                            {{ $role->hasPermissionTo($permission->name) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                                        <label class="form-check-label small text-dark" for="perm_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 5. Support Module -->
                                    <div class="col-md-6">
                                        <div class="card border shadow-sm h-100">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center fw-bold text-dark">
                                                <span><i class="fa-solid fa-headset me-1 text-danger"></i> Support Module</span>
                                                <div class="form-check m-0">
                                                    <input class="form-check-input select-all-module" type="checkbox" id="selectAllSupport" data-target="support-perms">
                                                    <label class="form-check-label small text-muted fw-normal" for="selectAllSupport">Select All</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach($permissions->filter(fn($p) => str_contains($p->name, 'support')) as $permission)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input support-perms permission-checkbox" type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                                            {{ $role->hasPermissionTo($permission->name) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                                        <label class="form-check-label small text-dark" for="perm_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 6. General Permissions -->
                                    <div class="col-md-6">
                                        <div class="card border shadow-sm h-100">
                                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center fw-bold text-dark">
                                                <span><i class="fa-solid fa-shield-halved me-1 text-secondary"></i> General Permissions</span>
                                                <div class="form-check m-0">
                                                    <input class="form-check-input select-all-module" type="checkbox" id="selectAllGeneral" data-target="general-perms">
                                                    <label class="form-check-label small text-muted fw-normal" for="selectAllGeneral">Select All</label>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @foreach($permissions->filter(fn($p) => !str_contains($p->name, 'category') && !str_contains($p->name, 'categories') && !str_contains($p->name, 'product') && !str_contains($p->name, 'watch') && !str_contains($p->name, 'order') && !str_contains($p->name, 'user') && !str_contains($p->name, 'support')) as $permission)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input general-perms permission-checkbox" type="checkbox" name="permissions[]"
                                                            value="{{ $permission->name }}" id="perm_{{ $permission->id }}"
                                                            {{ $role->hasPermissionTo($permission->name) || (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) ? 'checked' : '' }}>
                                                        <label class="form-check-label small text-dark" for="perm_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-light px-4 py-2">Cancel</a>
                                <button type="submit" class="btn btn-primary fw-semibold px-4 py-2">
                                    <i class="fa-solid fa-sync me-1"></i> Update Assignment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JavaScript for Select All Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllBoxes = document.querySelectorAll('.select-all-module');

            selectAllBoxes.forEach(function (selectAllBox) {
                const targetClass = selectAllBox.getAttribute('data-target');
                const checkboxes = document.querySelectorAll('.' + targetClass);

                // Initial state check on page load
                checkSelectAllState(selectAllBox, checkboxes);

                // When Select All changes
                selectAllBox.addEventListener('change', function () {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = selectAllBox.checked;
                    });
                });

                // When individual checkbox changes
                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        checkSelectAllState(selectAllBox, checkboxes);
                    });
                });
            });

            function checkSelectAllState(selectAllBox, checkboxes) {
                let allChecked = true;
                checkboxes.forEach(function (checkbox) {
                    if (!checkbox.checked) {
                        allChecked = false;
                    }
                });
                selectAllBox.checked = allChecked && checkboxes.length > 0;
            }
        });
    </script>
@endsection
