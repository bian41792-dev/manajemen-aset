<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'Manajemen Aset') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{
            --ink:#172033;--muted:#718096;--line:#e8edf4;--surface:#fff;--canvas:#f6f8fc;
            --navy:#0f172a;--blue:#315efb;--blue2:#5b7cfa;--green:#0e9f6e;--orange:#f59e0b;--red:#ef4444;
            --shadow:0 12px 35px rgba(15,23,42,.055);
        }
        *{box-sizing:border-box}
        body{margin:0;background:var(--canvas);color:var(--ink);font-family:"DM Sans",sans-serif;font-size:14px}
        .app{min-height:100vh}
        .sidebar{position:fixed;z-index:1040;left:0;top:0;bottom:0;width:258px;background:var(--navy);color:#fff;display:flex;flex-direction:column}
        .brand{height:82px;padding:0 22px;display:flex;align-items:center;gap:12px;border-bottom:1px solid rgba(255,255,255,.07)}
        .brand-logo{height:42px;width:42px;border-radius:13px;display:grid;place-items:center;background:linear-gradient(135deg,#5b7cfa,#315efb);font-size:20px;box-shadow:0 10px 25px rgba(49,94,251,.25)}
        .brand-name{font-family:"Plus Jakarta Sans";font-weight:800;font-size:15px;letter-spacing:-.3px}.brand-company{font-size:10px;color:#8fa0bd;margin-top:2px}
        .nav{display:block;flex-wrap:nowrap;padding:17px 13px;overflow-y:auto}.nav-label{padding:10px 11px 7px;color:#687896;font-size:10px;text-transform:uppercase;letter-spacing:1.1px;font-weight:700}
        .nav a{display:flex;align-items:center;gap:12px;text-decoration:none;color:#aebbd0;padding:11px 12px;margin:3px 0;border-radius:10px;font-weight:500;transition:.18s}
        .nav a i{width:19px;text-align:center;font-size:16px}.nav a:hover{background:rgba(255,255,255,.055);color:#fff}.nav a.active{background:linear-gradient(90deg,#315efb,#426cf7);color:#fff;box-shadow:0 8px 22px rgba(49,94,251,.2)}
        .sidebar-bottom{margin-top:auto;padding:14px;border-top:1px solid rgba(255,255,255,.07)}
        .mini-user{display:flex;align-items:center;gap:10px;padding:5px 4px 12px}.avatar{width:36px;height:36px;border-radius:50%;display:grid;place-items:center;background:#dbeafe;color:#315efb;font-weight:800}
        .mini-user strong{font-size:12px;color:#fff}.mini-user span{display:block;color:#7f8da5;font-size:10px;margin-top:2px}
        .main{margin-left:258px;min-height:100vh}.topbar{height:82px;position:sticky;top:0;z-index:1000;background:rgba(255,255,255,.88);backdrop-filter:blur(14px);border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 34px}
        .top-title{font-family:"Plus Jakarta Sans";font-size:17px;font-weight:800;letter-spacing:-.4px}.top-sub{font-size:11px;color:var(--muted);margin-top:2px}
        .top-actions{display:flex;align-items:center;gap:9px}.top-icon{width:38px;height:38px;border:1px solid var(--line);background:#fff;border-radius:10px;display:grid;place-items:center;color:#66748c}
        .content{padding:30px 34px 45px;max-width:1700px}
        .heading{display:flex;justify-content:space-between;gap:18px;align-items:flex-start;margin-bottom:24px}.heading h1{font-family:"Plus Jakarta Sans";font-size:25px;font-weight:800;letter-spacing:-.8px;margin:0}.heading p{margin:5px 0 0;color:var(--muted);font-size:12px}
        .card{background:var(--surface);border:1px solid var(--line)!important;border-radius:16px!important;box-shadow:var(--shadow)!important;overflow:hidden}
        .card-header{padding:17px 20px!important;background:#fff!important;border-bottom:1px solid var(--line)!important;font-weight:700}.card-body{padding:20px}
        .stat{position:relative;min-height:142px;border:0!important;color:#fff;overflow:hidden}.stat:after{content:"";position:absolute;width:130px;height:130px;border-radius:50%;right:-38px;top:-42px;background:rgba(255,255,255,.08)}.stat-body{position:relative;z-index:2;padding:20px}
        .stat-icon{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.16);display:grid;place-items:center;font-size:18px;margin-bottom:16px}.stat-label{font-size:10px;text-transform:uppercase;letter-spacing:.75px;opacity:.82;font-weight:700}.stat-value{font-family:"Plus Jakarta Sans";font-size:27px;font-weight:800;margin-top:4px}.stat-note{font-size:10px;opacity:.72;margin-top:3px}
        .s-blue{background:linear-gradient(135deg,#315efb,#5275fa)}.s-green{background:linear-gradient(135deg,#079669,#12b981)}.s-orange{background:linear-gradient(135deg,#df8500,#f5a915)}.s-dark{background:linear-gradient(135deg,#1f2937,#3b4657)}.s-cyan{background:linear-gradient(135deg,#087ea5,#12a5cf)}.s-red{background:linear-gradient(135deg,#dc3030,#f25555)}.s-purple{background:linear-gradient(135deg,#6941c6,#8459df)}
        .quick{display:flex;align-items:center;gap:12px;padding:16px 18px;text-decoration:none;color:inherit;border:1px solid var(--line);background:#fff;border-radius:13px;box-shadow:0 5px 18px rgba(15,23,42,.035);transition:.18s}.quick:hover{transform:translateY(-2px);box-shadow:var(--shadow)}.quick i{width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#eef2ff;color:#315efb;font-size:17px}.quick strong{font-size:12px}.quick span{display:block;color:var(--muted);font-size:10px;margin-top:2px}
        .table{margin:0}.table thead th{padding:12px 14px;background:#f8fafc;border-bottom:1px solid var(--line);font-size:10px;color:#718096;text-transform:uppercase;letter-spacing:.55px;white-space:nowrap}.table tbody td{padding:14px;border-color:#eef2f6;vertical-align:middle;color:#3a4659}.table-hover tbody tr:hover{background:#fbfdff}
        .code{font-weight:700;color:#315efb;font-size:12px}.muted{color:var(--muted)}
        .badge{border-radius:7px;padding:.48em .68em;font-weight:700;font-size:10px}.pill{border:1px solid var(--line);background:#f8fafc;color:#526176;border-radius:8px;padding:5px 8px;font-size:10px}
        .progress{height:7px;background:#edf1f7;border-radius:99px}.progress-bar{border-radius:99px;background:linear-gradient(90deg,#315efb,#6b86fb)}
        .form-label{font-weight:700;color:#39465a;font-size:12px}.form-control,.form-select{min-height:43px;border-radius:10px;border-color:#dfe5ee;box-shadow:none!important;font-size:13px}.form-control:focus,.form-select:focus{border-color:#7b96fb;box-shadow:0 0 0 3px rgba(49,94,251,.1)!important}
        textarea.form-control{min-height:110px}.btn{border-radius:9px;font-weight:700;font-size:12px;padding:.62rem .9rem}.btn-sm{padding:.42rem .62rem;font-size:11px}.btn-primary{background:#315efb;border-color:#315efb}.btn-primary:hover{background:#244ee4;border-color:#244ee4}.btn-light{border-color:var(--line);background:#fff}
        .alert{border:0;border-radius:11px;box-shadow:0 6px 20px rgba(15,23,42,.04);font-size:12px}.empty{text-align:center;padding:38px;color:#9aa6b8}.empty i{font-size:27px;display:block;margin-bottom:7px}
        .menu-btn{display:none;width:39px;height:39px;border:1px solid var(--line);background:#fff;border-radius:10px}.overlay{display:none}
        @media(max-width:1000px){.sidebar{transform:translateX(-100%);transition:.22s}.sidebar.open{transform:translateX(0)}.main{margin-left:0}.menu-btn{display:grid;place-items:center}.overlay.show{display:block;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:1030}}
        @media(max-width:600px){.topbar{padding:0 16px;height:70px}.content{padding:22px 15px 35px}.top-actions .profile-name{display:none}.heading{align-items:center}.heading h1{font-size:21px}}
    </style>
    @stack('styles')
</head>
<body>
<div class="app">
    <div class="overlay" id="overlay" onclick="closeNav()"></div>
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo"><i class="bi bi-box-seam"></i></div>
            <div><div class="brand-name">Manajemen Aset</div><div class="brand-company">PT Kreasi Putra Hotama</div></div>
        </div>
        <nav class="nav">
            <div class="nav-label">Overview</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard')?'active':'' }}"><i class="bi bi-grid-1x2-fill"></i>Dashboard</a>
            <div class="nav-label">Master Data</div>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*')?'active':'' }}"><i class="bi bi-tags-fill"></i>Kategori</a>
            <a href="{{ route('locations.index') }}" class="{{ request()->routeIs('locations.*')?'active':'' }}"><i class="bi bi-geo-alt-fill"></i>Lokasi</a>
            <a href="{{ route('assets.index') }}" class="{{ request()->routeIs('assets.*')?'active':'' }}"><i class="bi bi-box-seam-fill"></i>Data Aset</a>
            @if(Route::has('users.index'))
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*')?'active':'' }}"><i class="bi bi-people-fill"></i>Pengguna</a>
            @endif
            <div class="nav-label">Manajemen</div>
            <a href="{{ route('mutations.index') }}" class="{{ request()->routeIs('mutations.*')?'active':'' }}"><i class="bi bi-arrow-left-right"></i>Mutasi Aset</a>
            @if(Route::has('loans.index'))
            <a href="{{ route('loans.index') }}" class="{{ request()->routeIs('loans.*')?'active':'' }}"><i class="bi bi-box-arrow-up-right"></i>Peminjaman</a>
            @endif
            @if(Route::has('maintenance.index'))
            <a href="{{ route('maintenance.index') }}" class="{{ request()->routeIs('maintenance.*')?'active':'' }}"><i class="bi bi-tools"></i>Pemeliharaan</a>
            @elseif(Route::has('maintenances.index'))
            <a href="{{ route('maintenances.index') }}" class="{{ request()->routeIs('maintenances.*')?'active':'' }}"><i class="bi bi-tools"></i>Pemeliharaan</a>
            @endif
            @if(Route::has('reports.index'))
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*')?'active':'' }}"><i class="bi bi-file-earmark-bar-graph-fill"></i>Laporan</a>
            @endif
        </nav>
        <div class="sidebar-bottom">
            <div class="mini-user">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}</div>
                <div class="text-truncate"><strong>{{ auth()->user()->name ?? 'User' }}</strong><span>Administrator</span></div>
            </div>
            <div class="d-flex gap-2">
                @if(Route::has('profile.edit'))<a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-light flex-grow-1"><i class="bi bi-person me-1"></i>Profil</a>@endif
                <form method="POST" action="{{ route('logout') }}" class="flex-grow-1">@csrf<button class="btn btn-sm btn-outline-light w-100"><i class="bi bi-box-arrow-right me-1"></i>Keluar</button></form>
            </div>
        </div>
    </aside>
    <section class="main">
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-btn" onclick="toggleNav()"><i class="bi bi-list"></i></button>
                <div><div class="top-title">@yield('title','Dashboard')</div><div class="top-sub">Sistem Informasi Manajemen Aset</div></div>
            </div>
            <div class="top-actions">
                <div class="top-icon"><i class="bi bi-bell"></i></div>
                <div class="d-flex align-items-center gap-2 ms-1">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}</div>
                    <div class="profile-name"><div style="font-size:11px;font-weight:700">{{ auth()->user()->name ?? 'User' }}</div><div style="font-size:9px;color:var(--muted)">Akun aktif</div></div>
                </div>
            </div>
        </header>
        <main class="content">
            @if(session('success'))<div class="alert alert-success alert-dismissible fade show mb-4"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
            @if(session('error'))<div class="alert alert-danger alert-dismissible fade show mb-4"><i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
            @if($errors->any())<div class="alert alert-danger mb-4"><strong>Periksa kembali input:</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </main>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleNav(){document.getElementById('sidebar').classList.toggle('open');document.getElementById('overlay').classList.toggle('show')}
function closeNav(){document.getElementById('sidebar').classList.remove('open');document.getElementById('overlay').classList.remove('show')}
</script>
@stack('scripts')
</body>
</html>
