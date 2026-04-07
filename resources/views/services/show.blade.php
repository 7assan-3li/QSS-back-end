@extends('layouts.admin')

@section('title', __('تفاصيل الخدمة'))

@section('content')
<div class="max-w-6xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5">🔍</span>
                {{ __('تفاصيل الخدمة') }}
            </h3>
            <div class="flex items-center gap-3 text-[10px] font-black mt-3 mr-20 uppercase tracking-[0.2em] font-Cairo text-start opacity-60">
                <span>{{ __('سجل الأصول') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('مراجعة الجودة') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary opacity-100">{{ __('هوية الخدمة') }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('services.index') }}" class="px-8 py-4 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-2xl text-[10px] font-black hover:bg-slate-200 transition-all font-Cairo shadow-sm">
                {{ __('العودة للقائمة') }}
            </a>
            <a href="{{ route('services.edit', $service->id) }}" class="px-8 py-4 bg-brand-primary text-white rounded-2xl text-[10px] font-black shadow-[0_20px_40px_-5px_rgba(var(--brand-primary-rgb),0.3)] hover:scale-[1.05] active:scale-95 transition-all font-Cairo">
                {{ __('تعديل الخدمة') }}
            </a>
        </div>
    </div>

    <!-- Service Details -->
    <div class="card-premium glass-panel rounded-[4.5rem] shadow-[0_60px_120px_-30px_rgba(0,0,0,0.15)] relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
        <div class="p-12 md:p-16 space-y-14 text-start">
            <!-- Split Header: Details & Financials -->
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-10 pb-12 border-b border-slate-100 dark:border-slate-800/50 text-start">
                <div class="space-y-4 text-start">
                    <span class="px-4 py-2 bg-indigo-500/10 text-indigo-500 rounded-xl text-[9px] font-black uppercase tracking-[0.3em] font-Cairo inline-block text-start opacity-80">
                        {{ $service->category->name ?? __('خدمة غير مصنفة') }}
                    </span>
                    <h2 class="text-4xl font-black leading-[1.2] font-Cairo text-start italic">{{ $service->name }}</h2>
                </div>
                
                <div class="flex flex-wrap gap-6 text-start">
                    <div class="px-8 py-5 bg-brand-primary/[0.03] rounded-[2.5rem] border border-brand-primary/10 text-center relative group overflow-hidden">
                        <div class="absolute inset-0 bg-brand-primary/[0.02] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                        <span class="block text-[8px] font-black text-brand-primary uppercase tracking-[0.3em] mb-2 font-Cairo relative z-10 opacity-60">{{ __('السعر الحالي') }}</span>
                        <div class="flex items-center justify-center gap-2 relative z-10 font-mono">
                            <span class="text-3xl font-black leading-none text-start italic">{{ number_format($service->price, 2) }}</span>
                            <span class="text-xs font-black font-Cairo text-start opacity-40">USD</span>
                        </div>
                    </div>
                    
                    <div class="px-8 py-5 bg-amber-500/[0.03] rounded-[2.5rem] border border-amber-500/10 text-center relative group overflow-hidden">
                        <div class="absolute inset-0 bg-amber-500/[0.02] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                        <span class="block text-[8px] font-black text-amber-600 uppercase tracking-[0.3em] mb-2 font-Cairo relative z-10 opacity-70">{{ __('تقييم الخدمة') }}</span>
                        <div class="flex items-center justify-center gap-3 relative z-10 font-mono">
                            <span class="text-3xl font-black leading-none text-start italic">{{ number_format($service->average_rating, 1) }}</span>
                            <div class="flex items-center gap-1">
                                <svg class="w-5 h-5 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-start">
                <div class="space-y-3 text-start">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] px-1 font-Cairo text-start opacity-60">{{ __('مزود الخدمة') }}</span>
                    <div class="flex items-center gap-3 text-start">
                        <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-black font-Cairo opacity-70">
                             {{ mb_substr($service->provider->name ?? '?', 0, 1) }}
                        </div>
                        <p class="text-[13px] font-black font-Cairo text-start italic">{{ $service->provider->name ?? __('غير محدد') }}</p>
                    </div>
                </div>

                <div class="space-y-3 text-start">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] px-1 font-Cairo text-start opacity-60">{{ __('الحالة الإدارية') }}</span>
                    <div class="text-start">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-indigo-500/10 text-indigo-600 text-[10px] font-black uppercase tracking-widest border border-indigo-500/20 font-Cairo text-start">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                </div>

                <div class="space-y-3 text-start">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] px-1 font-Cairo text-start opacity-60">{{ __('حالة التوافر') }}</span>
                    <div class="text-start">
                        <span class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-[10px] font-black font-Cairo text-start">
                            <span class="w-2 h-2 rounded-full {{ $service->is_available ? 'bg-emerald-500 animate-pulse outline outline-4 outline-emerald-500/20' : 'bg-rose-500 shadow-lg shadow-rose-500/40' }}"></span>
                            <span class="{{ $service->is_available ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $service->is_available ? __('متاح حالياً') : __('غير متاح حالياً') }}
                            </span>
                        </span>
                    </div>
                </div>

                <div class="space-y-3 text-start">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] px-1 font-Cairo text-start opacity-60">{{ __('حالة التنشيط') }}</span>
                    <div class="text-start">
                        <p class="text-[13px] font-black flex items-center gap-2 font-Cairo text-start italic {{ $service->is_active ? 'text-indigo-600' : 'opacity-60' }}">
                            {{ $service->is_active ? __('✅ نشطة') : __('🚫 موقوفة') }}
                        </p>
                    </div>
                </div>

                <div class="space-y-3 text-start">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] px-1 font-Cairo text-start opacity-60">{{ __('الخدمة الرئيسية') }}</span>
                    <p class="text-[13px] font-black font-Cairo text-start italic">{{ $service->parent->name ?? __('خدمة رئيسية') }}</p>
                </div>

                <div class="space-y-3 text-start">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] px-1 font-Cairo text-start opacity-60">{{ __('التسعير حسب المسافة') }}</span>
                    <p class="text-[13px] font-black font-Cairo text-start italic">{{ $service->distance_based_price ? __('مفعل: حسب المسافة الفاصلة') : __('ثابت: لا يتأثر بالموقع') }}</p>
                </div>

                @if ($service->distance_based_price)
                    <div class="space-y-3 p-4 bg-brand-primary/[0.03] rounded-2xl border border-brand-primary/10 text-start">
                        <span class="text-[8px] font-black text-brand-primary uppercase tracking-[0.3em] px-1 font-Cairo text-start opacity-60">{{ __('معامل السعر / كم') }}</span>
                        <div class="flex items-baseline gap-1 font-mono text-start italic">
                             <span class="text-xl font-black text-start italic">{{ number_format($service->price_per_km, 2) }}</span>
                             <span class="text-[10px] font-black font-Cairo text-start opacity-40">USD</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Service Description -->
    <div class="card-premium glass-panel p-12 md:p-16 rounded-[4.5rem] shadow-2xl relative border border-white dark:border-slate-800/50 text-start">
        <div class="flex items-center gap-4 mb-10 text-start">
            <span class="w-2.5 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/40"></span>
            <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('وصف الخدمة والمهام') }}</h4>
        </div>
        <div class="relative text-start">
            <div class="absolute right-0 top-0 bottom-0 w-2 bg-slate-100 dark:bg-slate-800 rounded-full opacity-50"></div>
            <p class="text-lg font-black leading-[2] pr-10 font-Cairo italic text-start opacity-60">
                " {{ $service->description ?? __('لا يوجد وصف متاح لهذه الخدمة حالياً.') }} "
            </p>
        </div>
    </div>

    <!-- Sub-services List -->
    @if ($service->children->isNotEmpty())
        <div class="space-y-10 text-start">
            <div class="flex items-center gap-4 px-6 text-start">
                <span class="w-3 h-10 bg-indigo-500 rounded-full shadow-lg shadow-indigo-500/30"></span>
                <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('الخدمات الفرعية التابعة') }}</h4>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 text-start">
                @foreach ($service->children as $child)
                    <div class="card-premium glass-panel p-10 rounded-[3rem] shadow-xl hover:-translate-y-2 transition-all duration-500 group border border-white dark:border-slate-800/50 text-start">
                        <div class="flex flex-col gap-6 text-start">
                            <div class="flex justify-between items-start gap-4 text-start">
                                <h5 class="text-lg font-black group-hover:text-brand-primary transition-colors leading-[1.4] font-Cairo text-start italic">{{ $child->name }}</h5>
                                <div class="flex flex-col items-end text-start">
                                    <span class="text-xl font-black text-brand-primary font-mono text-start italic">{{ number_format($child->price, 2) }}</span>
                                    <span class="text-[8px] font-black uppercase font-Cairo text-start opacity-40">USD</span>
                                </div>
                            </div>
                            <div class="pt-6 border-t border-slate-50 dark:border-slate-800/50 flex items-center justify-between text-start">
                                <a href="{{ route('services.show', $child->id) }}" class="text-[9px] font-black hover:text-brand-primary uppercase tracking-[0.3em] flex items-center gap-3 transition-colors font-Cairo text-start font-Cairo opacity-40 hover:opacity-100">
                                    {{ __('عرض التفاصيل') }}
                                    <svg class="w-4 h-4 rtl:rotate-0 ltr:rotate-180 group-hover:translate-x-[-4px] transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                                <span class="w-2 h-2 rounded-full {{ $child->is_active ? 'bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.5)]' : 'bg-slate-300' }}"></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
