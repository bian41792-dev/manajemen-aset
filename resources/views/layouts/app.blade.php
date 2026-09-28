<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Manajemen Aset') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body{background:#f5f7fb;font-family:Inter,Arial,sans-serif}
        .profile-top{background:#111827;color:#fff;padding:16px 28px;display:flex;justify-content:space-between;align-items:center}
        .profile-main{max-width:1000px;margin:35px auto;padding:0 18px}
        .profile-card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;padding:24px;margin-bottom:20px;box-shadow:0 5px 20px rgba(15,23,42,.045)}
    </style>
</head>
<body>
<header class="profile-top">
    <a href="{{ route('dashboard') }}" class="text-white text-decoration-none fw-bold">
        <i class="bi bi-box-seam me-2"></i> Manajemen Aset
    </a>
    <div class="d-flex align-items-center gap-3">
        <span class="small">{{ Auth::user()->name }}</span>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-light">Dashboard</a>
    </div>
</header>
@if (isset($header))
    <div class="bg-white border-bottom">
        <div class="profile-main py-3 mb-0">{{ $header }}</div>
    </div>
@endif
<main class="profile-main">{{ $slot }}</main>
</body>
</html>
