@extends('layouts.admin')

@section('title', __('سندات العمولات'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-3xl font-Cairo shadow-lg shadow-emerald-500/5 whitespace-nowrap inline-flex items-center justify-center">🧾</span>
                {{ __('سندات العمولات') }}
            </h3>
            <p class="text-[13px] font-black uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo opacity-60">
                {{ __('متابعة وتحصيل عمولات المنصة من مزودي الخدمات.') }}
            </p>
        </div>
    </div>

    <!-- Stats Matrix -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 font-Cairo text-start">
        <div class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] transition-all text-start border border-[var(--glass-border)]">
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-[var(--glass-border)] rounded-2xl flex items-center justify-center text-[var(--main-text)] shadow-inner font-Cairo text-2xl">📊</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black font-mono leading-none text-start italic">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[12px] font-black uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-60">{{ __('إجمالي السندات') }}</span>
                </div>
            </div>
        </div>

        <a href="?status=pending" class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] transition-all text-start border border-amber-500/10 bg-amber-50/20 dark:bg-amber-950/10">
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform italic font-black">؟</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-amber-600 font-mono leading-none text-start italic">{{ str_pad($stats['pending'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[12px] font-black text-amber-500 uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-80">{{ __('بانتظار الموافقة') }}</span>
                </div>
            </div>
        </a>

        <div class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] transition-all text-start border border-emerald-500/10 bg-emerald-50/20 dark:bg-emerald-950/10">
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl italic font-black">✔</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-emerald-600 font-mono leading-none text-start italic">{{ str_pad($stats['approved'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[12px] font-black text-emerald-500 uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-80">{{ __('سندات مقبولة') }}</span>
                </div>
            </div>
        </div>

        <div class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] transition-all text-start border border-indigo-500/10 bg-indigo-50/20 dark:bg-indigo-950/10">
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-indigo-500 text-white rounded-2xl flex items-center justify-center text-2xl italic font-black">💰</div>
                <div class="flex flex-col text-start">
                    <span class="text-2xl font-black text-indigo-600 font-mono leading-none text-start italic">{{ number_format($stats['total_amount'], 2) }}</span>
                    <span class="text-[12px] font-black text-indigo-500 uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-80">{{ __('إجمالي المحصل (ر.س)') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bonds Table Matrix -->
    <div class="card-premium glass-panel rounded-[4.5rem] overflow-hidden shadow-2xl relative border border-[var(--glass-border)] text-start font-Cairo">
        <div class="px-12 py-10 border-b border-[var(--glass-border)] bg-[var(--main-bg)] flex justify-between items-center text-start font-Cairo">
            <div class="text-start">
                <h4 class="font-black text-xl font-Cairo text-start italic">{{ __('سجل الحوالات والعمولات') }}</h4>
                <p class="text-[13px] font-black uppercase tracking-[0.3em] mt-2 text-start font-Cairo opacity-60">{{ __('عرض شامل لجميع سندات دفع العمولات المقدمة من المزودين.') }}</p>
            </div>
        </div>
        
        <div class="overflow-x-auto text-start">
            <table class="w-full text-start">
                <thead class="bg-[var(--main-bg)] font-black text-[12px] uppercase tracking-[0.3em] border-b border-[var(--glass-border)] font-Cairo text-start opacity-60">
                    <tr>
                        <th class="px-10 py-6 text-start">ID</th>
                        <th class="px-10 py-6 text-start">{{ __('الطلب / المرجع') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('مزود الخدمة') }}</th>
                        <th class="px-10 py-6 text-center">{{ __('المبلغ') }}</th>
                        <th class="px-10 py-6 text-center">{{ __('الحالة') }}</th>
                        <th class="px-10 py-6 text-end">{{ __('الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--glass-border)] font-Cairo text-start">
                    @forelse ($bonds as $bond)
                        <tr class="hover:bg-emerald-500/[0.01] transition-all group text-start">
                            <td class="px-10 py-7 text-start">
                                <span class="text-xs font-black font-mono tracking-tighter opacity-60">#{{ str_pad($bond->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-10 py-7 text-start">
                                <div class="flex flex-col text-start">
                                    <a href="{{ route('requests.show', $bond->request_id) }}" class="text-sm font-black font-Cairo leading-tight mb-2 hover:text-brand-primary italic">#{{ $bond->request_id }} - {{ $bond->request->user->name ?? '---' }}</a>
                                    <span class="text-[12px] font-black text-[var(--text-muted)] italic">📅 {{ $bond->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-7 text-start">
                                <div class="flex items-center gap-3 text-start">
                                    <div class="w-10 h-10 bg-[var(--glass-border)] rounded-xl flex items-center justify-center text-[14px] font-black group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-inner font-Cairo italic">
                                        {{ mb_substr($bond->request->serviceProvider()->name ?? 'P', 0, 1) }}
                                    </div>
                                    <span class="text-[13px] font-black font-Cairo text-start italic">{{ $bond->request->serviceProvider()->name ?? '---' }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-7 text-center">
                                <span class="text-base font-black font-mono text-emerald-600 italic">{{ number_format($bond->amount, 2) }}</span>
                                <span class="text-[12px] font-bold opacity-40 ml-1 italic">ر.س</span>
                            </td>
                            <td class="px-10 py-7 text-center">
                                <span class="px-4 py-2 rounded-xl text-[12px] font-black uppercase tracking-widest font-Cairo @if($bond->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 @elseif($bond->status == 'approved') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 @endif whitespace-nowrap inline-flex items-center justify-center">
                                    {{ __($bond->status) }}
                                </span>
                            </td>
                            <td class="px-10 py-7 text-end">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ asset('storage/' . $bond->image_path) }}" target="_blank" class="w-10 h-10 bg-[var(--glass-border)] rounded-xl flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm" title="{{ __('فتح الصورة') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    
                                    @if($bond->status == 'pending')
                                        <form action="{{ route('commission-bonds.approve', $bond) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-10 h-10 bg-emerald-500/10 text-emerald-600 rounded-xl flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="{{ __('موافقة') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>

                                        <form action="{{ route('commission-bonds.reject', $bond) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-10 h-10 bg-rose-500/10 text-rose-600 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm" title="{{ __('رفض') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center justify-center gap-6 opacity-30">
                                    <div class="w-24 h-24 bg-[var(--main-bg)] rounded-[2rem] flex items-center justify-center text-6xl shadow-inner animate-pulse italic">🧾</div>
                                    <span class="text-[13px] font-black uppercase tracking-[0.3em] font-Cairo opacity-60 italic">{{ __('لا توجد سندات عمولات حالياً.') }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bonds->hasPages())
        <div class="p-10 border-t border-[var(--glass-border)]">
            {{ $bonds->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
