<!doctype html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Clothing Shop') }} - Quản trị</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        >
        <style>
            :root {
                --admin-bg: #0f172a;
                --admin-panel: #111827;
                --admin-card: #ffffff;
                --admin-accent: #f59e0b;
                --admin-text: #e5e7eb;
                --admin-muted: #9ca3af;
            }

            body {
                font-family: "Space Grotesk", sans-serif;
                background: #0b1120;
                color: var(--admin-text);
            }

            .admin-shell {
                min-height: 100vh;
                background: radial-gradient(circle at 15% 20%, rgba(245, 158, 11, 0.12), transparent 55%),
                    radial-gradient(circle at 80% 0%, rgba(56, 189, 248, 0.1), transparent 45%),
                    #0b1120;
            }

            .admin-sidebar {
                background: var(--admin-panel);
                border-right: 1px solid rgba(255, 255, 255, 0.06);
                min-height: 100vh;
            }

            .admin-brand {
                font-size: 1.15rem;
                letter-spacing: 0.04em;
            }

            .admin-link {
                color: var(--admin-muted);
                text-decoration: none;
                padding: 0.7rem 1rem;
                border-radius: 0.6rem;
                display: block;
                transition: all 0.2s ease;
            }

            .admin-link:hover,
            .admin-link.active {
                color: #fff;
                background: rgba(245, 158, 11, 0.18);
            }

            .admin-topbar {
                background: rgba(17, 24, 39, 0.8);
                border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            }

            .admin-card {
                background: var(--admin-card);
                border: none;
                border-radius: 1rem;
                box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
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
        <div class="admin-shell d-flex">
            <aside class="admin-sidebar p-3 p-lg-4">
                <div class="admin-brand fw-semibold text-white mb-4">Quản trị cửa hàng</div>
                <nav class="d-grid gap-2">
                    <a class="admin-link" href="{{ route('admin.dashboard') }}">Tổng quan</a>
                    <a class="admin-link" href="{{ route('admin.products.index') }}">Sản phẩm</a>
                    <a class="admin-link" href="{{ route('admin.categories.index') }}">Danh mục</a>
                    <a class="admin-link" href="{{ route('admin.users.index') }}">Khách hàng</a>
                    <a class="admin-link" href="{{ route('admin.orders.index') }}">Đơn hàng</a>
                    <a class="admin-link" href="{{ route('admin.coupons.index') }}">Mã giảm giá</a>
                    <a class="admin-link" href="{{ route('admin.reports.index') }}">Báo cáo</a>
                </nav>
                <div class="mt-4">
                    <a class="admin-link" href="{{ route('home') }}">Về cửa hàng</a>
                </div>
            </aside>
            <div class="flex-grow-1">
                <header class="admin-topbar px-4 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-muted small">Bảng quản trị</div>
                        <div class="fw-semibold text-white">{{ Auth::user()->name }}</div>
                    </div>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm" type="submit">Đăng xuất</button>
                    </form>
                </header>
                <main class="p-4 p-lg-5">
                    @include('partials.alerts')
                    @yield('content')
                </main>
            </div>
        </div>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
