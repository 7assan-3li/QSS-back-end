@extends('layouts.admin')

@section('title', __('لوحة التحكم الرئيسية'))

@section('content')
<div class="space-y-8 mt-4">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in">
        <div class="card-premium p-6 relative overflow-hidden group">
            <div class="absolute -right-8 -top-8 w-24 h-24 bg-emerald-500 opacity-[0.05] dark:opacity-[0.1] rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
            
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4 border border-emerald-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.732 4c-.77.234-1.476.614-2.066 1.114M6.718 4c.77.234 1.476.614 2.066 1.114M12 7h.01"></path></svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest mb-1 opacity-60">{{ __('إجمالي المستخدمين') }}</p>
                <h3 class="text-3xl font-black mb-2">{{ number_format($usersCount) }}</h3>
                <p class="text-[10px] font-black inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7-7m-7-7v18"></path></svg> 
                    {{ __('حالة الاتصال') }} <span class="font-bold opacity-60">{{ __('نشط') }}</span>
                </p>
            </div>
        </div>
        
        <div class="card-premium p-6 relative overflow-hidden group">
            <div class="absolute -right-8 -top-8 w-24 h-24 bg-blue-500 opacity-[0.05] dark:opacity-[0.1] rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>

            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 border border-blue-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path></svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest mb-1 opacity-60">{{ __('أقسام السوق') }}</p>
                <h3 class="text-3xl font-black mb-2">{{ number_format($categoriesCount) }}</h3>
                <p class="text-[10px] font-black inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-500/20">
                    <span>{{ __('قنوات الخدمة المفعلة') }}</span>
                </p>
            </div>
        </div>

        <div class="card-premium p-6 relative overflow-hidden group">
            <div class="absolute -right-8 -top-8 w-24 h-24 bg-amber-500 opacity-[0.05] dark:opacity-[0.1] rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>

            <div class="relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400 mb-4 border border-amber-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <p class="text-xs font-black uppercase tracking-widest mb-1 opacity-60">{{ __('عدد الصفقات') }}</p>
                <h3 class="text-3xl font-black mb-2">{{ number_format($requestsCount ?? 0) }}</h3>
                <p class="text-[10px] font-black inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20">
                    <span class="font-bold opacity-60">{{ __('إجمالي المعاملات') }}</span>
                </p>
            </div>
        </div>

        <div class="card-premium bg-gradient-to-br from-brand-primary to-brand-primary-hover p-6 relative overflow-hidden group shadow-xl shadow-brand-primary/20 border-0">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white opacity-[0.15] rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>

            <div class="relative z-10 text-white">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mb-4 backdrop-blur-md border border-white/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-xs font-black text-white uppercase tracking-widest mb-1">{{ __('العمولات المحصلة') }}</p>
                <h3 class="text-3xl font-black mb-2 text-white">{{ number_format($commissionsTotal ?? 0, 2) }} <span class="text-sm font-bold opacity-80">{{ __('ر.س') }}</span></h3>
                <p class="text-[10px] font-black inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-white/20 text-white">
                    <span class="font-bold opacity-80">{{ __('تراكمي') }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass-panel p-8 rounded-[2.5rem]">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <h3 class="font-black text-xl">{{ __('إيرادات المنصة (آخر 6 أشهر)') }}</h3>
                <select class="bg-white dark:bg-black border-none text-xs font-bold rounded-xl px-4 py-2 outline-none dark:text-white shadow-sm ring-1 ring-slate-100 dark:ring-slate-800">
                    <option>{{ date('Y') }}</option>
                </select>
            </div>
            <div class="relative h-72 w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="glass-panel rounded-[2.5rem] overflow-hidden border-none flex flex-col">
            <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800/50">
                <h3 class="font-black text-lg">{{ __('المهام العاجلة') }}</h3>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-800/50 flex-1">
                <div class="p-6 hover:bg-brand-primary/[0.02] dark:hover:bg-brand-primary/5 transition group cursor-pointer" onclick="window.location='{{ route('verification-requests.index') }}'">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-amber-500 rounded-full shadow-lg shadow-amber-500/20"></div>
                            <p class="text-sm font-bold">{{ __('توثيق الحسابات') }}</p>
                        </div>
                        <span class="bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[10px] px-2.5 py-1 rounded-lg font-black border border-amber-500/20 shadow-sm">{{ __('معلق') }}</span>
                    </div>
                    <p class="text-[11px] font-bold italic opacity-60">{{ __('هناك طلبات بانتظار المراجعة والتدقيق.') }}</p>
                </div>
                
                <div class="p-6 hover:bg-brand-primary/[0.02] dark:hover:bg-brand-primary/5 transition group cursor-pointer" onclick="window.location='{{ route('request-complaints.index') }}'">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 bg-rose-500 rounded-full animate-pulse shadow-lg shadow-rose-500/20"></div>
                            <p class="text-sm font-bold">{{ __('نزاعات جديدة') }}</p>
                        </div>
                        <span class="bg-rose-500/10 text-rose-600 dark:text-rose-400 text-[10px] px-2.5 py-1 rounded-lg font-black border border-rose-500/20 shadow-sm">{{ __('حرج') }}</span>
                    </div>
                    <p class="text-[11px] font-bold italic opacity-60">{{ __('نزاع مالي بين عميل ومزود يحتاج تدخل سريع.') }}</p>
                </div>
            </div>
            <button class="m-6 bg-slate-900 dark:bg-white text-white dark:text-slate-900 py-4 rounded-2xl text-xs font-black transition-all hover:scale-[1.02] active:scale-95 shadow-xl hover:shadow-2xl" onclick="window.location='{{ route('settings.index') }}'">{{ __('مراجعة الإعدادات المركزية') }}</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($revenueLabels),
                    datasets: [{
                        label: '{{ __("الإيرادات (ر.س)") }}',
                        data: @json($revenueData),
                        borderColor: '#4f46e5',
                        backgroundColor: gradient,
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 6,
                        pointBackgroundColor: '#4f46e5',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { family: 'Cairo', size: 14, weight: 'bold' },
                            bodyFont: { family: 'Cairo', size: 13 },
                            padding: 15,
                            cornerRadius: 15,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                            ticks: { 
                                font: { family: 'Cairo', weight: 'bold', size: 11 },
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { 
                                font: { family: 'Cairo', weight: 'bold', size: 11 },
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
