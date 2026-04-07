@extends('layouts.admin')

@section('title', __('بلاغات الطلبات'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl text-slate-800 dark:text-white flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-pink-500/10 rounded-2xl flex items-center justify-center text-pink-600 text-3xl font-Cairo shadow-lg shadow-pink-500/5">⚖️</span>
                {{ __('إدارة شكاوى الطلبات') }}
            </h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('إدارة الشكاوى معالجة النزاعات والوصول لحلول مرضية لجميع الأطراف.') }}
            </p>
        </div>
        <div class="flex items-center gap-3 px-8 py-3 bg-pink-500/5 rounded-2xl border border-pink-500/10 text-pink-600 text-[10px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm animate-pulse">
            <span class="w-2.5 h-2.5 bg-pink-600 rounded-full"></span>
            LIVE MONITORING 🌏
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 font-Cairo text-start">
        <!-- Total Complaints -->
        <div class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] active:scale-95 transition-all text-start border border-white dark:border-slate-800/50">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-slate-500/[0.03] rounded-full blur-3xl group-hover:bg-slate-500/[0.08] transition-colors"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-500 shadow-inner group-hover:rotate-6 transition-transform font-Cairo text-2xl">📁</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-slate-800 dark:text-white font-mono leading-none text-start">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('إجمالي الشكاوى') }}</span>
                </div>
            </div>
        </div>

        <!-- Pending Review -->
        <a href="?status=pending" class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] active:scale-95 transition-all text-start border border-amber-500/10 bg-amber-50/20 dark:bg-amber-950/10">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/[0.05] rounded-full blur-3xl group-hover:bg-amber-500/[0.1] transition-colors"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-amber-500/20 group-hover:scale-110 transition-transform">⏳</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-amber-600 font-mono leading-none text-start">{{ str_pad($stats['pending'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[9px] font-black text-amber-500/80 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('بانتظار المراجعة') }}</span>
                </div>
            </div>
        </a>

        <!-- In-Progress Resolution -->
        <a href="?status=in_progress" class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] active:scale-95 transition-all text-start border border-blue-500/10 bg-blue-50/20 dark:bg-blue-950/10">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/[0.05] rounded-full blur-3xl group-hover:bg-blue-500/[0.1] transition-colors"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-blue-600/20 group-hover:rotate-6 transition-transform font-Cairo">⚖️</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-blue-600 font-mono leading-none text-start">{{ str_pad($stats['in_progress'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[9px] font-black text-blue-500/80 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('قيد المعالجة') }}</span>
                </div>
            </div>
        </a>

        <!-- Resolved Complaints -->
        <a href="?status=resolved" class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group hover:scale-[1.05] active:scale-95 transition-all text-start border border-emerald-500/10 bg-emerald-50/20 dark:bg-emerald-950/10">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/[0.05] rounded-full blur-3xl group-hover:bg-emerald-500/[0.1] transition-colors"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-emerald-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform font-Cairo">✔️</div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black text-emerald-600 font-mono leading-none text-start">{{ str_pad($stats['completed'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[9px] font-black text-emerald-500/80 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('بلاغات مكتملة') }}</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Complaints Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 text-start">
        <!-- Status Distribution -->
        <div class="lg:col-span-4 card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50 text-start font-Cairo">
            <div class="flex items-center justify-between mb-10 text-start">
                <h4 class="font-black text-slate-800 dark:text-white text-base flex items-center gap-3 font-Cairo text-start">
                    <span class="w-2 h-6 bg-pink-500 rounded-full shadow-lg shadow-pink-500/20"></span>
                    {{ __('إحصائيات الشكاوى والحلول') }}
                </h4>
            </div>
            <div class="relative h-72 text-start font-Cairo">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Complaints Frequency Chart -->
        <div class="lg:col-span-8 card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50 text-start font-Cairo">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 text-start">
                <h4 class="font-black text-slate-800 dark:text-white text-base flex items-center gap-3 font-Cairo text-start">
                    <span class="w-2 h-6 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/20"></span>
                    {{ __('معدل تقديم الشكاوى') }}
                </h4>
                <div class="flex gap-2 bg-slate-900/5 dark:bg-white/5 p-1.5 rounded-2xl border border-slate-200/10 text-start font-Cairo shadow-inner">
                    @foreach([7, 30, 90] as $d)
                        <a href="?days={{ $d }}" class="px-6 py-2 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] transition-all font-Cairo {{ $days == $d ? 'bg-pink-600 text-white shadow-lg shadow-pink-600/20' : 'text-slate-400 hover:text-slate-600' }}">
                            {{ $d }} يوم
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="relative h-72 text-start font-Cairo font-mono">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Complaints List Table -->
    <div class="card-premium glass-panel rounded-[4rem] overflow-hidden shadow-2xl relative border border-white dark:border-slate-800/50 text-start font-Cairo">
        <div class="px-12 py-10 border-b border-white dark:border-slate-800/50 bg-slate-50/40 dark:bg-slate-950/20 text-start font-Cairo">
            <h4 class="font-black text-xl text-slate-800 dark:text-white font-Cairo text-start">{{ __('سجل شكاوى الطلبات') }}</h4>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-2 text-start font-Cairo">{{ __('قائمة بجميع الشكاوى المقدمة بخصوص طلبات الخدمات.') }}</p>
        </div>
        
        <div class="overflow-x-auto text-start">
            <table class="w-full text-start">
                <thead class="bg-slate-50/80 dark:bg-slate-900/40 text-slate-400 dark:text-slate-500 font-black text-[9px] uppercase tracking-[0.3em] border-b border-slate-100 dark:border-slate-800/50 font-Cairo text-start uppercase">
                    <tr>
                        <th class="px-10 py-6 text-start">{{ __('رقم الشكوى / ID') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('الطلب المرجعي') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('عنوان الشكوى') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('مقدم الشكوى') }}</th>
                        <th class="px-10 py-6 text-center">{{ __('الحالة') }}</th>
                        <th class="px-10 py-6 text-end">{{ __('الإجراء') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50 font-Cairo text-start">
                    @forelse ($complaints as $complaint)
                        <tr class="hover:bg-pink-500/[0.01] transition-all group text-start">
                            <td class="px-10 py-7 text-start">
                                <span class="text-xs font-black text-slate-400 font-mono tracking-tighter">#{{ str_pad($complaint->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-10 py-7 text-start">
                                <a href="{{ route('requests.show', $complaint->request_id) }}" class="inline-flex items-center gap-3 px-4 py-2 bg-indigo-500/5 text-indigo-600 rounded-xl font-black text-[10px] border border-indigo-500/10 hover:bg-indigo-600 hover:text-white transition-all shadow-sm font-Cairo group/link">
                                    <svg class="w-3.5 h-3.5 group-hover/link:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    <span>{{ __('رقم الطلب') }} #{{ $complaint->request_id }}</span>
                                </a>
                            </td>
                            <td class="px-10 py-7 text-start">
                                <div class="flex flex-col text-start">
                                    <span class="text-sm font-black text-slate-800 dark:text-slate-200 font-Cairo leading-tight mb-2 text-start italic">{{ $complaint->title }}</span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] font-Cairo text-start font-mono">{{ $complaint->type }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-7 text-start">
                                <div class="flex flex-col gap-2 text-start">
                                    <div class="flex items-center gap-3 text-start">
                                        <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-[11px] font-black group-hover:bg-brand-primary group-hover:text-white transition-all shadow-inner font-Cairo">
                                            {{ mb_substr($complaint->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-[13px] font-black text-slate-700 dark:text-white font-Cairo text-start">{{ $complaint->user->name ?? 'NON-OBJECT' }}</span>
                                    </div>
                                    <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest w-max font-Cairo
                                        {{ $complaint->user_id == $complaint->request->user_id ? 'bg-pink-500/10 text-pink-600 border border-pink-500/20' : 'bg-indigo-500/10 text-indigo-600 border border-indigo-500/20' }}">
                                        {{ $complaint->user_id == $complaint->request->user_id ? __('طرف العميل') : __('طرف المزود') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-10 py-7 text-center">
                                <span class="px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest font-Cairo">
                                    @if($complaint->status == 'pending') {{ __('بانتظار المراجعة') }}
                                    @elseif($complaint->status == 'in_progress') {{ __('قيد التحقيق') }}
                                    @else {{ __('بلاغ مكتمل') }} @endif
                                </span>
                            </td>
                            <td class="px-10 py-7 text-end">
                                <a href="{{ route('request-complaints.show', $complaint) }}" class="inline-flex items-center justify-center gap-4 px-8 py-3 bg-white dark:bg-slate-900 text-slate-900 dark:text-white rounded-[1.2rem] text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900 transition-all shadow-xl shadow-slate-900/5 font-Cairo border border-slate-100 dark:border-slate-800">
                                    <span>{{ __('تفاصيل الشكوى') }}</span>
                                    <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center justify-center gap-6 opacity-30">
                                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-[2rem] flex items-center justify-center text-6xl shadow-inner animate-pulse">📢</div>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] font-Cairo">{{ __('لا توجد بلاغات أو شكاوى حاليا.') }}</span>
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
    /* ===== Status Distribution Chart ===== */
    const statusCtx = document.getElementById('statusChart');
    if(statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['{{ __("بانتظار المراجعة") }}', '{{ __("تحت التحقيق") }}', '{{ __("بلاغات مكتملة") }}'],
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

    /* ===== Daily Complaints Chart ===== */
    const dailyCtx = document.getElementById('dailyChart');
    if(dailyCtx) {
        const dCtx = dailyCtx.getContext('2d');
        const gradient = dCtx.createLinearGradient(0, 0, 0, 350);
        gradient.addColorStop(0, 'rgba(236, 72, 153, 0.2)');
        gradient.addColorStop(1, 'rgba(236, 72, 153, 0)');

        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: '{{ __("معدل البلاغات") }}',
                    data: @json($data),
                    borderColor: '#ec4899',
                    backgroundColor: gradient,
                    borderWidth: 5,
                    tension: 0.45,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#ec4899',
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
                        grid: { color: 'rgba(226, 232, 240, 0.4)', drawBorder: false },
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
@endsection
