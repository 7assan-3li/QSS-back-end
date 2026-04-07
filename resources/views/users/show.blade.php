@extends('layouts.admin')

@section('title', __('تدقيق الهوية الرقمية'))

@section('content')
<div class="max-w-5xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start font-Cairo">
        <div class="text-start font-Cairo">
            <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                <a href="{{ route('users.index') }}" class="w-14 h-14 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-800 font-Cairo">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl text-slate-800 dark:text-white flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl font-Cairo shadow-lg shadow-indigo-500/5 font-Cairo underline-offset-8 italic">👤</span>
                    {{ __('ملف الهوية الرقمية للكيان') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 mt-3 mr-20 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('حوكمة المستخدمين') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('البيانات التقنية للملف') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary">{{ __('مرجع النظام') }} #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
    </div>

    <!-- Core Identity Matrix Card -->
    <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden font-Cairo text-start">
        <!-- Decorative Vector Elements -->
        <div class="absolute -top-32 -right-32 w-80 h-80 bg-brand-primary/[0.03] rounded-full blur-3xl opacity-60"></div>
        <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-indigo-500/[0.03] rounded-full blur-3xl opacity-60"></div>

        <div class="flex flex-col lg:flex-row items-center gap-14 relative z-10 text-start font-Cairo">
            <!-- Dynamic Avatar Node -->
            <div class="relative group font-Cairo">
                <div class="w-48 h-48 rounded-[4rem] bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-7xl font-black shadow-[0_30px_60px_-15px_rgba(79,70,229,0.4)] transform group-hover:scale-[1.05] group-hover:rotate-3 transition-all duration-1000 font-mono italic">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <!-- Verification Pulse Aura -->
                <div class="absolute -bottom-4 -right-4 w-14 h-14 bg-white dark:bg-slate-900 rounded-[1.5rem] flex items-center justify-center shadow-2xl border-4 border-slate-50 dark:border-slate-950 group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </div>
            </div>

            <!-- Profile Intelligence Sector -->
            <div class="flex-1 space-y-10 text-center lg:text-start font-Cairo">
                <div class="space-y-4 text-start font-Cairo">
                    <h2 class="text-4xl font-black text-slate-800 dark:text-white font-Cairo italic text-start">{{ $user->name }}</h2>
                    <div class="flex flex-col lg:flex-row lg:items-center gap-3 lg:gap-6 text-start font-Cairo">
                        <span class="text-lg font-bold text-slate-400 font-mono tracking-wide text-start italic">{{ $user->email }}</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 font-Cairo">
                    @php
                        $roleColor = match($user->role) {
                            \App\constant\Role::EMPLOYEE => 'bg-amber-500/10 text-amber-600 border-amber-500/20',
                            \App\constant\Role::PROVIDER => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
                            \App\constant\Role::SEEKER   => 'bg-blue-500/10 text-blue-600 border-blue-500/20',
                            default => 'bg-slate-500/10 text-slate-600 border-slate-500/20'
                        };
                        $roleInternalName = match($user->role) {
                            \App\constant\Role::EMPLOYEE => __('مسؤول تنفيذي'),
                            \App\constant\Role::PROVIDER => __('شريك استراتيجي'),
                            \App\constant\Role::SEEKER   => __('طالب منفعة'),
                            default => $user->role
                        };
                    @endphp
                    <span class="inline-flex items-center px-6 py-3 rounded-2xl text-[10px] font-black {{ $roleColor }} border uppercase tracking-[0.2em] font-Cairo shadow-sm italic text-start">
                        {{ $roleInternalName }}
                    </span>
                    <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] font-Cairo italic text-start">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ __('الاستناد الزمني') }}: {{ $user->created_at->format('Y-m-d') }}
                    </div>
                </div>

                <!-- Executive Terminal Hub -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 pt-10 border-t border-slate-100 dark:border-slate-800/60 text-start font-Cairo">
                    <a href="{{ route('users.edit', $user->id) }}" class="w-full sm:w-auto px-10 py-5 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-[2rem] text-[11px] font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-600/20 hover:scale-[1.05] active:scale-95 transition-all font-Cairo flex items-center justify-center gap-3 italic text-start font-Cairo">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        {{ __('إعادة معايرة البيانات') }}
                    </a>
                    
                    <button type="button" class="w-full sm:w-auto px-10 py-5 bg-rose-500/5 text-rose-600 border border-rose-500/20 rounded-[2rem] text-[11px] font-black uppercase tracking-[0.2em] hover:bg-rose-600 hover:text-white transition-all duration-500 font-Cairo flex items-center justify-center gap-3 shadow-sm italic text-start font-Cairo">
                        <svg class="w-5 h-5 font-black uppercase" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        {{ __('تعليق الوصول الفوري') }}
                    </button>
                    
                    <div class="px-6 py-5 bg-emerald-500/10 text-emerald-600 rounded-[2rem] text-[9px] font-black uppercase tracking-[0.2em] border border-emerald-500/20 font-Cairo italic text-start shadow-sm">
                        {{ __('الحالة: مصادق عليه') }} ✅
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
