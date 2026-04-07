<header class="h-24 flex items-center justify-between px-12 z-40 transition-all duration-700 bg-[var(--glass-bg)] border-b border-slate-200 dark:border-white/5 sticky top-0 font-Cairo">
    <!-- Left Section -->
    <div class="flex flex-col text-start font-Cairo">
        <h2 id="header-title" class="text-2xl font-black tracking-tighter italic text-start font-Cairo uppercase">
            @yield('title', __('محطة المراقبة المركزية'))
        </h2>
        <div class="flex items-center gap-3 text-[10px] font-extrabold text-slate-600 dark:text-slate-400 uppercase tracking-[0.3em] mt-2 text-start font-Cairo italic">
            <span class="text-brand-primary">QSS_ADMIN_CORE</span>
            <span class="w-1.5 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full"></span>
            <span>{{ __('لوحة التحكم الرئيسية') }}</span>
        </div>
    </div>
    
    <!-- Right Section -->
    <div class="flex items-center gap-8 text-start font-Cairo">
        <!-- Universal Connectivity Terminal -->
        <div class="hidden lg:flex items-center gap-5 px-6 py-2.5 bg-brand-primary/5 rounded-2xl border border-brand-primary/10">
            <div class="flex flex-col items-end">
                <span class="text-[9px] font-extrabold text-slate-600 dark:text-slate-400 uppercase tracking-[0.2em] italic">{{ __('Network Status') }}</span>
                <span class="text-[10px] font-extrabold text-emerald-600 italic flex items-center gap-1">{{ __('متصل بالخادم المركزي') }} <span class="text-[8px] mt-0.5">🟢</span></span>
            </div>
        </div>

        <!-- System Parameters Group -->
        <div class="flex items-center bg-brand-primary/5 p-1.5 rounded-[1.25rem] border border-brand-primary/10">
            <button onclick="toggleTheme()" class="w-12 h-12 flex items-center justify-center rounded-xl text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-white/10 hover:text-brand-primary transition-all duration-500 group">
                <span id="theme-icon" class="text-xl group-hover:rotate-[360deg] transition-all duration-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </span>
            </button>
            <div class="w-px h-6 bg-slate-200 dark:bg-white/10 mx-1"></div>
            <a href="{{ route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar') }}" 
               class="w-12 h-12 flex items-center justify-center rounded-xl text-slate-600 dark:text-slate-400 font-black text-[10px] hover:bg-white dark:hover:bg-white/10 hover:text-brand-primary transition-all duration-500 italic uppercase">
                {{ app()->getLocale() == 'ar' ? 'EN' : 'AR' }}
            </a>
        </div>
        
        <div class="w-px h-10 bg-slate-200 dark:bg-white/10 mx-2"></div>
        
        <!-- Executive Profile Node -->
        <div class="flex items-center gap-5 pl-4 group cursor-pointer">
            <div class="text-end hidden sm:block">
                <p class="text-[13px] font-black text-brand-primary leading-tight group-hover:dark:text-white transition-all duration-500 italic uppercase">
                    {{ auth()->user()->name ?? __('ادمن النظام') }}
                </p>
                <p class="text-[10px] font-black text-slate-600 dark:text-slate-300 tracking-[0.2em] mt-1 italic uppercase subpixel-antialiased">Root Admin</p>
            </div>
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=6366f1&color=fff&bold=true&format=svg" 
                    class="w-14 h-14 rounded-[1.5rem] shadow-2xl border-4 border-white dark:border-slate-800 object-cover transform group-hover:scale-105 group-hover:rotate-3 transition-all duration-500 relative z-10 font-Cairo italic">
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-4 border-white dark:border-[#000000] rounded-full z-20 animate-pulse"></div>
            </div>
        </div>
    </div>
</header>
