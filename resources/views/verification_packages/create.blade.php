@extends('layouts.admin')

@section('title', __('إضافة باقة توثيق جديدة'))

@section('content')
<div class="max-w-4xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl text-[var(--main-text)] flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5 font-Cairo whitespace-nowrap inline-flex items-center justify-center">➕</span>
                {{ __('إضافة باقة توثيق جديدة') }}
            </h3>
            <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('أدخل تفاصيل الباقة، السعر، ومدة الصلاحية.') }}
            </p>
        </div>
        <a href="{{ route('verification-packages.index') }}" class="w-14 h-14 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-[var(--glass-border)] font-Cairo">
            <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
    </div>

    <!-- Genesis Form Matrix -->
    <form action="{{ route('verification-packages.store') }}" method="POST" class="space-y-12 text-start font-Cairo">
        @csrf

        <!-- Technical & Financial Specifications -->
        <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-primary/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60"></div>
            
            <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30"></span>
                <h4 class="text-xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('بيانات الباقة الأساسية') }}</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10 text-start font-Cairo">
                <!-- Package Identity -->
                <div class="flex flex-col gap-4 text-start">
                    <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] px-3 font-Cairo text-start">{{ __('اسم الباقة') }}</label>
                    <div class="relative group text-start font-Cairo">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('أدخل اسم الباقة...') }}" class="w-full bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[1.5rem] px-8 py-5 text-sm font-black text-[var(--main-text)] text-[var(--main-text)] focus:border-brand-primary focus:ring-[12px] focus:ring-brand-primary/5 transition-all outline-none shadow-inner font-Cairo text-start" required>
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-hover:text-brand-primary transition-all font-Cairo">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                    </div>
                    @error('name') <span class="text-[13px] font-black text-rose-500 px-3 font-Cairo whitespace-nowrap inline-flex items-center justify-center">{{ $message }}</span> @enderror
                </div>

                <!-- Monetary Valuation -->
                <div class="flex flex-col gap-4 text-start font-Cairo">
                    <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] px-3 font-Cairo text-start">{{ __('السعر (ريال يمني)') }}</label>
                    <div class="relative group text-start font-Cairo">
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="0.00" class="w-full bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[1.5rem] px-8 py-5 text-sm font-black text-[var(--main-text)] text-[var(--main-text)] focus:border-emerald-500 focus:ring-[12px] focus:ring-emerald-500/5 transition-all outline-none shadow-inner font-Cairo font-mono text-start" required>
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-hover:text-emerald-500 transition-all font-Cairo">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V15"></path></svg>
                        </div>
                    </div>
                    @error('price') <span class="text-[13px] font-black text-rose-500 px-3 font-Cairo whitespace-nowrap inline-flex items-center justify-center">{{ $message }}</span> @enderror
                </div>

                <!-- Temporal Span -->
                <div class="flex flex-col gap-4 text-start font-Cairo">
                    <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] px-3 font-Cairo text-start">{{ __('مدة الصلاحية (بالأيام)') }}</label>
                    <div class="relative group text-start font-Cairo">
                        <input type="number" name="duration_days" value="{{ old('duration_days', 30) }}" placeholder="30" class="w-full bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[1.5rem] px-8 py-5 text-sm font-black text-[var(--main-text)] text-[var(--main-text)] focus:border-amber-500 focus:ring-[12px] focus:ring-amber-500/5 transition-all outline-none shadow-inner font-Cairo font-mono text-start" required>
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-hover:text-amber-500 transition-all font-Cairo">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    @error('duration_days') <span class="text-[13px] font-black text-rose-500 px-3 font-Cairo whitespace-nowrap inline-flex items-center justify-center">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Narrative & Features Blueprint -->
        <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] text-start font-Cairo">
            <div class="flex items-center gap-5 mb-10 text-start font-Cairo">
                <span class="w-3 h-10 bg-indigo-600 rounded-full shadow-lg shadow-indigo-600/30 font-Cairo"></span>
                <h4 class="text-xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('وصف الباقة ومميزاتها') }}</h4>
            </div>

            <div class="flex flex-col gap-4 text-start font-Cairo">
                <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] px-3 font-Cairo text-start">{{ __('الوصف') }}</label>
                <textarea name="description" rows="6" placeholder="{{ __('اكتب وصفاً مختصراً للباقة ومميزاتها...') }}" class="w-full bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] px-10 py-8 text-sm font-bold text-[var(--main-text)] text-[var(--main-text)] focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all outline-none resize-none leading-relaxed font-Cairo shadow-inner text-start italic">{{ old('description') }}</textarea>
                @error('description') <span class="text-[13px] font-black text-rose-500 px-3 font-Cairo whitespace-nowrap inline-flex items-center justify-center">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Executive Deployment Terminal -->
        <div class="card-premium glass-panel p-12 rounded-[4.5rem] shadow-2xl relative border border-[var(--glass-border)] flex flex-col md:flex-row items-center justify-between gap-12 overflow-hidden text-start font-Cairo">
            <div class="absolute inset-0 bg-brand-primary/[0.04] pointer-events-none font-Cairo"></div>
            
            <div class="flex items-center gap-8 relative z-10 text-start font-Cairo">
                <div class="w-20 h-20 bg-[var(--glass-bg)] rounded-[2rem] flex items-center justify-center text-brand-primary shadow-xl border border-[var(--glass-border)] font-Cairo">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div class="flex flex-col text-start font-Cairo">
                    <h4 class="text-xl font-black text-[var(--main-text)] font-Cairo leading-none mb-3 text-start italic">{{ __('تفعيل الباقة فوراً') }}</h4>
                    <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] leading-relaxed text-start italic">
                        {{ __('عند التفعيل، ستكون الباقة متاحة للمشتركين فور الحفظ.') }}
                    </span>
                </div>
            </div>

            <div class="flex flex-col items-center md:items-end gap-10 relative z-10 text-start font-Cairo">
                <label class="relative inline-flex items-center cursor-pointer group text-start font-Cairo">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                    <div class="w-20 h-11 bg-slate-200 peer-focus:outline-none peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-[var(--glass-bg)] after:border-var(--glass-border) after:border after:rounded-full after:h-9 after:w-9 after:transition-all dark:border-var(--glass-border) peer-checked:bg-gradient-to-r peer-checked:from-brand-primary peer-checked:to-indigo-600 rounded-full group-hover:scale-110 transition-all shadow-inner font-Cairo"></div>
                </label>
                
                <div class="flex flex-wrap justify-center gap-6 text-start font-Cairo">
                    <button type="submit" class="px-12 py-5 bg-gradient-to-r from-brand-primary to-indigo-600 text-white rounded-[1.5rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-[0_25px_50px_-10px_rgba(var(--brand-primary-rgb),0.4)] hover:scale-[1.05] transition-all duration-500 font-Cairo text-start">
                        {{ __('حفظ ونشر الباقة 💾') }}
                    </button>
                    <a href="{{ route('verification-packages.index') }}" class="px-12 py-5 bg-[var(--glass-bg)] text-[var(--text-muted)] rounded-[1.5rem] text-[14px] font-black uppercase tracking-[0.3em] hover:bg-[var(--glass-bg)] dark:hover:bg-[var(--glass-border)] text-white transition-all font-Cairo border border-[var(--glass-border)] text-start">
                        {{ __('إلغاء') }}
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
