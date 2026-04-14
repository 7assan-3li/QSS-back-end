@extends('layouts.admin')

@section('title', __('شكاوى النظام'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-rose-500/10 rounded-2xl flex items-center justify-center text-rose-600 text-3xl font-Cairo shadow-lg shadow-rose-500/5 whitespace-nowrap inline-flex items-center justify-center">📢</span>
                {{ __('شكاوى النظام') }}
            </h3>
            <p class="text-[13px] font-black uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo opacity-60">
                {{ __('متابعة البلاغات التقنية وحل المشاكل البرمجية والتشغيلية.') }}
            </p>
        </div>
        <div class="flex items-center gap-3 px-8 py-3 bg-slate-900 text-white rounded-2xl text-[13px] font-black uppercase tracking-[0.2em] font-Cairo shadow-[0_20px_40px_-10px_rgba(0,0,0,0.2)] animate-pulse">
            {{ __('التحليلات المباشرة نشطة') }} 📡
        </div>
    </div>

    <!-- Intelligence Stats Matrix (4 Items) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 font-Cairo text-start">
        <!-- Total Intelligence Node -->
        <div class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] transition-all text-start border border-[var(--glass-border)]">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-slate-500/[0.03] rounded-full blur-3xl group-hover:bg-slate-500/[0.08] transition-colors"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-[var(--glass-border)] rounded-2xl flex items-center justify-center text-[var(--main-text)] shadow-inner group-hover:rotate-6 transition-transform font-Cairo text-2xl">📊</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black font-mono leading-none text-start italic">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[12px] font-black uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-60">{{ __('إجمالي البلاغات') }}</span>
                </div>
            </div>
        </div>

        <!-- Pending Intelligence Node -->
        <a href="?status=pending" class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] transition-all text-start border border-amber-500/10 bg-amber-50/20 dark:bg-amber-950/10">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/[0.05] rounded-full blur-3xl group-hover:bg-amber-500/[0.1] transition-colors"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">⏳</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-amber-600 font-mono leading-none text-start italic">{{ str_pad($stats['pending'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[12px] font-black text-amber-500 uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-80">{{ __('بانتظار المراجعة') }}</span>
                </div>
            </div>
        </a>

        <!-- In-Progress Intelligence Node -->
        <a href="?status=in_progress" class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] transition-all text-start border border-blue-500/10 bg-blue-50/20 dark:bg-blue-950/10">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/[0.05] rounded-full blur-3xl group-hover:bg-blue-500/[0.1] transition-colors"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-blue-600/20 group-hover:rotate-6 transition-transform font-Cairo">⚙️</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-blue-600 font-mono leading-none text-start italic">{{ str_pad($stats['in_progress'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[12px] font-black text-blue-500 uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-80">{{ __('قيد العمليات') }}</span>
                </div>
            </div>
        </a>

        <!-- Resolved Node -->
        <a href="?status=completed" class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] transition-all text-start border border-emerald-500/10 bg-emerald-50/20 dark:bg-emerald-950/10">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/[0.05] rounded-full blur-3xl group-hover:bg-emerald-500/[0.1] transition-colors"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform font-Cairo">✔️</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-emerald-600 font-mono leading-none text-start italic">{{ str_pad($stats['completed'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[12px] font-black text-emerald-500 uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-80">{{ __('ملفات مغلقة') }}</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Analytics Dashboard Deck -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 text-start">
        <!-- Distribution Engine -->
        <div class="lg:col-span-4 card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo">
            <div class="flex items-center justify-between mb-10 text-start">
                <h4 class="font-black text-base flex items-center gap-3 font-Cairo text-start">
                    <span class="w-2 h-6 bg-rose-500 rounded-full shadow-lg shadow-rose-500/20"></span>
                    {{ __('توزيع ضغط البلاغات') }}
                </h4>
            </div>
            <div class="relative h-72 text-start font-Cairo">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Frequency Engine -->
        <div class="lg:col-span-8 card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 text-start">
                <h4 class="font-black text-base flex items-center gap-3 font-Cairo text-start">
                    <span class="w-2 h-6 bg-indigo-500 rounded-full shadow-lg shadow-indigo-500/20"></span>
                    {{ __('تحليل وتيرة الواردات اليومية') }}
                </h4>
                <div class="flex gap-2 bg-slate-900/5 dark:bg-[var(--glass-bg)]/5 p-1.5 rounded-2xl border border-[var(--glass-border)] text-start font-Cairo shadow-inner">
                    @foreach([7, 30, 90] as $d)
                        <a href="?days={{ $d }}" class="px-6 py-2 rounded-xl text-[12px] font-black uppercase tracking-[0.2em] transition-all font-Cairo {{ $days == $d ? 'bg-rose-600 text-white shadow-lg shadow-rose-600/20' : 'opacity-40 hover:opacity-100' }}">
                            {{ $d }} {{ __('يوم') }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="relative h-72 text-start font-Cairo font-mono">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Payout Index Table Matrix -->
    <div class="card-premium glass-panel rounded-[4.5rem] overflow-hidden shadow-2xl relative border border-[var(--glass-border)] text-start font-Cairo">
        <div class="px-12 py-10 border-b border-[var(--glass-border)] bg-[var(--main-bg)] flex justify-between items-center text-start font-Cairo">
            <div class="text-start">
                <h4 class="font-black text-xl font-Cairo text-start italic">{{ __('البيان الختامي لسجل شكاوى النظام') }}</h4>
                <p class="text-[13px] font-black uppercase tracking-[0.3em] mt-2 text-start font-Cairo opacity-60">{{ __('عرض شامل لجميع الملفات الفنية والتقنية المقدمة من شركاء المنصة.') }}</p>
            </div>

            <a href="{{ route('system-complaints.export', request()->all()) }}" class="bg-rose-600 text-white px-8 py-3.5 rounded-2xl font-black text-[13px] uppercase tracking-widest flex items-center gap-4 hover:scale-105 transition-all shadow-xl shadow-rose-600/20">
                <span class="w-8 h-8 bg-[var(--glass-bg)]/20 rounded-lg flex items-center justify-center text-sm italic">📥</span>
                <div class="flex flex-col items-start leading-none">
                    <span class="font-Cairo">{{ __('تصدير تقارير الجودة') }}</span>
                    <span class="text-[14px] opacity-60 font-mono tracking-normal lowercase">{{ __('.csv (Excel)') }}</span>
                </div>
            </a>
        </div>
        
        <div class="overflow-x-auto text-start">
            <table id="system-complaints-table" class="w-full text-start">
                <thead class="bg-[var(--main-bg)] font-black text-[12px] uppercase tracking-[0.3em] border-b border-[var(--glass-border)] font-Cairo text-start opacity-60">
                    <tr>
                        <th class="px-10 py-6 text-start">UUID / ID</th>
                        <th class="px-10 py-6 text-start">{{ __('جوهر البلاغ') }}</th>
                        <th class="px-10 py-6 text-center">{{ __('المصدر التشغيلي') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('صاحب المطلب') }}</th>
                        <th class="px-10 py-6 text-center">{{ __('الوضعية') }}</th>
                        <th class="px-10 py-6 text-end">{{ __('التصرف') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--glass-border)] font-Cairo text-start">
                    @forelse ($complaints as $complaint)
                        <tr class="hover:bg-rose-500/[0.01] transition-all group text-start">
                            <td class="px-10 py-7 text-start">
                                <span class="text-xs font-black font-mono tracking-tighter opacity-60">#{{ str_pad($complaint->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-10 py-7 text-start">
                                <div class="flex flex-col text-start">
                                    <span class="text-sm font-black font-Cairo leading-tight mb-2 text-start italic">{{ $complaint->title }}</span>
                                    <span class="text-[12px] font-black uppercase tracking-[0.2em] font-Cairo text-start font-mono opacity-60">{{ $complaint->type }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-7 text-center">
                                @if($complaint->app_source === 'provider')
                                    <span class="px-4 py-1.5 bg-indigo-500/10 text-indigo-600 rounded-xl font-black text-[14px] border border-indigo-500/20 shadow-sm font-Cairo uppercase tracking-widest whitespace-nowrap inline-flex items-center justify-center">{{ __('تطبيق المزود') }}</span>
                                @else
                                    <span class="px-4 py-1.5 bg-pink-500/10 text-pink-600 rounded-xl font-black text-[14px] border border-pink-500/20 shadow-sm font-Cairo uppercase tracking-widest whitespace-nowrap inline-flex items-center justify-center">{{ __('تطبيق العميل') }}</span>
                                @endif
                            </td>
                            <td class="px-10 py-7 text-start">
                                <div class="flex items-center gap-3 text-start">
                                    <div class="w-10 h-10 bg-[var(--glass-border)] rounded-xl flex items-center justify-center text-[14px] font-black group-hover:bg-brand-primary group-hover:text-white transition-all shadow-inner font-Cairo">
                                        {{ mb_substr($complaint->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-[13px] font-black font-Cairo text-start">{{ $complaint->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-7 text-center">
                                <span class="px-4 py-2 rounded-xl text-[12px] font-black uppercase tracking-widest font-Cairo @if($complaint->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 @elseif($complaint->status == 'in_progress') bg-blue-500/10 text-blue-600 border border-blue-500/20 @else bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-lg shadow-emerald-500/10 @endif whitespace-nowrap inline-flex items-center justify-center">
                                    {{ __($complaint->status) }}
                                </span>
                            </td>
                            <td class="px-10 py-7 text-end">
                                <a href="{{ route('system-complaints.show', $complaint) }}" class="btn-action btn-action-view mx-auto flex items-center justify-center" title="{{ __('تحليل الملف') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center justify-center gap-6 opacity-30">
                                    <div class="w-24 h-24 bg-[var(--main-bg)] rounded-[2rem] flex items-center justify-center text-6xl shadow-inner animate-pulse">📢</div>
                                    <span class="text-[13px] font-black uppercase tracking-[0.3em] font-Cairo opacity-60">{{ __('سجل البلاغات نظيف تماما من الشوائب حاليا.') }}</span>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    /* ===== Status Doughnut Intelligence ===== */
    const statusCtx = document.getElementById('statusChart');
    if(statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['{{ __("بانتظار المراجعة") }}', '{{ __("قيد المعالجة") }}', '{{ __("بلاغات مكتملة") }}'],
                datasets: [{
                    data: [{{ $stats['pending'] }}, {{ $stats['in_progress'] }}, {{ $stats['completed'] }}],
                    backgroundColor: ['#f5a623', '#3b82f6', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 20,
                    borderRadius: 10
                }]
            },
            options: {
                cutout: '82%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        rtl: {{ app()->getLocale() == 'ar' ? 'true' : 'false' }},
                        labels: {
                            usePointStyle: true,
                            padding: 30,
                            font: { size: 10, family: 'Cairo', weight: '900' },
                            color: '#94a3b8'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { family: 'Cairo', size: 12 },
                        bodyFont: { family: 'Cairo', size: 11 },
                        padding: 12,
                        cornerRadius: 15
                    }
                }
            }
        });
    }

    /* ===== Daily Frequency Engine ===== */
    const dailyCtx = document.getElementById('dailyChart');
    if(dailyCtx) {
        const dCtx = dailyCtx.getContext('2d');
        const gradient = dCtx.createLinearGradient(0, 0, 0, 350);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: '{{ __("نبض البلاغات") }}',
                    data: @json($data),
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    borderWidth: 5,
                    tension: 0.45,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#6366f1',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148, 163, 184, 0.1)', drawBorder: false },
                        ticks: { font: { size: 9, family: 'Cairo', weight: 'bold' }, color: '#94a3b8', stepSize: 1 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9, family: 'Cairo', weight: 'bold' }, color: '#94a3b8' }
                    }
                }
            }
        });
    }
</script>
@endpush