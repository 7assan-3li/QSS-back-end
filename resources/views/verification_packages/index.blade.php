@extends('layouts.admin')

@section('title', __('إدارة باقات التوثيق'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl text-slate-800 dark:text-white flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5">💎</span>
                {{ __('باقات التوثيق') }}
            </h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('إدارة باقات توثيق الهوية، أسعارها، ميزاتها، ومدة صلاحيتها.') }}
            </p>
        </div>
        <a href="{{ route('verification-packages.create') }}" class="group relative px-10 py-5 bg-slate-950 dark:bg-brand-primary rounded-[2rem] text-white text-[11px] font-black uppercase tracking-[0.3em] shadow-[0_20px_40px_-10px_rgba(0,0,0,0.4)] hover:scale-[1.05] active:scale-95 transition-all font-Cairo flex items-center gap-4 overflow-hidden">
             <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
             <span class="relative z-10 w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center group-hover:rotate-180 transition-transform font-Cairo">➕</span>
             <span class="relative z-10">{{ __('إضافة باقة جديدة') }}</span>
        </a>
    </div>

    <!-- Ecosystem Magnitude Matrix -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-4xl mx-auto font-Cairo text-start">
        <!-- Total Modules Node -->
        <div class="card-premium glass-panel p-8 rounded-[2rem] shadow-2xl border border-white dark:border-slate-800/50 flex items-center gap-8 group hover:scale-[1.02] transition-all text-start">
            <div class="w-16 h-16 bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">📦</div>
            <div class="flex flex-col text-start">
                <span class="text-3xl font-black text-slate-800 dark:text-white leading-none font-mono text-start">{{ str_pad($packages->count(), 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('إجمالي الباقات') }}</span>
            </div>
        </div>

        <!-- Active Nodes Magnitude -->
        <div class="card-premium glass-panel p-8 rounded-[2rem] shadow-2xl border border-emerald-500/20 flex items-center gap-8 group hover:scale-[1.02] transition-all text-start bg-emerald-50/20 dark:bg-emerald-950/10">
            <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform font-Cairo">⚡</div>
            <div class="flex flex-col text-start">
                <span class="text-3xl font-black text-emerald-600 font-mono leading-none text-start">{{ str_pad($packages->where('is_active', true)->count(), 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[9px] font-black text-emerald-500/60 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('الباقات النشطة حالياً') }}</span>
            </div>
        </div>
    </div>

    <!-- Package Architecture Grid -->
    @if ($packages->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 font-Cairo">
            @foreach ($packages as $package)
                <div class="card-premium glass-panel p-10 rounded-[2.5rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] relative border border-white dark:border-slate-800/50 flex flex-col group overflow-hidden text-start hover:shadow-brand-primary/[0.05]">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/[0.03] to-transparent pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    
                    <!-- Structural Header -->
                    <div class="flex justify-between items-start mb-10 relative z-10 text-start">
                        <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] font-Cairo text-start shadow-sm
                            @if($package->is_active) bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 @endif">
                            {{ $package->is_active ? __('نشطة') : __('غير نشطة') }}
                        </span>
                        <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-slate-300 group-hover:text-brand-primary transition-all shadow-inner font-Cairo">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>

                    <!-- Identity & Pricing Node -->
                    <div class="mb-10 relative z-10 text-start">
                        <h4 class="text-2xl font-black text-slate-800 dark:text-white mb-3 font-Cairo text-start italic">{{ $package->name }}</h4>
                        <div class="flex items-baseline gap-2 text-start">
                            <span class="text-4xl font-black text-brand-primary font-mono text-start">{{ number_format($package->price, 0) }}</span>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-Cairo text-start">{{ __('ريال') }}</span>
                        </div>
                    </div>

                    <!-- Feature Matrix Summary -->
                    <div class="space-y-6 mb-12 flex-grow relative z-10 text-start font-Cairo">
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-3 font-Cairo text-start">
                            {{ $package->description ?? __('لا يوجد وصف متاح لهذه الباقة حالياً.') }}
                        </p>
                        <div class="flex items-center gap-4 text-emerald-500/60 text-start font-Cairo">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/5 flex items-center justify-center font-Cairo shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] font-Cairo text-start">{{ __('الصلاحية') }}: {{ $package->duration_days }} {{ __('يوم') }}</span>
                        </div>
                    </div>

                    <!-- Operational Controls -->
                    <div class="grid grid-cols-2 gap-5 relative z-10 text-start font-Cairo">
                        <a href="{{ route('verification-packages.show', $package->id) }}" class="py-4 bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-white rounded-2xl text-[9px] font-black text-center hover:bg-slate-950 hover:text-white dark:hover:bg-white dark:hover:text-slate-950 transition-all font-Cairo uppercase tracking-widest border border-slate-100 dark:border-slate-800 shadow-sm text-start">{{ __('عرض التفاصيل') }}</a>
                        <a href="{{ route('verification-packages.edit', $package->id) }}" class="py-4 bg-brand-primary text-white rounded-2xl text-[9px] font-black text-center shadow-2xl shadow-brand-primary/20 hover:scale-[1.03] active:scale-95 transition-all font-Cairo uppercase tracking-widest text-start">{{ __('تعديل') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-32 bg-slate-50/[0.3] dark:bg-slate-950/[0.2] rounded-[3rem] text-center border-2 border-dashed border-slate-200 dark:border-slate-800 font-Cairo text-start">
            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-900 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 text-slate-300 shadow-inner animate-pulse font-Cairo">📦</div>
            <span class="text-slate-400 font-black text-xs uppercase tracking-[0.3em] font-Cairo opacity-50 text-start">{{ __('لا توجد باقات مضافة حالياً.') }}</span>
        </div>
    @endif
</div>
@endsection
