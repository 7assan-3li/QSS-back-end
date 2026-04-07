@extends('layouts.admin')

@section('title', 'تفاصيل الباقة: ' . $package->name)

@section('content')
<div class="max-w-6xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-5 mb-5 text-start">
                <a href="{{ route('verification-packages.index') }}" class="w-14 h-14 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-800">
                    <svg class="w-6 h-6 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl text-slate-800 dark:text-white flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl font-Cairo shadow-lg shadow-indigo-500/5">💎</span>
                    {{ __('مواصفات باقة التوثيق') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('الباقات') }}</span>
                <svg class="w-2 h-2 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('التفاصيل') }}</span>
                <svg class="w-2 h-2 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary">{{ __('الباقة') }} ID #{{ str_pad($package->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
             <span class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.1em] font-Cairo text-start shadow-xl
                @if($package->is_active) bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-emerald-500/5
                @else bg-rose-500/10 text-rose-600 border border-rose-500/20 shadow-rose-500/5 @endif text-start font-Cairo">
                {{ $package->is_active ? __('حالة الباقة: نشطة') : __('حالة الباقة: معطلة') }}
            </span>
        </div>
    </div>

    <!-- Main Architecture Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo">
        <!-- Structural specs Space -->
        <div class="lg:col-span-8 space-y-12 text-start">
            <!-- Information Matrix Card -->
            <div class="card-premium glass-panel p-14 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-primary/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30"></span>
                    <h4 class="text-2xl font-black text-slate-800 dark:text-white font-Cairo text-start italic">{{ __('البيانات الأساسية للباقة') }}</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 text-start font-Cairo">
                    <!-- Name ID Node -->
                    <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-white dark:border-white/5 flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start">
                        <div class="w-16 h-16 bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">📦</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('اسم الباقة') }}</span>
                            <span class="text-sm font-black text-slate-800 dark:text-white font-Cairo text-start">{{ $package->name }}</span>
                        </div>
                    </div>

                    <!-- Monetary Valuation Node -->
                    <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-white dark:border-white/5 flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start">
                        <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">💰</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('السعر') }}</span>
                            <div class="flex items-baseline gap-2 text-start">
                                <span class="text-lg font-black text-emerald-600 font-mono text-start">{{ number_format($package->price, 0) }}</span>
                                <span class="text-[9px] font-black text-emerald-600/60 font-Cairo text-start">{{ __('ريال') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Temporal Span Node -->
                    <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-white dark:border-white/5 flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-amber-500/10 text-amber-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">⏳</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('مدة الصلاحية') }}</span>
                            <span class="text-sm font-black text-slate-800 dark:text-white font-Cairo text-start">{{ $package->duration_days }} {{ __('يوم') }}</span>
                        </div>
                    </div>

                    <!-- Genesis Date Node -->
                    <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-white dark:border-white/5 flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo font-mono">📅</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('تاريخ الإضافة') }}</span>
                            <span class="text-sm font-black text-slate-800 dark:text-white font-Cairo text-start">{{ $package->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descriptive Narrative Card -->
            <div class="card-premium glass-panel p-14 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo min-h-[350px]">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/[0.03] to-transparent pointer-events-none"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-indigo-600 rounded-full shadow-lg shadow-indigo-600/30"></span>
                    <h4 class="text-2xl font-black text-slate-800 dark:text-white font-Cairo text-start italic">{{ __('وصف الباقة ومميزاتها') }}</h4>
                </div>

                <div class="bg-slate-50/50 dark:bg-slate-950/40 p-12 rounded-[1.5rem] border border-slate-100 dark:border-slate-800/80 mb-8 relative group text-start font-Cairo shadow-inner">
                    <div class="absolute -top-8 -right-8 w-20 h-20 bg-white dark:bg-slate-900 rounded-[1.2rem] shadow-2xl flex items-center justify-center text-4xl group-hover:rotate-12 transition-all duration-500 font-Cairo">📜</div>
                    @if ($package->description)
                        <p class="text-lg font-bold text-slate-700 dark:text-slate-200 leading-[2.2] font-Cairo italic text-start font-Cairo">
                             {!! nl2br(e($package->description)) !!}
                        </p>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 opacity-30 gap-6 text-start">
                            <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center text-5xl">🔭</div>
                            <span class="text-xs font-black text-slate-500 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('لا يوجد وصف متاح لهذه الباقة حالياً.') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Infrastructure Controls Sidebar -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <!-- Control Panel Terminal -->
            <div class="card-premium glass-panel p-10 rounded-[2rem] shadow-2xl border border-white dark:border-slate-800/50 text-start font-Cairo overflow-hidden relative">
                 <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-brand-primary via-indigo-500 to-indigo-600 opacity-60"></div>
                 
                <div class="flex items-center gap-4 mb-10 text-start">
                    <span class="w-2 h-8 bg-slate-800 dark:bg-white rounded-full shadow-md"></span>
                    <h4 class="font-black text-slate-900 dark:text-white font-Cairo text-sm uppercase tracking-[0.2em] text-start">{{ __('إدارة الباقة') }}</h4>
                </div>

                <div class="space-y-6 text-start font-Cairo">
                    <a href="{{ route('verification-packages.edit', $package->id) }}" class="w-full py-6 bg-gradient-to-r from-brand-primary to-indigo-600 text-white rounded-[1.2rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-[0_20px_40px_-10px_rgba(var(--brand-primary-rgb),0.3)] hover:scale-[1.03] active:scale-95 transition-all duration-500 font-Cairo flex items-center justify-center gap-4 text-start">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                         {{ __('تعديل بيانات الباقة') }}
                    </a>
                    
                    <form id="delete-package-{{ $package->id }}" action="{{ route('verification-packages.destroy', $package->id) }}" method="POST" class="text-start">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                            onclick="confirmAction('delete-package-{{ $package->id }}', {
                                title: '{{ __('حذف باقة التوثيق نهائياً') }}',
                                text: '{{ __('تحذير: أنت على وشك حذف هذه الباقة وكافة البيانات المرتبطة بها. الحذف قد يؤثر على سجلات المشتركين الحاليين. هذا الإجراء نهائي.') }}',
                                icon: 'warning',
                                isDanger: true,
                                confirmButtonText: '{{ __('تأكيد المسح النهائي') }}'
                            })"
                            class="w-full py-6 bg-white dark:bg-slate-900 text-rose-500 border border-rose-100 dark:border-rose-500/20 rounded-[1.2rem] text-[11px] font-black hover:bg-rose-50 dark:hover:bg-rose-500/5 transition-all font-Cairo flex items-center justify-center gap-4 uppercase tracking-[0.3em] shadow-sm text-start">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            {{ __('حذف الباقة') }}
                        </button>
                    </form>
                </div>
                
                <div class="mt-10 pt-8 border-t border-slate-100 dark:border-slate-800/50 flex flex-col gap-6 text-start">
                    <div class="flex items-start gap-4 opacity-75 px-2 text-start">
                        <div class="w-6 h-6 rounded-full bg-amber-500/10 flex items-center justify-center text-amber-500 flex-shrink-0 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 leading-relaxed font-Cairo text-start">
                             {{ __('ملاحظة: هذه الباقة قد تكون مرتبطة بمشتركين حاليين. الحذف قد يؤثر على سجلاتهم.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Eco Support Tip -->
             <div class="p-10 bg-slate-900 text-white rounded-[3.5rem] shadow-2xl relative overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-[8rem] -mr-15 -mt-15"></div>
                <h5 class="text-[10px] font-black uppercase tracking-[0.3em] mb-6 flex items-center gap-4 font-Cairo text-start">
                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full shadow-[0_0_15px_rgba(16,185,129,0.5)]"></span>
                    {{ __('نصيحة هامة') }}
                </h5>
                <p class="text-[11px] font-bold text-slate-400 leading-loose font-Cairo text-start">
                    {{ __('يفضل تعطيل الباقة بدلاً من حذفها إذا كان هناك مستخدمون مشتركين فيها، وذلك للحفاظ على دقة التقارير والسجلات.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
