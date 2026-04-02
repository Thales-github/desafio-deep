<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Acesso') — {{ config('app.name', 'Sistema Escolar') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --auth-primary: #5b4fd6;
            --auth-primary-dark: #4338ca;
        }

        body.auth-body {
            min-height: 100vh;
            background: linear-gradient(145deg, #eef2ff 0%, #f5f3ff 35%, #ede9fe 70%, #e0e7ff 100%);
        }

        .auth-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1rem 3rem rgba(67, 56, 202, 0.12);
            overflow: hidden;
            max-width: 28rem;
            width: 100%;
        }

        .auth-card .card-header-custom {
            background: linear-gradient(135deg, var(--auth-primary) 0%, var(--auth-primary-dark) 100%);
            color: #fff;
            padding: 1.5rem 1.75rem;
            border: none;
        }

        .auth-card .card-header-custom h1 {
            font-size: 1.35rem;
            font-weight: 600;
            margin: 0;
        }

        .auth-card .card-header-custom p {
            margin: 0.35rem 0 0;
            opacity: 0.92;
            font-size: 0.9rem;
        }

        .auth-card .card-body {
            padding: 1.75rem;
            background: #fff;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
        }

        .btn-auth-primary {
            background: linear-gradient(135deg, var(--auth-primary) 0%, var(--auth-primary-dark) 100%);
            border: none;
            font-weight: 600;
            padding: 0.65rem 1rem;
        }

        .btn-auth-primary:hover {
            filter: brightness(1.05);
            background: linear-gradient(135deg, var(--auth-primary) 0%, var(--auth-primary-dark) 100%);
        }

        .auth-footer-link {
            font-size: 0.9rem;
        }
    </style>
    @stack('styles')
</head>

<body class="auth-body">
    <div class="min-vh-100 d-flex flex-column">
        <header class="py-3 px-4 text-center">
            <a href="{{ url('/') }}" class="text-decoration-none d-inline-flex align-items-center gap-2 text-dark fw-semibold">
                <span class="rounded-3 d-inline-flex align-items-center justify-content-center text-white"
                    style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,var(--auth-primary),var(--auth-primary-dark));">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>
                {{ config('app.name', 'Sistema Escolar') }}
            </a>
        </header>

        <main class="flex-grow-1 d-flex align-items-center justify-content-center px-3 pb-5">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
