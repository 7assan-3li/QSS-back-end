@extends('layouts.admin')

@section('title', __('طلبات إضافة أقسام للمزودين'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5 whitespace-nowrap inline-flex items-center justify-center">📂</span>
                {{ __('إدارة طلبات الأقسام الإضافية') }}
            </h3>
            <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('مراجعة طلبات مزودي الخدمة للعمل في أقسام جديدة والموافقة عليها.') }}
            </p>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Total Requests -->
        <a href="{{ route('provider-category-requests.index') }}" class="card-premium glass-panel p-8 rounded-[3rem] border border-[var(--glass-border)] flex flex-col items-center gap-4 group hover:scale-[1.05] transition-all bg-[var(--glass-bg)]/40 shadow-2xl">
            <div class="w-16 h-16 bg-slate-500/10 text-[var(--text-muted)] rounded-2xl flex items-center justify-center text-2xl group-hover:rotate-12 transition-transform shadow-inner font-Cairo">📄</div>
            <div class="text-center font-Cairo">
                <span class="text-3xl font-black block font-mono leading-none">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mt-3 font-Cairo">{{ __('إجمالي الطلبات') }}</span>
            </div>
        </a>

        <!-- Pending Requests -->
        <a href="{{ route('provider-category-requests.index', ['status' => 'pending']) }}" class="card-premium glass-panel p-8 rounded-[3rem] border border-amber-500/20 flex flex-col items-center gap-4 group hover:scale-[1.05] transition-all bg-amber-50/20 dark:bg-amber-950/10 shadow-2xl">
            <div class="w-16 h-16 bg-amber-500/10 text-amber-600 rounded-2xl flex items-center justify-center text-2xl group-hover:rotate-12 transition-transform shadow-inner font-Cairo">⏳</div>
            <div class="text-center font-Cairo">
                <span class="text-3xl font-black text-amber-600 block font-mono leading-none">{{ str_pad($stats['pending'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[12px] font-black text-amber-500/60 uppercase tracking-[0.3em] mt-3 font-Cairo">{{ __('بانتظار المراجعة') }}</span>
            </div>
        </a>

        <!-- Accepted Requests -->
        <a href="{{ route('provider-category-requests.index', ['status' => 'accepted']) }}" class="card-premium glass-panel p-8 rounded-[3rem] border border-emerald-500/20 flex flex-col items-center gap-4 group hover:scale-[1.05] transition-all bg-emerald-50/20 dark:bg-emerald-950/10 shadow-2xl">
            <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:rotate-12 transition-transform shadow-inner font-Cairo font-mono">✅</div>
            <div class="text-center font-Cairo">
                <span class="text-3xl font-black text-emerald-600 block font-mono leading-none">{{ str_pad($stats['accepted'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[12px] font-black text-emerald-500/60 uppercase tracking-[0.3em] mt-3 font-Cairo">{{ __('تمت الموافقة') }}</span>
            </div>
        </a>

        <!-- Rejected Requests -->
        <a href="{{ route('provider-category-requests.index', ['status' => 'rejected']) }}" class="card-premium glass-panel p-8 rounded-[3rem] border border-rose-500/20 flex flex-col items-center gap-4 group hover:scale-[1.05] transition-all bg-rose-50/20 dark:bg-rose-950/10 shadow-2xl font-mono">
            <div class="w-16 h-16 bg-rose-500/10 text-rose-600 rounded-2xl flex items-center justify-center text-2xl group-hover:rotate-12 transition-transform shadow-inner font-Cairo">❌</div>
            <div class="text-center font-Cairo">
                <span class="text-3xl font-black text-rose-600 block font-mono leading-none">{{ str_pad($stats['rejected'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[12px] font-black text-rose-500/60 uppercase tracking-[0.3em] mt-3 font-Cairo">{{ __('طلبات مرفوضة') }}</span>
            </div>
        </a>
    </div>

    <!-- Requests List -->
    <div class="card-premium glass-panel rounded-[4.5rem] shadow-2xl border border-[var(--glass-border)] overflow-hidden font-Cairo text-start">
        <div class="p-12 border-b border-[var(--glass-border)] flex flex-col md:flex-row justify-between items-center gap-8 text-start">
            <div class="text-start">
                <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('قائمة طلبات الأقسام الإضافية') }}</h4>
                <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-3 text-start font-Cairo">{{ __('إدارة طلبات المزودين الراغبين بالتوسع في أقسام جديدة.') }}</p>
            </div>
        </div>

        <div class="overflow-x-auto text-start font-Cairo">
            <table class="w-full text-start">
                <thead>
                    <tr class="bg-[var(--main-bg)] border-b border-[var(--glass-border)] text-start">
                        <th class="px-10 py-8 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-start font-Cairo">{{ __('رقم الطلب') }}</th>
                        <th class="px-10 py-8 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-start font-Cairo">{{ __('المزود') }}</th>
                        <th class="px-10 py-8 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-start font-Cairo">{{ __('القسم المطلوب') }}</th>
                        <th class="px-10 py-8 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-center font-Cairo">{{ __('الحالة') }}</th>
                        <th class="px-10 py-8 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-start font-Cairo">{{ __('المدقق') }}</th>
                        <th class="px-10 py-8 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-start font-Cairo">{{ __('تاريخ التقديم') }}</th>
                        <th class="px-10 py-8 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-center font-Cairo">{{ __('الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--glass-border)] text-start font-Cairo">
                    @forelse ($requests as $request)
                        <tr class="hover:bg-brand-primary/[0.02] dark:hover:bg-brand-primary/[0.03] transition-all group font-Cairo">
                            <td class="px-10 py-8">
                                <span class="px-3 py-1.5 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-xl text-[12px] font-black font-mono shadow-sm whitespace-nowrap inline-flex items-center justify-center">#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex flex-col gap-1 text-start">
                                    <span class="text-[14px] font-bold text-[var(--text-muted)] font-Cairo flex items-center gap-2 text-start">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $request->user->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5 text-start">
                                    <div class="w-11 h-11 bg-gradient-to-br from-indigo-500/20 to-indigo-500/10 text-indigo-500 rounded-2xl flex items-center justify-center text-xs font-black uppercase font-Cairo shadow-sm border border-indigo-500/10">
                                        {{ mb_substr($request->category->name, 0, 1) }}
                                    </div>
                                    <span class="text-[13px] font-black font-Cairo text-start">{{ $request->category->name }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-center">
                                <div class="flex flex-col items-center gap-1.5">
                                    <span class="px-4 py-2 rounded-2xl text-[12px] font-black uppercase tracking-[0.2em] shadow-sm font-Cairo @if($request->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 @elseif($request->status == 'accepted') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 @endif font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                                        {{ __($request->status) }}
                                    </span>
                                    @if($request->status === 'rejected' && $request->rejection_reason)
                                        <span class="text-[11px] font-bold text-rose-500/80 max-w-[150px] truncate" title="{{ $request->rejection_reason }}">
                                            {{ $request->rejection_reason }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-[13px] font-black text-[var(--text-muted)] font-Cairo italic text-start">{{ $request->admin->name ?? '— ' . __('النظام') . ' —' }}</span>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-[13px] font-black text-[var(--text-muted)] font-mono text-start">{{ $request->created_at->format('Y-m-d') }}</span>
                            </td>
                            <td class="px-10 py-8 text-center font-Cairo">
                                <a href="{{ route('provider-category-requests.show', $request->id) }}" class="w-12 h-12 bg-[var(--main-bg)] text-[var(--text-muted)] hover:text-white hover:bg-brand-primary rounded-2xl flex items-center justify-center mx-auto transition-all shadow-sm border border-[var(--glass-border)] font-Cairo">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-10 py-32 text-center font-Cairo">
                                <div class="flex flex-col items-center opacity-30 gap-8 font-Cairo text-start">
                                    <div class="w-24 h-24 bg-[var(--glass-border)] rounded-[2.5rem] flex items-center justify-center text-slate-300 shadow-inner font-Cairo text-4xl italic">📂</div>
                                    <span class="text-xs font-black text-[var(--text-muted)] uppercase tracking-[0.3em] font-Cairo text-start">{{ __('لا توجد طلبات أقسام حالياً.') }}</span>
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
