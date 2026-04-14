<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>QSS | @yield('title', 'Admin')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS & JS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Init theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @yield('css')
</head>

<body class="font-Cairo antialiased text-[var(--main-text)] h-screen flex overflow-hidden relative bg-[var(--main-bg)] selection:bg-brand-primary selection:text-white">

    <div class="admin-layout w-full h-full flex">

        <!-- Sidebar -->
        <aside class="sidebar w-64 h-full bg-[var(--sidebar-bg)] border-l border-[var(--glass-border)] flex flex-col transition-all duration-500">

            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>

            <nav class="sidebar-nav">

                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="icon">📊</span>
                    <span class="text">لوحة التحكم</span>
                </a>

                <a href="{{ route('categories.index') }}" class="{{ request()->is('categories*') ? 'active' : '' }}">
                    <span class="icon">📁</span>
                    <span class="text">التصنيفات</span>
                </a>

                <a href="{{ route('services.index') }}" class="{{ request()->is('services*') ? 'active' : '' }}">
                    <span class="icon">🛠️</span>
                    <span class="text">الخدمات</span>
                </a>

                <a href="{{ route('banks.index') }}" class="{{ request()->is('banks*') ? 'active' : '' }}">
                    <span class="icon">🏦</span>
                    <span class="text">البنوك</span>
                </a>

                <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}">
                    <span class="icon">👤</span>
                    <span class="text">المستخدمين</span>
                </a>

                <a href="{{ route('provider-requests.index') }}" class="{{ request()->is('provider-requests*') ? 'active' : '' }}">
                    <span class="icon">📈</span>
                    <span class="text">طلبات مزودي الخدمات</span>
                </a>
                <a href="{{ route('requests.index') }}" class="{{ request()->is('requests*') ? 'active' : '' }}">
                    <span class="icon">📈</span>
                    <span class="text">طلبات الخدمات</span>
                </a>

                <a href="{{ route('verification-requests.index') }}" class="{{ request()->routeIs('verification-requests*') ? 'active' : '' }}">
                    <span class="icon">📑</span>
                    <span class="text">طلبات التوثيق</span>
                </a>

                <a href="{{ route('verification-packages.index') }}" class="{{ request()->is('verification-packages*') ? 'active' : '' }}">
                    <span class="icon">📦</span>
                    <span class="text">باقات التحقق</span>
                </a>

                <a href="{{ route('user-verification-packages.index') }}" class="{{ request()->is('user-verification-packages*') ? 'active' : '' }}">
                    <span class="icon">💳</span>
                    <span class="text">طلبات اشتراك الباقات</span>
                </a>

                <a href="{{ route('admin.points-packages.index') }}" class="{{ request()->is('admin/points-packages*') ? 'active' : '' }}">
                    <span class="icon">💎</span>
                    <span class="text">باقات النقاط</span>
                </a>

                <a href="{{ route('admin.user-points-packages.index') }}" class="{{ request()->is('admin/user-points-packages*') ? 'active' : '' }}">
                    <span class="icon">💰</span>
                    <span class="text">طلبات شحن النقاط</span>
                </a>

                <a href="{{ route('admin.withdrawals.index') }}" class="{{ request()->is('admin/withdrawals*') ? 'active' : '' }}">
                    <span class="icon">💸</span>
                    <span class="text">طلبات السحب</span>
                </a>

                <a href="{{ route('system-complaints.index') }}" class="{{ request()->is('system-complaints*') ? 'active' : '' }}">
                    <span class="icon">⚠️</span>
                    <span class="text">شكاوى النظام</span>
                </a>

                <a href="{{ route('request-complaints.index') }}" class="{{ request()->is('request-complaints*') ? 'active' : '' }}">
                    <span class="icon">🚨</span>
                    <span class="text">بلاغات الطلبات</span>
                </a>

                <a href="{{ route('settings.index') }}" class="{{ request()->is('settings*') ? 'active' : '' }}">
                    <span class="icon">⚙️</span>
                    <span class="text">إعدادات النظام الديناميكية</span>
                </a>

                <!-- Logout -->
                <a class="logout">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <span class="icon">🚪</span>
                        <input type="submit" class="text" value="تسجيل خروج">
                    </form>
                </a>

            </nav>
        </aside>


        <!-- Main Content -->
        <main class="dashboard-content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>

    </div>
    @yield('js')
</body>

</html>
