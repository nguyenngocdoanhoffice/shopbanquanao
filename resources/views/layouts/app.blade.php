<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Clothing Shop') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        >
        <style>
            :root {
                --brand: #f59e0b;
                --brand-dark: #b45309;
                --accent: #0ea5e9;
                --ink: #0f172a;
                --muted: #6b7280;
                --surface: #ffffff;
            }

            body {
                font-family: "Outfit", sans-serif;
                color: var(--ink);
                background: radial-gradient(circle at top left, rgba(14, 165, 233, 0.18), transparent 45%),
                    radial-gradient(circle at 20% 40%, rgba(245, 158, 11, 0.18), transparent 55%),
                    #f8fafc;
            }

            .nav-glass {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            }

            .brand-pill {
                background: linear-gradient(135deg, var(--brand), var(--accent));
                color: #fff;
                padding: 0.45rem 0.9rem;
                border-radius: 999px;
                font-weight: 600;
                letter-spacing: 0.02em;
            }

            .btn-brand {
                background: var(--brand);
                border: none;
                color: #fff;
                box-shadow: 0 12px 20px rgba(245, 158, 11, 0.24);
            }

            .btn-brand:hover {
                background: var(--brand-dark);
                color: #fff;
            }

            .btn-outline-brand {
                border: 1px solid rgba(15, 23, 42, 0.15);
                color: var(--ink);
            }

            .card-product {
                border: none;
                border-radius: 1.2rem;
                box-shadow: 0 22px 40px rgba(15, 23, 42, 0.08);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .card-product:hover {
                transform: translateY(-4px);
                box-shadow: 0 28px 50px rgba(15, 23, 42, 0.12);
            }

            .soft-pill {
                background: rgba(15, 23, 42, 0.06);
                color: var(--muted);
                border-radius: 999px;
                padding: 0.2rem 0.75rem;
                font-size: 0.85rem;
            }

            .fade-up {
                opacity: 0;
                transform: translateY(12px);
                animation: fadeUp 0.6s ease forwards;
                animation-delay: var(--delay, 0s);
            }

            @keyframes fadeUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <body>
        @php
            $cartCount = collect(session('cart', []))->sum('quantity');
        @endphp
        <nav class="navbar navbar-expand-lg nav-glass py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                    <span class="brand-pill">CLOTHING</span>
                    <span class="fw-semibold">Shop</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">Cart <span class="soft-pill">{{ $cartCount }}</span></a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-2">
                        @guest
                            <a class="btn btn-outline-brand btn-sm" href="{{ route('login') }}">Login</a>
                            <a class="btn btn-brand btn-sm" href="{{ route('register') }}">Register</a>
                        @else
                            <span class="text-muted">Hello,</span>
                            <span class="fw-semibold">{{ Auth::user()->name }}</span>
                            @if (Auth::user()->is_admin)
                                <a class="btn btn-outline-brand btn-sm" href="{{ route('admin.dashboard') }}">Admin</a>
                            @endif
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-brand btn-sm" type="submit">Logout</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="container py-4 py-lg-5">
            @include('partials.alerts')
            @yield('content')
        </main>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
