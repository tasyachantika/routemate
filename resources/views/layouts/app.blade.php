<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RouteMate — ' . __('Rencanakan Perjalananmu'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-routemate.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --rm-teal: #0d9488; --rm-blue: #0284c7; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background: #f8fafc; color: #1e293b; }
        .brand-gradient { background: linear-gradient(90deg, var(--rm-teal), var(--rm-blue)); }
        .brand-text { background: linear-gradient(90deg, var(--rm-teal), var(--rm-blue)); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .navbar-brand img { height: 36px; width: auto; }
        .btn-brand { background: linear-gradient(90deg, var(--rm-teal), var(--rm-blue)); border: none; color: #fff; }
        .btn-brand:hover, .btn-brand:focus { color: #fff; opacity: .92; }
        .btn-outline-light:hover { color: var(--rm-teal); }
        .card { border: none; border-radius: 1rem; box-shadow: 0 1px 3px rgba(15, 23, 42, .08); }
        .destination-card { transition: transform .18s ease, box-shadow .18s ease; overflow: hidden; }
        .destination-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(15, 23, 42, .14); }
        .destination-img { height: 200px; width: 100%; object-fit: cover; }
        .destination-placeholder { height: 200px; background: linear-gradient(135deg, #64748b, #94a3b8); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 600; }
        .badge-category { background: linear-gradient(90deg, var(--rm-teal), var(--rm-blue)); }
        .hero { background: linear-gradient(120deg, #0f766e 0%, #0369a1 60%, #1d4ed8 100%); color: #fff; border-radius: 0 0 2rem 2rem; }
        .hero .lead { color: rgba(255,255,255,.85); }
        .feature-icon { width: 52px; height: 52px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #fff; background: linear-gradient(135deg, var(--rm-teal), var(--rm-blue)); }
        footer a { color: rgba(255,255,255,.75); text-decoration: none; }
        footer a:hover { color: #fff; }
        .nav-link.active { font-weight: 700; text-decoration: underline; text-underline-offset: 6px; }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark brand-gradient shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('images/logo-routemate.png') }}" alt="Logo RouteMate">
            <span>RouteMate</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="{{ __('Buka menu') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">{{ __('Beranda') }}</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}" href="{{ route('destinations.index') }}">{{ __('Destinasi') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('map.*') ? 'active' : '' }}" href="{{ route('map.index') }}">{{ __('Peta') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('trips.*') ? 'active' : '' }}" href="{{ route('trips.index') }}">{{ __('Itinerary Saya') }}</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#destinasi') }}">{{ __('Destinasi') }}</a></li>
                @endauth
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                <li class="nav-item d-flex align-items-center gap-1">
                    <a class="nav-link px-1 {{ app()->getLocale() === 'id' ? 'fw-bold' : '' }}" href="{{ route('language.switch', 'id') }}">ID</a>
                    <span style="color:rgba(255,255,255,.5)">|</span>
                    <a class="nav-link px-1 {{ app()->getLocale() === 'en' ? 'fw-bold' : '' }}" href="{{ route('language.switch', 'en') }}">EN</a>
                </li>
                @guest
                    <li class="nav-item"><a class="btn btn-outline-light btn-sm px-3" href="{{ route('login') }}">{{ __('Masuk') }}</a></li>
                    <li class="nav-item"><a class="btn btn-light btn-sm px-3 fw-semibold" href="{{ route('register') }}">{{ __('Daftar Gratis') }}</a></li>
                @else
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Admin</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm px-3">{{ __('Keluar') }}</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1">
    <div class="container pt-4">
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
    </div>

    @auth
        @unless (auth()->user()->hasVerifiedEmail())
            <div class="container">
                <div class="alert alert-warning d-flex flex-wrap justify-content-between align-items-center gap-2" role="alert">
                    <span><i class="bi bi-envelope-exclamation"></i> {{ __('Email kamu belum terverifikasi.') }}</span>
                    <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-warning fw-semibold">{{ __('Verifikasi Sekarang') }}</a>
                </div>
            </div>
        @endunless
    @endauth

    @yield('content')
</main>

<footer class="mt-5 py-4" style="background:#0f172a;">
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-md-6 d-flex align-items-center gap-2">
                <img src="{{ asset('images/logo-routemate.png') }}" alt="Logo RouteMate" style="height:30px;width:auto;">
                <div>
                    <div class="fw-bold text-white">RouteMate</div>
                    <div class="small" style="color:rgba(255,255,255,.6)">{{ __('Rencanakan perjalanan wisata dalam dan luar negeri dengan aman.') }}</div>
                </div>
            </div>
            <div class="col-md-6 text-md-end small" style="color:rgba(255,255,255,.6)">
                <div>{{ __('Peta © kontributor OpenStreetMap') }} &middot; {{ __('Foto © Wikimedia Commons') }}</div>
                <div>&copy; {{ date('Y') }} RouteMate — {{ __('Proyek Cyber Security') }}</div>
            </div>
        </div>
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
