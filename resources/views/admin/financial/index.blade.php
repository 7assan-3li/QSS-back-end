@extends('layouts.admin')

@section('title', __('التحليل المالي والذكاء المحاسبي'))

@section('content')
<div class="max-w-7xl mx-auto space-y-8 mt-4 animate-fade-in text-start font-Cairo print:p-0 print:m-0">
    <!-- Fiscal Alerts (Hidden in Print) -->
    @if(count($alerts) > 0)
    <div class="space-y-4 print:hidden">
        @foreach($alerts as $alert)
        <div class="glass-panel p-6 rounded-3xl border-r-8 {{ $alert['type'] == 'warning' ? 'border-amber-500 bg-amber-500/[0.02]' : 'border-rose-500 bg-rose-500/[0.02]' }} flex items-center justify-between animate-slide-up">
            <div class="flex items-center gap-6">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $alert['type'] == 'warning' ? 'bg-amber-500/10 text-amber-600' : 'bg-rose-500/10 text-rose-600' }} text-2xl">
                    {{ $alert['type'] == 'warning' ? '⚠️' : '🚨' }}
                </div>
                <div class="text-start">
                    <h5 class="font-black text-sm {{ $alert['type'] == 'warning' ? 'text-amber-700' : 'text-rose-700' }}">{{ $alert['title'] }}</h5>
                    <p class="text-[11px] font-black opacity-70 mt-1">{{ $alert['message'] }}</p>
                </div>
            </div>
            <button class="p-4 hover:rotate-90 transition-all opacity-40 hover:opacity-100" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Executive Header & Global Filter -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 text-start group print:flex-row print:justify-between">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5 print:hidden">📊</span>
                {{ __('نظام الذكاء المحاسبي') }}
            </h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 lg:mr-20 text-start font-Cairo">
                {{ __('تحليل اتجاهات النمو، توزيع الأرباح، والرقابة المالية الذكية.') }}
            </p>
        </div>

        <div class="flex items-center gap-4 print:hidden">
            <!-- Date Filter Form -->
            <form action="{{ route('admin.financial.index') }}" method="GET" class="glass-panel p-3 rounded-2xl border border-slate-100 dark:border-white/5 flex items-center gap-4 shadow-xl">
                <div class="flex flex-col gap-1">
                    <input type="date" name="from_date" value="{{ $fromDate->format('Y-m-d') }}" class="bg-slate-50 dark:bg-slate-900/50 border-none rounded-xl text-[10px] font-black px-4 py-2 outline-none h-10 w-36">
                </div>
                <div class="flex flex-col gap-1">
                    <input type="date" name="to_date" value="{{ $toDate->format('Y-m-d') }}" class="bg-slate-50 dark:bg-slate-900/50 border-none rounded-xl text-[10px] font-black px-4 py-2 outline-none h-10 w-36">
                </div>
                <button type="submit" class="bg-brand-primary text-white p-2.5 rounded-xl hover:scale-105 active:scale-95 transition-all shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>

            <!-- Export Buttons -->
            <button onclick="window.print()" class="bg-slate-800 text-white px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center gap-3 hover:bg-slate-900 transition-all shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H7a2 2 0 00-2 2v4m14 0h-2"></path></svg>
                {{ __('تصدير PDF') }}
            </button>
        </div>
    </div>

    <!-- Tier 1: Liquidity Stats with Trends -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-start">
        @php
            $statCards = [
                ['label' => __('إجمالي الداخل'), 'val' => $totalInflow, 'trend' => $trends['inflow'], 'color' => 'indigo', 'icon' => '📥'],
                ['label' => __('إجمالي الخارج'), 'val' => $totalOutflow, 'trend' => $trends['outflow'], 'color' => 'rose', 'icon' => '📤'],
                ['label' => __('صافي الربح المحقق'), 'val' => $totalProfit, 'trend' => $trends['profit'], 'color' => 'emerald', 'icon' => '💎'],
                ['label' => __('عوائد التوثيق'), 'val' => $verificationRevenue, 'trend' => $trends['verification'], 'color' => 'amber', 'icon' => '✅'],
            ];
        @endphp

        @foreach($statCards as $stat)
        <div class="card-premium glass-panel p-8 relative overflow-hidden group text-start">
            <div class="flex flex-col gap-2 relative z-10 text-start">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] font-Cairo text-start subpixel-antialiased">{{ $stat['label'] }}</span>
                <div class="flex items-baseline gap-2 text-start mt-1">
                    <span class="text-3xl font-black leading-none font-mono italic text-start text-slate-800 dark:text-white">{{ number_format($stat['val'], 2) }}</span>
                    <span class="text-[10px] font-black opacity-40 font-Cairo italic text-start">{{ __('ر.س') }}</span>
                </div>
                
                <!-- Trend Indicator -->
                <div class="flex items-center gap-2 mt-4 text-start">
                    <span class="px-2 py-1 rounded-lg text-[9px] font-black font-mono {{ $stat['trend'] >= 0 ? 'bg-emerald-500/10 text-emerald-600' : 'bg-rose-500/10 text-rose-600' }}">
                        {{ $stat['trend'] >= 0 ? '+' : '' }}{{ $stat['trend'] }}%
                    </span>
                    <span class="text-[9px] font-black text-slate-400 opacity-60 italic">{{ __('عن الفترة السابقة') }}</span>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 text-6xl opacity-[0.03] group-hover:scale-125 group-hover:-rotate-12 transition-all duration-700 select-none">{{ $stat['icon'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Tier 2: Commission & Top Services -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 text-start font-Cairo">
        <!-- Top Services Analysis -->
        <div class="lg:col-span-8 card-premium glass-panel rounded-[3.5rem] overflow-hidden flex flex-col">
            <div class="p-10 border-b border-slate-100 dark:border-white/5 flex justify-between items-center text-start">
                <div class="text-start">
                    <h4 class="text-lg font-black font-Cairo text-start italic">{{ __('تحليل ربحية الخدمات') }}</h4>
                    <p class="text-[9px] font-black text-slate-400 mt-1 uppercase tracking-widest">{{ __('ترتيب الخدمات حسب أعلى العمولات المحققة للمنصة.') }}</p>
                </div>
                <div class="p-4 bg-brand-primary/10 rounded-2xl text-brand-primary"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></div>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-start">
                    <thead>
                        <tr class="bg-slate-50/40 dark:bg-slate-900/40">
                            <th class="table-header-cell px-10 py-6">{{ __('الخدمة') }}</th>
                            <th class="table-header-cell px-10 py-6">{{ __('الطلبات') }}</th>
                            <th class="table-header-cell px-10 py-6">{{ __('إجمالي العمولات') }}</th>
                            <th class="table-header-cell px-10 py-6">{{ __('نشاط الخدمة') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/3">
                        @forelse($topServices as $service)
                        <tr class="hover:bg-brand-primary/[0.02] transition-all group">
                            <td class="px-10 py-6 text-start">
                                <span class="text-[11px] font-black text-brand-primary group-hover:underline">{{ $service->name }}</span>
                            </td>
                            <td class="px-10 py-6 text-[11px] font-black font-mono">x{{ $service->request_count }}</td>
                            <td class="px-10 py-6 text-[12px] font-black text-emerald-500 font-mono italic">{{ number_format($service->total_commission, 2) }} ر.س</td>
                            <td class="px-10 py-6">
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-brand-primary h-full rounded-full" style="width: {{ min(($service->total_commission / max($metrics['paidCommissions'] ?? 1, 1)) * 100, 100) }}%"></div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-20 text-center text-slate-400 font-black italic">{{ __('لا توجد بيانات كافية للتحليل حالياً.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detailed Commission Breakdown -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <div class="card-premium glass-panel p-10 flex flex-col gap-8 flex-1 text-start">
                <h4 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] font-Cairo mb-2">{{ __('دورة حياة السيولة') }}</h4>
                
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-xl font-Cairo shadow-lg">🗂️</div>
                    <div class="flex flex-col text-start">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('العمولات المستوفاة') }}</span>
                        <span class="text-2xl font-black font-mono italic text-emerald-600 mt-1">{{ number_format($paidCommissions, 2) }} ر.س</span>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600 text-xl font-Cairo shadow-lg">🕒</div>
                    <div class="flex flex-col text-start">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('العمولات المستحقة') }}</span>
                        <span class="text-2xl font-black font-mono italic text-amber-600 mt-1">{{ number_format($accruedCommissions, 2) }} ر.س</span>
                    </div>
                </div>

                <div class="mt-auto pt-8 border-t border-slate-100 dark:border-white/5">
                    <p class="text-[10px] font-black text-slate-400 italic">{{ __('صافي العمولات المسددة للمنصة سواء عبر الرصيد أو السندات مقارنة بما لم يتم تسويته بعد.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section (Hidden in Print) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 font-Cairo text-start print:hidden">
        <div class="lg:col-span-8 card-premium glass-panel p-10 text-start font-Cairo">
            <h4 class="text-xl font-black font-Cairo text-start italic mb-10">{{ __('تحليل الأداء النقدي (6 أشهر)') }}</h4>
            <div class="h-[350px]">
                <canvas id="cashflowChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-4 card-premium glass-panel p-10 text-start font-Cairo">
            <h4 class="text-xl font-black font-Cairo text-start italic mb-10">{{ __('موزع الأرباح') }}</h4>
            <div class="h-[300px] flex justify-center items-center">
                <canvas id="profitChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tier 3: Transaction Ledgers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 font-Cairo text-start">
        <!-- Inflow Ledger -->
        <div class="card-premium glass-panel rounded-[3.5rem] shadow-2xl overflow-hidden font-Cairo text-start flex flex-col">
            <div class="p-10 border-b border-slate-100 dark:border-white/5 flex justify-between items-center text-start">
                <h4 class="text-lg font-black font-Cairo text-start italic">{{ __('سجل شحن المحافظ المعتمد') }}</h4>
                <span class="px-6 py-2 bg-indigo-500/10 rounded-xl text-indigo-600 text-[10px] font-black uppercase tracking-widest">{{ $detailedInflows->total() }} {{ __('سجل') }}</span>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-start">
                    <thead>
                        <tr class="bg-slate-50/40 dark:bg-slate-900/40">
                            <th class="table-header-cell px-10 py-6">{{ __('طالب الخدمة') }}</th>
                            <th class="table-header-cell px-10 py-6">{{ __('المبلغ') }}</th>
                            <th class="table-header-cell px-10 py-6">{{ __('التاريخ') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/3">
                        @foreach($detailedInflows as $item)
                        <tr class="hover:bg-brand-primary/[0.02] transition-all group">
                            <td class="px-10 py-6 text-start">
                                <a href="{{ route('users.show', $item->user_id) }}" class="flex items-center gap-3 hover:underline">
                                    <div class="w-9 h-9 bg-indigo-50 dark:bg-slate-800 rounded-lg flex items-center justify-center text-[10px] font-black text-indigo-500 uppercase">{{ mb_substr($item->user->name ?? '?', 0, 1) }}</div>
                                    <span class="text-[11px] font-black group-hover:text-brand-primary transition-colors">{{ $item->user->name ?? '---' }}</span>
                                </a>
                            </td>
                            <td class="px-10 py-6 text-[11px] font-black text-emerald-500 font-mono italic">+{{ number_format($item->package->price ?? 0, 2) }}</td>
                            <td class="px-10 py-6 text-[9px] font-bold text-slate-400 font-mono">{{ $item->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-8 border-t border-slate-100 dark:border-white/5 print:hidden">
                {{ $detailedInflows->appends(request()->all())->links() }}
            </div>
        </div>

        <!-- Outflow Ledger -->
        <div class="card-premium glass-panel rounded-[3.5rem] shadow-2xl overflow-hidden font-Cairo text-start flex flex-col">
            <div class="p-10 border-b border-slate-100 dark:border-white/5 flex justify-between items-center text-start">
                <h4 class="text-lg font-black font-Cairo text-start italic">{{ __('سجل السحوبات المكتملة') }}</h4>
                <span class="px-6 py-2 bg-rose-500/10 rounded-xl text-rose-600 text-[10px] font-black uppercase tracking-widest">{{ $detailedOutflows->total() }} {{ __('سجل') }}</span>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-start">
                    <thead>
                        <tr class="bg-slate-50/40 dark:bg-slate-900/40">
                            <th class="table-header-cell px-10 py-6">{{ __('المزود') }}</th>
                            <th class="table-header-cell px-10 py-6">{{ __('المبلغ') }}</th>
                            <th class="table-header-cell px-10 py-6">{{ __('التاريخ') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/3">
                        @foreach($detailedOutflows as $item)
                        <tr class="hover:bg-brand-primary/[0.02] transition-all group">
                            <td class="px-10 py-6 text-start">
                                <a href="{{ route('users.show', $item->user_id) }}" class="flex items-center gap-3 hover:underline">
                                    <div class="w-9 h-9 bg-rose-50 dark:bg-slate-800 rounded-lg flex items-center justify-center text-[10px] font-black text-rose-500 uppercase">{{ mb_substr($item->user->name ?? '?', 0, 1) }}</div>
                                    <span class="text-[11px] font-black group-hover:text-rose-600 transition-colors">{{ $item->user->name ?? '---' }}</span>
                                </a>
                            </td>
                            <td class="px-10 py-6 text-[11px] font-black text-rose-500 font-mono italic">-{{ number_format($item->amount, 2) }}</td>
                            <td class="px-10 py-6 text-[9px] font-bold text-slate-400 font-mono">{{ $item->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-8 border-t border-slate-100 dark:border-white/5 print:hidden">
                {{ $detailedOutflows->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body { padding: 0 !important; margin: 0 !important; background: white !important; }
        .glass-panel { border: 1px solid #eee !important; box-shadow: none !important; background: transparent !important; }
        .card-premium { border-radius: 1rem !important; }
        aside, header, nav, footer, .print-hide { display: none !important; }
        .max-w-7xl { max-width: 100% !important; border: none !important; }
        .divide-y > * { border-color: #eee !important; }
        img, canvas, .chart-container { display: none !important; }
        @page { size: auto; margin: 10mm; }
    }
</style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = 'Cairo, sans-serif';
        Chart.defaults.color = 'rgba(148, 163, 184, 0.7)';
        
        const ctxFlow = document.getElementById('cashflowChart').getContext('2d');
        new Chart(ctxFlow, {
            type: 'line',
            data: {
                labels: @json($formattedInflow->keys()),
                datasets: [
                    {
                        label: '{{ __('التدفق الداخل') }}',
                        data: @json($formattedInflow->values()),
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 4
                    },
                    {
                        label: '{{ __('التدفق الخارج') }}',
                        data: @json($formattedOutflow->values()),
                        borderColor: '#f43f5e',
                        backgroundColor: 'rgba(244, 63, 94, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top', labels: { font: { weight: 'black', size: 10 } } } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { weight: 'bold', size: 9 } } },
                    y: { beginAtZero: true, grid: { color: 'rgba(148, 163, 184, 0.05)' }, ticks: { font: { weight: 'bold', size: 9 } } }
                }
            }
        });

        new Chart(document.getElementById('profitChart'), {
            type: 'doughnut',
            data: {
                labels: ['{{ __('العمولات المحصلة') }}', '{{ __('اشتراكات التوثيق') }}'],
                datasets: [{
                    data: [{{ $paidCommissions }}, {{ $verificationRevenue }}],
                    backgroundColor: ['#10b981', '#f59e0b'],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true, font: { weight: 'black', size: 10 } } }
                }
            }
        });
    </script>
@endpush
