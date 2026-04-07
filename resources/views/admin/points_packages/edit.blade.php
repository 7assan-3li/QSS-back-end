@extends('layouts.admin')

@section('title', __('تعديل باقة النقاط'))

@section('content')
<div class="max-w-4xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600 text-3xl font-Cairo shadow-lg shadow-amber-500/5 font-Cairo underline-offset-8">✍️</span>
                {{ __('تعديل بيانات الباقة') }}
            </h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('تحديث سعر الباقة، عدد النقاط، أو حالة التفعيل للباقة: ') }} <span class="text-amber-600 font-black italic">"{{ $package->name }}"</span>
            </p>
        </div>
        <a href="{{ route('admin.points-packages.index') }}" class="w-14 h-14 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-800 font-Cairo">
            <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
    </div>

    <!-- Form Container -->
    <div class="card-premium glass-panel p-12 md:p-16 rounded-[4.5rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
        <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60 font-Cairo"></div>
        
        <form action="{{ route('admin.points-packages.update', $package->id) }}" method="POST" class="space-y-14 relative z-10 text-start font-Cairo">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 text-start font-Cairo">
                <!-- Package Name -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="name" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-brand-primary rounded-full shadow-sm font-Cairo"></span>
                        {{ __('اسم الباقة المحدث') }}
                    </label>
                    <input type="text" name="name" id="name" required value="{{ $package->name }}"
                           class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-amber-500 focus:ring-[15px] focus:ring-amber-500/5 transition-all dark:text-white font-Cairo shadow-inner italic text-start">
                </div>

                <!-- Points Amount -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="points" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full shadow-sm font-Cairo"></span>
                        {{ __('عدد النقاط الأساسية') }}
                    </label>
                    <div class="relative text-start font-Cairo">
                        <input type="number" name="points" id="points" required min="1" value="{{ $package->points }}"
                               class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-emerald-500 focus:ring-[15px] focus:ring-emerald-500/5 transition-all dark:text-white font-mono shadow-inner pl-20 text-start">
                        <span class="absolute left-8 top-1/2 -translate-y-1/2 text-2xl font-black text-emerald-500/40 font-Cairo">💎</span>
                    </div>
                </div>

                <!-- Bonus Points -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="bonus_points" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full shadow-sm font-Cairo"></span>
                        {{ __('النقاط الإضافية (المكافأة)') }}
                    </label>
                    <div class="relative text-start font-Cairo">
                        <input type="number" name="bonus_points" id="bonus_points" min="0" value="{{ $package->bonus_points }}"
                               class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-indigo-500 focus:ring-[15px] focus:ring-indigo-500/5 transition-all dark:text-white font-mono shadow-inner pl-20 text-start">
                        <span class="absolute left-8 top-1/2 -translate-y-1/2 text-2xl font-black text-indigo-500/40 font-Cairo">🎁</span>
                    </div>
                </div>

                <!-- Price -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="price" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-rose-500 rounded-full shadow-sm font-Cairo"></span>
                        {{ __('سعر الباقة (ريال يمني)') }}
                    </label>
                    <div class="relative text-start font-Cairo">
                        <input type="number" step="0.01" name="price" id="price" required min="0" value="{{ $package->price }}"
                               class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-rose-500 focus:ring-[15px] focus:ring-rose-500/5 transition-all dark:text-white font-mono shadow-inner pl-24 text-rose-600 text-start">
                        <span class="absolute left-8 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 font-Cairo tracking-widest italic opacity-60">{{ __('عملة الريال اليمني') }}</span>
                    </div>
                </div>

                <!-- Visibility Status -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="is_active" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-indigo-600 rounded-full shadow-sm font-Cairo"></span>
                        {{ __('حالة ظهور الباقة في المتجر') }}
                    </label>
                    <div class="relative text-start font-Cairo">
                        <select name="is_active" id="is_active" 
                                class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all dark:text-white appearance-none cursor-pointer font-Cairo shadow-inner italic text-center">
                            <option value="1" {{ $package->is_active ? 'selected' : '' }}>{{ __('نشطة (متاحة للشراء)') }}</option>
                            <option value="0" {{ !$package->is_active ? 'selected' : '' }}>{{ __('معطلة (مخفية من قائمة العرض)') }}</option>
                        </select>
                        <div class="absolute left-8 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 font-Cairo">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Expiry Date -->
                <div class="space-y-4 text-start font-Cairo">
                    <label for="expires_at" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-slate-300 rounded-full shadow-sm font-Cairo"></span>
                        {{ __('تاريخ انتهاء الصلاحية') }}
                    </label>
                    <input type="date" name="expires_at" id="expires_at" value="{{ $package->expires_at ? $package->expires_at->format('Y-m-d') : '' }}"
                           class="w-full px-10 py-6 bg-slate-50/50 dark:bg-slate-950/40 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all dark:text-white font-Cairo shadow-inner text-start italic">
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-14 flex flex-col md:flex-row items-center gap-8 text-start font-Cairo">
                <button type="submit" class="flex-1 w-full px-14 py-7 bg-gradient-to-r from-brand-primary to-indigo-600 text-white rounded-[2.5rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-[0_25px_50px_-10px_rgba(var(--brand-primary-rgb),0.4)] hover:scale-[1.03] active:scale-95 transition-all duration-500 font-Cairo flex items-center justify-center gap-5 text-start font-Cairo">
                    <svg class="w-6 h-6 animate-spin-slow rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    {{ __('حفظ التعديلات وتحديث الباقة 🔄') }}
                </button>
                <a href="{{ route('admin.points-packages.index') }}" class="px-14 py-7 bg-white dark:bg-slate-900 text-slate-400 rounded-[2.5rem] text-[11px] font-black uppercase tracking-[0.3em] hover:bg-slate-50 dark:hover:bg-slate-800 transition-all font-Cairo border border-slate-100 dark:border-slate-800 text-start italic">
                    {{ __('إلغاء المراجعة') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
