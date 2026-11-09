<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ruiz - Admin Control Panel')</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Admin Styles matching Ruiz Theme -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');

        :root {
            --accent-gold: #ffc107;
            --accent-gold-dark: #d5b531;
            --bg-color: #7664ab;
            --sidebar-bg: #121041;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .custom-modal-font {
            font-family: 'Montserrat', sans-serif !important;
        }

        /* Brand Logo Style */
        .brand-logo {
            font-weight: 700;
            font-size: 28px;
            color: var(--accent-gold);
            text-decoration: none;
        }

        .brand-logo span {
            color: #ffffff;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .admin-sidebar .nav-link {
            color: #b0c4de;
            font-size: 15px;
            font-weight: 500;
            padding: 12px 18px;
            border-radius: 6px;
            transition: all 0.3s ease;
            margin-bottom: 5px;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 193, 7, 0.15);
            border-left: 4px solid var(--accent-gold);
        }

        /* Top Header Styling */
        .admin-header {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar p-3">
                <div class="text-center my-3">
                    <a href="{{ route('shop.index') }}" class="brand-logo">
                        <i class="fa-regular fa-clock me-1 text-gold"></i>ruiz<span>.</span>
                    </a>
                </div>

                <hr class="text-secondary opacity-50 my-3">

                <ul class="nav flex-column" style="font-family: 'PT Serif', serif;">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-line me-2"></i> Dashboard
                        </a>
                    </li>

                    <!-- Categories -->
                    @can('categories.index')
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-folder-plus me-2"></i> Manage Categories
                            </a>
                        </li>
                    @endcan

                    <!-- Manage Watches / Products (Placeholder route or active check) -->
                    @can('products.index')
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-plus me-2"></i></i> Manage Products
                            </a>
                        </li>
                    @endcan

                    <!-- Orders -->
                    @can('orders.index')
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-bag-shopping me-2"></i> Manage Orders
                            </a>
                        </li>
                    @endcan


                    @can('payment_methods.index')
                        <li class="nav-item">
                            <a href="{{ route('admin.payment_methods.index') }}" class="nav-link {{ request()->routeIs('admin.payment_methods.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-dollar-sign me-2"></i> Payment Method
                            </a>
                        </li>
                    @endcan

                    <!-- User Management Dropdown Menu -->
                    @can('users.index')
                        <li class="nav-item mb-1">
                            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') || request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#userManagementSubmenu" role="button"
                                aria-expanded="{{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') || request()->routeIs('admin.users.*') ? 'true' : 'false' }}"
                                aria-controls="userManagementSubmenu">
                                <span><i class="fa-solid fa-users me-2"></i> User Management</span>
                                <i class="fa-solid fa-chevron-down small"></i>
                            </a>

                            <!-- Submenu Items (Collapse) -->
                            <div class="collapse {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') || request()->routeIs('admin.users.*') ? 'show' : '' }} ps-3 mt-1"
                                id="userManagementSubmenu">
                                <ul class="nav flex-column border-start border-2 border-secondary ps-2">

                                    <!-- 1. Create Roles -->
                                    <li class="nav-item my-1">
                                        <a href="{{ route('admin.roles.index') }}"
                                            class="nav-link py-2 px-2 small {{ request()->routeIs('admin.roles.*') ? 'active text-warning fw-bold' : '' }}">
                                            <i class="fa-solid fa-circle-plus me-2"></i> Create Roles
                                        </a>
                                    </li>

                                    <!-- 2. Create Permission -->
                                    <li class="nav-item my-1">
                                        <a href="{{ route('admin.permissions.index') }}"
                                            class="nav-link py-2 px-2 small {{ request()->routeIs('admin.permissions.*') ? 'active text-warning fw-bold' : '' }}">
                                            <i class="fa-solid fa-shield-halved me-2"></i> Create Permission
                                        </a>
                                    </li>

                                    <!-- 3. Create User -->
                                    <li class="nav-item my-1">
                                        <a href="{{ route('admin.users.create') }}"
                                            class="nav-link py-2 px-2 small {{ request()->routeIs('admin.users.create') ? 'active text-warning fw-bold' : '' }}">
                                            <i class="fa-solid fa-user-plus me-2"></i> Create User
                                        </a>
                                    </li>

                                    <!-- 4. Users List -->
                                    <li class="nav-item my-1">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="nav-link py-2 px-2 small {{ request()->routeIs('admin.users.index') ? 'active text-warning fw-bold' : '' }}">
                                            <i class="fa-solid fa-user-group me-2"></i> Users List
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endcan
                </ul>

                <hr class="text-secondary opacity-50 my-4">

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="px-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm w-100 py-2 fw-semibold">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                    </button>
                </form>
            </nav>

            <!-- Main Content Area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4" style="font-family: 'Delius', cursive;">
                <div class="admin-header d-flex justify-content-between align-items-center p-3 mb-4 rounded-3">
                    <div class="d-flex align-items-center gap-2">
                        <h1 class="h4 mb-0 fw-bold text-dark">Admin Control Panel</h1>

                        @if (Auth::user() && Auth::user()->roles->isNotEmpty())
                            <span class="badge bg-warning text-dark text-uppercase px-2 py-1"
                                style="font-size: 11px; font-weight: 700;">
                                {{ Auth::user()->roles->pluck('name')->implode(', ') }}
                            </span>
                        @endif
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge text-white px-3 py-2 rounded-pill"
                            style="background-color: var(--sidebar-bg);">
                            <i class="fa-solid fa-user-shield me-1 text-warning"></i>
                            {{ Auth::user()->name ?? 'Admin' }}
                        </span>
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Global Delete Confirmation Modal (Bootstrap 5) -->
    <div class="modal fade custom-modal-font" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="deleteModalTitle">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 text-center">
                    <p class="mb-0 text-dark fw-semibold">Are you sure you want to delete this item?</p>
                    <small class="text-muted">This action cannot be undone.</small>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Success Notification Modal (Bootstrap 5) -->
    <div class="modal fade custom-modal-font" id="successModal" tabindex="-1" aria-labelledby="successModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalTitle">
                        <i class="fa-solid fa-circle-check me-1"></i> Success
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-4 text-center">
                    <p id="successMessage" class="mb-0 text-dark fw-semibold fs-5"></p>
                </div>
                <div class="modal-footer bg-light justify-content-center">
                    <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Hidden Session for Success Modal -->
    @if (session('success'))
        <div id="session-success" data-message="{{ session('success') }}" style="display: none;"></div>
    @endif

    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global JavaScript for Modals (Bootstrap 5 Native JS) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete Modal URL Binding
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    document.getElementById('deleteForm').setAttribute('action', url);
                });
            });

            // Auto-show Success Modal if session success exists using Bootstrap 5 JS
            const successElement = document.getElementById('session-success');
            if (successElement) {
                const message = successElement.getAttribute('data-message');
                document.getElementById('successMessage').textContent = message;

                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            }
        });
    </script>
</body>

</html>
