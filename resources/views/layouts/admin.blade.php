<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — RouteMate')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-routemate.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --rm-teal: #0d9488; --rm-blue: #0284c7; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background: #f1f5f9; color: #1e293b; }
        .brand-gradient { background: linear-gradient(90deg, var(--rm-teal), var(--rm-blue)); }
        .navbar-brand img { height: 34px; width: auto; }
        .btn-brand { background: linear-gradient(90deg, var(--rm-teal), var(--rm-blue)); border: none; color: #fff; }
        .btn-brand:hover, .btn-brand:focus { color: #fff; opacity: .92; }
        .card { border: none; border-radius: 1rem; box-shadow: 0 1px 3px rgba(15, 23, 42, .08); }
        .admin-nav .nav-link { color: #334155; border-radius: .65rem; padding: .5rem .9rem; font-weight: 600; }
        .admin-nav .nav-link:hover { background: #e2e8f0; }
        .admin-nav .nav-link.active { background: linear-gradient(90deg, var(--rm-teal), var(--rm-blue)); color: #fff; }
        .table thead th { background: #f8fafc; }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark brand-gradient shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo-routemate.png') }}" alt="Logo RouteMate">
            <span>RouteMate <span class="badge bg-light text-dark align-middle">Admin</span></span>
        </a>
        <div class="d-flex align-items-center gap-2">
            <span class="d-flex align-items-center gap-1 me-1">
                <a class="text-white text-decoration-none {{ app()->getLocale() === 'id' ? 'fw-bold' : '' }}" href="{{ route('language.switch', 'id') }}">ID</a>
                <span style="color:rgba(255,255,255,.5)">|</span>
                <a class="text-white text-decoration-none {{ app()->getLocale() === 'en' ? 'fw-bold' : '' }}" href="{{ route('language.switch', 'en') }}">EN</a>
            </span>
            <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm"><i class="bi bi-globe"></i> {{ __('Lihat Situs') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-light btn-sm fw-semibold">{{ __('Keluar') }}</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-3">
    <ul class="nav admin-nav gap-2 flex-wrap">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags"></i> {{ __('Kategori') }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}" href="{{ route('admin.destinations.index') }}"><i class="bi bi-geo-alt"></i> {{ __('Destinasi') }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.report*') ? 'active' : '' }}" href="{{ route('admin.report') }}"><i class="bi bi-bar-chart"></i> {{ __('Laporan') }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.activity') ? 'active' : '' }}" href="{{ route('admin.activity') }}"><i class="bi bi-journal-text"></i> {{ __('Log Aktivitas') }}</a></li>
    </ul>
</div>

<main class="flex-grow-1">
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Tutup') }}"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Tutup') }}"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<footer class="py-3 mt-auto" style="background:#0f172a;">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
        <span class="small" style="color:rgba(255,255,255,.65)">&copy; {{ date('Y') }} RouteMate — {{ __('Panel Admin') }}</span>
        <span class="small" style="color:rgba(255,255,255,.65)">{{ __('Area terbatas: hanya untuk administrator.') }}</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@stack('scripts')
<script>
    // Indikator loading: tombol kirim pada formulir POST menampilkan spinner
    // dan menjadi nonaktif setelah diklik, untuk mencegah pengiriman ganda.
    document.addEventListener('submit', function (event) {
        var form = event.target;
        if ((form.getAttribute('method') || 'get').toLowerCase() !== 'post') { return; }
        var button = form.querySelector('button[type="submit"], input[type="submit"]');
        if (!button || button.disabled) { return; }
        button.disabled = true;
        if (button.tagName === 'BUTTON') {
            button.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Memproses...';
        }
    });
</script>
</body>
</html>
