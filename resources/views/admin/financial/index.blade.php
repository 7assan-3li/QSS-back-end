@extends('layouts.admin')

@section('title', __('التحصيل المالي والذكاء المحاسبي'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo pb-24 print:p-0 print:m-0" x-data="{ activeTooltip: null }">
    
    <!-- Fiscal Alerts -->
    @if(count($alerts) > 0)
    <div class="space-y-4 print:hidden px-4 md:px-0">
        @foreach($alerts as $alert)
        <div class="glass-panel p-6 rounded-3xl border-r-8 {{ $alert['type'] == 'warning' ? 'border-amber-500 bg-amber-500/[0.02]' : 'border-rose-500 bg-rose-500/[0.02]' }} flex items-center justify-between animate-slide-up shadow-xl shadow-slate-200/50 dark:shadow-none">
            <div class="flex items-center gap-6 text-start">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $alert['type'] == 'warning' ? 'bg-amber-500/10 text-amber-600' : 'bg-rose-500/10 text-rose-600' }} text-2xl shadow-inner animate-pulse">
                    {{ $alert['type'] == 'warning' ? '⚠️' : '🚨' }}
                </div>
                <div class="text-start">
                    <h5 class="font-black text-sm {{ $alert['type'] == 'warning' ? 'text-amber-700' : 'text-rose-700' }} italic underline-offset-4">{{ $alert['title'] }}</h5>
                    <p class="text-[11px] font-bold opacity-60 mt-1 leading-relaxed">{{ $alert['message'] }}</p>
                </div>
            </div>
            <button class="p-4 hover:rotate-90 transition-all opacity-40 hover:opacity-100" @click="$el.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Executive Header & Controls -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 px-4 md:px-0 text-start group print:flex-row print:justify-between font-Cairo">
        <div class="text-start">
            <h3 class="font-black text-4xl flex items-center gap-6 text-start font-Cairo leading-tight">
                <div class="relative group/icon print:hidden">
                    <span class="w-20 h-20 bg-brand-primary text-white rounded-[2.2rem] flex items-center justify-center text-4xl font-Cairo shadow-2xl shadow-brand-primary/20 transition-all group-hover/icon:scale-110 group-hover/icon:-rotate-3">📊</span>
                    <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-white dark:bg-slate-900 rounded-full flex items-center justify-center shadow-lg border-2 border-slate-50 dark:border-slate-800">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-ping"></div>
                    </div>
                </div>
                <div class="flex flex-col text-start">
                    <span class="italic text-slate-900 dark:text-white">{{ __('نظام الذكاء المحاسبي') }}</span>
                    <span class="text-[10px] font-black text-slate-400 mt-2 tracking-[0.5em] uppercase opacity-60">Strategic Ledger Control</span>
                </div>
            </h3>
        </div>

        <div class="flex flex-wrap items-center gap-6 print:hidden">
            <form action="{{ route('admin.financial.index') }}" method="GET" class="glass-panel p-2.5 rounded-[2.5rem] border border-slate-100 dark:border-white/5 flex items-center gap-4 bg-white/60 dark:bg-slate-900/60 shadow-xl">
                <div class="flex items-center gap-3 px-5 border-l border-slate-200 dark:border-white/10 rtl:border-l-0 rtl:border-r">
                    <span class="text-[10px] font-black text-brand-primary uppercase italic">{{ __('من') }}:</span>
                    <input type="date" name="from_date" value="{{ $fromDate->format('Y-m-d') }}" class="bg-transparent border-none text-[12px] font-black outline-none w-32 dark:text-white font-mono opacity-80 hover:opacity-100 transition-opacity">
                </div>
                <div class="flex items-center gap-3 px-5">
                    <span class="text-[10px] font-black text-indigo-500 uppercase italic">{{ __('إلى') }}:</span>
                    <input type="date" name="to_date" value="{{ $toDate->format('Y-m-d') }}" class="bg-transparent border-none text-[12px] font-black outline-none w-32 dark:text-white font-mono opacity-80 hover:opacity-100 transition-opacity">
                </div>
                <button type="submit" class="bg-brand-primary text-white w-12 h-12 rounded-[1.3rem] flex items-center justify-center hover:scale-110 active:scale-95 transition-all shadow-xl shadow-brand-primary/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>

            <button onclick="window.print()" class="h-16 px-8 bg-slate-900 hover:bg-black text-white rounded-[2rem] font-black text-[11px] uppercase tracking-[0.2em] flex items-center gap-4 transition-all shadow-2xl shadow-slate-900/20 italic group">
                <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4m14 0h-2"></path></svg>
                {{ __('تصدير PDF') }}
            </button>
        </div>
    </div>

    <!-- Tier 1: Master Ledger Breakdown (In vs Out) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 px-4 md:px-0">
        <!-- Inflow Summary -->
        <div class="card-premium glass-panel p-10 md:p-14 relative overflow-hidden group bg-emerald-500/5 dark:bg-emerald-500/[0.02] border border-emerald-500/10 shadow-emerald-500/5 text-start hover:scale-[1.01] transition-all duration-500"
             @mouseenter="activeTooltip = 'master-in'" @mouseleave="activeTooltip = null">
            
            <div class="flex justify-between items-start relative z-10 text-start">
                <div class="text-start">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[11px] font-black text-emerald-600 uppercase tracking-[0.4em] italic">{{ __('إجمالي التدفق الداخل الدقيق') }}</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-black font-mono italic mt-8 text-emerald-600 leading-none">
                        {{ number_format($totalInflow, 2) }}
                        <span class="text-sm opacity-40 ml-2 italic font-Cairo uppercase">{{ __('ر.س') }}</span>
                    </h2>
                </div>
                <div class="w-16 h-16 md:w-20 md:h-20 bg-white dark:bg-emerald-500/20 rounded-[2rem] flex items-center justify-center text-emerald-600 text-3xl md:text-4xl shadow-2xl shadow-emerald-500/10 transition-all group-hover:rotate-12">📥</div>
            </div>

            <div class="grid grid-cols-3 gap-8 mt-16 pt-12 border-t border-emerald-500/10 relative z-10 text-start font-Cairo">
                <div class="text-start">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 opacity-70 group-hover:text-emerald-500 transition-colors">{{ __('باقات النقاط') }}</p>
                    <span class="text-xl font-black text-slate-800 dark:text-emerald-300 italic opacity-90">+{{ number_format($pointsRevenue, 0) }}</span>
                </div>
                <div class="text-start border-x border-emerald-500/10 px-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 opacity-70 group-hover:text-emerald-500 transition-colors">{{ __('رسوم التوثيق') }}</p>
                    <span class="text-xl font-black text-slate-800 dark:text-emerald-300 italic opacity-90">+{{ number_format($verificationRevenue, 0) }}</span>
                </div>
                <div class="text-start">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 opacity-70 group-hover:text-emerald-500 transition-colors">{{ __('دخل العمولات') }}</p>
                    <span class="text-xl font-black text-slate-800 dark:text-emerald-300 italic opacity-90">+{{ number_format($paidCommissions, 0) }}</span>
                </div>
            </div>

            <!-- Absolute Help Overlay -->
            <div class="absolute inset-0 bg-emerald-600/95 backdrop-blur-xl p-12 flex flex-col justify-center items-center text-center text-white transition-all duration-500 opacity-0 group-hover:opacity-100 z-50 pointer-events-none" x-show="activeTooltip === 'master-in'" x-transition>
                <span class="text-4xl mb-6 italic">💎</span>
                <h5 class="text-xs font-black uppercase tracking-[0.5em] mb-4 opacity-70 italic">{{ __('المعادلة المحاسبية للمدخلات') }}</h5>
                <p class="text-sm font-bold leading-relaxed max-w-sm">{{ __('إجمالي السيولة النقدية التي دخلت المنصة فعلياً من (نقاط العملاء + رسوم توثيق المزودين + العمولات المسددة).') }}</p>
            </div>
        </div>

        <!-- Outflow Summary -->
        <div class="card-premium glass-panel p-10 md:p-14 relative overflow-hidden group bg-rose-500/5 dark:bg-rose-500/[0.02] border border-rose-500/10 shadow-rose-500/5 text-start hover:scale-[1.01] transition-all duration-500"
             @mouseenter="activeTooltip = 'master-out'" @mouseleave="activeTooltip = null">
            
            <div class="flex justify-between items-start relative z-10 text-start">
                <div class="text-start">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 bg-rose-500 rounded-full animate-pulse"></span>
                        <span class="text-[11px] font-black text-rose-600 uppercase tracking-[0.4em] italic">{{ __('إجمالي التدفق الخارج الفعلي') }}</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-black font-mono italic mt-8 text-rose-600 leading-none">
                        {{ number_format($totalOutflow, 2) }}
                        <span class="text-sm opacity-40 ml-2 italic font-Cairo uppercase">{{ __('ر.س') }}</span>
                    </h2>
                </div>
                <div class="w-16 h-16 md:w-20 md:h-20 bg-white dark:bg-rose-500/20 rounded-[2rem] flex items-center justify-center text-rose-600 text-3xl md:text-4xl shadow-2xl shadow-rose-500/10 transition-all group-hover:rotate-12">📤</div>
            </div>

            <div class="mt-16 pt-12 border-t border-rose-500/10 relative z-10 text-start font-Cairo">
                 <div class="text-start">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 opacity-70 group-hover:text-rose-500 transition-colors uppercase leading-tight">{{ __('حوالات الكاش المكتملة لمزودي الخدمة') }}</p>
                    <div class="flex items-center gap-5 text-start font-Cairo">
                        <span class="text-3xl font-black text-slate-800 dark:text-rose-300 italic opacity-90">{{ number_format($totalOutflow, 2) }}</span>
                        <span class="px-4 py-1.5 bg-rose-500/10 text-rose-600 text-[10px] font-black rounded-xl border border-rose-500/10 italic">Realized Payouts Only</span>
                    </div>
                </div>
            </div>

            <!-- Absolute Help Overlay -->
            <div class="absolute inset-0 bg-rose-600/95 backdrop-blur-xl p-12 flex flex-col justify-center items-center text-center text-white transition-all duration-500 opacity-0 group-hover:opacity-100 z-50 pointer-events-none" x-show="activeTooltip === 'master-out'" x-transition>
                <span class="text-4xl mb-6">📉</span>
                <h5 class="text-xs font-black uppercase tracking-[0.5em] mb-4 opacity-70 italic">{{ __('المحاسبة المادية للمخرجات') }}</h5>
                <p class="text-sm font-bold leading-relaxed max-w-sm">{{ __('إجمالي المبالغ النقدية الحقيقية التي تم تحويلها من حساب المنصة البنكي لمزودي الخدمة بناءً على طلبات سحب رصيدهم المعتمدة.') }}</p>
            </div>
        </div>
    </div>

    <!-- Tier 2: Internal Point Economy Dynamics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 px-4 md:px-0">
         <div class="card-premium glass-panel p-10 flex items-center justify-between border-l-8 border-indigo-500 bg-white/40 dark:bg-slate-900/40 text-start shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500"
              @mouseenter="activeTooltip = 'points-total'" @mouseleave="activeTooltip = null">
            <div class="flex items-center gap-8 text-start relative z-10">
                <div class="w-16 h-16 bg-indigo-500 text-white rounded-3xl flex items-center justify-center text-3xl shadow-xl shadow-indigo-500/20 italic font-black font-Cairo transition-transform group-hover:scale-110">∑</div>
                <div class="flex flex-col text-start">
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3 opacity-80">{{ __('إجمالي النقاط المسجلة في النظام') }}</span>
                    <div class="flex items-baseline gap-4 text-start">
                        <span class="text-5xl font-black font-mono italic text-indigo-600">{{ number_format($totalSystemPoints, 0) }}</span>
                        <span class="text-[11px] font-black opacity-30 uppercase tracking-widest leading-loose">{{ __('نقطة معلقة') }}</span>
                    </div>
                </div>
            </div>
            
             <!-- Help Overlay -->
            <div class="absolute inset-0 bg-indigo-600/95 backdrop-blur-md p-10 flex flex-col justify-center items-center text-center text-white transition-all duration-500 opacity-0 group-hover:opacity-100 z-50 pointer-events-none" x-show="activeTooltip === 'points-total'" x-transition>
                <p class="text-xs font-bold leading-relaxed">{{ __('مجموع رصيد "العملة الافتراضية" لجميع المستخدمين (طالبين ومزودين) حالياً.') }}</p>
            </div>
         </div>

         <div class="card-premium glass-panel p-10 flex items-center justify-between border-l-8 border-amber-500 bg-white/40 dark:bg-slate-900/40 text-start shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500"
              @mouseenter="activeTooltip = 'points-withdraw'" @mouseleave="activeTooltip = null">
            <div class="flex items-center gap-8 text-start relative z-10">
                <div class="w-16 h-16 bg-amber-500 text-white rounded-3xl flex items-center justify-center text-3xl shadow-xl shadow-amber-500/20 font-black italic transition-transform group-hover:scale-110 font-Cairo">♺</div>
                <div class="flex flex-col text-start">
                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.3em] mb-3 opacity-80">{{ __('نقاط المزودين القابلة للسحب كاش') }}</span>
                    <div class="flex items-baseline gap-4 text-start">
                        <span class="text-5xl font-black font-mono italic text-amber-600">{{ number_format($withdrawablePoints, 0) }}</span>
                        <span class="text-[11px] font-black opacity-30 uppercase tracking-widest leading-loose">{{ __('التزام سيولة') }}</span>
                    </div>
                </div>
            </div>

            <!-- Help Overlay -->
            <div class="absolute inset-0 bg-amber-600/95 backdrop-blur-md p-10 flex flex-col justify-center items-center text-center text-white transition-all duration-500 opacity-0 group-hover:opacity-100 z-50 pointer-events-none" x-show="activeTooltip === 'points-withdraw'" x-transition>
                <p class="text-xs font-bold leading-relaxed">{{ __('إجمالي الأرباح "الحقيقية" للمزودين بانتظار طلبات السحب لتحويلها لنقد.') }}</p>
            </div>
         </div>
    </div>

    <!-- Tier 3: Revenue Breakdown Analysis -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 md:px-0">
        @php
            $revStats = [
                ['id' => 'rev-p', 'label' => __('باقات النقاط'), 'val' => $pointsRevenue, 'col' => 'indigo', 'icon' => '🎫', 'help' => __('إجمالي مبيعات "العملة الداخلية" من شحن محافظ العملاء.')],
                ['id' => 'rev-v', 'label' => __('رسوم التوثيق'), 'val' => $verificationRevenue, 'col' => 'amber', 'icon' => '🛡️', 'help' => __('الدخل المباشر من رسوم تأكيد هوية المزودين وشارات الثقة.')],
                ['id' => 'rev-c', 'label' => __('عمولات ناجزة'), 'val' => $paidCommissions, 'col' => 'emerald', 'icon' => '💹', 'help' => __('ربح المنصة المقتطع من عمليات الخدمات التي تمت تسويتها فعلياً.')],
            ];
        @endphp

        @foreach($revStats as $item)
        <div class="card-premium glass-panel p-10 relative overflow-hidden group border border-slate-100 dark:border-white/5 shadow-lg hover:border-{{ $item['col'] }}-500/50 transition-all duration-500 text-start"
             @mouseenter="activeTooltip = '{{ $item['id'] }}'" @mouseleave="activeTooltip = null">
            
            <div class="flex items-center justify-between mb-10 text-start relative z-10">
                <div class="w-14 h-14 bg-{{ $item['col'] }}-500/10 rounded-2xl flex items-center justify-center text-{{ $item['col'] }}-600 text-2xl shadow-inner transition-transform group-hover:rotate-6">{{ $item['icon'] }}</div>
                <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest italic opacity-60">Source Breakdown</span>
            </div>

            <div class="text-start relative z-10">
                <h5 class="text-xs font-black italic text-slate-400 mb-3">{{ $item['label'] }}</h5>
                <div class="flex items-baseline gap-3 text-start">
                    <span class="text-4xl font-black font-mono italic text-slate-800 dark:text-white">{{ number_format($item['val'], 2) }}</span>
                    <span class="text-[11px] font-black opacity-20 italic uppercase tracking-widest">{{ __('ر.س') }}</span>
                </div>
            </div>

             <!-- Slide-up Help Overlay (The Fix) -->
            <div class="absolute inset-0 bg-slate-900/95 backdrop-blur-md p-8 flex flex-col justify-center items-center text-center text-white transition-all duration-500 group-hover:translate-y-0 translate-y-full z-50 pointer-events-none" 
                 x-show="activeTooltip === '{{ $item['id'] }}'" x-transition:enter="duration-500" x-transition:leave="duration-300">
                <div class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center mb-4 italic text-sm">ℹ️</div>
                <p class="text-[11px] font-bold leading-relaxed italic">{{ $item['help'] }}</p>
            </div>
            
            <div class="absolute -bottom-6 -right-6 text-7xl opacity-[0.03] group-hover:scale-110 transition-transform grayscale select-none">{{ $item['icon'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Tier 4: Analytical Deep-Dive -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 px-4 md:px-0">
        <!-- Service Logic table -->
        <div class="lg:col-span-8 card-premium glass-panel rounded-[4rem] overflow-hidden flex flex-col shadow-2xl border border-white/10 bg-white/40 dark:bg-slate-900/40">
            <div class="p-12 border-b border-slate-100 dark:border-white/5 flex justify-between items-center text-start font-Cairo">
                <div class="text-start">
                    <h4 class="text-2xl font-black font-Cairo text-start italic flex items-center gap-5">
                        <span class="w-2.5 h-12 bg-brand-primary rounded-full"></span>
                        {{ __('تحليل ربحية العمليات التشغيلية') }}
                    </h4>
                     <p class="text-[10px] font-black text-slate-400 mt-3 uppercase tracking-[0.3em] font-Cairo opacity-50">Profit contribution by active service category</p>
                </div>
            </div>
            <div class="flex-1 overflow-x-auto custom-scrollbar">
                <table class="w-full text-start">
                    <thead>
                        <tr class="bg-indigo-50/50 dark:bg-slate-950/50">
                            <th class="table-header-cell px-12 py-8 text-start text-[10px] uppercase font-black tracking-widest">{{ __('الخدمة') }}</th>
                            <th class="table-header-cell px-12 py-8 text-start text-[10px] uppercase font-black tracking-widest font-Cairo">{{ __('النشاط') }}</th>
                            <th class="table-header-cell px-12 py-8 text-start text-[10px] uppercase font-black tracking-widest">{{ __('دخل العمولة') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/3">
                        @foreach($topServices as $service)
                        <tr class="hover:bg-brand-primary/[0.04] transition-all group">
                            <td class="px-12 py-8 text-start">
                                <span class="text-[13px] font-black italic opacity-90 group-hover:text-brand-primary transition-colors">{{ $service->name }}</span>
                            </td>
                            <td class="px-12 py-8">
                                <span class="px-5 py-2.5 bg-brand-primary/10 text-brand-primary rounded-xl text-[11px] font-black font-mono shadow-inner italic animate-fade-in group-hover:scale-105 transition-transform">x{{ $service->request_count }} Requests</span>
                            </td>
                            <td class="px-12 py-8 text-start">
                                <div class="flex flex-col gap-3">
                                    <span class="text-sm font-black text-emerald-500 font-mono italic">{{ number_format($service->total_commission, 2) }} ر.س</span>
                                    <div class="w-40 bg-slate-100 dark:bg-slate-900/60 h-1.5 rounded-full overflow-hidden shadow-inner flex">
                                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-full rounded-full transition-all duration-1000 origin-left" style="width: {{ min(($service->total_commission / max($paidCommissions, 1)) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Net Profit Structure -->
        <div class="lg:col-span-4 card-premium glass-panel p-12 text-start flex flex-col justify-between shadow-2xl rounded-[4rem] bg-white/60 dark:bg-slate-900/60 border border-white/10 font-Cairo">
            <div @mouseenter="activeTooltip = 'profit-split'" @mouseleave="activeTooltip = null" class="relative">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.5em] italic mb-12">{{ __('هيكلية صافي الأرباح') }}</h4>
                <div class="flex-1 flex flex-col justify-center items-center relative gap-10">
                    <canvas id="profitChart" class="max-w-[210px]"></canvas>
                    <div class="absolute flex flex-col items-center translate-y-[-25px] pointer-events-none">
                        <span class="text-3xl font-black italic text-slate-800 dark:text-white">{{ number_format($totalProfit, 0) }}</span>
                        <span class="text-[10px] font-black uppercase opacity-30 mt-1 uppercase tracking-widest">Net Realized</span>
                    </div>
                </div>

                <!-- Hover Anatomy Guide -->
                <div class="space-y-4 mt-12 relative z-10 font-Cairo">
                    <div class="flex justify-between items-center p-5 bg-indigo-500/[0.03] rounded-2xl border border-indigo-500/10 group/item hover:bg-indigo-500/10 transition-all">
                        <div class="flex items-center gap-4 text-start font-Cairo"><span class="w-3 h-3 bg-indigo-500 rounded-full animate-pulse"></span><span class="text-[10px] font-black uppercase italic">{{ __('دخل العمولات') }}</span></div>
                        <span class="text-sm font-black italic font-mono text-indigo-600">{{ number_format(($paidCommissions / max($totalProfit, 1)) * 100, 0) }}%</span>
                    </div>
                    <div class="flex justify-between items-center p-5 bg-amber-500/[0.03] rounded-2xl border border-amber-500/10 group/item hover:bg-amber-500/10 transition-all font-Cairo text-start">
                        <div class="flex items-center gap-4 text-start font-Cairo text-start"><span class="w-3 h-3 bg-amber-500 rounded-full animate-pulse"></span><span class="text-[10px] font-black uppercase italic">{{ __('دخل التوثيق') }}</span></div>
                        <span class="text-sm font-black italic font-mono text-amber-600 font-mono">{{ number_format(($verificationRevenue / max($totalProfit, 1)) * 100, 0) }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tier 5: Accounting Lexicon & Latest Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 px-4 md:px-0 font-Cairo">
        <!-- Expanded Glossary -->
        <div class="card-premium glass-panel p-14 rounded-[5rem] text-start border-2 border-slate-100 dark:border-white/5 shadow-2xl font-Cairo bg-slate-900 text-white min-h-[500px] flex flex-col">
            <h4 class="text-2xl font-black italic mb-12 flex items-center gap-5 text-start font-Cairo">
                <span class="w-3 h-12 bg-brand-primary rounded-xl italic font-black"></span>
                {{ __('الموسوعة المحاسبية للمنصة') }}
            </h4>
            <div class="space-y-12 text-start flex-1 font-Cairo">
                <div class="text-start font-Cairo">
                    <h6 class="text-base font-black text-brand-primary italic mb-4">{{ __('النقاط المسجلة (Internal Debt)') }}</h6>
                    <p class="text-[12px] font-bold opacity-60 leading-relaxed font-Cairo italic">{{ __('تمثل "التزاماً مستقبلياً" من المنصة تجاه المستخدمين. هي القوة الشرائية المتاحة داخل النظام بانتظار استهلاكها أو سحبها.') }}</p>
                </div>
                <div class="text-start font-Cairo">
                    <h6 class="text-base font-black text-amber-500 italic mb-4 font-Cairo">{{ __('النقاط القابلة للسحب (Liability)') }}</h6>
                    <p class="text-[12px] font-bold opacity-60 leading-relaxed font-Cairo italic">{{ __('هي السيولة "الواقعية" التي يحق للمزودين تحويلها لنقد في أي لحظة. يجب التأكد دائماً من توفر غطاء بكي لهذا الرقم.') }}</p>
                </div>
                <div class="mt-auto p-8 bg-white/5 rounded-[2.5rem] border border-white/10 italic text-start font-Cairo">
                     <p class="text-[11px] font-black opacity-40 uppercase tracking-[0.2em] leading-loose text-start font-Cairo">{{ __('تنبيه الدقة: إحصائيات الأرباح في هذه الصفحة تعتمد حصراً على المبالغ التي تم "تسويتها فعلياً" لضمان سلامة التدفق المالي.') }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Ledger -->
        <div class="card-premium glass-panel rounded-[5rem] overflow-hidden flex flex-col font-Cairo shadow-2xl border border-slate-100 dark:border-white/5">
             <div class="p-12 border-b border-slate-100 dark:border-white/5 flex justify-between items-center text-start group">
                  <div class="text-start">
                        <h4 class="text-xl font-black italic text-start font-Cairo">{{ __('أحدث التدفقات المعتمدة') }}</h4>
                        <span class="text-[10px] font-black opacity-30 uppercase tracking-[0.3em] mt-2 block font-Cairo italic">Cash-In Verification Registry</span>
                  </div>
                  <a href="#" class="w-12 h-12 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary transition-all hover:bg-brand-primary hover:text-white group-hover:rotate-12 shadow-lg">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                  </a>
             </div>
             <div class="flex-1 overflow-x-auto custom-scrollbar">
                <table class="w-full text-start">
                    <tbody class="divide-y divide-slate-100 dark:divide-white/3">
                        @foreach($detailedInflows->take(6) as $item)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-white/[0.04] transition-all">
                            <td class="px-12 py-12 text-start">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-slate-900 text-white rounded-xl flex items-center justify-center text-xs font-black shadow-lg">👤</div>
                                    <div class="flex flex-col">
                                        <span class="text-[13px] font-black italic text-slate-800 dark:text-white">{{ $item->user->name ?? '---' }}</span>
                                        <span class="text-[9px] font-black opacity-40 uppercase italic tracking-widest mt-1">{{ $item->package->name ?? __('قيد الربط') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-12 py-12 text-start leading-none italic">
                                <span class="text-lg font-black text-emerald-600 font-mono italic">+{{ number_format($item->package->price ?? 0, 0) }} <span class="text-[10px] opacity-40 uppercase">R.S</span></span>
                            </td>
                            <td class="px-12 py-12 text-[10px] font-black text-slate-300 font-mono uppercase italic text-start">
                                {{ $item->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
             </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { height: 10px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.1); border-radius: 10px; border: 3px solid transparent; background-clip: content-box; }
    .animate-fade-in { animation: fade-in 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fade-in { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    
    @media print {
        body { padding: 0 !important; margin: 0 !important; background: white !important; font-size: 10pt; }
        .glass-panel { border: 0.5pt solid #ddd !important; box-shadow: none !important; background: transparent !important; }
        .card-premium { border-radius: 1rem !important; }
        aside, header, nav, footer, .print-hide, .animate-pulse, [x-show] { display: none !important; }
        .max-w-7xl { max-width: 100% !important; border: none !important; margin: 0 !important; }
        .divide-y > * { border-color: #ddd !important; }
        canvas, .chart-container { display: none !important; }
        @page { size: A4; margin: 15mm; }
    }
</style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = 'Cairo, sans-serif';
        Chart.defaults.color = 'rgba(148, 163, 184, 0.5)';
        
        const ctxProfit = document.getElementById('profitChart')?.getContext('2d');
        if(ctxProfit){
            new Chart(ctxProfit, {
                type: 'doughnut',
                data: {
                    labels: ['{{ __('العمولات') }}', '{{ __('التوثيق') }}'],
                    datasets: [{
                        data: [{{ $paidCommissions }}, {{ $verificationRevenue }}],
                        backgroundColor: ['#6366f1', '#f59e0b'],
                        borderWidth: 10,
                        borderColor: 'transparent',
                        hoverOffset: 30
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '84%',
                    plugins: { legend: { display: false } }
                }
            });
        }
    </script>
@endpush
