<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Ruiz - Watch Store')</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Goudy+Bookletter+1911&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Domine:wght@400..700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&display=swap');

        :root {
            --accent-gold: #ffc107;
            --accent-gold-dark: #d5b531;
            --bg-color: #0d1b2a;
            --text-muted: #888888;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        .header-main {
            background: var(--bg-color);
            padding: 20px 0;
        }

        .brand-logo {
            font-weight: 700;
            font-size: 32px;
            color: var(--accent-gold);
            text-decoration: none;
        }

        .brand-logo span {
            color: #ffffff;
        }

        .main-nav-menu .nav-link {
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 10px 15px;
            transition: 0.3s;
        }

        .main-nav-menu .nav-link:hover {
            color: var(--accent-gold) !important;
        }

        body {
            padding-top: 30px;
        }

        @media (max-width: 991px) {
            body {
                padding-top: 130px;
            }
        }

        .hero-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #333;
            min-height: calc(100vh - 30px);
            display: flex;
            align-items: center;
            padding: 40px 0;
            position: relative;
        }

        @media (max-width: 991px) {
            .hero-section {
                min-height: auto;
                padding: 60px 0;
            }
        }

        .header-icons a {
            color: #ffffff;
            font-size: 20px;
            position: relative;
            text-decoration: none;
        }

        .header-icons a:hover {
            color: var(--accent-gold);
        }

        .header-icons .badge-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background-color: var(--accent-gold-dark);
            color: #fff;
            font-size: 11px;
            font-weight: bold;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-auth-login,
        .btn-auth-register {
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 2px 8px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-auth-login {
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background-color: transparent;
        }

        .btn-auth-login:hover {
            color: #000;
            background-color: #000;
        }

        .btn-auth-register {
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background-color: transparent;
        }

        .btn-auth-register:hover {
            color: #000;
            color: #0d1b2a;
        }

        .hero-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #333;
            padding: 130px 0;
            margin-top: 0px;
            position: relative;
        }

        .footer-main {
            background-color: #191919;
            color: #aaaaaa;
            font-size: 13px;
            padding-top: 60px;
            padding-bottom: 30px;
        }

        .footer-title {
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 25px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #aaaaaa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--accent-gold);
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            background-color: #252525;
            color: #fff;
            border-radius: 4px;
            margin-right: 6px;
            text-decoration: none;
        }

        .social-icons a:hover {
            background-color: var(--accent-gold);
        }

        .copyright-bar {
            background-color: #111111;
            color: #777;
            font-size: 12px;
            padding: 20px 0;
            border-top: 1px solid #222;
        }

        .custom-watch-btn {
            background-color: #111;
            border: 1px solid #111;
            color: #fff;
            border-radius: 0px;
        }

        .custom-watch-btn:hover {
            background-color: #333;
            border-color: #333;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
</head>

<body>
    <!-- Header -->
    @include('layouts.header')

    @guest
        @include('layouts.banner')
    @endguest
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @guest
        @include('layouts.footer')
    @endguest

    <!-- ========================================== -->
    <!-- GLOBAL LOGIN & REGISTER MODALS             -->
    <!-- ========================================== -->

    <!-- 1. Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-0" style="font-family: 'Crimson Text', serif;">
                    <h3 class="text-center mb-4">Welcome Back</h3>

                    {{-- <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-3">{{ session('status') }}</div>
                    @endif

                    <!-- General Login Error (အကယ်၍ ရှိပါက) -->
                    @if ($errors->has('email') && !old('name') && $errors->first('email'))
                        <div class="alert alert-danger py-2 mb-3" style="font-size: 14px;">
                            {{ $errors->first('email') }}
                        </div>
                    @endif --}}

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3 text-start">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3 text-start">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check text-start">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2">Login</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                            data-bs-target="#registerModal" data-bs-dismiss="modal">
                            Don't have an account? Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-0" style="font-family: 'Crimson Text', serif;">
                    <h3 class="text-center mb-4">Create Account</h3>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3 text-start">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3 text-start">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('name') ? old('email') : '' }}" required>
                            @error('email')
                                @if (old('name') || old('phone'))
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @endif
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3 text-start">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3 text-start">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3 text-start">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal"
                            data-bs-target="#loginModal" data-bs-dismiss="modal">
                            Already have an account? Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        @if (($errors->has('email') && !old('name')) || $errors->has('password'))
            @if (!old('name') && empty(old('phone')))
                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            @endif
        @endif

        @if ($errors->has('name') || $errors->has('phone') || ($errors->has('email') && old('name')))
            var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
            registerModal.show();
        @endif
    });
    const allModals = document.querySelectorAll('.modal');
    allModals.forEach(modal => {
        let isSubmittedOrClosedExplicitly = false;

        const closeButtons = modal.querySelectorAll('[data-bs-dismiss="modal"]');
        closeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                isSubmittedOrClosedExplicitly = true;
            });
        });

        modal.addEventListener('hidden.bs.modal', function() {
            if (window.location.pathname.includes('/cart') || window.location.pathname.includes('/checkout')) {
                return;
            }

            if (isSubmittedOrClosedExplicitly || window.location.search.length > 0) {
                window.location.href = "{{ route('shop.index') }}";
            }
        });
    });
</script>
</body>

</html>
