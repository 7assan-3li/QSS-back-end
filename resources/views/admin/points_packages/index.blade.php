@extends('layouts.admin')

@section('title', __('إدارة باقات النقاط'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5 font-Cairo italic whitespace-nowrap inline-flex items-center justify-center">💎</span>
                {{ __('باقات شحن النقاط') }}
            </h3>
            <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('إدارة النقاط، ضبط الباقات، وتوفير خيارات الشحن للمستخدمين.') }}
            </p>
        </div>
        <a href="{{ route('admin.points-packages.create') }}" class="group relative px-10 py-5 bg-slate-950 dark:bg-brand-primary rounded-[2rem] text-white text-[14px] font-black uppercase tracking-[0.3em] shadow-[0_20px_40px_-10px_rgba(0,0,0,0.4)] hover:scale-[1.05] transition-all font-Cairo flex items-center gap-4 overflow-hidden">
             <div class="absolute inset-0 bg-[var(--glass-bg)]/10 translate-y-full group-hover:translate-y-0 transition-transform duration-500 font-Cairo"></div>
             <span class="relative z-10 w-6 h-6 bg-[var(--glass-bg)]/20 rounded-lg flex items-center justify-center group-hover:rotate-180 transition-transform font-Cairo font-mono">➕</span>
             <span class="relative z-10">{{ __('إصدار باقة جديدة') }}</span>
        </a>
    </div>

    <!-- Points Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-4xl mx-auto font-Cairo text-start">
        <!-- Total Packages -->
        <div class="card-premium glass-panel p-8 rounded-[2rem] shadow-2xl border border-[var(--glass-border)] flex items-center gap-8 group hover:scale-[1.02] transition-all text-start font-Cairo">
            <div class="w-16 h-16 bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">📦</div>
            <div class="flex flex-col text-start">
                <span class="text-3xl font-black leading-none font-mono text-start">{{ str_pad($packages->count(), 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[12px] font-black uppercase tracking-[0.2em] mt-2 font-Cairo text-start opacity-60">{{ __('إجمالي باقات النقاط') }}</span>
            </div>
        </div>

        <!-- Active Packages -->
        <div class="card-premium glass-panel p-8 rounded-[2rem] shadow-2xl border border-emerald-500/20 flex items-center gap-8 group hover:scale-[1.02] transition-all text-start bg-emerald-50/20 dark:bg-emerald-950/10 font-Cairo">
            <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">⚡</div>
            <div class="flex flex-col text-start">
                <span class="text-3xl font-black text-emerald-600 font-mono leading-none text-start">{{ str_pad($packages->where('is_active', true)->count(), 2, '0', STR_PAD_LEFT) }}</span>
                <span class="text-[12px] font-black text-emerald-500/80 uppercase tracking-[0.2em] mt-2 font-Cairo text-start">{{ __('الباقات المتاحة حالياً') }}</span>
            </div>
        </div>
    </div>

    <!-- Asset Portfolio Grid -->
    @if ($packages->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 font-Cairo text-start">
            @foreach ($packages as $package)
                <div class="card-premium glass-panel p-12 rounded-[2rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] relative border border-[var(--glass-border)] flex flex-col group overflow-hidden text-start hover:shadow-brand-primary/[0.05] {{ !$package->is_active ? 'opacity-70 grayscale-[0.3]' : '' }}">
                    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-brand-primary/40 to-indigo-500/40 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <!-- Performance status -->
                    <div class="flex justify-between items-start mb-10 relative z-10 text-start">
                        <span class="px-5 py-2 rounded-xl text-[12px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm @if($package->is_active) bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 @endif whitespace-nowrap inline-flex items-center justify-center">
                            {{ $package->is_active ? __('نشطة') : __('معطلة') }}
                        </span>
                        <div class="w-12 h-12 bg-[var(--main-bg)] rounded-2xl flex items-center justify-center text-brand-primary shadow-inner rotate-3 group-hover:rotate-12 transition-transform font-Cairo">💎</div>
                    </div>

                    <div class="text-center flex-1 text-start font-Cairo">
                        <div class="w-32 h-32 bg-[var(--glass-bg)] rounded-[2rem] flex items-center justify-center text-6xl shadow-2xl border-4 border-[var(--glass-border)] mx-auto mb-10 transform group-hover:scale-110 transition-all duration-700 font-Cairo shadow-brand-primary/5">💠</div>
                        <h4 class="font-black text-2xl tracking-tight mb-4 font-Cairo text-start italic">{{ $package->name }}</h4>
                        
                        <div class="flex flex-col items-center gap-2 mb-10 text-start">
                            <span class="text-5xl font-black text-brand-primary tracking-tighter font-mono text-start">{{ number_format($package->points) }}</span>
                            <span class="text-[13px] font-black uppercase tracking-[0.3em] font-Cairo mt-1 text-start opacity-60">{{ __('نقطة شحن أساسية') }}</span>
                        </div>

                        @if ($package->bonus_points > 0)
                            <div class="px-8 py-3 bg-indigo-500/5 text-indigo-600 border border-indigo-500/10 rounded-xl text-[13px] font-black mb-10 inline-flex items-center gap-3 font-Cairo shadow-sm animate-pulse">
                                <span class="text-lg">🎁</span>
                                {{ number_format($package->bonus_points) }} {{ __('نقطة مكافأة إضافية') }}
                            </div>
                        @endif

                        <div class="text-3xl font-black mb-12 py-8 bg-[var(--main-bg)] rounded-[1.5rem] border border-[var(--glass-border)] shadow-inner text-start font-mono flex items-center justify-center gap-3">
                            {{ number_format($package->price, 0) }} <span class="text-xs font-black uppercase tracking-widest font-Cairo opacity-60">{{ __('ريال يمني') }}</span>
                        </div>
                    </div>

                    <!-- Operational Controls -->
                    <div class="flex gap-6 pt-10 border-t border-[var(--glass-border)] text-start font-Cairo">
                        <a href="{{ route('admin.points-packages.edit', $package->id) }}" class="flex-1 bg-[var(--glass-bg)] border border-[var(--glass-border)] text-[var(--text-secondary)] py-5 rounded-xl text-[13px] font-black text-center uppercase tracking-widest hover:bg-slate-950 hover:text-white hover:bg-[var(--glass-border)] dark:hover:text-slate-950 transition-all font-Cairo shadow-sm text-start">{{ __('تعديل الباقة') }}</a>
                        <form id="delete-points-package-{{ $package->id }}" action="{{ route('admin.points-packages.destroy', $package->id) }}" method="POST" class="contents text-start">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                onclick="confirmAction('delete-points-package-{{ $package->id }}', {
                                    title: '{{ __('حذف باقة النقاط نهائياً') }}',
                                    text: '{{ __('تحذير: المسح سيؤدي لإزالة الباقة من خيارات الشحن المتاحة فوراً. هل أنت متأكد؟') }}',
                                    icon: 'warning',
                                    isDanger: true,
                                    confirmButtonText: '{{ __('تأكيد المسح النهائي') }}'
                                })" class="w-16 h-16 items-center justify-center bg-rose-50 dark:bg-rose-950/20 text-rose-500 dark:text-rose-400 rounded-xl hover:bg-rose-600 hover:text-white transition-all flex shadow-sm border border-[var(--glass-border)] font-Cairo text-start">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-40 bg-[var(--glass-bg)]/[0.3] /[0.2] rounded-[2rem] text-center border-2 border-dashed border-[var(--glass-border)] font-Cairo text-start">
            <div class="w-32 h-32 bg-[var(--main-bg)] rounded-[2rem] flex items-center justify-center mx-auto mb-10 text-slate-300 shadow-inner animate-pulse transition-all italic font-Cairo text-6xl">💎</div>
            <h3 class="font-black text-3xl mb-4 font-Cairo text-start italic">{{ __('لا توجد باقات نقاط حالياً') }}</h3>
            <p class="font-bold max-w-lg mx-auto text-xs font-Cairo leading-loose text-center italic opacity-60">
                {{ __('يرجى إضافة أول باقة نقاط للسماح للمستخدمين بشحن أرصدتهم واستخدام مميزات المنصة.') }}
            </p>
            <a href="{{ route('admin.points-packages.create') }}" class="mt-12 px-14 py-6 bg-slate-950 text-white rounded-[1.2rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-[0_25px_50px_-10px_rgba(0,0,0,0.3)] hover:scale-[1.05] transition-all font-Cairo text-start italic">
                {{ __('+ إصدار أول باقة الآن') }}
            </a>
        </div>
    @endif
</div>
@endsection
