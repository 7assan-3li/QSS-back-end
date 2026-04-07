@extends('layouts.admin')

@section('title', __('طلبات التحقق'))

@section('content')
<div class="space-y-12 mt-4 text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3
                class="font-black text-3xl text-slate-800 dark:text-white flex items-center gap-4 text-start font-Cairo">
                <span
                    class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-3xl font-Cairo shadow-lg shadow-emerald-500/5">🆔</span>
                {{ __('توثيق الحسابات') }}
            </h3>
            <p
                class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('مراجعة واعتماد طلبات توثيق هوية المستخدمين والمزودين.') }}
            </p>
        </div>
    </div>

    <!-- Statistics Bar -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 font-Cairo text-start">
        <!-- Total -->
        <div
            class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl border border-white dark:border-slate-800/50 relative overflow-hidden group hover:scale-[1.05] active:scale-95 transition-all text-start">
            <div
                class="absolute -top-12 -right-12 w-32 h-32 bg-slate-500/[0.03] rounded-full blur-3xl group-hover:bg-slate-500/[0.08] transition-colors">
            </div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div
                    class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-500 shadow-inner group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div class="flex flex-col text-start">
                    <span
                        class="text-3xl font-black text-slate-800 dark:text-white font-mono leading-none text-start">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span
                        class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('إجمالي الطلبات') }}</span>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div
            class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl border border-amber-100 dark:border-amber-500/20 relative overflow-hidden group hover:scale-[1.05] active:scale-95 transition-all text-start bg-amber-50/20 dark:bg-amber-950/10">
            <div
                class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/[0.05] rounded-full blur-3xl group-hover:bg-amber-500/[0.1] transition-colors">
            </div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div
                    class="w-16 h-16 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-500 shadow-inner group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex flex-col text-start">
                    <span
                        class="text-3xl font-black text-amber-600 font-mono leading-none text-start">{{ str_pad($stats['pending'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span
                        class="text-[9px] font-black text-amber-500/80 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('طلبات قيد الانتظار') }}</span>
                </div>
            </div>
        </div>

        <!-- Accepted -->
        <div
            class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl border border-emerald-100 dark:border-emerald-500/20 relative overflow-hidden group hover:scale-[1.05] active:scale-95 transition-all text-start bg-emerald-50/20 dark:bg-emerald-950/10">
            <div
                class="absolute -top-12 -right-12 w-32 h-32 bg-emerald-500/[0.05] rounded-full blur-3xl group-hover:bg-emerald-500/[0.1] transition-colors">
            </div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div
                    class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-500 shadow-inner group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex flex-col text-start">
                    <span
                        class="text-3xl font-black text-emerald-600 font-mono leading-none text-start">{{ str_pad($stats['accepted'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span
                        class="text-[9px] font-black text-emerald-500/80 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('طلبات مقبولة') }}</span>
                </div>
            </div>
        </div>

        <!-- Rejected -->
        <div
            class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl border border-rose-100 dark:border-rose-500/20 relative overflow-hidden group hover:scale-[1.05] active:scale-95 transition-all text-start bg-rose-50/20 dark:bg-rose-950/10">
            <div
                class="absolute -top-12 -right-12 w-32 h-32 bg-rose-500/[0.05] rounded-full blur-3xl group-hover:bg-rose-500/[0.1] transition-colors">
            </div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div
                    class="w-16 h-16 bg-rose-500/10 rounded-2xl flex items-center justify-center text-rose-500 shadow-inner group-hover:rotate-6 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex flex-col text-start">
                    <span
                        class="text-3xl font-black text-rose-600 font-mono leading-none text-start">{{ str_pad($stats['rejected'], 2, '0', STR_PAD_LEFT) }}</span>
                    <span
                        class="text-[9px] font-black text-rose-500/80 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('طلبات مرفوضة') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 text-start">
        <!-- Distribution Statistics -->
        <div
            class="lg:col-span-1 card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50 text-start font-Cairo">
            <div class="flex items-center justify-between mb-10 text-start">
                <h4 class="font-black text-slate-800 dark:text-white text-base flex items-center gap-3 font-Cairo text-start">
                    <span class="w-2 h-6 bg-emerald-500 rounded-full shadow-lg shadow-emerald-500/20"></span>
                    {{ __('إحصائيات قرارات التوثيق') }}
                </h4>
            </div>
            <div class="relative h-64 text-start font-Cairo text-start">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Daily Request Analysis -->
        <div
            class="lg:col-span-2 card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50 text-start font-Cairo">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10 text-start">
                <h4 class="font-black text-slate-800 dark:text-white text-base flex items-center gap-3 font-Cairo text-start">
                    <span class="w-2 h-6 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/20"></span>
                    {{ __('تحليل عدد الطلبات يومياً') }}
                </h4>
                <div
                    class="flex gap-2 bg-slate-100/50 dark:bg-slate-900/50 p-1.5 rounded-2xl border border-slate-200 dark:border-slate-800 text-start font-Cairo">
                    <a href="?days=7"
                        class="px-6 py-2 rounded-xl text-[9px] font-black tracking-widest transition-all font-Cairo {{ $days == 7 ? 'bg-white dark:bg-slate-800 text-brand-primary shadow-lg' : 'text-slate-400 hover:text-slate-600' }}">{{ __('7 أيام') }}</a>
                    <a href="?days=30"
                        class="px-6 py-2 rounded-xl text-[9px] font-black tracking-widest transition-all font-Cairo {{ $days == 30 ? 'bg-white dark:bg-slate-800 text-brand-primary shadow-lg' : 'text-slate-400 hover:text-slate-600' }}">{{ __('30 يوم') }}</a>
                    <a href="?days=90"
                        class="px-6 py-2 rounded-xl text-[9px] font-black tracking-widest transition-all font-Cairo {{ $days == 90 ? 'bg-white dark:bg-slate-800 text-brand-primary shadow-lg' : 'text-slate-400 hover:text-slate-600' }}">{{ __('90 يوم') }}</a>
                </div>
            </div>
            <div class="relative h-64 text-start font-Cairo font-mono">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div
        class="card-premium glass-panel rounded-[2rem] overflow-hidden shadow-2xl relative border border-white dark:border-slate-800/50 text-start font-Cairo">
        <div
            class="px-12 py-8 border-b border-slate-100 dark:border-slate-800/50 bg-slate-50/40 dark:bg-slate-950/20 text-start">
            <h4 class="font-black text-lg text-slate-800 dark:text-white font-Cairo text-start">
                {{ __('سجل طلبات التوثيق') }}</h4>
        </div>

        <div class="overflow-x-auto text-start">
            <table class="w-full text-sm text-start">
                <thead
                    class="bg-slate-50/80 dark:bg-slate-900/40 text-slate-400 dark:text-slate-500 font-black text-[9px] uppercase tracking-[0.3em] border-b border-slate-100 dark:border-slate-800/50 font-Cairo text-start">
                    <tr>
                        <th class="px-10 py-6 text-start">{{ __('رقم الطلب') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('المستخدم') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('محتوى الطلب') }}</th>
                        <th class="px-10 py-6 text-center uppercase">{{ __('حالة الطلب') }}</th>
                        <th class="px-10 py-6 text-start uppercase">{{ __('التاريخ') }}</th>
                        <th class="px-10 py-6 text-end uppercase">{{ __('الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50 font-Cairo text-start">
                    @forelse ($requests as $request)
                        <tr class="hover:bg-brand-primary/[0.02] transition-colors group text-start">
                            <td class="px-10 py-7 text-start">
                                <span
                                    class="font-black text-slate-400 font-mono tracking-tighter">#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-10 py-7 text-start">
                                <div class="flex items-center gap-4 text-start">
                                    <div
                                        class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-600 font-black text-[10px] shadow-inner group-hover:scale-110 transition-transform font-Cairo">
                                        {{ mb_substr($request->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span
                                        class="font-black text-[13px] text-slate-700 dark:text-white font-Cairo text-start">{{ $request->user->name ?? __('مستخدم غير معروف') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-7 text-start">
                                <span
                                    class="text-[11px] font-black text-slate-500 dark:text-slate-400 line-clamp-1 font-Cairo italic text-start">{{ $request->content }}</span>
                            </td>
                            <td class="px-10 py-7 text-center">
                                @php
                                    $statusLabel = match ($request->status) {
                                        'pending' => __('قيد الانتظار'),
                                        'accepted' => __('مقبول'),
                                        default => __('مرفوض')
                                    };
                                    $statusBadge = match ($request->status) {
                                        'pending' => 'badge-status-pending',
                                        'accepted' => 'badge-status-success',
                                        default => 'badge-status-danger'
                                    };
                                @endphp
                                <span class="badge-status {{ $statusBadge }} mx-auto">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full mr-2 {{ $request->status == 'pending' ? 'bg-amber-500 animate-pulse' : ($request->status == 'accepted' ? 'bg-emerald-500' : 'bg-rose-500') }}"></span>
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-10 py-7 text-start text-[11px] font-black text-slate-400 font-mono text-start">
                                {{ $request->created_at->format('Y/m/d') }}</td>
                            <td class="px-10 py-7 text-end">
                                <div class="flex items-center justify-end gap-3 text-start">
                                    <a href="{{ route('verification-requests.show', $request->id) }}"
                                        class="btn-action btn-action-view" title="{{ __('استعراض الطلب') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    @if($request->status == 'pending')
                                        <form id="accept-v-{{ $request->id }}" method="POST"
                                            action="{{ route('verification-requests.accept', $request->id) }}"
                                            class="text-start">
                                            @csrf
                                            <button type="button" onclick="confirmAction('accept-v-{{ $request->id }}', {
                                                            title: '{{ __('قبول التوثيق') }}',
                                                            text: '{{ __('هل أنت متأكد من قبول طلب توثيق ' . $request->user->name . '؟') }}',
                                                            icon: 'success'
                                                        })"
                                                class="btn-action btn-action-success flex items-center justify-center text-start"
                                                title="{{ __('قبول') }}">
                                                <svg class="w-5 h-5 flex items-center justify-center" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        <form id="reject-v-{{ $request->id }}" method="POST"
                                            action="{{ route('verification-requests.reject', $request->id) }}"
                                            class="text-start">
                                            @csrf
                                            <button type="button" onclick="confirmAction('reject-v-{{ $request->id }}', {
                                                            title: '{{ __('رفض التوثيق') }}',
                                                            text: '{{ __('هل أنت متأكد من رفض طلب توثيق ' . $request->user->name . '؟') }}',
                                                            icon: 'warning',
                                                            isDanger: true
                                                        })"
                                                class="btn-action btn-action-danger flex items-center justify-center text-start"
                                                title="{{ __('رفض') }}">
                                                <svg class="w-5 h-5 flex items-center justify-center" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span
                                            class="w-10 h-10 flex items-center justify-center text-[18px] opacity-20 text-start">🔒</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center text-slate-300 font-black font-Cairo text-start">
                                <div class="flex flex-col items-center justify-center gap-4 text-start">
                                    <span class="text-6xl text-slate-100">📭</span>
                                    <span
                                        class="uppercase tracking-[0.3em] text-[10px] text-start">{{ __('لا توجد طلبات توثيق حالياً.') }}</span>
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
        /* Status Distribution Chart */
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['{{ __("بانتظار المراجعة") }}', '{{ __("طلبات مقبولة") }}', '{{ __("طلبات مرفوضة") }}'],
                    datasets: [{
                        data: [{{ $stats['pending'] }}, {{ $stats['accepted'] }}, {{ $stats['rejected'] }}],
                        backgroundColor: ['#f5a623', '#10b981', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 15,
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
                            cornerRadius: 12
                        }
                    }
                }
            });
        }

        /* Daily Request Chart */
        const dailyCtx = document.getElementById('dailyChart');
        if (dailyCtx) {
            const dCtx = dailyCtx.getContext('2d');
            const gradient = dCtx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: '{{ __("عدد الطلبات") }}',
                        data: @json($data),
                        borderColor: '#4f46e5',
                        backgroundColor: gradient,
                        borderWidth: 5,
                        tension: 0.45,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#4f46e5',
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