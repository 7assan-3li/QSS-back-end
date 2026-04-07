@extends('layouts.admin')

@section('title', __('طلبات اشتراك التوثيق'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start font-Cairo">
        <div class="text-start font-Cairo">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600 text-3xl font-Cairo shadow-lg shadow-indigo-500/5">💎</span>
                {{ __('سجل اشتراكات التوثيق') }}
            </h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('إدارة طلبات ترقية الحسابات ومراجعة سندات الدفع واعتماد توثيق الحسابات.') }}
            </p>
        </div>
        <div class="px-8 py-3 bg-indigo-500/10 rounded-2xl border border-indigo-500/20 text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm animate-pulse text-start">
            {{ __('مراجعة الطلبات') }} 📊
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-start font-Cairo">
        <!-- Total Requests -->
        <div class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group border border-white dark:border-white/5 text-start font-Cairo shadow-indigo-500/5">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-slate-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000 font-Cairo"></div>
            <div class="flex flex-col gap-2 relative z-10 text-start font-Cairo">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('إجمالي الطلبات') }}</span>
                <div class="flex items-baseline gap-3 text-start font-Cairo">
                    <span class="text-4xl font-black leading-none font-mono italic text-start">{{ number_format($userPackages->count()) }}</span>
                    <span class="text-[10px] font-black text-slate-400 italic text-start font-Cairo">{{ __('طلب') }}</span>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-[10px] font-black text-slate-400 font-Cairo text-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>{{ __('سجل الطلبات الكامل') }}</span>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group border border-white dark:border-white/5 text-start font-Cairo shadow-amber-500/5">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000 font-Cairo"></div>
            <div class="flex flex-col gap-2 relative z-10 text-start font-Cairo">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('طلبات بانتظار المراجعة') }}</span>
                <div class="flex items-baseline gap-3 text-start font-Cairo">
                    <span class="text-4xl font-black text-amber-600 leading-none font-mono italic text-start font-Cairo">{{ number_format($userPackages->where('status', \App\constant\BondStatus::PENDING)->count()) }}</span>
                    <span class="text-[10px] font-black text-amber-500 italic text-start font-Cairo">{{ __('بانتظار المراجعة') }}</span>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-[10px] font-black text-amber-500 font-Cairo text-start">
                <svg class="w-4 h-4 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ __('طلبات تتطلب مراجعة إدارية') }}</span>
            </div>
        </div>

        <!-- Approved Requests -->
        <div class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group border border-white dark:border-white/5 text-start font-Cairo shadow-emerald-500/5">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000 font-Cairo"></div>
            <div class="flex flex-col gap-2 relative z-10 text-start font-Cairo">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('طلبات مقبولة') }}</span>
                <div class="flex items-baseline gap-3 text-start font-Cairo">
                    <span class="text-4xl font-black text-emerald-600 leading-none font-mono italic text-start font-Cairo">{{ number_format($userPackages->where('status', \App\constant\BondStatus::APPROVED)->count()) }}</span>
                    <span class="text-[10px] font-black text-emerald-500 italic text-start font-Cairo">{{ __('تمت الموافقة') }}</span>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-[10px] font-black text-emerald-500 font-Cairo text-start">
                <svg class="w-4 h-4 italic" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ __('تم توثيق الحسابات') }}</span>
            </div>
        </div>

        <!-- Rejected Requests -->
        <div class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group border border-white dark:border-white/5 text-start font-Cairo shadow-rose-500/5">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-rose-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000 font-Cairo"></div>
            <div class="flex flex-col gap-2 relative z-10 text-start font-Cairo">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('طلبات مرفوضة') }}</span>
                <div class="flex items-baseline gap-3 text-start font-Cairo">
                    <span class="text-4xl font-black text-rose-600 leading-none font-mono italic text-start font-Cairo">{{ number_format($userPackages->where('status', \App\constant\BondStatus::REJECTED)->count()) }}</span>
                    <span class="text-[10px] font-black text-rose-500 italic text-start font-Cairo">{{ __('تم الرفض') }}</span>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-[10px] font-black text-rose-500 font-Cairo text-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ __('طلبات لم تستوف الشروط') }}</span>
            </div>
        </div>
    </div>

    <!-- Subscription Requests Table -->
    <div class="card-premium glass-panel rounded-[2rem] shadow-2xl border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
        <div class="p-10 border-b border-slate-100 dark:border-slate-800/50 flex flex-col md:flex-row justify-between items-center gap-8 text-start font-Cairo">
            <div class="text-start font-Cairo">
                <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('سجل طلبات باقات التوثيق') }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 text-start font-Cairo">{{ __('مراجعة وإدارة طلبات اشتراك باقات التوثيق.') }}</p>
            </div>
            <div class="flex items-center gap-4 text-start font-Cairo">
                <span class="bg-indigo-500/10 text-indigo-600 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm text-start">{{ __('إدارة مراجعة الطلبات') }}</span>
            </div>
        </div>
        
        <div class="overflow-x-auto text-start font-Cairo">
            <table class="w-full text-start border-collapse font-Cairo">
                <thead>
                    <tr class="bg-slate-50/40 dark:bg-slate-900/40 border-b border-slate-100 dark:border-slate-800 text-start font-Cairo">
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-start font-Cairo">{{ __('المستخدم') }}</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-start font-Cairo">{{ __('الباقة المطلوب') }}</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-start font-Cairo">{{ __('رقم السند') }}</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-center font-Cairo">{{ __('حالة الطلب') }}</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-start font-Cairo">{{ __('التاريخ') }}</th>
                        <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] text-center font-Cairo">{{ __('الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50 text-start font-Cairo">
                    @forelse ($userPackages as $request)
                        <tr class="hover:bg-brand-primary/[0.02] dark:hover:bg-brand-primary/[0.03] transition-all group text-start font-Cairo shadow-inner">
                            <td class="px-10 py-8 text-start font-Cairo">
                                <div class="flex items-center gap-5 text-start font-Cairo">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 flex items-center justify-center text-indigo-600 font-black text-xs border border-white dark:border-white/5 shadow-sm group-hover:rotate-12 transition-transform font-mono italic">
                                        {{ mb_substr($request->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col text-start font-Cairo">
                                        <span class="text-[13px] font-black font-Cairo leading-none mb-2 italic text-start uppercase">{{ $request->user->name ?? __('مستخدم غير معروف') }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 font-mono tracking-wide text-start italic">{{ $request->user->email ?? '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-start font-Cairo">
                                <div class="flex flex-col text-start font-Cairo">
                                    <span class="text-[13px] font-black text-indigo-600 dark:text-indigo-400 font-Cairo italic text-start">{{ $request->verificationPackage->name ?? __('باقة منتهية') }}</span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2 text-start italic">{{ __('باقة توثيق') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-start font-Cairo">
                                <span class="px-4 py-2 bg-slate-100 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 rounded-xl text-[10px] font-black font-mono tracking-[0.2em] border border-slate-200 dark:border-white/5 italic text-start font-Cairo shadow-inner">#{{ $request->number_bond }}</span>
                            </td>
                            <td class="px-10 py-8 text-center font-Cairo">
                                @php
                                    $statusLabel = match($request->status) {
                                        \App\constant\BondStatus::PENDING => __('قيد الانتظار'),
                                        \App\constant\BondStatus::APPROVED => __('مقبول'),
                                        \App\constant\BondStatus::REJECTED => __('مرفوض'),
                                        default => __('غير معروف')
                                    };
                                    $statusColor = match($request->status) {
                                        \App\constant\BondStatus::PENDING => 'bg-amber-500/10 text-amber-600 border-amber-500/20',
                                        \App\constant\BondStatus::APPROVED => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
                                        \App\constant\BondStatus::REJECTED => 'bg-rose-500/10 text-rose-600 border-rose-500/20',
                                        default => 'bg-slate-500/10 text-slate-600 border-slate-500/20'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-5 py-2.5 rounded-2xl text-[9px] font-black uppercase tracking-[0.2em] {{ $statusColor }} border shadow-sm font-Cairo italic text-start mx-auto">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-start font-Cairo">
                                <span class="text-[10px] font-black text-slate-400 font-mono tracking-[0.2em] italic text-start font-Cairo">{{ $request->created_at->format('Y-m-d') }}</span>
                            </td>
                            <td class="px-10 py-8 text-center font-Cairo">
                                <a href="{{ route('user-verification-packages.show', $request->id) }}" class="w-12 h-12 bg-slate-50 dark:bg-slate-900 text-slate-400 hover:text-white hover:bg-brand-primary rounded-2xl transition-all shadow-sm border border-slate-100 dark:border-white/5 flex items-center justify-center mx-auto font-Cairo text-start" title="{{ __('عرض تفاصيل الطلب') }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-40 text-center font-Cairo text-start">
                                <div class="flex flex-col items-center opacity-30 gap-8 font-Cairo text-start">
                                    <div class="w-24 h-24 bg-slate-100 dark:bg-slate-900 rounded-[3rem] flex items-center justify-center text-6xl shadow-inner animate-pulse font-Cairo italic">💎</div>
                                    <p class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] font-Cairo text-start italic">{{ __('لا توجد طلبات اشتراك حالياً.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
