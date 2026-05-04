@extends('layouts.admin')

@section('title', __('إنشاء حساب جديد'))

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
                    <span class="w-12 h-12 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-2xl font-Cairo shadow-lg shadow-brand-primary/5 font-Cairo underline-offset-8 italic whitespace-nowrap inline-flex items-center justify-center">👤</span>
                    {{ __('إنشاء حساب مستخدم جديد') }}
                </h3>
            </div>
        </div>
    </div>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-12 text-start font-Cairo" x-data="{ role: '{{ old('role', \App\constant\Role::SEEKER) }}' }">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo px-4">
            <!-- Main Configuration Core -->
            <div class="lg:col-span-8 space-y-12 text-start font-Cairo">
                
                <!-- Basic Data Entry Hub -->
                <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                    <div class="absolute -top-32 -right-32 w-80 h-80 bg-brand-primary/[0.05] rounded-full blur-3xl"></div>
                    
                    <div class="flex items-center gap-5 mb-14 text-start font-Cairo relative z-10">
                        <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30 font-Cairo"></span>
                        <h4 class="text-2xl font-black font-Cairo text-start italic text-[var(--main-text)]">{{ __('المعلومات الأساسية للحساب') }}</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo relative z-10">
                        <div class="space-y-4 text-start font-Cairo">
                            <label for="name" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60 text-[var(--text-secondary)]">
                                <span class="w-2 h-2 bg-brand-primary rounded-full"></span>
                                {{ __('الاسم الكامل') }}
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="input-premium w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-Cairo shadow-sm italic text-start">
                        </div>

                        <div class="space-y-4 text-start font-Cairo">
                            <label for="email" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60 text-[var(--text-secondary)]">
                                <span class="w-2 h-2 bg-brand-primary/60 rounded-full"></span>
                                {{ __('البريد الإلكتروني') }}
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="input-premium w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-mono tracking-widest text-start italic shadow-sm uppercase">
                        </div>

                        <div class="space-y-4 text-start font-Cairo">
                            <label for="password" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60 text-[var(--text-secondary)]">
                                <span class="w-2 h-2 bg-brand-primary/40 rounded-full"></span>
                                {{ __('كلمة المرور') }}
                            </label>
                            <input type="password" id="password" name="password" required class="input-premium w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-mono tracking-[0.5em] text-start italic shadow-sm">
                        </div>

                        <div class="space-y-4 text-start font-Cairo">
                            <label for="password_confirmation" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60 text-[var(--text-secondary)]">
                                <span class="w-2 h-2 bg-brand-primary/40 rounded-full"></span>
                                {{ __('تأكيد كلمة المرور') }}
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required class="input-premium w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-mono tracking-[0.5em] text-start italic shadow-sm">
                        </div>

                        <div class="space-y-4 md:col-span-2 text-start font-Cairo">
                            <label for="role" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60 text-[var(--text-secondary)]">
                                <span class="w-2 h-2 bg-brand-primary/80 rounded-full"></span>
                                {{ __('تحديد الرتبة الإدارية') }}
                            </label>
                            <div class="relative font-Cairo">
                                <select name="role" id="role" x-model="role" class="w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 appearance-none transition-all text-[var(--main-text)] font-Cairo shadow-sm italic text-start">
                                    <option value="{{ \App\constant\Role::EMPLOYEE }}">{{ __('مسؤول تنفيذي') }} (Employee)</option>
                                    <option value="{{ \App\constant\Role::SEEKER }}">{{ __('طالب منفعة') }} (Seeker)</option>
                                    <option value="{{ \App\constant\Role::PROVIDER }}">{{ __('شريك خدمات استراتيجي') }} (Provider)</option>
                                </select>
                                <div class="absolute left-10 top-1/2 -translate-y-1/2 pointer-events-none text-[var(--text-muted)] font-Cairo">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Profile Hub (Conditional) -->
                <div x-show="role === '{{ \App\constant\Role::PROVIDER }}'" x-transition.duration.500ms class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                    <div class="absolute -top-32 -left-32 w-80 h-80 bg-emerald-500/[0.05] rounded-full blur-3xl"></div>
                    
                    <div class="flex items-center gap-5 mb-14 text-start font-Cairo relative z-10">
                        <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30"></span>
                        <h4 class="text-2xl font-black font-Cairo text-start italic text-[var(--main-text)]">{{ __('الملف المهني للمزود') }}</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo relative z-10">
                        <div class="space-y-4 md:col-span-2 text-start font-Cairo">
                            <label for="job_title" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 opacity-60">
                                <span class="w-2 h-2 bg-brand-primary rounded-full"></span>
                                {{ __('المسمى الوظيفي') }}
                            </label>
                            <input type="text" id="job_title" name="job_title" value="{{ old('job_title') }}" class="input-premium w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary transition-all text-[var(--main-text)] shadow-sm italic text-start">
                        </div>

                        <div class="space-y-4 md:col-span-2 text-start font-Cairo">
                            <label for="bio" class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 opacity-60">
                                <span class="w-2 h-2 bg-brand-primary/60 rounded-full"></span>
                                {{ __('السيرة الذاتية (Bio)') }}
                            </label>
                            <textarea id="bio" name="bio" rows="4" class="input-premium w-full px-10 py-8 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[3rem] text-sm font-black outline-none focus:border-brand-primary transition-all text-[var(--main-text)] shadow-sm text-start font-Cairo leading-relaxed">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Strategic Validation Sidebar -->
            <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
                <!-- Governance Core -->
                <div x-show="role === '{{ \App\constant\Role::PROVIDER }}'" x-transition.duration.500ms class="glass-panel p-12 rounded-[4rem] shadow-xl relative overflow-hidden text-start font-Cairo border border-[var(--glass-border)]">
                    <h4 class="font-black text-[13px] uppercase tracking-[0.4em] mb-12 px-2 text-start opacity-60 italic">💸 {{ __('الحوكمة والعمولات') }}</h4>
                    
                    <div class="space-y-10 relative z-10 text-start">
                        <div class="space-y-4">
                            <label for="commission" class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2">{{ __('نسبة العمولة الافتراضية %') }}</label>
                            <div class="relative">
                                <input type="number" id="commission" name="commission" value="{{ old('commission', '10') }}" class="w-full px-8 py-5 bg-[var(--main-bg)] rounded-2xl text-lg font-black text-brand-primary outline-none border-2 border-transparent focus:border-brand-primary/20 transition-all font-mono italic">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[var(--text-muted)] font-mono font-black">%</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-6 bg-rose-500/5 rounded-3xl border border-rose-500/10">
                            <div class="flex flex-col gap-1">
                                <span class="text-[14px] font-black text-rose-600 dark:text-rose-400">{{ __('استثناء من العمولات') }}</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="no_commission" value="1" {{ old('no_commission') ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-8 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:-translate-x-full rtl:peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:inline-start-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-rose-500"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Hub -->
                <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                     <button type="submit" class="w-full py-7 bg-brand-primary text-white rounded-[2.5rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-2xl hover:shadow-brand-primary/40 hover:scale-[1.02] transition-all duration-500 flex items-center justify-center gap-5 italic text-start">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        {{ __('إنشاء الحساب الآن') }}
                    </button>
                    <p class="text-[11px] font-black text-[var(--text-muted)] text-center mt-6 uppercase tracking-widest leading-relaxed px-4 opacity-50 italic">
                        {{ __('ملاحظة: سيتم توثيق البريد الإلكتروني تلقائياً للحسابات المنشأة بواسطة الإدارة.') }}
                    </p>
                </div>
            </div>
        </div>
    </form>
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
