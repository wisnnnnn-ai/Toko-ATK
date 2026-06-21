<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Arum Sakti - Sistem Informasi Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background-color: var(--gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
            min-height: 100vh;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top, rgba(37, 99, 235, 0.18), transparent 40%),
                        linear-gradient(180deg, #2563eb 0%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
        }

        .login-page::before {
            content: '';
            position: absolute;
            top: -40%;
            left: -40%;
            width: 180%;
            height: 180%;
            background: radial-gradient(circle, rgba(255,255,255,0.25) 0%, transparent 55%);
            animation: glow 9s ease-in-out infinite alternate;
        }

        @keyframes glow {
            0% { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(1.05); opacity: 0.7; }
        }

        .login-page::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Ccircle cx='40' cy='40' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .login-card {
            background: rgba(255,255,255,0.96);
            border-radius: 24px;
            padding: 44px 34px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 25px 70px rgba(15,23,42,0.16);
            position: relative;
            z-index: 10;
            backdrop-filter: blur(12px);
        }

        .login-logo {
            width: 120px;
            height: 120px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            background: rgba(59, 130, 246, 0.12);
        }

        .login-page .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(59,130,246,0.2);
            border-color: #3b82f6;
        }

        .login-page .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .login-page .btn-primary:hover {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
        }

        .bg-accent {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255,255,255,0.22), transparent 35%);
            pointer-events: none;
        }
    </style>
</head>
<body>
    @yield('content')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>
</html>
