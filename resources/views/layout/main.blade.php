<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Arum Sakti')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --white: #ffffff;
            --gray: #f8fafc;
            --danger: #dc2626;
            --success: #16a34a;
            --warning: #f59e0b;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--gray);
            color: #0f172a;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary), var(--primary-light));
            box-shadow: 2px 0 25px rgba(15, 23, 42, 0.12);
            padding-bottom: 80px;
        }

        .sidebar-brand {
            padding: 24px 20px;
            color: var(--white);
            font-size: 1.25rem;
            font-weight: 700;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.92);
            padding: 12px 20px;
            border-radius: 10px;
            margin: 6px 12px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.18);
            color: var(--white);
        }

        .sidebar .nav-link i {
            width: 24px;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--white);
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.08);
            padding: 14px 24px;
            position: sticky;
            top: 0;
            z-index: 9;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .stat-card {
            background: var(--white);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.12);
        }

        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            background: rgba(59, 130, 246, 0.12);
            color: var(--primary);
        }

        .bg-primary-soft { background-color: rgba(59, 130, 246, 0.12); color: var(--primary); }
        .bg-success-soft { background-color: rgba(16, 185, 129, 0.12); color: var(--success); }
        .bg-warning-soft { background-color: rgba(245, 158, 11, 0.12); color: var(--warning); }
        .bg-danger-soft { background-color: rgba(239, 68, 68, 0.12); color: var(--danger); }

        .table thead th {
            background-color: #eef2ff;
            border: none;
            font-weight: 700;
            color: #1e3a8a;
        }

        .table tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.06);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
        }

        .text-primary { color: var(--primary) !important; }

        .stok-rendah {
            background-color: rgba(239, 68, 68, 0.12);
            color: var(--danger);
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
        }

        .page-header {
            background: var(--white);
            padding: 20px 24px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
        }

        .top-card,
        .quick-card,
        .chart-card {
            border-radius: 14px;
            border-left: 4px solid #3b82f6;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .card-header {
            border-bottom: 1px solid #e5e7eb;
        }

        .produk-scroll {
            height: 205px;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 4px;
        }

        .produk-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .produk-scroll::-webkit-scrollbar-thumb {
            background: rgba(15, 23, 42, 0.18);
            border-radius: 10px;
        }

        .produk-number {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.12);
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 13px;
        }

        .quick-action-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px;
            background: #ffffff;
            transition: 0.2s ease;
        }

        .quick-action-card:hover {
            background: rgba(59, 130, 246, 0.05);
        }

        .quick-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(59, 130, 246, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #2563eb;
        }

        .chart-filter-group .btn {
            border-radius: 8px !important;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #d1d5db;
            transition: 0.2s ease;
        }

        .chart-filter-group .btn-light {
            background: #f8fafc;
            color: #475569;
        }

        .chart-filter-group .btn-light:hover {
            background: #e2e8f0;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            margin: auto;
            border-radius: 14px;
            background: rgba(59, 130, 246, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 22px;
        }
    </style>
    @yield('styles')

</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand mb-3 text-center">
            <img src="{{ asset('img/logo 1.png') }}" alt="Logo" style="height: 60px;">
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('barang.index') }}" class="nav-link {{ request()->routeIs('barang.index') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Data Barang
            </a>
            <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> Kategori
            </a>
            <a href="{{ route('barang.stokrendah') }}" class="nav-link {{ request()->routeIs('barang.stokrendah') ? 'active' : '' }}">
                <i class="fas fa-warehouse"></i> Stok Barang
            </a>
            <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Transaksi
            </a>
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Laporan
            </a>
            <a href="{{ route('akun.index') }}" class="nav-link {{ request()->routeIs('akun.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog"></i> Kelola Akun
            </a>
        </nav>
<div class="position-absolute bottom-0 w-100 p-3">
             <a href="{{ route('logout') }}" class="btn btn-outline-light w-100"
                onclick="event.preventDefault(); fetch('{{ route('logout') }}').then(() => window.location.href='/login');">
                 <i class="fas fa-sign-out-alt me-2"></i> Logout
             </a>
         </div>
    </div>

    <div class="main-content">
<nav class="navbar d-flex justify-content-between">
    <div class="d-flex align-items-center">
        <h5 class="mb-0 text-primary">@yield('page-title', 'Dashboard')</h5>
    </div>
    <div class="d-flex align-items-center">
        <a href="{{ route('akun.index') }}" class="text-decoration-none text-dark">
            <span class="me-1"><i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name ?? 'Admin' }}</span>
            <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'danger' : 'secondary' }} ms-2">{{ Auth::user()->role }}</span>
        </a>
    </div>
</nav>

        <div class="p-4">
            @yield('main-content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAlert(icon, title, text) {
            Swal.fire({ icon, title, text, timer: 2000, showConfirmButton: false });
        }

        @if(session('success'))
            showAlert('success', 'Berhasil', '{{ session("success") }}');
        @endif
        @if(session('error'))
            showAlert('error', 'Gagal', '{{ session("error") }}');
        @endif
    </script>
    @yield('scripts')
</body>
</html>
