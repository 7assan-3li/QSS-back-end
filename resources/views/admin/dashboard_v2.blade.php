@extends('layouts.admin')

@section('title', __('التحليلات العامة'))

@section('content')
<div class="space-y-8 mt-4">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in">
        <div class="card-premium glass-panel p-6 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.732 4c-.77.234-1.476.614-2.066 1.114M6.718 4c.77.234 1.476.614 2.066 1.114M12 7h.01"></path></svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest mb-1 opacity-60">{{ __('المستخدمين') }}</p>
                <h3 class="text-3xl font-black mb-2">14,230</h3>
                <p class="text-[10px] font-black inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> 
                    12% <span class="font-bold opacity-60">{{ __('هذا الشهر') }}</span>
                </p>
            </div>
        </div>
        
        <div class="card-premium glass-panel p-6 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest mb-1 opacity-60">{{ __('المزودين الموثقين') }}</p>
                <h3 class="text-3xl font-black mb-2">1,842</h3>
                <p class="text-[10px] font-black inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">
                    <span>{{ __('+42 مزود جديد') }}</span>
                </p>
            </div>
        </div>

        <div class="card-premium glass-panel p-6 relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-all"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 mb-4 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest mb-1 opacity-60">{{ __('الطلب المكتملة') }}</p>
                <h3 class="text-3xl font-black mb-2">28,450</h3>
                <p class="text-[10px] font-black inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                    94% <span class="font-bold opacity-60">{{ __('نسبة الإنجاز') }}</span>
                </p>
            </div>
        </div>

        <div class="card-premium bg-gradient-to-br from-brand-primary to-brand-primary-hover p-6 relative overflow-hidden group shadow-xl shadow-brand-primary/20 border-0">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl transition-all group-hover:scale-125"></div>
            <div class="relative z-10 text-white">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mb-4 backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-xs font-black text-white/70 uppercase tracking-widest mb-1">{{ __('العمولات المحصلة') }}</p>
                <h3 class="text-3xl font-black mb-2">152,000 <span class="text-sm font-bold opacity-70">{{ __('ر.س') }}</span></h3>
                <p class="text-[10px] font-black inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-white/20">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> 
                    +8.4% <span class="font-bold opacity-70">{{ __('هذا الشهر') }}</span>
                </p>
            </div>
        </div>
    </div>

    </div>
    
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in font-Cairo">
        <a href="{{ route('requests.index') }}" class="glass-panel p-6 rounded-3xl border border-white dark:border-slate-800/50 hover:bg-brand-primary/5 transition-all group flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">📦</div>
            <div>
                <h4 class="text-sm font-black mb-1">{{ __('سجل طلبات الخدمات') }}</h4>
                <p class="text-[10px] font-bold italic opacity-60">{{ __('متابعة العملاء والمزودين') }}</p>
            </div>
        </a>
        <a href="{{ route('admin.points-packages.index') }}" class="glass-panel p-6 rounded-3xl border border-white dark:border-slate-800/50 hover:bg-brand-primary/5 transition-all group flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform italic">💎</div>
            <div>
                <h4 class="text-sm font-black mb-1">{{ __('إدارة باقات النقاط') }}</h4>
                <p class="text-[10px] font-bold italic opacity-60">{{ __('ضبط الباقات وأسعار الشحن') }}</p>
            </div>
        </a>
        <a href="{{ route('admin.user.index') }}" class="glass-panel p-6 rounded-3xl border border-white dark:border-slate-800/50 hover:bg-brand-primary/5 transition-all group flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-500/10 text-amber-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">👥</div>
            <div>
                <h4 class="text-sm font-black mb-1">{{ __('إدارة المستخدمين') }}</h4>
                <p class="text-[10px] font-bold italic opacity-60">{{ __('عرض وتعديل بيانات الأعضاء') }}</p>
            </div>
        </a>
        <a href="{{ route('request-complaints.index') }}" class="glass-panel p-6 rounded-3xl border border-white dark:border-slate-800/50 hover:bg-brand-primary/5 transition-all group flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-500/10 text-rose-600 rounded-2xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">⚖️</div>
            <div>
                <h4 class="text-sm font-black mb-1">{{ __('مركز الشكاوى') }}</h4>
                <p class="text-[10px] font-bold italic opacity-60">{{ __('متابعة وحل نزاعات العمليات') }}</p>
            </div>
        </a>
    </div>

    <!-- Charts and Tasks Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Chart Area -->
         <div class="lg:col-span-2 glass-panel p-8 rounded-[2.5rem]">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-black text-xl">{{ __('إيرادات المنصة (آخر 6 أشهر)') }}</h3>
                <select class="bg-slate-50 dark:bg-slate-800 border-none text-xs font-bold rounded-xl px-4 py-2 outline-none dark:text-white shadow-sm ring-1 ring-slate-200 dark:ring-slate-700">
                    <option>2026</option>
                </select>
            </div>
            <div class="relative h-72 w-full bg-slate-50/50 dark:bg-slate-900/30 rounded-2xl flex items-center justify-center border-2 border-dashed border-slate-200 dark:border-slate-800">
                <span class="text-sm font-bold text-slate-400">Chart Canvas Integration Area</span>
            </div>
        </div>

        <!-- System Alerts/Tasks -->
         <div class="glass-panel rounded-[2.5rem] overflow-hidden border-none flex flex-col">
            <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800/50">
                <h3 class="font-black text-lg">{{ __('المهام العاجلة') }}</h3>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-800/50 flex-1">
                <div class="p-6 hover:bg-slate-50/50 dark:hover:bg-brand-primary/5 transition group cursor-pointer">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-amber-500 rounded-full shadow-lg shadow-amber-500/20"></div>
                            <p class="text-sm font-bold">{{ __('توثيق الحسابات') }}</p>
                        </div>
                        <span class="bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 text-[10px] px-2.5 py-1 rounded-lg font-black">{{ __('3 معلق') }}</span>
                    </div>
                    <p class="text-xs font-bold opacity-60">{{ __('هناك مزودين بانتظار تفعيل باقاتهم الذهبية.') }}</p>
                </div>
                
                <div class="p-6 hover:bg-slate-50/50 dark:hover:bg-brand-primary/5 transition group cursor-pointer">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-rose-500 rounded-full animate-pulse shadow-lg shadow-rose-500/20"></div>
                            <p class="text-sm font-bold">{{ __('نزاعات جديدة') }}</p>
                        </div>
                        <span class="bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 text-[10px] px-2.5 py-1 rounded-lg font-black">{{ __('2 حرج') }}</span>
                    </div>
                    <p class="text-xs font-bold opacity-60">{{ __('نزاع مالي بين عميل ومزود يحتاج تدخل سريع.') }}</p>
                </div>
            </div>
            <button class="m-6 bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-4 rounded-2xl text-xs font-black transition-all hover:scale-105 active:scale-95 shadow-xl">{{ __('مراجعة مركز الشكاوى') }}</button>
        </div>
    </div>
</div>
@endsection
