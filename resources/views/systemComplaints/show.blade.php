@extends('layouts.admin')

@section('title', __('تفاصيل بلاغ النظام'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-5 mb-5 text-start">
                <a href="{{ route('system-complaints.index') }}" class="w-14 h-14 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm border border-[var(--glass-border)]">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-rose-500/10 rounded-2xl flex items-center justify-center text-rose-600 text-2xl font-Cairo shadow-lg shadow-rose-500/5 whitespace-nowrap inline-flex items-center justify-center">🚩</span>
                    {{ __('معالجة بلاغ النظام') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[13px] font-black mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start opacity-60">
                <span>{{ __('تفاصيل البلاغ') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('التحليل النوعي') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-rose-600 opacity-100">{{ __('البلاغ') }} #{{ str_pad($systemComplaint->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
             <span class="px-8 py-3 rounded-2xl text-[13px] font-black uppercase tracking-[0.1em] font-Cairo shadow-xl @if($systemComplaint->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 shadow-amber-500/5 @elseif($systemComplaint->status == 'in_progress') bg-blue-500/10 text-blue-600 border border-blue-500/20 shadow-blue-500/5 @else bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-emerald-500/5 @endif whitespace-nowrap inline-flex items-center justify-center">
                {{ __('حالة النظام') }}: {{ __($systemComplaint->status) }}
            </span>
        </div>
    </div>

    <!-- Processing Status -->
    <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl border border-[var(--glass-border)] overflow-hidden relative text-start font-Cairo">
        <div class="absolute inset-0 bg-gradient-to-r from-rose-500/[0.04] to-transparent pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-12 text-start font-Cairo">
            @foreach ($statusSteps as $step)
                @php
                    $isCurrent = $systemComplaint->status == $step;
                    $isCompleted = array_search($systemComplaint->status, $statusSteps) > array_search($step, $statusSteps);
                @endphp
                <div class="flex-1 flex flex-col items-center gap-5 group relative text-center font-Cairo">
                    <div class="w-16 h-16 rounded-[1.5rem] flex items-center justify-center transition-all duration-700 relative z-10 font-Cairo @if($isCurrent) bg-rose-600 text-white shadow-[0_20px_40px_-5px_rgba(225,29,72,0.4)] scale-110 ring-8 ring-rose-500/10 @elseif($isCompleted) bg-emerald-500 text-white shadow-lg shadow-emerald-500/20 @else bg-[var(--glass-border)] text-[var(--text-muted)] border border-[var(--glass-border)] shadow-inner @endif font-black text-lg">
                        @if($isCompleted)
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        @endif
                    </div>
                    <div class="flex flex-col items-center text-center font-Cairo">
                        <span class="text-[13px] font-black uppercase tracking-[0.2em] font-Cairo mb-2 @if($isCurrent) text-rose-600 @elseif($isCompleted) text-emerald-600 @else opacity-60 @endif">
                            {{ $step == 'pending' ? __('المرحلة') . ': ' . __('قيد الانتظار') : ($step == 'in_progress' ? __('المرحلة') . ': ' . __('قيد المعالجة') : __('المرحلة') . ': ' . __('تم الحل')) }}
                        </span>
                        <span class="text-xs font-black font-Cairo italic">
                            {{ __($step) }}
                        </span>
                    </div>
                    
                    @if(!$loop->last)
                        <div class="hidden md:block absolute h-[2px] w-[calc(100%-4rem)] top-8 -right-[calc(50%-2rem)] bg-[var(--glass-border)] -z-0 overflow-hidden text-start">
                            <div class="h-full bg-emerald-500 transition-all duration-1000" style="width: {{ $isCompleted ? '100%' : '0%' }}"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Report Details -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo">
        <!-- Content & Source Space -->
        <div class="lg:col-span-8 space-y-12 text-start">
            <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-rose-600 rounded-full shadow-lg shadow-rose-600/30"></span>
                    <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('محتوى البلاغ') }}</h4>
                </div>
                
                <div class="bg-[var(--main-bg)] p-12 rounded-[3.5rem] border border-[var(--glass-border)] mb-16 relative group text-start font-Cairo shadow-inner">
                    <div class="absolute -top-8 -right-8 w-20 h-20 bg-[var(--glass-bg)] rounded-3xl shadow-2xl flex items-center justify-center text-4xl group-hover:rotate-12 transition-all duration-500 font-Cairo">💬</div>
                    <p class="text-xl font-bold leading-[2.2] font-Cairo italic text-start font-Cairo opacity-70">" {{ $systemComplaint->content }}"
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo">
                    <!-- Metadata Node: Source -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start">
                        <div class="w-16 h-16 bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">📱</div>
                        <div class="flex flex-col text-start font-Cairo">
                            <span class="text-[12px] font-black uppercase tracking-[0.3em] mb-2 font-Cairo text-start opacity-60">{{ __('قناة الوارد') }}</span>
                            <span class="text-sm font-black text-indigo-600 font-Cairo text-start">
                                {{ $systemComplaint->app_source === 'provider' ? __('تطبيق المزود') : __('تطبيق العميل') }}
                            </span>
                        </div>
                    </div>

                    <!-- Metadata Node: User Identity -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start">
                        <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">👤</div>
                        <div class="flex flex-col text-start font-Cairo">
                            <span class="text-[12px] font-black uppercase tracking-[0.3em] mb-2 font-Cairo text-start opacity-60">{{ __('هوية المُبلغ') }}</span>
                            <span class="text-sm font-black font-Cairo text-start italic">{{ $systemComplaint->user->name }}</span>
                        </div>
                    </div>

                    <!-- Metadata Node: Communication -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-blue-500/10 text-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">✉️</div>
                        <div class="flex flex-col text-start font-Cairo font-mono">
                            <span class="text-[12px] font-black uppercase tracking-[0.3em] mb-2 font-Cairo text-start opacity-60">{{ __('قنوات الاتصال') }}</span>
                            <span class="text-[14px] font-black tracking-tight text-start italic opacity-70">{{ $systemComplaint->user->email }}</span>
                        </div>
                    </div>

                    <!-- Metadata Node: Chronology -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-amber-500/10 text-amber-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo font-mono">📅</div>
                        <div class="flex flex-col text-start">
                            <span class="inline-flex items-center gap-3 px-6 py-3 bg-[var(--main-bg)] rounded-2xl border border-[var(--glass-border)] text-[13px] font-black text-[var(--text-muted)] font-mono whitespace-nowrap inline-flex items-center justify-center">
                                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                {{ __('توقيت الدخول') }}: {{ $systemComplaint->created_at->format('Y-m-d H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Administrative Actions Sidebar -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <!-- Status Control Terminal -->
            <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo overflow-hidden relative">
                 <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-rose-500 via-pink-500 to-indigo-600 opacity-60 font-Cairo"></div>
                 
                <div class="flex items-center gap-4 mb-10 text-start font-Cairo">
                    <span class="w-2 h-8 bg-rose-600 rounded-full shadow-md font-Cairo"></span>
                    <h4 class="font-black font-Cairo text-sm uppercase tracking-[0.2em] text-start italic">{{ __('تحديث حالة البلاغ') }}</h4>
                </div>

                @if(session('success'))
                    <div class="p-6 bg-emerald-500/10 text-emerald-600 text-[14px] font-black rounded-[2rem] mb-10 border border-emerald-500/20 text-center animate-pulse font-Cairo shadow-sm">
                         ⚠️ {{ __('نظام') }}: {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('system-complaints.update-status', $systemComplaint) }}" class="space-y-10 text-start font-Cairo">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4 text-start font-Cairo">
                        <label class="text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">{{ __('الحالة الجديدة') }}</label>
                        <div class="relative text-start font-Cairo">
                            <select name="status" class="w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-rose-600 focus:ring-[12px] focus:ring-rose-500/5 appearance-none font-Cairo transition-all text-center shadow-inner">
                                @foreach (\App\constant\SystemComplaintStatus::all() as $status)
                                    <option value="{{ $status }}" {{ $systemComplaint->status == $status ? 'selected' : '' }}>
                                        {{ __($status) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute left-8 top-1/2 -translate-y-1/2 pointer-events-none text-[var(--text-muted)]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 text-start font-Cairo">
                        <button type="submit" class="w-full py-6 bg-gradient-to-r from-rose-600 to-pink-700 text-white rounded-[2.5rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-[0_25px_50px_-10px_rgba(225,29,72,0.4)] hover:scale-[1.03] hover:shadow-rose-600/50 transition-all duration-500 font-Cairo flex items-center justify-center gap-4">
                            {{ __('حفظ التغييرات') }} 💾
                        </button>
                    </div>
                </form>
            </div>

            <!-- Processing Efficiency -->
            <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo">
                <div class="flex items-center gap-4 mb-10 text-start font-Cairo">
                    <span class="w-2 h-8 bg-indigo-500 rounded-full shadow-md font-Cairo"></span>
                    <h4 class="font-black font-Cairo text-sm uppercase tracking-[0.2em] text-start italic">{{ __('إحصائيات المعالجة') }}</h4>
                </div>
                <div class="relative h-64 text-start font-Cairo font-mono">
                    <canvas id="complaintChart"></canvas>
                </div>
                <div class="mt-10 grid grid-cols-2 gap-6 text-start font-Cairo">
                    <div class="bg-amber-500/10 p-6 rounded-[2rem] border border-amber-500/20 text-center group hover:bg-amber-500/15 transition-all text-start font-Cairo">
                        <span class="block text-[14px] font-black text-amber-600 uppercase tracking-[0.3em] mb-2 font-Cairo opacity-70">{{ __('وقت الانتظار') }}</span>
                        <span class="text-lg font-black font-mono italic">{{ $waitingHours }}h</span>
                    </div>
                    <div class="bg-emerald-500/10 p-6 rounded-[2rem] border border-emerald-500/20 text-center group hover:bg-emerald-500/15 transition-all text-start font-Cairo">
                        <span class="block text-[14px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-2 font-Cairo opacity-70">{{ __('وقت المعالجة') }}</span>
                        <span class="text-lg font-black font-mono italic">{{ $processingHours }}h</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const complaintCtx = document.getElementById('complaintChart');
    if (complaintCtx) {
        new Chart(complaintCtx, {
            type: 'bar',
            data: {
                labels: ['{{ __("الانتظار") }}', '{{ __("المعالجة") }}'],
                datasets: [{
                    data: [{{ $waitingHours }}, {{ $processingHours }}],
                    backgroundColor: ['#f59e0b', '#10b981'],
                    borderRadius: 20,
                    barThickness: 45,
                    borderWidth: 0,
                    hoverBackgroundColor: ['#d97706', '#059669']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { family: 'Cairo', size: 12 },
                        bodyFont: { family: 'Cairo', size: 11 },
                        padding: 15,
                        cornerRadius: 15,
                        displayColors: false
                    }
                },
                scales: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148, 163, 184, 0.1)', drawBorder: false },
                        ticks: { font: { size: 10, family: 'Cairo' }, color: '#94a3b8', callback: v => v + 'h' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, family: 'Cairo', weight: '900' }, color: '#94a3b8' }
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection