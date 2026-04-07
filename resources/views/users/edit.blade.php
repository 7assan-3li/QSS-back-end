@extends('layouts.admin')

@php
    /** @var \App\Models\User $user */
@endphp

@section('title', __('تعديل بيانات المستخدم'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo pb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start font-Cairo px-4">
        <div class="text-start font-Cairo">
            <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                <a href="{{ route('users.index') }}" class="w-14 h-14 bg-white dark:bg-slate-900 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-xl border border-slate-100 dark:border-white/5 font-Cairo">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-brand-primary text-2xl font-Cairo shadow-lg shadow-indigo-500/5 font-Cairo underline-offset-8 italic">✍️</span>
                    {{ __('تعديل مصفوفة الهوية') }}: {{ $user->name }}
                </h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo px-4">
        <!-- Main Configuration Core -->
        <div class="lg:col-span-8 space-y-12 text-start font-Cairo">
            <!-- Basic Data Reconfiguration Hub -->
            <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-white dark:border-white/5 overflow-hidden text-start font-Cairo">
                <div class="absolute -top-32 -right-32 w-80 h-80 bg-brand-primary/[0.05] rounded-full blur-3xl"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo relative z-10">
                    <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30 font-Cairo"></span>
                    <h4 class="text-2xl font-black font-Cairo text-start italic text-slate-800 dark:text-white">{{ __('تعديل المعلومات الأساسية') }} (CORE_DATA)</h4>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-10 text-start font-Cairo relative z-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo">
                        <!-- Entity Name Node -->
                        <div class="space-y-4 text-start font-Cairo">
                            <label for="name" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                                <span class="w-2 h-2 bg-brand-primary rounded-full font-Cairo"></span>
                                {{ __('الاسم الكامل للمستخدم') }}
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-10 py-6 bg-white dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all dark:text-white font-Cairo shadow-sm italic text-start">
                            @error('name')
                                <span class="text-[10px] font-black text-rose-500 px-4 font-Cairo tracking-tight text-start italic block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Node -->
                        <div class="space-y-4 text-start font-Cairo">
                            <label for="email" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full font-Cairo"></span>
                                {{ __('البريد الإلكتروني المعتمد') }}
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-10 py-6 bg-white dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all dark:text-white font-mono tracking-widest text-start italic shadow-sm uppercase">
                            @error('email')
                                <span class="text-[10px] font-black text-rose-500 px-4 font-Cairo tracking-tight text-start italic block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Role Calibration Node -->
                        <div class="space-y-4 md:col-span-2 text-start font-Cairo">
                            <label for="role" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full font-Cairo"></span>
                                {{ __('تعديل الرتبة الإدارية') }} (ACCESS_LEVEL)
                            </label>
                            <div class="relative font-Cairo">
                                <select name="role" id="role" 
                                        class="w-full px-10 py-6 bg-white dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 appearance-none transition-all dark:text-white font-Cairo shadow-sm italic text-start">
                                    <option value="{{ \App\constant\Role::EMPLOYEE }}" {{ $user->role === \App\constant\Role::EMPLOYEE ? 'selected' : '' }}>{{ __('مسؤول تنفيذي') }} (Executive)</option>
                                    <option value="{{ \App\constant\Role::SEEKER }}" {{ $user->role === \App\constant\Role::SEEKER ? 'selected' : '' }}>{{ __('طالب منفعة') }} (Seeker)</option>
                                    <option value="{{ \App\constant\Role::PROVIDER }}" {{ $user->role === \App\constant\Role::PROVIDER ? 'selected' : '' }}>{{ __('شريك خدمات استراتيجي') }} (Provider)</option>
                                </select>
                                <div class="absolute left-10 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 font-Cairo">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 text-start font-Cairo">
                        <button type="submit" class="w-full py-7 bg-gradient-to-r from-brand-primary to-indigo-600 text-white rounded-[2.5rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-2xl hover:shadow-brand-primary/40 hover:scale-[1.02] active:scale-95 transition-all duration-500 font-Cairo flex items-center justify-center gap-5 italic text-start font-Cairo">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v8"></path></svg>
                            {{ __('تحديث وحفظ مصفوفة الهوية') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Integrity Sector (Hash Reset) -->
            <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-white dark:border-white/5 overflow-hidden text-start font-Cairo">
                <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-amber-500/[0.05] rounded-full blur-3xl"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo relative z-10">
                    <span class="w-3 h-10 bg-amber-600 rounded-full shadow-lg shadow-amber-600/30 font-Cairo"></span>
                    <div class="text-start font-Cairo">
                        <h4 class="text-2xl font-black font-Cairo text-start italic text-slate-800 dark:text-white">{{ __('تدقيق الشفرة السرية') }} (SECURITY_RESET)</h4>
                        <p class="text-[10px] font-black uppercase tracking-widest mt-2 font-Cairo text-start font-Cairo opacity-50">{{ __('اترك الحقول فارغة إذا كنت لا تريد تغيير كلمة المرور.') }}</p>
                    </div>
                </div>

                <form action="{{ route('users.update.password', $user->id) }}" method="POST" class="space-y-10 text-start font-Cairo relative z-10">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4 text-start font-Cairo">
                        <label for="password" class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                            <span class="w-2 h-2 bg-amber-500 rounded-full font-Cairo"></span>
                            {{ __('إعادة ضبط الشفرة السرية') }}
                        </label>
                        <div class="relative font-Cairo">
                            <input type="password" id="password" name="password" required placeholder="••••••••••••"
                                   class="w-full px-10 py-6 bg-white dark:bg-slate-950/50 border-2 border-slate-100 dark:border-white/5 rounded-[2.5rem] text-sm font-black outline-none focus:border-amber-500 focus:ring-[15px] focus:ring-amber-500/5 transition-all dark:text-white tracking-[0.8em] text-start italic shadow-sm">
                        </div>
                    </div>

                    <div class="pt-6 text-start font-Cairo">
                        <button type="submit" class="w-full py-7 bg-gradient-to-r from-amber-600 to-amber-500 text-white rounded-[2.5rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-2xl hover:shadow-amber-500/40 hover:scale-[1.02] active:scale-95 transition-all duration-500 font-Cairo flex items-center justify-center gap-5 italic text-start font-Cairo">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            {{ __('اعتماد كلمة المرور الجديدة') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Strategic Validation Sidebar -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <!-- Strategic Trust Badge Node -->
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 p-12 rounded-[4rem] shadow-xl relative overflow-hidden text-start font-Cairo h-full group">
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-500/[0.05] rounded-tr-[8rem] -ml-16 -mb-16 font-Cairo"></div>
                
                <h4 class="font-black text-[10px] uppercase tracking-[0.4em] mb-12 px-2 font-Cairo text-start opacity-60">🛡️ {{ __('مستوى الثقة والمصادقة') }}</h4>

                <div class="space-y-10 text-start font-Cairo relative z-10">
                    @if ($user->email_verified_at)
                        <div class="p-10 bg-emerald-500/10 rounded-[3rem] border-2 border-emerald-500/10 text-center hover:scale-[1.03] transition-all duration-700 text-start font-Cairo">
                            <div class="w-20 h-20 rounded-[2.2rem] bg-emerald-500 text-white flex items-center justify-center mx-auto mb-8 shadow-2xl shadow-emerald-500/30 group-hover:rotate-12 transition-transform font-Cairo italic">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                            <h5 class="text-lg font-black text-emerald-600 font-Cairo mb-3 text-center italic">{{ __('كيان موثق') }}</h5>
                            <p class="text-[10px] font-bold font-Cairo leading-relaxed mb-0 text-center italic text-slate-500 opacity-80">{{ __('تم التحقق من معايير الهوية بنجاح.') }}</p>
                        </div>
                    @else
                        <div class="p-10 bg-rose-500/5 rounded-[3rem] border-2 border-dashed border-rose-500/20 text-center text-start font-Cairo group">
                            <div class="w-20 h-20 rounded-[2.2rem] bg-rose-500/10 text-rose-600 flex items-center justify-center mx-auto mb-8 animate-pulse font-Cairo">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <h5 class="text-lg font-black text-rose-600 font-Cairo mb-4 text-center italic">{{ __('غير مصادق عليه') }}</h5>
                            <p class="text-[11px] font-bold font-Cairo leading-relaxed mb-8 text-center italic text-slate-500 opacity-80">{{ __('بانتظار تفعيل المعايير الأمنية.') }}</p>
                            
                            <form action="{{ route('users.verify.email', $user->id) }}" method="POST" class="text-start font-Cairo">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="w-full bg-emerald-600 text-white py-5 rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] shadow-xl shadow-emerald-600/20 hover:scale-[1.05] transition-all font-Cairo text-start font-Cairo hover:bg-emerald-500">
                                    {{ __('مصادقة يدوية فورية') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Management Compliance Dashboard -->
            <div class="bg-slate-900 text-white p-12 rounded-[4rem] shadow-3xl relative overflow-hidden group text-start font-Cairo">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000 font-Cairo"></div>
                <div class="relative z-10 font-Cairo text-start">
                    <h4 class="font-black text-white text-[11px] uppercase tracking-[0.4em] mb-8 flex items-center gap-4 font-Cairo text-start opacity-70">
                        <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-indigo-400 font-Cairo italic">!</span>
                        {{ __('امتثال الرتب الإدارية') }}
                    </h4>
                    <p class="text-[11px] leading-[2.2] font-black text-white/40 font-Cairo text-start italic">
                        {{ __('تغيير "رتبة المستخدم" يؤدي لتغيير صلاحياته فوراً عبر جميع قطاعات النظام. يرجى التأكد من توافق الرتبة الجديدة مع المهام المكلف بها لضمان استمرارية الأعمال الموثقة.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
