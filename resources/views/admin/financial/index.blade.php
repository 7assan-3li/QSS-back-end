@extends('layouts.admin')

@section('title', __('التحصيل المالي والذكاء المحاسبي'))

@section('content')
<div class="max-w-7xl mx-auto space-y-16 mt-4 animate-fade-in text-start font-Cairo pb-32 print:p-0 print:m-0" x-data="{ activeTooltip: null, activeLedger: 'points' }">
    
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
                    <p class="text-[14px] font-bold opacity-60 mt-1 leading-relaxed">{{ $alert['message'] }}</p>
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
                    <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-[var(--glass-bg)] rounded-full flex items-center justify-center shadow-lg border-2 border-[var(--glass-border)]">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-ping"></div>
                    </div>
                </div>
                <div class="flex flex-col text-start">
                    <span class="italic text-[var(--main-text)]">{{ __('نظام الذكاء المحاسبي') }}</span>
                    <span class="text-[13px] font-black text-[var(--text-muted)] mt-2 tracking-[0.5em] uppercase opacity-60">Complete Financial Ledger Control</span>
                </div>
            </h3>
        </div>

        <div class="flex flex-wrap items-center gap-6 print:hidden">
            <form action="{{ route('admin.financial.index') }}" method="GET" class="glass-panel p-2.5 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-4 bg-[var(--glass-bg)]/60 shadow-xl">
                <div class="flex items-center gap-3 px-5 border-l border-[var(--glass-border)] rtl:border-l-0 rtl:border-r font-Cairo">
                    <span class="text-[13px] font-black text-brand-primary uppercase italic">{{ __('من') }}:</span>
                    <input type="date" name="from_date" value="{{ $fromDate->format('Y-m-d') }}" class="bg-transparent border-none text-[12px] font-black outline-none w-32 text-[var(--main-text)] font-mono opacity-80 hover:opacity-100 transition-opacity">
                </div>
                <div class="flex items-center gap-3 px-5 font-Cairo">
                    <span class="text-[13px] font-black text-indigo-500 uppercase italic">{{ __('إلى') }}:</span>
                    <input type="date" name="to_date" value="{{ $toDate->format('Y-m-d') }}" class="bg-transparent border-none text-[12px] font-black outline-none w-32 text-[var(--main-text)] font-mono opacity-80 hover:opacity-100 transition-opacity">
                </div>
                <button type="submit" class="bg-brand-primary text-white w-12 h-12 rounded-[1.3rem] flex items-center justify-center hover:scale-110 transition-all shadow-xl shadow-brand-primary/30 font-Cairo">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>

            <button onclick="window.print()" class="h-16 px-8 bg-slate-900 hover:bg-black text-white rounded-[2rem] font-black text-[14px] uppercase tracking-[0.2em] flex items-center gap-4 transition-all shadow-2xl shadow-slate-900/20 italic group font-Cairo">
                <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4m14 0h-2"></path></svg>
                {{ __('تصدير التقرير الكامل') }}
            </button>
        </div>
    </div>

    <!-- Tier 1: Master Statistics Ledger -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 px-4 md:px-0">
        <!-- Inflow Summary -->
        <div class="card-premium glass-panel p-10 md:p-14 relative overflow-hidden group bg-emerald-500/5 dark:bg-emerald-500/[0.02] border border-emerald-500/10 shadow-emerald-500/5 text-start hover:scale-[1.01] transition-all duration-500"
             @mouseenter="activeTooltip = 'master-in'" @mouseleave="activeTooltip = null">
            
            <div class="flex justify-between items-start relative z-10 text-start">
                <div class="text-start">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[14px] font-black text-emerald-600 uppercase tracking-[0.4em] italic">{{ __('إجمالي السيولة الداخلة المعتمدة') }}</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-black font-mono italic mt-8 text-emerald-600 leading-none">
                        {{ number_format($totalInflow, 2) }}
                        <span class="text-sm opacity-40 ml-2 italic font-Cairo uppercase">{{ __('ر.س') }}</span>
                    </h2>
                </div>
                <div class="w-16 h-16 md:w-20 md:h-20 bg-[var(--glass-bg)] dark:bg-emerald-500/20 rounded-[2rem] flex items-center justify-center text-emerald-600 text-3xl md:text-4xl shadow-2xl shadow-emerald-500/10 transition-all group-hover:rotate-12">📥</div>
            </div>

            <div class="grid grid-cols-3 gap-8 mt-16 pt-12 border-t border-emerald-500/10 relative z-10 text-start font-Cairo">
                <div class="text-start">
                    <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-4 opacity-70 group-hover:text-emerald-500 transition-colors uppercase leading-none">{{ __('باقات النقاط') }}</p>
                    <span class="text-xl font-black text-[var(--main-text)] dark:text-emerald-300 italic opacity-90">+{{ number_format($pointsRevenue, 0) }}</span>
                </div>
                <div class="text-start border-x border-emerald-500/10 px-8">
                    <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-4 opacity-70 group-hover:text-emerald-500 transition-colors uppercase leading-none">{{ __('رسوم التوثيق') }}</p>
                    <span class="text-xl font-black text-[var(--main-text)] dark:text-emerald-300 italic opacity-90">+{{ number_format($verificationRevenue, 0) }}</span>
                </div>
                <div class="text-start">
                    <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-4 opacity-70 group-hover:text-emerald-500 transition-colors uppercase leading-none">{{ __('العمولات المحصلة') }}</p>
                    <span class="text-xl font-black text-[var(--main-text)] dark:text-emerald-300 italic opacity-90">+{{ number_format($paidCommissions, 0) }}</span>
                </div>
            </div>

            <div class="absolute inset-0 bg-emerald-600/95 backdrop-blur-xl p-12 flex flex-col justify-center items-center text-center text-white transition-all duration-500 opacity-0 group-hover:opacity-100 z-50 pointer-events-none" x-show="activeTooltip === 'master-in'" x-transition>
                <span class="text-4xl mb-6 italic">💎</span>
                <h5 class="text-xs font-black uppercase tracking-[0.5em] mb-4 opacity-70 italic">{{ __('المعادلة المحاسبية للمدخلات') }}</h5>
                <p class="text-sm font-bold leading-relaxed max-w-sm font-Cairo italic">{{ __('إجمالي السيولة النقدية التي دخلت المنصة فعلياً من (نقاط العملاء + رسوم توثيق المزودين + العمولات المسددة).') }}</p>
            </div>
        </div>

        <!-- Outflow Summary -->
        <div class="card-premium glass-panel p-10 md:p-14 relative overflow-hidden group bg-rose-500/5 dark:bg-rose-500/[0.02] border border-rose-500/10 shadow-rose-500/5 text-start hover:scale-[1.01] transition-all duration-500"
             @mouseenter="activeTooltip = 'master-out'" @mouseleave="activeTooltip = null">
            
            <div class="flex justify-between items-start relative z-10 text-start font-Cairo">
                <div class="text-start">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 bg-rose-500 rounded-full animate-pulse"></span>
                        <span class="text-[14px] font-black text-rose-600 uppercase tracking-[0.4em] italic">{{ __('إجمالي السيولة الخارجة المعتمدة') }}</span>
                    </div>
                    <h2 class="text-5xl md:text-7xl font-black font-mono italic mt-8 text-rose-600 leading-none">
                        {{ number_format($totalOutflow, 2) }}
                        <span class="text-sm opacity-40 ml-2 italic font-Cairo uppercase font-Cairo text-start">{{ __('ر.س') }}</span>
                    </h2>
                </div>
                <div class="w-16 h-16 md:w-20 md:h-20 bg-[var(--glass-bg)] dark:bg-rose-500/20 rounded-[2rem] flex items-center justify-center text-rose-600 text-3xl md:text-4xl shadow-2xl shadow-rose-500/10 transition-all group-hover:rotate-12">📤</div>
            </div>

            <div class="mt-16 pt-12 border-t border-rose-500/10 relative z-10 text-start font-Cairo">
                 <div class="text-start font-Cairo">
                    <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest mb-4 opacity-70 group-hover:text-rose-500 transition-colors uppercase leading-tight font-Cairo italic">{{ __('حوالات الكاش المكتملة لمزودي الخدمة') }}</p>
                    <div class="flex items-center gap-5 text-start font-Cairo">
                        <span class="text-3xl font-black text-[var(--main-text)] dark:text-rose-300 italic opacity-90">{{ number_format($totalOutflow, 2) }}</span>
                        <span class="px-4 py-1.5 bg-rose-500/10 text-rose-600 text-[13px] font-black rounded-xl border border-rose-500/10 italic whitespace-nowrap inline-flex items-center justify-center">Realized Payouts Only</span>
                    </div>
                </div>
            </div>

            <div class="absolute inset-0 bg-rose-600/95 backdrop-blur-xl p-12 flex flex-col justify-center items-center text-center text-white transition-all duration-500 opacity-0 group-hover:opacity-100 z-50 pointer-events-none" x-show="activeTooltip === 'master-out'" x-transition>
                <span class="text-4xl mb-6">📉</span>
                <h5 class="text-xs font-black uppercase tracking-[0.5em] mb-4 opacity-70 italic">{{ __('المحاسبة المادية للمخرجات') }}</h5>
                <p class="text-sm font-bold leading-relaxed max-w-sm font-Cairo italic">{{ __('إجمالي المبالغ النقدية الحقيقية التي تم تحويلها من حساب المنصة البنكي لمزودي الخدمة بناءً على طلبات سحب رصيدهم المعتمدة.') }}</p>
            </div>
        </div>
    </div>

    <!-- Tier 2: Performance Growth Pulse (RESTORED TREND CHART) -->
    <div class="px-4 md:px-0">
        <div class="card-premium glass-panel p-10 md:p-14 rounded-[3.5rem] border border-white/10 bg-[var(--glass-bg)]/40 shadow-2xl relative overflow-hidden">
             <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-primary/0 via-brand-primary/20 to-brand-primary/0"></div>
             
             <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6 text-start">
                  <div class="text-start font-Cairo">
                       <h4 class="text-2xl font-black font-Cairo text-start italic flex items-center gap-4">
                            <span class="w-2.5 h-10 bg-brand-primary rounded-full"></span>
                            {{ __('نبض النمو والتدفق المالي (6 أشهر)') }}
                       </h4>
                       <p class="text-[13px] font-black text-[var(--text-muted)] mt-2 uppercase tracking-[0.3em] font-Cairo opacity-50 italic">Monthly Cashflow Evolution Trend</p>
                  </div>
                  <div class="flex items-center gap-6 font-Cairo">
                       <div class="flex items-center gap-2">
                           <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                           <span class="text-[13px] font-black opacity-60">{{ __('السيولة الداخلة') }}</span>
                       </div>
                       <div class="flex items-center gap-2">
                           <span class="w-3 h-3 bg-rose-500 rounded-full"></span>
                           <span class="text-[13px] font-black opacity-60">{{ __('السيولة الخارجة') }}</span>
                       </div>
                  </div>
             </div>

             <div class="h-[400px] w-full relative">
                  <canvas id="cashflowChart"></canvas>
             </div>
        </div>
    </div>

    <!-- Tier 3: Internal Currency Dynamics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 px-4 md:px-0">
         <div class="card-premium glass-panel p-10 flex items-center justify-between border-l-8 border-indigo-500 bg-[var(--glass-bg)]/40 text-start shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500"
              @mouseenter="activeTooltip = 'points-total'" @mouseleave="activeTooltip = null">
            <div class="flex items-center gap-8 text-start relative z-10 font-Cairo">
                <div class="w-16 h-16 bg-indigo-500 text-white rounded-3xl flex items-center justify-center text-3xl shadow-xl shadow-indigo-500/20 italic font-black transition-transform group-hover:scale-110 font-Cairo text-start">∑</div>
                <div class="flex flex-col text-start">
                    <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-3 opacity-80 font-Cairo italic">{{ __('إجمالي النقاط المسجلة حالياً') }}</span>
                    <div class="flex items-baseline gap-4 text-start font-Cairo text-start">
                        <span class="text-5xl font-black font-mono italic text-indigo-600">{{ number_format($totalSystemPoints, 0) }}</span>
                        <span class="text-[14px] font-black opacity-30 uppercase tracking-widest leading-loose font-Cairo italic">{{ __('نقطة معلقة') }}</span>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 bg-indigo-600/95 backdrop-blur-md p-10 flex flex-col justify-center items-center text-center text-white transition-all duration-500 opacity-0 group-hover:opacity-100 z-50 pointer-events-none" x-show="activeTooltip === 'points-total'" x-transition>
                <p class="text-xs font-bold leading-relaxed font-Cairo italic">{{ __('مجموع رصيد"العملة الافتراضية" لجميع المستخدمين (طالبين ومزودين) حالياً.') }}</p>
            </div>
         </div>

         <div class="card-premium glass-panel p-10 flex items-center justify-between border-l-8 border-amber-500 bg-[var(--glass-bg)]/40 text-start shadow-xl relative overflow-hidden group hover:scale-[1.02] transition-all duration-500"
              @mouseenter="activeTooltip = 'points-withdraw'" @mouseleave="activeTooltip = null">
            <div class="flex items-center gap-8 text-start relative z-10 font-Cairo">
                <div class="w-16 h-16 bg-amber-500 text-white rounded-3xl flex items-center justify-center text-3xl shadow-xl shadow-amber-500/20 font-black italic transition-transform group-hover:scale-110 font-Cairo text-start">♺</div>
                <div class="flex flex-col text-start">
                    <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-3 opacity-80 font-Cairo italic">{{ __('نقاط المزودين القابلة للسحب كاش') }}</span>
                    <div class="flex items-baseline gap-4 text-start">
                        <span class="text-5xl font-black font-mono italic text-amber-600">{{ number_format($withdrawablePoints, 0) }}</span>
                        <span class="text-[14px] font-black opacity-30 uppercase tracking-widest leading-loose font-Cairo italic">{{ __('التزام سيولة') }}</span>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 bg-amber-600/95 backdrop-blur-md p-10 flex flex-col justify-center items-center text-center text-white transition-all duration-500 opacity-0 group-hover:opacity-100 z-50 pointer-events-none" x-show="activeTooltip === 'points-withdraw'" x-transition>
                <p class="text-xs font-bold leading-relaxed font-Cairo italic">{{ __('إجمالي الأرباح"الحقيقية" للمزودين بانتظار طلبات السحب لتحويلها لنقد.') }}</p>
            </div>
         </div>
    </div>

    <!-- Tier 4: Revenue Breakdown Analysis -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 md:px-0">
        @php
            $revStats = [
                ['id' => 'rev-p', 'label' => __('باقات النقاط'), 'val' => $pointsRevenue, 'col' => 'indigo', 'icon' => '🎫', 'help' => __('إجمالي مبيعات"العملة الداخلية" من شحن محافظ العملاء.')],
                ['id' => 'rev-v', 'label' => __('رسوم التوثيق'), 'val' => $verificationRevenue, 'col' => 'amber', 'icon' => '🛡️', 'help' => __('الدخل المباشر من رسوم تأكيد هوية المزودين وشارات الثقة.')],
                ['id' => 'rev-c', 'label' => __('عمولات ناجزة'), 'val' => $paidCommissions, 'col' => 'emerald', 'icon' => '💹', 'help' => __('ربح المنصة المقتطع من عمليات الخدمات التي تمت تسويتها فعلياً.')],
            ];
        @endphp

        @foreach($revStats as $item)
        <div class="card-premium glass-panel p-10 relative overflow-hidden group border border-[var(--glass-border)] shadow-lg hover:border-{{ $item['col'] }}-500/50 transition-all duration-500 text-start"
             @mouseenter="activeTooltip = '{{ $item['id'] }}'" @mouseleave="activeTooltip = null">
            
            <div class="flex items-center justify-between mb-10 text-start relative z-10 font-Cairo">
                <div class="w-14 h-14 bg-{{ $item['col'] }}-500/10 rounded-2xl flex items-center justify-center text-{{ $item['col'] }}-600 text-2xl shadow-inner transition-transform group-hover:rotate-6">{{ $item['icon'] }}</div>
                <span class="text-[12px] font-black text-slate-300 uppercase tracking-widest italic opacity-60 font-Cairo text-start">Source Breakdown</span>
            </div>

            <div class="text-start relative z-10">
                <h5 class="text-xs font-black italic text-[var(--text-muted)] mb-3 font-Cairo">{{ $item['label'] }}</h5>
                <div class="flex items-baseline gap-3 text-start font-Cairo">
                    <span class="text-4xl font-black font-mono italic text-[var(--main-text)]">{{ number_format($item['val'], 2) }}</span>
                    <span class="text-[14px] font-black opacity-20 italic uppercase tracking-widest font-Cairo">{{ __('ر.س') }}</span>
                </div>
            </div>

            <div class="absolute inset-0 bg-slate-900/95 backdrop-blur-md p-8 flex flex-col justify-center items-center text-center text-white transition-all duration-500 group-hover:translate-y-0 translate-y-full z-50 pointer-events-none" 
                 x-show="activeTooltip === '{{ $item['id'] }}'" x-transition:enter="duration-500" x-transition:leave="duration-300">
                <div class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center mb-4 italic text-sm">ℹ️</div>
                <p class="text-[14px] font-bold leading-relaxed italic font-Cairo">{{ $item['help'] }}</p>
            </div>
            
            <div class="absolute -bottom-6 -right-6 text-7xl opacity-[0.03] group-hover:scale-110 transition-transform grayscale select-none">{{ $item['icon'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Tier 5: Detailed Financial Archive -->
    <div class="px-4 md:px-0 space-y-12">
        <div class="text-start">
            <h4 class="text-3xl font-black italic font-Cairo flex items-center gap-6">
                <span class="w-4 h-14 bg-slate-900 rounded-2xl whitespace-nowrap inline-flex items-center justify-center"></span>
                {{ __('مركز الأرشيف المالي الشامل') }}
            </h4>
            <p class="text-xs font-bold text-[var(--text-muted)] mt-2 uppercase tracking-[0.4em] opacity-60">Full Granular Transaction Repository</p>
        </div>

        <div class="card-premium glass-panel rounded-[4rem] overflow-hidden shadow-2xl border border-white/10 bg-[var(--glass-bg)]/40">
            <div class="flex items-center bg-[var(--glass-bg)]/50 dark:bg-[var(--glass-bg)]/5 p-4 md:p-6 border-b border-white/10 overflow-x-auto gap-4 md:gap-8 font-Cairo">
                <button @click="activeLedger = 'points'" :class="activeLedger === 'points' ? 'bg-indigo-600 text-white shadow-lg scale-105' : 'bg-transparent text-[var(--text-muted)] opacity-60 hover:opacity-100'" class="px-8 py-4 rounded-2xl text-[14px] font-black uppercase tracking-widest transition-all italic flex items-center gap-3 whitespace-nowrap">
                    <span class="text-lg">🎟️</span> {{ __('سجل شحن المحافظ') }}
                </button>
                <button @click="activeLedger = 'verification'" :class="activeLedger === 'verification' ? 'bg-amber-500 text-white shadow-lg scale-105' : 'bg-transparent text-[var(--text-muted)] opacity-60 hover:opacity-100'" class="px-8 py-4 rounded-2xl text-[14px] font-black uppercase tracking-widest transition-all italic flex items-center gap-3 whitespace-nowrap">
                    <span class="text-lg">🛡️</span> {{ __('سجل رسوم التوثيق') }}
                </button>
                <button @click="activeLedger = 'outflow'" :class="activeLedger === 'outflow' ? 'bg-rose-500 text-white shadow-lg scale-105' : 'bg-transparent text-[var(--text-muted)] opacity-60 hover:opacity-100'" class="px-8 py-4 rounded-2xl text-[14px] font-black uppercase tracking-widest transition-all italic flex items-center gap-3 whitespace-nowrap">
                    <span class="text-lg">📤</span> {{ __('سجل تحويلات الكاش') }}
                </button>
            </div>

            <div class="p-4 md:p-8 font-Cairo">
                <!-- Points Ledger -->
                <div x-show="activeLedger === 'points'" x-transition class="space-y-8 animate-fade-in">
                    <div class="overflow-x-auto custom-scrollbar rounded-[2.5rem] border border-white/5 font-Cairo text-start">
                        <table class="w-full text-start">
                            <thead class="bg-indigo-500/5 border-b border-indigo-500/10">
                                <tr>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('المستفيد') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('الباقة / القيمة') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('رقم السند') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('التاريخ') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($detailedPoints as $item)
                                <tr class="hover:bg-indigo-500/[0.03] transition-all group font-Cairo text-start">
                                    <td class="px-10 py-8 text-start font-Cairo">
                                        <div class="flex items-center gap-5">
                                            <div class="w-12 h-12 bg-[var(--glass-bg)] text-[var(--main-text)] border border-[var(--glass-border)] rounded-xl flex items-center justify-center text-[14px] font-black shadow-lg">👤</div>
                                            <div class="flex flex-col text-start">
                                                <span class="text-[13px] font-black italic lrading-none">{{ $item->user->name ?? '---' }}</span>
                                                <span class="text-[12px] opacity-40 uppercase tracking-widest mt-1">ID #{{ $item->user_id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-start font-Cairo">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-indigo-500 italic">{{ $item->package->name ?? __('باقة عامة') }}</span>
                                            <span class="text-sm font-black text-emerald-500 font-mono mt-1">+{{ number_format($item->package->price ?? 0, 2) }} <span class="text-[12px] opacity-40 uppercase font-Cairo underline italic leading-tight">{{ __('ر.س') }}</span></span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-start font-Cairo">
                                        <span class="px-4 py-2 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-xl text-[14px] font-black font-mono italic border border-white/5 whitespace-nowrap inline-flex items-center justify-center">REF: {{ $item->number_bond ?? 'DUE-' . $item->id }}</span>
                                    </td>
                                    <td class="px-10 py-8 text-start text-[13px] font-black text-[var(--text-muted)] font-mono uppercase tracking-tighter">
                                        {{ $item->created_at->format('Y/m/d H:i') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-8 py-4 print:hidden">
                        {{ $detailedPoints->appends(request()->except('page_points'))->links() }}
                    </div>
                </div>

                <!-- Verification Ledger -->
                <div x-show="activeLedger === 'verification'" x-transition class="space-y-8 animate-fade-in">
                    <div class="overflow-x-auto custom-scrollbar rounded-[2.5rem] border border-white/5">
                        <table class="w-full text-start">
                            <thead class="bg-amber-500/5 border-b border-amber-500/10">
                                <tr>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('المزود') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('اشتراك التوثيق') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('سند القبض') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('التاريخ') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($detailedVerifications as $item)
                                <tr class="hover:bg-amber-500/[0.03] transition-all group font-Cairo text-start">
                                    <td class="px-10 py-8 text-start">
                                        <div class="flex items-center gap-5">
                                            <div class="w-12 h-12 bg-amber-500 text-white rounded-xl flex items-center justify-center text-[14px] font-black shadow-lg">🛡️</div>
                                            <div class="flex flex-col text-start">
                                                <span class="text-[13px] font-black italic lrading-none">{{ $item->user->name ?? '---' }}</span>
                                                <span class="text-[12px] opacity-40 uppercase tracking-widest mt-1">Verified Expert</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-start font-Cairo">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-amber-600 italic leading-tight">{{ $item->verificationPackage->name ?? __('رسوم توثيق') }}</span>
                                            <span class="text-sm font-black text-emerald-500 font-mono mt-1">+{{ number_format($item->verificationPackage->price ?? 0, 2) }} <span class="text-[12px] opacity-40 uppercase font-Cairo underline italic leading-tight">{{ __('ر.س') }}</span></span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-start font-Cairo">
                                        <span class="px-4 py-2 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-xl text-[14px] font-black font-mono italic border border-white/5 whitespace-nowrap inline-flex items-center justify-center">VRF: {{ $item->number_bond ?? 'BOND-' . $item->id }}</span>
                                    </td>
                                    <td class="px-10 py-8 text-start text-[13px] font-black text-[var(--text-muted)] font-mono uppercase tracking-tighter">
                                        {{ $item->created_at->format('Y/m/d H:i') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-8 py-4 print:hidden">
                        {{ $detailedVerifications->appends(request()->except('page_verif'))->links() }}
                    </div>
                </div>

                <!-- Withdrawals Ledger -->
                <div x-show="activeLedger === 'outflow'" x-transition class="space-y-8 animate-fade-in font-Cairo">
                    <div class="overflow-x-auto custom-scrollbar rounded-[2.5rem] border border-white/5 font-Cairo text-start">
                        <table class="w-full text-start font-Cairo">
                            <thead class="bg-rose-500/5 border-b border-rose-500/10">
                                <tr>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('المزود المستلم') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('المبلغ المصروف') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('سند الصرف') }}</th>
                                    <th class="table-header-cell px-10 py-7 text-start text-[13px] uppercase font-black opacity-40 italic">{{ __('التاريخ') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 font-Cairo text-start">
                                @foreach($detailedWithdrawals as $item)
                                <tr class="hover:bg-rose-500/[0.03] transition-all group font-Cairo text-start">
                                    <td class="px-10 py-8 text-start font-Cairo">
                                        <div class="flex items-center gap-5">
                                            <div class="w-12 h-12 bg-rose-500 text-white rounded-xl flex items-center justify-center text-[14px] font-black shadow-lg">🏦</div>
                                            <div class="flex flex-col text-start">
                                                <span class="text-[13px] font-black italic lrading-none">{{ $item->user->name ?? '---' }}</span>
                                                <span class="text-[12px] opacity-40 uppercase tracking-widest mt-1">Payout Executed</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-start font-Cairo">
                                        <span class="text-lg font-black text-rose-500 font-mono italic leading-none">-{{ number_format($item->amount, 2) }} <span class="text-[12px] opacity-40 uppercase font-Cairo underline italic leading-tight">{{ __('ر.س') }}</span></span>
                                    </td>
                                    <td class="px-10 py-8 text-start font-Cairo">
                                        <span class="px-4 py-2 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-xl text-[14px] font-black font-mono italic border border-white/5 whitespace-nowrap inline-flex items-center justify-center">PAY: {{ $item->bond_number ?? 'WD-' . $item->id }}</span>
                                    </td>
                                    <td class="px-10 py-8 text-start text-[13px] font-black text-[var(--text-muted)] font-mono uppercase tracking-tighter">
                                        {{ $item->created_at->format('Y/m/d H:i') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-8 py-4 print:hidden">
                        {{ $detailedWithdrawals->appends(request()->except('page_withdraw'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tier 6: Pro-Accounting Guidance -->
    <div class="px-4 md:px-0">
        <div class="card-premium glass-panel p-16 rounded-[5rem] shadow-2xl relative border-2 border-brand-primary/10 overflow-hidden bg-[var(--glass-bg)]">
            <h4 class="text-3xl font-black font-Cairo text-start italic mb-12 flex items-center gap-6">
                <span class="w-2.5 h-12 bg-brand-primary rounded-xl font-Cairo whitespace-nowrap inline-flex items-center justify-center"></span>
                {{ __('الدليل الفني للرقابة المالية المتقدمة') }}
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-start font-Cairo">
                <div class="text-start font-Cairo">
                    <h6 class="text-base font-black italic text-brand-primary mb-5 font-Cairo">{{ __('علاقة النقاط بالسيولة') }}</h6>
                    <p class="text-[14px] font-bold text-[var(--text-muted)] leading-relaxed font-Cairo italic">{{ __('كل نقطة مباعة هي التزام مالي بنكي. عند شراء"باقة نقاط"، تدخل السيولة للمنصة (Cash-in)، ولكنها تبقى"ديناً افتراضياً" حتى يتم استهلاكها أو سحبها.') }}</p>
                </div>
                 <div class="text-start font-Cairo">
                    <h6 class="text-base font-black italic text-amber-600 mb-5 font-Cairo">{{ __('رسوم التوثيق السيادية') }}</h6>
                    <p class="text-[14px] font-bold text-[var(--text-muted)] leading-relaxed font-Cairo italic">{{ __('تعتبر رسوم التوثيق"ربحاً تشغيلياً مباشراً" للمنصة بنسبة 100%، حيث لا تقابلها التزامات دفع للمزودين، وتساهم في تغطية التكاليف.') }}</p>
                </div>
                 <div class="text-start font-Cairo">
                    <h6 class="text-base font-black italic text-emerald-600 mb-5 font-Cairo">{{ __('صافي الربح المحقق') }}</h6>
                    <p class="text-[14px] font-bold text-[var(--text-muted)] leading-relaxed font-Cairo italic">{{ __('هو الحصاد الفعلي لمجهود المنصة؛ يُحسب من العمولات المقتطعة من العمليات الناجزة + عوائد التوثيق. هذا الرقم يعبر عن النمو الحقيقي.') }}</p>
                </div>
                 <div class="text-start font-Cairo">
                    <h6 class="text-base font-black italic text-rose-600 mb-5 font-Cairo">{{ __('إدارة مخاطر السحوبات') }}</h6>
                    <p class="text-[14px] font-bold text-[var(--text-muted)] leading-relaxed font-Cairo italic">{{ __('نرصد كافة"النقاط القابلة للسحب" لضمان توفر رصيد بنكي موازٍ (Backing)، مما يضمن عدم حدوث فجوة في السيولة (Liquidity Gap).') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { height: 10px; width: 8px; }
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
        
        const ctxFlow = document.getElementById('cashflowChart')?.getContext('2d');
        if(ctxFlow){
            const gradientIn = ctxFlow.createLinearGradient(0, 0, 0, 400);
            gradientIn.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
            gradientIn.addColorStop(1, 'rgba(16, 185, 129, 0)');

            const gradientOut = ctxFlow.createLinearGradient(0, 0, 0, 400);
            gradientOut.addColorStop(0, 'rgba(244, 63, 94, 0.2)');
            gradientOut.addColorStop(1, 'rgba(244, 63, 94, 0)');

            new Chart(ctxFlow, {
                type: 'line',
                data: {
                    labels: @json($formattedInflow->keys()),
                    datasets: [
                        {
                            label: '{{ __('التدفق الداخل') }}',
                            data: @json($formattedInflow->values()),
                            borderColor: '#10b981',
                            backgroundColor: gradientIn,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 4,
                            pointRadius: 6,
                            pointBackgroundColor: '#fff',
                            pointBorderWidth: 3
                        },
                        {
                            label: '{{ __('التدفق الخارج') }}',
                            data: @json($formattedOutflow->values()),
                            borderColor: '#f43f5e',
                            backgroundColor: gradientOut,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 4,
                            pointRadius: 6,
                            pointBackgroundColor: '#fff',
                            pointBorderWidth: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { position: 'top', labels: { font: { weight: 'black', size: 10 } } } 
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, grid: { color: 'rgba(148, 163, 184, 0.1)' } }
                    }
                }
            });
        }

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
