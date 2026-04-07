@extends('layouts.admin')

@section('title', __('تدقيق الهوية الرقمية'))

@section('content')
<div class="max-w-7xl mx-auto space-y-10 mt-4 animate-fade-in text-start font-Cairo pb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start font-Cairo px-4">
        <div class="text-start font-Cairo">
            <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                <a href="{{ route('users.index') }}" class="w-14 h-14 bg-white dark:bg-slate-900 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-xl border border-slate-100 dark:border-white/5 font-Cairo">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-2xl font-Cairo shadow-lg shadow-brand-primary/5 font-Cairo underline-offset-8 italic">👤</span>
                    {{ __('تدقيق مصفوفة الهوية الإدارية') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Identity Center Piece -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Main Hub Card -->
            <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-white dark:border-white/5 overflow-hidden font-Cairo text-start">
                <div class="absolute -top-32 -right-32 w-80 h-80 bg-brand-primary/[0.05] rounded-full blur-3xl"></div>
                <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-indigo-500/[0.05] rounded-full blur-3xl"></div>

                <div class="flex flex-col md:flex-row items-center gap-12 relative z-10 text-start font-Cairo">
                    <div class="relative group font-Cairo">
                        <div class="w-44 h-44 rounded-[3.5rem] bg-gradient-to-br from-brand-primary to-indigo-600 flex items-center justify-center text-white text-7xl font-black shadow-2xl transform group-hover:scale-[1.03] transition-all duration-700 font-mono italic">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-white dark:bg-slate-900 rounded-2xl flex items-center justify-center shadow-2xl border-4 border-slate-50 dark:border-slate-950">
                            <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>

                    <div class="flex-1 space-y-6 text-center md:text-start font-Cairo">
                        <div class="space-y-2 text-start font-Cairo">
                            <div class="flex flex-wrap items-center gap-4 text-start">
                                <h2 class="text-4xl font-black font-Cairo italic text-start text-slate-800 dark:text-white">{{ $user->name }}</h2>
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
                                <span class="px-5 py-2 rounded-xl text-[9px] font-black {{ $roleColor }} border uppercase tracking-widest font-Cairo shadow-sm italic transition-all">
                                    {{ $roleInternalName }}
                                </span>
                            </div>
                            <p class="text-lg font-bold text-slate-400 dark:text-slate-500 italic">{{ $user->email }}</p>
                        </div>

                        <div class="flex flex-wrap items-center justify-start gap-8 pt-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ __('المرجع الرقمي') }}</span>
                                <span class="text-sm font-black text-brand-primary">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="w-px h-8 bg-slate-100 dark:bg-white/5"></div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ __('تم الانضمام') }}</span>
                                <span class="text-sm font-black text-slate-700 dark:text-slate-300">{{ $user->created_at->format('Y-m-d') }}</span>
                            </div>
                            <div class="w-px h-8 bg-slate-100 dark:bg-white/5"></div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ __('الحالة الأمنية') }}</span>
                                <span class="text-sm font-black text-emerald-500 flex items-center gap-2">
                                    {{ __('نشط') }}
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Strategic Metrics Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Financials Sector -->
                <div class="bg-white dark:bg-slate-900/50 p-10 rounded-[3rem] border border-slate-100 dark:border-white/5 shadow-xl space-y-8 relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/5 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between">
                        <h4 class="text-[11px] font-black text-slate-500 uppercase tracking-widest italic">{{ __('المحفظة المالية') }}</h4>
                        <span class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-600 font-bold italic">💰</span>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">{{ __('النقاط المشتراة') }}</span>
                            <span class="text-2xl font-black text-slate-800 dark:text-white">{{ number_format($user->paid_points) }}</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">{{ __('نقاط المكافأة') }}</span>
                            <span class="text-2xl font-black text-brand-primary">{{ number_format($user->bonus_points) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Operational Sector -->
                <div class="bg-white dark:bg-slate-900/50 p-10 rounded-[3rem] border border-slate-100 dark:border-white/5 shadow-xl space-y-8 relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between">
                        <h4 class="text-[11px] font-black text-slate-500 uppercase tracking-widest italic">{{ __('الأداء التشغيلي') }}</h4>
                        <span class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-600 font-bold italic">⚡</span>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">{{ __('إجمالي الطلبات') }}</span>
                            <span class="text-2xl font-black text-slate-800 dark:text-white">{{ $user->requests_count }}</span>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">{{ __('الخدمات المضافة') }}</span>
                            <span class="text-2xl font-black text-indigo-500">{{ $user->services_count }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System & Compliance Sidebar -->
        <div class="space-y-10">
            <!-- Quick Actions Hub -->
            <div class="bg-slate-900 p-10 rounded-[3.5rem] shadow-2xl space-y-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-brand-primary/20 to-transparent opacity-50 pointer-events-none"></div>
                
                <h4 class="text-[10px] font-black text-white uppercase tracking-[0.3em] italic mb-10 opacity-60">{{ __('مركز العمليات الإدارية') }}</h4>
                
                <div class="space-y-4 relative z-10">
                    <a href="{{ route('users.edit', $user->id) }}" class="w-full py-5 bg-white/10 hover:bg-white text-white hover:text-brand-primary border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-500 flex items-center justify-center gap-3 italic">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        {{ __('تعديل المصفوفة') }}
                    </a>

                    <button class="w-full py-5 bg-rose-500/20 hover:bg-rose-600 text-rose-500 hover:text-white border border-rose-500/20 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-500 flex items-center justify-center gap-3 italic">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        {{ __('تعليق الوصول') }}
                    </button>

                    <div class="pt-6 mt-6 border-t border-white/5 space-y-4">
                        <div class="flex items-center justify-between text-[10px] font-bold text-white/40 uppercase tracking-widest italic">
                            <span>{{ __('توثيق البريد') }}</span>
                            <span class="{{ $user->email_verified_at ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $user->email_verified_at ? __('مكتمل') : __('قيد الانتظار') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-[10px] font-bold text-white/40 uppercase tracking-widest italic">
                            <span>{{ __('توثيق الهوية') }}</span>
                            <span class="text-indigo-400">
                                {{ $user->verification_requests_count > 0 ? __('بانتظار المراجعة') : __('لم يتم الطلب') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Temporal Logs Summary -->
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-white/5 p-10 rounded-[3.5rem] shadow-xl space-y-8">
                <h4 class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest italic">{{ __('آخر طلبات الهوية') }}</h4>
                
                <div class="space-y-6">
                    @forelse($user->verificationRequests as $vReq)
                        <div class="flex items-start gap-5 group cursor-default">
                            <div class="w-10 h-10 bg-slate-100 dark:bg-white/5 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-brand-primary group-hover:text-white transition-all duration-500 font-bold italic">V</div>
                            <div class="flex-1 space-y-1">
                                <p class="text-[11px] font-black text-slate-700 dark:text-white transition-colors">{{ $vReq->status_text ?? __('طلب توثيق') }}</p>
                                <p class="text-[9px] font-bold text-slate-400 italic uppercase">{{ $vReq->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 opacity-30 italic">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ __('لا توجد سجلات حالية') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
