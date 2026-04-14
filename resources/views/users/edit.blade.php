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
                <a href="{{ route('users.index') }}" class="w-14 h-14 bg-[var(--glass-bg)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-xl border border-[var(--glass-border)] font-Cairo">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-brand-primary text-2xl font-Cairo shadow-lg shadow-indigo-500/5 font-Cairo underline-offset-8 italic whitespace-nowrap inline-flex items-center justify-center">✍️</span>
                    {{ __('تعديل مصفوفة الهوية') }}: {{ $user->name }}
                </h3>
            </div>
        </div>
    </div>

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-12 text-start font-Cairo">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo px-4">
            <!-- Main Configuration Core -->
            <div class="lg:col-span-8 space-y-12 text-start font-Cairo">
                
                <!-- Basic Data Reconfiguration Hub -->
                <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                    <div class="absolute -top-32 -right-32 w-80 h-80 bg-brand-primary/[0.05] rounded-full blur-3xl"></div>
                    
                    <div class="flex items-center gap-5 mb-14 text-start font-Cairo relative z-10">
                        <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30 font-Cairo"></span>
                        <h4 class="text-2xl font-black font-Cairo text-start italic text-[var(--main-text)]">{{ __('تعديل المعلومات الأساسية') }} (CORE_DATA)</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo relative z-10">
                        <div class="space-y-4 text-start font-Cairo">
                            <label for="name" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                                <span class="w-2 h-2 bg-brand-primary rounded-full"></span>
                                {{ __('الاسم الكامل للمستخدم') }}
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="input-premium w-full px-10 py-6 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-Cairo shadow-sm italic text-start">
                        </div>

                        <div class="space-y-4 text-start font-Cairo">
                            <label for="email" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                {{ __('البريد الإلكتروني المعتمد') }}
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="input-premium w-full px-10 py-6 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-mono tracking-widest text-start italic shadow-sm uppercase">
                        </div>

                        <div class="space-y-4 md:col-span-2 text-start font-Cairo">
                            <label for="role" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                {{ __('تعديل الرتبة الإدارية') }} (ACCESS_LEVEL)
                            </label>
                            <div class="relative font-Cairo">
                                <select name="role" id="role" class="w-full px-10 py-6 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 appearance-none transition-all text-[var(--main-text)] font-Cairo shadow-sm italic text-start">
                                    <option value="{{ \App\constant\Role::EMPLOYEE }}" {{ old('role', $user->role) === \App\constant\Role::EMPLOYEE ? 'selected' : '' }}>{{ __('مسؤول تنفيذي') }} (Executive)</option>
                                    <option value="{{ \App\constant\Role::SEEKER }}" {{ old('role', $user->role) === \App\constant\Role::SEEKER ? 'selected' : '' }}>{{ __('طالب منفعة') }} (Seeker)</option>
                                    <option value="{{ \App\constant\Role::PROVIDER }}" {{ old('role', $user->role) === \App\constant\Role::PROVIDER ? 'selected' : '' }}>{{ __('شريك خدمات استراتيجي') }} (Provider)</option>
                                </select>
                                <div class="absolute left-10 top-1/2 -translate-y-1/2 pointer-events-none text-[var(--text-muted)] font-Cairo">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($user->role === \App\constant\Role::PROVIDER)
                <!-- Professional Profile Hub (Exclusive to Providers) -->
                <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                    <div class="absolute -top-32 -left-32 w-80 h-80 bg-emerald-500/[0.05] rounded-full blur-3xl"></div>
                    
                    <div class="flex items-center gap-5 mb-14 text-start font-Cairo relative z-10">
                        <span class="w-3 h-10 bg-emerald-500 rounded-full shadow-lg shadow-emerald-500/30"></span>
                        <h4 class="text-2xl font-black font-Cairo text-start italic text-[var(--main-text)]">{{ __('الملف المهني للمزود') }} (PROFESSIONAL_ID)</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo relative z-10">
                        <div class="space-y-4 md:col-span-2 text-start font-Cairo">
                            <label for="job_title" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 opacity-60">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                {{ __('المسمى الوظيفي') }}
                            </label>
                            <input type="text" id="job_title" name="job_title" value="{{ old('job_title', $user->profile->job_title ?? '') }}" class="input-premium w-full px-10 py-6 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary transition-all text-[var(--main-text)] shadow-sm italic text-start">
                        </div>

                        <div class="space-y-4 md:col-span-2 text-start font-Cairo">
                            <label for="bio" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 opacity-60">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                {{ __('السيرة الذاتية (Bio)') }}
                            </label>
                            <textarea id="bio" name="bio" rows="4" class="input-premium w-full px-10 py-8 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[3rem] text-sm font-black outline-none focus:border-brand-primary transition-all text-[var(--main-text)] shadow-sm text-start font-Cairo leading-relaxed">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                        </div>

                        <div class="space-y-4 text-start font-Cairo">
                            <label for="latitude" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 opacity-60">
                                <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                                {{ __('خط العرض (Latitude)') }}
                            </label>
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $user->profile->latitude ?? '') }}" class="input-premium w-full px-10 py-6 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary transition-all text-[var(--main-text)] font-mono shadow-sm text-start">
                        </div>

                        <div class="space-y-4 text-start font-Cairo">
                            <label for="longitude" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 opacity-60">
                                <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                                {{ __('خط الطول (Longitude)') }}
                            </label>
                            <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $user->profile->longitude ?? '') }}" class="input-premium w-full px-10 py-6 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary transition-all text-[var(--main-text)] font-mono shadow-sm text-start">
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Strategic Validation Sidebar -->
            <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
                @if($user->role === \App\constant\Role::PROVIDER)
                <!-- Financials & Governance Core -->
                <div class="bg-[var(--glass-bg)] border border-[var(--glass-border)] p-12 rounded-[4rem] shadow-xl relative overflow-hidden text-start font-Cairo">
                    <h4 class="font-black text-[13px] uppercase tracking-[0.4em] mb-12 px-2 text-start opacity-60 italic">💸 {{ __('الحوكمة والعمولات') }}</h4>
                    
                    <div class="space-y-10 relative z-10 text-start">
                        <div class="space-y-4">
                            <label for="commission" class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2">{{ __('نسبة العمولة المخصصة %') }}</label>
                            <div class="relative">
                                <input type="number" id="commission" name="commission" value="{{ old('commission', $user->commission ?? '10') }}" class="w-full px-8 py-5 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-2xl text-lg font-black text-brand-primary outline-none border-2 border-transparent focus:border-brand-primary/20 transition-all font-mono italic">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[var(--text-muted)] font-mono font-black">%</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-6 bg-rose-500/5 rounded-3xl border border-rose-500/10">
                            <div class="flex flex-col gap-1">
                                <span class="text-[14px] font-black text-rose-600">{{ __('استثناء من العمولات') }}</span>
                                <span class="text-[14px] font-black text-rose-400 uppercase">{{ __('NO_COMMISSION_MODE') }}</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="no_commission" value="1" {{ $user->no_commission ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:-translate-x-full rtl:peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:inline-start-[4px] after:bg-[var(--glass-bg)] after:border-var(--glass-border) after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-var(--glass-border) peer-checked:bg-rose-500"></div>
                            </label>
                        </div>

                        <div class="space-y-4 pt-6">
                            <label for="provider_verified_until" class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2">{{ __('تاريخ انتهاء التوثيق') }}</label>
                            <input type="date" id="provider_verified_until" name="provider_verified_until" value="{{ $user->provider_verified_until ? \Carbon\Carbon::parse($user->provider_verified_until)->format('Y-m-d') : '' }}" class="w-full px-8 py-5 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-2xl text-xs font-black outline-none border-2 border-transparent focus:border-brand-primary/20 transition-all text-[var(--main-text)] uppercase font-mono">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Safety Hub -->
                <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                     <button type="submit" class="w-full py-7 bg-gradient-to-r from-brand-primary to-indigo-600 text-white rounded-[2.5rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-2xl hover:shadow-brand-primary/40 hover:scale-[1.02] transition-all duration-500 flex items-center justify-center gap-5 italic text-start">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v8"></path></svg>
                        {{ __('حفظ كافة التغييرات') }}
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Security Integrity Sector (Hash Reset) -->
    <div class="max-w-4xl mx-auto px-4">
        <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
            <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-amber-500/[0.05] rounded-full blur-3xl"></div>
            
            <div class="flex items-center gap-5 mb-14 text-start font-Cairo relative z-10">
                <span class="w-3 h-10 bg-amber-600 rounded-full shadow-lg shadow-amber-600/30"></span>
                <div class="text-start">
                    <h4 class="text-2xl font-black font-Cairo text-start italic text-[var(--main-text)]">{{ __('تدقيق الشفرة السرية') }} (SECURITY_RESET)</h4>
                    <p class="text-[13px] font-black uppercase tracking-widest mt-2 opacity-50">{{ __('اترك الحقول فارغة إذا كنت لا تريد تغيير كلمة المرور.') }}</p>
                </div>
            </div>

            <form action="{{ route('users.update.password', $user->id) }}" method="POST" class="space-y-10 text-start font-Cairo relative z-10">
                @csrf
                @method('PUT')
                
                <div class="space-y-4 text-start">
                    <label for="password" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 opacity-60">
                        <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                        {{ __('إعادة ضبط الشفرة السرية') }}
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="••••••••••••" class="w-full px-10 py-6 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-amber-500 focus:ring-[15px] focus:ring-amber-500/5 transition-all text-[var(--main-text)] tracking-[0.8em] text-start italic shadow-sm">
                    </div>
                </div>

                <div class="pt-6 text-start">
                    <button type="submit" class="w-full py-7 bg-gradient-to-r from-amber-600 to-amber-500 text-white rounded-[2.5rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-2xl hover:shadow-amber-500/40 hover:scale-[1.02] transition-all duration-500 flex items-center justify-center gap-5 italic text-start">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        {{ __('اعتماد كلمة المرور الجديدة') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .input-premium {
        @apply transition-all duration-300;
    }
    .input-premium:focus {
        @apply ring-[15px] ring-brand-primary/5 shadow-xl;
    }
    .animate-fade-in { animation: fade-in 0.6s ease-out forwards; }
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
