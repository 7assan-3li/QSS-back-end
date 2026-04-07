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

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const iconElement = document.getElementById('theme-icon');
            if (iconElement) {
                iconElement.innerHTML = document.documentElement.classList.contains('dark') 
                    ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 16.243l.707.707M7.757 7.757l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>'
                    : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>';
            }
        }

        document.addEventListener('DOMContentLoaded', updateThemeIcon);
    </script>
</head>
<body class="font-Cairo antialiased min-h-screen bg-white dark:bg-black overflow-hidden selection:bg-brand-primary selection:text-white">
    
    <div class="flex min-h-screen flex-col lg:flex-row">
        <!-- Visual Brand Column -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden mesh-gradient items-center justify-center p-20 order-last lg:order-first">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-brand-primary/20 rounded-full blur-3xl animate-pulse delay-700"></div>

            <div class="relative z-10 text-center flex flex-col items-center animate-fade-slide-up">
                <div class="w-32 h-32 bg-white/10 backdrop-blur-2xl rounded-[3rem] border border-white/20 flex items-center justify-center text-white text-6xl font-black shadow-2xl mb-10 transform hover:rotate-12 transition-all duration-1000 font-mono italic">Q</div>
                <h1 class="text-5xl font-black text-white tracking-tighter italic mb-6">QSS <span class="opacity-60 italic">Intelligence</span></h1>
                <p class="text-lg text-white/80 font-bold max-w-md leading-relaxed">
                    {{ __('المستقبل الرقمي يبدأ هنا. إدارة ذكية، أمان فائق، وكفاءة لا متناهية في منظومة واحدة متكاملة.') }}
                </p>
                
                <div class="mt-16 flex items-center gap-8">
                    <div class="flex flex-col items-center gap-1 opacity-60">
                        <span class="text-2xl font-black text-white">99.9%</span>
                        <span class="text-[10px] uppercase tracking-widest text-white/70">{{ __('جاهزية النظام') }}</span>
                    </div>
                    <div class="w-px h-10 bg-white/20"></div>
                    <div class="flex flex-col items-center gap-1 opacity-60">
                        <span class="text-2xl font-black text-white">AES-256</span>
                        <span class="text-[10px] uppercase tracking-widest text-white/70">{{ __('تشفير البيانات') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auth Form Column -->
        <div class="flex-1 flex flex-col p-8 lg:p-12 relative bg-[var(--main-bg)]">
            
            <!-- Floating Unit: Language & Theme Switcher -->
            <div class="absolute top-8 ltr:right-8 rtl:left-8 flex items-center gap-4 animate-fade-slide-up delay-400">
                <div class="flex items-center bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 p-1 rounded-2xl shadow-xl">
                    <button onclick="toggleTheme()" class="w-11 h-11 flex items-center justify-center rounded-xl hover:bg-brand-primary/5 hover:text-brand-primary transition-all duration-500 group">
                        <span id="theme-icon" class="group-hover:rotate-[360deg] transition-all duration-700"></span>
                    </button>
                    <div class="w-px h-5 bg-slate-100 dark:bg-white/10 mx-1"></div>
                    <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" 
                       class="w-11 h-11 flex items-center justify-center rounded-xl font-black text-[10px] hover:bg-white dark:hover:bg-white/10 hover:text-brand-primary transition-all duration-500 italic uppercase">
                        {{ app()->getLocale() == 'ar' ? 'EN' : 'AR' }}
                    </a>
                </div>
            </div>

            <!-- Main Form Wrapper Centered horizontally/vertically in the remaining area -->
            <div class="flex-1 flex flex-col items-center justify-center">
                <!-- Mobile Brand Mark -->
                <div class="lg:hidden flex flex-col items-center mb-12 animate-fade-slide-up">
                    <div class="w-16 h-16 bg-brand-primary rounded-2xl flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-brand-primary/20 font-mono italic">Q</div>
                    <h2 class="text-2xl font-black mt-4 italic">QSS <span class="text-brand-primary">Portal</span></h2>
                </div>

                <div class="w-full max-w-md space-y-12 animate-fade-slide-up delay-100">
                    <div class="text-start lg:text-start">
                        <h3 class="text-3xl font-black mb-4 italic">{{ __('تسجيل الدخول') }}</h3>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] font-Cairo">{{ __('مرحباً بك، يرجى إدخال بياناتك للدخول.') }}</p>
                    </div>

                    @if ($errors->any())
                        <div class="p-6 bg-rose-500/10 border border-rose-500/20 rounded-[2rem] animate-shake">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-[11px] font-black text-rose-600 dark:text-rose-400 flex items-center gap-3">
                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-8">
                        @csrf

                        <!-- Email Entry -->
                        <div class="space-y-4 group">
                            <label for="email" class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.4em] px-6 transition-colors group-focus-within:text-brand-primary italic">{{ __('البريد الإلكتروني') }}</label>
                            <div class="relative">
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                       class="w-full py-6 px-16 bg-white dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 rounded-[2rem] text-sm font-black outline-none transition-all focus:border-brand-primary focus:ring-8 focus:ring-brand-primary/5 placeholder:text-slate-300 dark:placeholder:text-slate-700"
                                       placeholder="admin@example.com">
                                <div class="absolute left-6 rtl:right-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-brand-primary transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Password Entry -->
                        <div class="space-y-4 group">
                            <div class="flex justify-between items-center px-6">
                                <label for="password" class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.4em] transition-colors group-focus-within:text-brand-primary italic">{{ __('كلمة المرور') }}</label>
                            </div>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                       class="w-full py-6 px-16 bg-white dark:bg-slate-900/50 border-2 border-slate-100 dark:border-white/5 rounded-[2rem] text-sm font-black outline-none transition-all focus:border-brand-primary focus:ring-8 focus:ring-brand-primary/5 placeholder:text-slate-300 dark:placeholder:text-slate-700"
                                       placeholder="••••••••">
                                <div class="absolute left-6 rtl:right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none group-focus-within:text-brand-primary transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Security & Remember Me -->
                        <div class="flex items-center justify-between px-6">
                            <label class="flex items-center gap-4 cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="remember" class="peer h-6 w-6 cursor-pointer appearance-none rounded-lg border-2 border-slate-200 dark:border-slate-800 transition-all checked:bg-brand-primary checked:border-brand-primary">
                                    <svg class="pointer-events-none absolute left-1 h-4 w-4 text-white opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:text-brand-primary transition-colors italic">{{ __('تذكرني') }}</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-10">
                            <button type="submit" class="w-full py-6 bg-gradient-to-tr from-brand-primary to-indigo-600 dark:from-brand-primary dark:to-indigo-500 text-white rounded-[2.2rem] text-[11px] font-black uppercase tracking-[0.4em] shadow-2xl hover:shadow-brand-primary/40 hover:scale-[1.02] hover:-translate-y-1 active:scale-95 transition-all duration-500 flex items-center justify-center gap-4 group">
                                <span>{{ __('دخول') }}</span>
                                <svg class="w-5 h-5 rtl:rotate-180 group-hover:translate-x-2 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                        </div>
                    </form>

                    <!-- Footer Info -->
                    <div class="pt-20 text-center lg:text-start flex flex-col gap-2">
                        <p class="text-[9px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest italic">
                            {{ __('جميع الحقوق محفوظة لمنظومة QSS الذكية') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
