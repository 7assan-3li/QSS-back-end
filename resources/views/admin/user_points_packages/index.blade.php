@extends('layouts.admin')

@section('title', __('طلبات شحن الرصيد'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5 whitespace-nowrap inline-flex items-center justify-center">💰</span>
                {{ __('طلبات شحن رصيد النقاط') }}
            </h3>
                <p class="text-[13px] font-black uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo opacity-60">
                    {{ __('متابعة عمليات شحن الرصيد، مراجعة الحوالات البنكية، وتأكيد وصول الإيداعات.') }}
                </p>
        </div>
        <div class="px-8 py-3 bg-brand-primary/10 rounded-2xl border border-brand-primary/20 text-brand-primary text-[13px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm animate-pulse text-start">
            {{ __('متابعة مالية مباشرة') }} ⚡
        </div>
    </div>

    <!-- Transaction Ledger Container -->
    <div class="card-premium glass-panel rounded-[2rem] shadow-2xl border border-[var(--glass-border)] overflow-hidden font-Cairo text-start">
        <div class="p-12 border-b border-[var(--glass-border)] flex flex-col md:flex-row justify-between items-center gap-8 text-start">
            <div class="text-start">
                <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('طلبات الشحن الحالية') }}</h4>
                <p class="text-[13px] font-black uppercase tracking-[0.2em] mt-3 text-start font-Cairo opacity-60">{{ __('مراجعة وتأكيد عمليات الدفع لضمان تحديث أرصدة المستخدمين.') }}</p>
            </div>
        </div>
        
        <div class="overflow-x-auto text-start font-Cairo">
            <table class="w-full text-start border-collapse">
                <thead>
                    <tr class="bg-[var(--main-bg)] border-b border-[var(--glass-border)] text-start font-Cairo">
                        <th class="table-header-cell">{{ __('المستخدم المستهدف') }}</th>
                        <th class="table-header-cell">{{ __('الباقة المطلوبة') }}</th>
                        <th class="table-header-cell text-center">{{ __('المبلغ (ريال يمني)') }}</th>
                        <th class="table-header-cell">{{ __('رقم الحوالة') }}</th>
                        <th class="table-header-cell">{{ __('تاريخ الطلب') }}</th>
                        <th class="table-header-cell text-center">{{ __('الحالة') }}</th>
                        <th class="table-header-cell text-center">{{ __('الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--glass-border)] text-start font-Cairo">
                    @forelse ($subscriptions as $sub)
                        <tr class="hover:bg-brand-primary/[0.02] dark:hover:bg-brand-primary/[0.03] transition-all group font-Cairo text-start">
                            <td class="px-10 py-8 text-start">
                                <div class="flex items-center gap-5 text-start">
                                    <div class="w-12 h-12 rounded-[1.2rem] bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-xs font-black border border-indigo-500/20 shadow-sm group-hover:scale-110 transition-transform font-Cairo italic">
                                        {{ mb_substr($sub->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col text-start font-Cairo">
                                        <span class="text-[13px] font-black font-Cairo leading-none mb-2 text-start italic">{{ $sub->user->name ?? __('مستخدم محذوف') }}</span>
                                        <span class="text-[13px] font-bold font-mono text-start opacity-60">{{ $sub->user->email ?? __('لا يوجد بريد') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-start font-Cairo">
                                <span class="badge-soft">{{ $sub->package->name ?? __('هيكل محذوف') }}</span>
                            </td>
                            <td class="px-10 py-8 text-center text-start font-Cairo">
                                <div class="flex items-center justify-center gap-2 font-mono text-start">
                                    <span class="text-xl font-black text-brand-primary italic">{{ number_format($sub->package->price ?? 0, 0) }}</span>
                                    <span class="text-[12px] font-black uppercase tracking-widest font-Cairo opacity-60">{{ __('ريال يمني') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-start">
                                <code class="px-4 py-2 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl text-[13px] font-black border border-amber-500/20 shadow-sm tracking-[0.1em] font-mono italic text-start">#{{ $sub->bond_number }}</code>
                            </td>
                            <td class="px-10 py-8 text-start font-Cairo">
                                <span class="text-[13px] font-black font-mono leading-none text-start opacity-60">{{ $sub->created_at->format('Y-m-d H:i') }}</span>
                            </td>
                            <td class="px-10 py-8 text-center font-Cairo">
                                <span class="px-5 py-2.5 rounded-2xl text-[12px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm whitespace-nowrap inline-flex items-center justify-center @if($sub->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 @elseif($sub->status == 'approved') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-emerald-500/5 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 @endif">
                                    @if($sub->status == 'pending') {{ __('بانتظار المراجعة') }} @elseif($sub->status == 'approved') {{ __('مقبول') }} ✓ @else {{ __('مرفوض إدارياً') }} @endif
                                </span>
                            </td>
                            <td class="px-10 py-8 text-center font-Cairo">
                                <a href="{{ route('admin.user-points-packages.show', $sub->id) }}" class="btn-action btn-action-view mx-auto">
                                    <svg class="w-6 h-6 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-10 py-32 text-center font-Cairo text-start">
                                <div class="flex flex-col items-center opacity-30 gap-8 text-start font-Cairo">
                                    <div class="w-24 h-24 bg-[var(--glass-border)] rounded-[2rem] flex items-center justify-center text-6xl shadow-inner animate-pulse transition-all italic font-Cairo">💰</div>
                                    <p class="text-xs font-black uppercase tracking-[0.3em] font-Cairo text-start opacity-60">{{ __('لا توجد طلبات شحن رصيد حالياً.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscriptions->hasPages())
            <div class="p-12 border-t border-[var(--glass-border)] bg-[var(--main-bg)] text-start font-Cairo">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
