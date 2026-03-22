<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @yield('css')
</head>

<body>
    <div class="admin-layout">

        <!-- Sidebar -->
        <!-- Sidebar -->
        <aside class="sidebar">

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

                <a href="{{ route('provider-requests.index') }}"
                    class="{{ request()->is('provider-requests*') ? 'active' : '' }}">
                    <span class="icon">📈</span>
                    <span class="text">طلبات مزودي الخدمات</span>
                </a>
                <a href="{{ route('requests.index') }}"
                    class="{{ request()->is('requests*') ? 'active' : '' }}">
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

                <a href="#" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <span class="icon">⚙️</span>
                    <span class="text">الإعدادات</span>
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
