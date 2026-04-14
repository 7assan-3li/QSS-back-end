@extends('layouts.admin')

@section('title', __('إدارة الطلبات'))

@section('content')
    <div class="space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-slate-500/10 rounded-2xl flex items-center justify-center text-[var(--text-muted)] text-3xl font-Cairo shadow-lg shadow-slate-500/5 whitespace-nowrap inline-flex items-center justify-center">📦</span>
                {{ __('إدارة طلبات الخدمات') }}
            </h3>
            <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('إدارة طلبات المستخدمين، متابعة العمولات، ومراقبة حالة التنفيذ.') }}
            </p>
        </div>
    </div>

    <!-- Orders Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 font-Cairo text-start">
        <!-- Total Orders -->
        <a href="{{ route('requests.index') }}" class="card-premium glass-panel p-6 rounded-[2.5rem] shadow-xl border border-[var(--glass-border)] hover:scale-[1.05] transition-all group text-center bg-[var(--glass-bg)]/40 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-slate-500/5 rounded-full blur-2xl group-hover:bg-slate-500/10 transition-colors"></div>
            <div class="flex flex-col items-center gap-3 relative z-10">
                <span class="text-3xl font-black group-hover:text-indigo-600 transition-colors font-mono leading-none">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] text-center font-Cairo">{{ __('إجمالي الطلبات') }}</span>
            </div>
        </a>

        <!-- Pending Orders -->
        <a href="{{ route('requests.index', ['status' => 'pending']) }}" class="card-premium glass-panel p-6 rounded-[2.5rem] shadow-xl border border-[var(--glass-border)] hover:scale-[1.05] transition-all group text-center bg-amber-50/40 dark:bg-amber-950/20 relative overflow-hidden">
             <div class="absolute -top-10 -right-10 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-colors"></div>
            <div class="flex flex-col items-center gap-3 relative z-10">
                <span class="text-3xl font-black text-amber-500 group-hover:scale-110 transition-transform font-mono leading-none">{{ str_pad($stats['pending'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] text-center font-Cairo">{{ __('قيد المعالجة') }}</span>
            </div>
        </a>

        <!-- Completed Orders -->
        <a href="{{ route('requests.index', ['status' => 'completed']) }}" class="card-premium glass-panel p-6 rounded-[2.5rem] shadow-xl border border-[var(--glass-border)] hover:scale-[1.05] transition-all group text-center bg-emerald-50/40 dark:bg-emerald-950/20 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <div class="flex flex-col items-center gap-3 relative z-10">
                <span class="text-3xl font-black text-emerald-500 group-hover:scale-110 transition-transform font-mono leading-none">{{ str_pad($stats['completed'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] text-center font-Cairo">{{ __('عمليات مكتملة') }}</span>
            </div>
        </a>

        <!-- Unpaid Commissions -->
        <a href="{{ route('requests.index', ['commission' => 'unpaid']) }}" class="card-premium glass-panel p-6 rounded-[2.5rem] shadow-xl border border-[var(--glass-border)] hover:scale-[1.05] transition-all group text-center bg-rose-50/40 dark:bg-rose-950/20 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-rose-500/5 rounded-full blur-2xl group-hover:bg-rose-500/10 transition-colors"></div>
            <div class="flex flex-col items-center gap-3 relative z-10">
                <span class="text-3xl font-black text-rose-500 group-hover:scale-110 transition-transform font-mono leading-none">{{ str_pad($stats['unpaid'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] text-center font-Cairo">{{ __('ديون معلقة') }}</span>
            </div>
        </a>

        <!-- Custom Services -->
        <a href="{{ route('requests.index', ['type' => 'custom']) }}" class="card-premium glass-panel p-6 rounded-[2.5rem] shadow-xl border border-[var(--glass-border)] hover:scale-[1.05] transition-all group text-center bg-blue-50/40 dark:bg-blue-950/20 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
            <div class="flex flex-col items-center gap-3 relative z-10">
                <span class="text-3xl font-black text-blue-500 group-hover:scale-110 transition-transform font-mono leading-none">{{ str_pad($stats['custom'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] text-center font-Cairo">{{ __('نماذج مخصصة') }}</span>
            </div>
        </a>

        <!-- Meetings -->
        <a href="{{ route('requests.index', ['type' => 'meeting']) }}" class="card-premium glass-panel p-6 rounded-[2.5rem] shadow-xl border border-[var(--glass-border)] hover:scale-[1.05] transition-all group text-center bg-violet-50/40 dark:bg-violet-950/20 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-violet-500/5 rounded-full blur-2xl group-hover:bg-violet-500/10 transition-colors"></div>
            <div class="flex flex-col items-center gap-3 relative z-10">
                <span class="text-3xl font-black text-violet-500 group-hover:scale-110 transition-transform font-mono leading-none">{{ str_pad($stats['meeting'], 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] text-center font-Cairo">{{ __('لقاءات مجدولة') }}</span>
            </div>
        </a>
    </div>

    <!-- Orders List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-start">
        @forelse ($requests as $request)
            @php
                $commission = $request->total_price * 0.10;
            @endphp
            <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white/50 border-[var(--glass-border)] hover:shadow-brand-primary/10 transition-all duration-500 flex flex-col group relative overflow-hidden text-start font-Cairo">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/[0.03] to-transparent pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex justify-between items-start mb-8 text-start">
                    <div class="text-start">
                        @php
                            $statusBadge = match($request->status) {
                                'pending' => 'badge-status-pending',
                                'completed' => 'badge-status-success',
                                'canceled' => 'badge-status-danger',
                                default => 'badge-status-info'
                            };
                        @endphp
                        <span class="badge-status {{ $statusBadge }} tracking-tighter">
                            <span class="dot"></span>
                            {{ __('الحالة') }}: {{ __($request->status) }}
                        </span>
                    </div>
                    <span class="text-[13px] font-black text-[var(--text-muted)] bg-[var(--main-bg)] px-4 py-1.5 rounded-xl border border-[var(--glass-border)] font-mono whitespace-nowrap inline-flex items-center justify-center">ID: #{{ $request->id }}</span>
                </div>

                <!-- Client Details -->
                <div class="flex items-center gap-5 mb-8 text-start">
                    <div class="w-14 h-14 bg-gradient-to-br from-brand-primary to-indigo-600 rounded-[1.3rem] flex items-center justify-center text-white font-black text-base shadow-lg shadow-brand-primary/20 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500">
                        {{ mb_substr($request->user->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col text-start">
                        <h4 class="font-black text-lg leading-tight font-Cairo text-start">{{ $request->user->name }}</h4>
                        <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-1 font-Cairo text-start">{{ __('صاحب الطلب (العميل)') }}</span>
                    </div>
                </div>

                <!-- Requested Services -->
                <div class="space-y-4 mb-10 flex-grow text-start">
                    <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] block mb-3 px-1 font-Cairo text-start">{{ __('قائمة الخدمات المطلوبة') }}</span>
                    <div class="flex flex-wrap gap-2 text-start">
                        @foreach ($request->services as $service)
                             <div class="px-3.5 py-2 bg-[var(--main-bg)] rounded-xl border border-[var(--glass-border)] flex items-center gap-3 transition-all hover:bg-[var(--glass-bg)] dark:hover:bg-[var(--glass-border)] text-white text-start">
                                <span class="text-[13px] font-black font-Cairo text-start">{{ $service->name }}</span>
                                <div class="w-px h-3 bg-slate-200"></div>
                                <span class="text-[12px] font-black text-brand-primary font-mono text-start">×{{ $service->pivot->quantity }}</span>
                                @if($service->pivot->is_main)
                                    <span class="text-[13px] font-black bg-indigo-500 text-white px-2 py-0.5 rounded-md uppercase tracking-tighter shadow-sm font-Cairo text-start">{{ __('أساسية') }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Financial Details -->
                <div class="grid grid-cols-2 gap-6 pt-10 border-t border-[var(--glass-border)] mb-10 text-start">
                    <div class="flex flex-col gap-1.5 text-start">
                        <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo text-start">{{ __('القيمة الإجمالية') }}</span>
                        <div class="flex items-baseline gap-1 text-start">
                            <span class="text-base font-black font-mono text-start">{{ number_format($request->total_price, 2) }}</span>
                            <span class="text-[14px] font-black text-[var(--text-muted)] font-Cairo text-start">YER</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 text-end text-start">
                        <span class="text-[14px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo text-start">{{ __('عمولة المنصة (10%)') }}</span>
                         <div class="flex items-baseline gap-1 justify-end text-start">
                            <span class="text-base font-black text-brand-primary font-mono text-start">{{ number_format($commission, 2) }}</span>
                            <span class="text-[14px] font-black text-[var(--text-muted)] font-Cairo text-start">YER</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between gap-6 text-start">
                    <div class="badge-status {{ $request->commission_paid ? 'badge-status-success' : 'badge-status-danger animate-pulse' }} tracking-normal">
                        <span class="dot"></span>
                        {{ $request->commission_paid ? __('العمولة مدفوعة') : __('العمولة معلقة') }}
                    </div>
                    <a href="{{ route('requests.show', $request) }}" class="btn-action btn-action-view" title="{{ __('عرض تفاصيل الطلب') }}">
                        <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 bg-[var(--main-bg)] rounded-[4rem] text-center border-4 border-dashed border-[var(--glass-border)] flex flex-col items-center justify-center text-start">
                <div class="w-24 h-24 bg-[var(--glass-bg)] rounded-[2rem] flex items-center justify-center text-5xl mb-8 shadow-inner">🕳️</div>
                <h5 class="text-2xl font-black font-Cairo text-start">{{ __('لا توجد طلبات') }}</h5>
                <p class="text-[13px] font-black text-[var(--text-muted)] mt-6 max-w-sm leading-relaxed uppercase tracking-[0.2em] font-Cairo text-start">
                    {{ __('لا توجد طلبات مسجلة في هذا القسم حالياً.') }}
                </p>
            </div>
        @endforelse
    </div>

    <!-- Enhanced Pagination -->
    @if ($requests->hasPages())
        <div class="mt-12 text-start">
            {{ $requests->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>
@endsection
