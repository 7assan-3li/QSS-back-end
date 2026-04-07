@extends('layouts.admin')

@section('title', __('إضافة باقة نقاط جديدة'))

@section('content')
<div class="max-w-4xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-3xl font-Cairo shadow-lg shadow-emerald-500/5 font-Cairo">➕</span>
                {{ __('بيانات باقة النقاط الجديدة') }}
            </h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('أدخل السعر، عدد النقاط، والمكافآت الإضافية للباقة الجديدة.') }}
            </p>
        </div>
        <a href="{{ route('admin.points-packages.index') }}" class="w-14 h-14 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-800 font-Cairo">
            <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
    </div>

    <!-- Form Container -->
    <div class="card-premium glass-panel p-12 md:p-16 rounded-[4.5rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-primary/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60 font-Cairo"></div>
        
        <form action="{{ route('admin.points-packages.store') }}" method="POST" class="space-y-14 relative z-10 text-start font-Cairo">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 text-start font-Cairo">
                <!-- Package Name -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="name" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-brand-primary rounded-full shadow-sm"></span>
                        {{ __('اسم الباقة') }}
                    </label>
                    <input type="text" name="name" id="name" required placeholder="{{ __('مثال: باقة النقاط الكبرى') }}" 
                           class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all dark:text-white font-Cairo shadow-inner italic text-start">
                </div>

                <!-- Points Amount -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="points" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-amber-400 rounded-full shadow-sm"></span>
                        {{ __('عدد النقاط الأساسية') }}
                    </label>
                    <div class="relative text-start font-Cairo">
                        <input type="number" name="points" id="points" required min="1" placeholder="0"
                               class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-amber-500 focus:ring-[15px] focus:ring-amber-500/5 transition-all dark:text-white font-mono shadow-inner pl-20 text-start">
                        <span class="absolute left-8 top-1/2 -translate-y-1/2 text-2xl font-black text-amber-500/40 font-Cairo">💎</span>
                    </div>
                </div>

                <!-- Bonus Points -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="bonus_points" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full shadow-sm"></span>
                        {{ __('النقاط الإضافية (المكافأة)') }}
                    </label>
                    <div class="relative text-start font-Cairo">
                        <input type="number" name="bonus_points" id="bonus_points" min="0" value="0"
                               class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-indigo-500 focus:ring-[15px] focus:ring-indigo-500/5 transition-all dark:text-white font-mono shadow-inner pl-20 text-start">
                        <span class="absolute left-8 top-1/2 -translate-y-1/2 text-2xl font-black text-indigo-500/40 font-Cairo">🎁</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="price" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full shadow-sm"></span>
                        {{ __('سعر الباقة (ريال يمني)') }}
                    </label>
                    <div class="relative text-start font-Cairo">
                        <input type="number" step="0.01" name="price" id="price" required min="0" placeholder="0.00"
                               class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-emerald-500 focus:ring-[15px] focus:ring-emerald-500/5 transition-all dark:text-white font-mono shadow-inner pl-24 text-emerald-600 text-start">
                        <span class="absolute left-8 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 font-Cairo tracking-widest italic opacity-60">{{ __('عملة الريال اليمني') }}</span>
                    </div>
                </div>

                <!-- Expiry Date -->
                <div class="space-y-4 md:col-span-2 text-start font-Cairo">
                    <label for="expires_at" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-slate-300 rounded-full shadow-sm"></span>
                        {{ __('تاريخ انتهاء صلاحية العرض') }}
                    </label>
                    <input type="date" name="expires_at" id="expires_at"
                           class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all dark:text-white font-Cairo shadow-inner text-start italic">
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-14 flex flex-col md:flex-row items-center gap-8 text-start font-Cairo">
                <button type="submit" class="flex-1 w-full px-14 py-7 bg-gradient-to-r from-slate-900 to-slate-800 dark:from-white dark:to-slate-100 text-white dark:text-slate-950 rounded-[2.5rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-[0_25px_50px_-10px_rgba(0,0,0,0.4)] hover:scale-[1.03] active:scale-95 transition-all duration-500 font-Cairo flex items-center justify-center gap-5 text-start">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    {{ __('حفظ وتفعيل الباقة 🚀') }}
                </button>
                <a href="{{ route('admin.points-packages.index') }}" class="px-14 py-7 bg-white dark:bg-slate-900 text-slate-400 rounded-[2.5rem] text-[11px] font-black uppercase tracking-[0.3em] hover:bg-slate-50 dark:hover:bg-slate-800 transition-all font-Cairo border border-slate-100 dark:border-slate-800 text-start italic">
                    {{ __('إلغاء العملية') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
