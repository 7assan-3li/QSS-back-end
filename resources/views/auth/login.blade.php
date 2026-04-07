<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSS | {{ __('تسجيل الدخول') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script shadow-header>
        // Init theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-Cairo antialiased min-h-screen flex items-center justify-center p-6 overflow-hidden relative bg-[var(--main-bg)] selection:bg-brand-primary selection:text-white">
    
    <!-- Ambient Glow Backgrounds -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="ambient-glow bg-brand-primary/10 w-[500px] h-[500px] -top-48 -right-48 rounded-full"></div>
        <div class="ambient-glow bg-brand-secondary/10 w-[600px] h-[600px] -bottom-64 -left-64 rounded-full"></div>
    </div>

    <!-- Login Container -->
    <div class="w-full max-w-[480px] relative z-10 animate-fade-in-up">
        
        <!-- Brand Logo Area -->
        <div class="flex flex-col items-center mb-10 group cursor-default">
            <div class="w-20 h-20 bg-gradient-to-tr from-brand-primary to-indigo-600 rounded-[2rem] flex items-center justify-center text-white text-4xl font-black shadow-2xl transform group-hover:rotate-12 transition-all duration-700 font-mono italic">Q</div>
            <h1 class="text-3xl font-black mt-6 tracking-tight italic">QSS <span class="text-brand-primary">Portal</span></h1>
            <p class="text-[11px] uppercase font-black text-slate-600 dark:text-slate-400 tracking-[0.4em] mt-3 italic">{{ __('نظام الإدارة المركزي') }}</p>
        </div>

        <!-- Pure Theme Login Card -->
        <div class="card-premium login-card p-10 md:p-14 relative overflow-hidden">
            <div class="mb-10 text-center relative z-10">
                <h2 class="text-2xl font-black mb-3 italic">{{ __('تسجيل الدخول') }}</h2>
                <div class="w-12 h-1.5 bg-brand-primary rounded-full mx-auto shadow-lg shadow-brand-primary/20"></div>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-6 bg-rose-500/10 border border-rose-500/20 rounded-3xl animate-shake">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-[11px] font-black text-rose-600 dark:text-rose-400 flex items-center gap-2">
                                <span class="w-1 h-1 bg-rose-500 rounded-full"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-8 relative z-10">
                @csrf

                <!-- Email Entry -->
                <div class="space-y-3">
                    <label for="email" class="text-[11px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-[0.3em] px-4">{{ __('البريد الإلكتروني') }}</label>
                    <div class="relative group">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="input-premium ltr:pl-14 rtl:pr-14"
                               placeholder="admin@gmail.com">
                        <div class="absolute ltr:left-6 rtl:right-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-brand-primary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Password Entry -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center px-4">
                        <label for="password" class="text-[11px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-[0.3em]">{{ __('كلمة المرور') }}</label>
                    </div>
                    <div class="relative group">
                        <input type="password" id="password" name="password" required
                               class="input-premium ltr:pl-14 rtl:pr-14"
                               placeholder="••••••••">
                        <div class="absolute ltr:left-6 rtl:right-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-brand-primary transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Remember Me & Security Action -->
                <div class="flex items-center justify-between px-4 pt-2">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-2 border-slate-300 dark:border-slate-700 text-brand-primary focus:ring-offset-0 focus:ring-brand-primary/20 transition-all cursor-pointer">
                        <span class="text-[11px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest group-hover:text-brand-primary transition-colors">{{ __('تذكر دخولي') }}</span>
                    </label>
                </div>

                <!-- Ignition Button -->
                <div class="pt-6">
                    <button type="submit" class="w-full py-6 bg-gradient-to-r from-brand-primary to-indigo-700 text-white rounded-[1.8rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-xl hover:shadow-brand-primary/30 hover:scale-[1.03] active:scale-95 transition-all duration-500 flex items-center justify-center gap-4 group">
                        <span>{{ __('الولوج للمنظومة') }}</span>
                        <svg class="w-5 h-5 rtl:rotate-180 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer Policy -->
        <p class="text-center mt-12 text-[9px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em] italic">
            {{ __('© 2024 QSS Intelligence Systems. All Security Protocols Active.') }}
        </p>
    </div>

</body>
</html>
