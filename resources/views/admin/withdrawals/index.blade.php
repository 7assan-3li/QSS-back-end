@extends('layouts.admin')

@section('title', __('طلبات السحب'))

@section('content')
<div class="space-y-10 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-6 text-start">
        <div class="text-start">
            <h3 class="font-black text-2xl flex items-center gap-3 text-start font-Cairo">
                <span class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-xl font-Cairo whitespace-nowrap inline-flex items-center justify-center">💸</span>
                {{ __('مركز إدارة السيولة والمسحوبات') }}
            </h3>
            <p class="text-xs font-bold mt-1 mr-14 font-Cairo text-start opacity-60">{{ __('مراجعة طلبات تصفية الأرباح لمزودي الخدمات، التحقق من الحسابات البنكية، وجدولة التحويلات الصادرة.') }}</p>
        </div>
        <div class="px-6 py-3 bg-emerald-500/10 rounded-2xl border border-emerald-500/20 text-emerald-600 text-[13px] font-black uppercase tracking-widest font-Cairo">
            {{ __('جاهزية التحويل') }}: {{ __('مكتملة') }} ✅
        </div>
    </div>

    <!-- Withdrawals Table Section -->
    <div class="card-premium glass-panel rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] overflow-hidden text-start">
        <div class="p-10 border-b border-[var(--glass-border)] flex flex-col md:flex-row justify-between items-center gap-6 text-start">
            <div class="text-start">
                <h4 class="text-lg font-black font-Cairo text-start">{{ __('طلبات السحب المعلقة والمنفذة') }}</h4>
                <p class="text-[13px] font-bold uppercase tracking-widest mt-1 text-start font-Cairo opacity-60">{{ __('تتبع التدفقات المالية الخارجة لضمان التزام المنصة تجاه الشركاء والمزودين.') }}</p>
            </div>
        </div>
        
        <div class="overflow-x-auto text-start">
            <table class="w-full text-start">
                <thead>
                    <tr class="bg-[var(--main-bg)] border-b border-[var(--glass-border)] text-start font-Cairo tracking-widest uppercase text-[13px]">
                        <th class="table-header-cell">{{ __('مزود الخدمة') }}</th>
                        <th class="table-header-cell text-center">{{ __('القيمة الإجمالية') }}</th>
                        <th class="table-header-cell">{{ __('تاريخ تقديم الطلب') }}</th>
                        <th class="table-header-cell text-center">{{ __('وضعية الطلب') }}</th>
                        <th class="table-header-cell text-end">{{ __('عمليات التدقيق') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--glass-border)] text-start">
                    @forelse ($withdrawals as $w)
                        <tr class="hover:bg-[var(--glass-bg)]/50 dark:hover:bg-[var(--glass-border)] text-white/30 transition-colors group text-start">
                            <td class="px-8 py-6 text-start">
                                <div class="flex items-center gap-4 text-start">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-xs font-black border border-emerald-500/20 shadow-sm group-hover:scale-110 transition-transform">
                                        {{ substr($w->user->name ?? 'P', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col text-start font-Cairo">
                                        <span class="text-sm font-black font-Cairo leading-none mb-1 text-start">{{ $w->user->name ?? __('مزود محذوف') }}</span>
                                        <span class="text-[12px] font-bold font-Cairo text-start opacity-60">{{ $w->user->email ?? __('لا يوجد بريد') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center text-start font-Cairo">
                                <span class="text-lg font-black font-Cairo">{{ number_format($w->amount, 2) }}</span>
                                <span class="text-[12px] font-black text-emerald-500 font-Cairo mr-1 opacity-80">{{ __('ر.س') }}</span>
                            </td>
                            <td class="px-8 py-6 text-start font-Cairo">
                                <span class="text-[13px] font-black font-Cairo leading-none opacity-60">{{ $w->created_at->format('Y-m-d H:i') }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @php
                                    $statusBadge = match($w->status) {
                                        'pending' => 'badge-status-pending',
                                        'approved' => 'badge-status-success',
                                        default => 'badge-status-danger'
                                    };
                                    $statusName = match($w->status) {
                                        'pending' => __('قيد المراجعة'),
                                        'approved' => __('تم التحويل'),
                                        default => __('مرفوض')
                                    };
                                @endphp
                                <span class="badge-status {{ $statusBadge }}">
                                    @if($w->status == 'approved') ✓ @endif
                                    {{ $statusName }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-end">
                                <a href="{{ route('admin.withdrawals.show', $w->id) }}" class="btn-action-primary">
                                    <span>{{ __('معالجة الطلب') }}</span>
                                    <svg class="w-4 h-4 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center text-start">
                                <div class="flex flex-col items-center opacity-30 font-Cairo">
                                    <div class="w-20 h-20 bg-[var(--main-bg)] rounded-full flex items-center justify-center text-5xl mb-6 shadow-inner animate-pulse">💸</div>
                                    <p class="text-xs font-black uppercase tracking-widest font-Cairo text-start opacity-60">{{ __('لا توجد طلبات سحب حالياً') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($withdrawals->hasPages())
            <div class="p-10 border-t border-[var(--glass-border)]">
                {{ $withdrawals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
