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


    <!-- CSS Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Goudy+Bookletter+1911&display=swap');

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

    @include('layouts.banner')
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
