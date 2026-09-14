<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Blog')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ink: #252522;
            --muted: #77766f;
            --paper: #f7f6f2;
            --surface: #ffffff;
            --line: #e5e2da;
            --accent: #777b69;
            --accent-dark: #5f6352;
            --danger: #a2635b;
        }

        body {
            min-height: 100vh;
            background: var(--paper);
            color: var(--ink);
            font-family: "Segoe UI", Tahoma, sans-serif;
            letter-spacing: .01em;
        }

        .navbar {
            padding: 1rem 0;
            background: rgba(247, 246, 242, .94) !important;
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            color: var(--ink) !important;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .navbar-toggler {
            border-color: var(--line);
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .nav-link {
            margin-left: .5rem;
            padding: .45rem .8rem !important;
            color: var(--muted) !important;
            font-size: .92rem;
            border-radius: 999px;
            transition: .2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--ink) !important;
            background: #ebe9e2;
        }

        .page-shell {
            margin-top: 3rem;
            margin-bottom: 4rem;
            padding: clamp(1.4rem, 4vw, 3rem);
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 20px;
            box-shadow: 0 16px 45px rgba(42, 42, 36, .05);
        }

        h1, h2, h3, h4 {
            color: var(--ink);
            font-weight: 650;
            letter-spacing: -.025em;
        }

        h2 {
            margin-bottom: 1.5rem;
        }

        p {
            color: var(--muted);
            line-height: 1.8;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-hover-bg: #faf9f6;
            margin-bottom: 1.25rem;
            border-color: var(--line);
        }

        .table thead,
        .table-info {
            --bs-table-bg: #f1f0eb;
            --bs-table-color: var(--ink);
        }

        .table th {
            padding: .9rem 1rem;
            border-bottom-width: 1px;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .table td {
            padding: .85rem 1rem;
            vertical-align: middle;
        }

        .card {
            height: 100%;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: none;
        }

        .card-body {
            padding: 1.5rem;
        }

        .form-label,
        label {
            margin-bottom: .45rem;
            color: #55554f;
            font-size: .9rem;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            min-height: 46px;
            border-color: var(--line);
            border-radius: 10px;
            background-color: #fcfcfa;
        }

        textarea.form-control {
            min-height: 120px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 .2rem rgba(119, 123, 105, .12);
        }

        .btn {
            padding: .55rem 1rem;
            border-radius: 9px;
            font-weight: 600;
            font-size: .88rem;
            box-shadow: none !important;
        }

        .btn-dark,
        .btn-primary,
        .btn-success {
            color: #fff;
            background: var(--accent);
            border-color: var(--accent);
        }

        .btn-dark:hover,
        .btn-primary:hover,
        .btn-success:hover {
            background: var(--accent-dark);
            border-color: var(--accent-dark);
        }

        .btn-warning {
            color: #3d3300;
            background: #f2c94c;
            border-color: #f2c94c;
        }

        .btn-warning:hover {
            color: #302800;
            background: #dfb632;
            border-color: #dfb632;
        }

        .btn-secondary {
            color: var(--ink);
            background: #e9e6dd;
            border-color: #e9e6dd;
        }

        .btn-danger {
            background: var(--danger);
            border-color: var(--danger);
        }

        .btn-outline-success {
            color: #287a4b;
            border-color: #9dceb0;
            background: #eef8f1;
        }

        .btn-outline-success:hover {
            color: #fff;
            border-color: #287a4b;
            background: #287a4b;
        }

        .btn-outline-danger {
            color: #a23f3f;
            border-color: #dfaaaa;
            background: #fff1f1;
        }

        .btn-outline-danger:hover {
            color: #fff;
            border-color: #a23f3f;
            background: #a23f3f;
        }

        .pagination {
            gap: .35rem;
        }

        .page-link {
            min-width: 38px;
            color: var(--muted);
            text-align: center;
            border: 1px solid var(--line);
            border-radius: 8px !important;
        }

        .page-link:hover,
        .page-item.active .page-link {
            color: #fff;
            background: var(--accent);
            border-color: var(--accent);
        }

        .page-item.disabled .page-link {
            color: #bbb8af;
            background: #f7f6f2;
            border-color: var(--line);
        }

        .alert {
            border: 0;
            border-radius: 10px;
        }

        @media (max-width: 991px) {
            .nav-link {
                margin: .25rem 0 0;
            }

            .page-shell {
                margin-top: 1.5rem;
                border-radius: 14px;
            }

            .row > [class*="col-"] + [class*="col-"] {
                margin-top: 1rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">My Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">หน้าแรก</a>
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">เกี่ยวกับ</a>
                    <a class="nav-link {{ request()->routeIs('blog', 'form', 'book.edit') ? 'active' : '' }}" href="{{ route('blog') }}">บทความ</a>
                    <a class="nav-link {{ request()->routeIs('book') ? 'active' : '' }}" href="{{ route('book') }}">หนังสือ</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="container page-shell">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
