@extends('layouts.admin')

@section('title', __('إدارة الخدمات'))

@section('content')
<div class="space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-2xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-500 text-2xl font-Cairo shadow-lg shadow-indigo-500/5 whitespace-nowrap inline-flex items-center justify-center">🛠️</span>
                {{ __('إدارة الخدمات') }}
            </h3>
            <p class="text-[13px] font-black uppercase tracking-[0.2em] mt-2 mr-16 text-start font-Cairo opacity-60">
                {{ __('إدارة قائمة الخدمات المتاحة، أسعارها، وتوافرها في المنصة.') }}
            </p>
        </div>
        <a href="{{ route('services.create') }}" class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-brand-primary text-white rounded-[1.75rem] text-xs font-black shadow-[0_20px_40px_-5px_rgba(var(--brand-primary-rgb),0.3)] hover:scale-[1.05] transition-all font-Cairo">
            <div class="w-6 h-6 bg-[var(--glass-bg)]/20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            </div>
            {{ __('إضافة خدمة جديدة') }}
        </a>
    </div>

    <!-- Service Statistics (6 Items) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 font-Cairo text-start">
        <!-- Total Service Node -->
        <div class="card-premium glass-panel p-6 rounded-[2rem] shadow-xl border border-[var(--glass-border)] relative overflow-hidden group text-start">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-slate-500/5 rounded-full blur-2xl group-hover:bg-slate-500/10 transition-colors"></div>
            <span class="text-[14px] font-black uppercase tracking-[0.2em] block mb-3 font-Cairo opacity-60">{{ __('إجمالي الخدمات') }}</span>
            <div class="flex items-center justify-between relative z-10">
                <span class="text-3xl font-black leading-none font-mono">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</span>
                <div class="w-10 h-10 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-xl flex items-center justify-center shadow-inner group-hover:rotate-12 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
        </div>

        <!-- Available Service Node -->
        <div class="card-premium glass-panel p-6 rounded-[2rem] shadow-xl border border-[var(--glass-border)] relative overflow-hidden group text-start">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
            <span class="text-[14px] font-black text-emerald-500 uppercase tracking-[0.2em] block mb-3 font-Cairo">{{ __('المتاحة للحجز') }}</span>
            <div class="flex items-center justify-between relative z-10">
                <span class="text-3xl font-black leading-none font-mono">{{ str_pad($stats['available'], 2, '0', STR_PAD_LEFT) }}</span>
                <div class="w-10 h-10 bg-emerald-500/10 text-emerald-600 rounded-xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Unavailable Service Node -->
        <div class="card-premium glass-panel p-6 rounded-[2rem] shadow-xl border border-[var(--glass-border)] relative overflow-hidden group text-start">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-rose-500/5 rounded-full blur-2xl group-hover:bg-rose-500/10 transition-colors"></div>
            <span class="text-[14px] font-black text-rose-500 uppercase tracking-[0.2em] block mb-3 font-Cairo">{{ __('غير متاحــة') }}</span>
            <div class="flex items-center justify-between relative z-10">
                <span class="text-3xl font-black leading-none font-mono">{{ str_pad($stats['unavailable'], 2, '0', STR_PAD_LEFT) }}</span>
                <div class="w-10 h-10 bg-rose-500/10 text-rose-600 rounded-xl flex items-center justify-center shadow-inner group-hover:-rotate-12 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Active Service Node -->
        <div class="card-premium glass-panel p-6 rounded-[2rem] shadow-xl border border-[var(--glass-border)] relative overflow-hidden group text-start">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-indigo-500/5 rounded-full blur-2xl group-hover:bg-indigo-500/10 transition-colors"></div>
            <span class="text-[14px] font-black text-indigo-500 uppercase tracking-[0.2em] block mb-3 font-Cairo">{{ __('النشطة حالياً') }}</span>
            <div class="flex items-center justify-between relative z-10">
                <span class="text-3xl font-black leading-none font-mono">{{ str_pad($stats['active'], 2, '0', STR_PAD_LEFT) }}</span>
                <div class="w-10 h-10 bg-indigo-500/10 text-indigo-600 rounded-xl flex items-center justify-center shadow-inner group-hover:translate-y-[-2px] transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Meeting Service Node -->
        <div class="card-premium glass-panel p-6 rounded-[2rem] shadow-xl border border-[var(--glass-border)] relative overflow-hidden group text-start">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl group-hover:bg-amber-500/10 transition-colors"></div>
            <span class="text-[14px] font-black text-amber-500 uppercase tracking-[0.2em] block mb-3 font-Cairo">{{ __('خدمات اللقاء') }}</span>
            <div class="flex items-center justify-between relative z-10">
                <span class="text-3xl font-black leading-none font-mono">{{ str_pad($stats['meeting_service'], 2, '0', STR_PAD_LEFT) }}</span>
                <div class="w-10 h-10 bg-amber-500/10 text-amber-600 rounded-xl flex items-center justify-center shadow-inner group-hover:scale-125 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2-2v8a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Custom Service Node -->
        <div class="card-premium glass-panel p-6 rounded-[2rem] shadow-xl border border-[var(--glass-border)] relative overflow-hidden group text-start">
            <div class="absolute -top-10 -right-10 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl group-hover:bg-purple-500/10 transition-colors"></div>
            <span class="text-[14px] font-black text-purple-500 uppercase tracking-[0.2em] block mb-3 font-Cairo">{{ __('مهام مخصصة') }}</span>
            <div class="flex items-center justify-between relative z-10">
                <span class="text-3xl font-black leading-none font-mono">{{ str_pad($stats['custom_service'], 2, '0', STR_PAD_LEFT) }}</span>
                <div class="w-10 h-10 bg-purple-500/10 text-purple-600 rounded-xl flex items-center justify-center shadow-inner group-hover:rotate-45 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Service List -->
    <div class="card-premium glass-panel rounded-[3rem] overflow-hidden shadow-2xl relative border border-[var(--glass-border)] text-start font-Cairo">
        <div class="px-10 py-8 border-b border-[var(--glass-border)] flex justify-between items-center bg-[var(--main-bg)] text-start">
            <div class="flex items-center gap-4 text-start">
                <span class="w-2 h-10 bg-indigo-500 rounded-full shadow-lg shadow-indigo-500/20"></span>
                <h4 class="font-black text-xl font-Cairo text-start">{{ __('سجل الخدمات المتاحة') }}</h4>
            </div>
            <div class="flex items-center gap-3 text-start">
                <span class="px-4 py-2 bg-[var(--glass-border)] rounded-xl text-[13px] font-black uppercase tracking-widest border border-[var(--glass-border)] font-Cairo opacity-70 whitespace-nowrap inline-flex items-center justify-center">
                    {{ __('إجمالي السجلات') }}: {{ $services->count() }}
                </span>
            </div>
        </div>
        
        <div class="overflow-x-auto text-start">
            <table class="w-full text-sm text-start">
                <thead class="bg-[var(--main-bg)] font-black text-[12px] uppercase tracking-[0.2em] border-b border-[var(--glass-border)] text-start opacity-60">
                    <tr>
                        <th class="px-10 py-6 text-start">{{ __('اسم الخدمة') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('مزود الخدمة') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('التصنيف') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('السعر') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('حالة القبول') }}</th>
                        <th class="px-10 py-6 text-start">{{ __('حالة التنشيط') }}</th>
                        <th class="px-10 py-6 text-end">{{ __('التحكم') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--glass-border)] text-start font-Cairo">
                    @forelse ($services as $service)
                        <tr class="hover:bg-brand-primary/[0.03] transition-all group/row">
                            <td class="px-10 py-6 text-start">
                                <span class="font-black text-base group-hover/row:text-brand-primary transition-colors font-Cairo text-start italic">{{ $service->name }}</span>
                            </td>
                            <td class="px-10 py-6 text-start">
                                <div class="flex items-center gap-3 text-start font-Cairo">
                                    <div class="w-8 h-8 rounded-lg bg-[var(--glass-border)] flex items-center justify-center text-xs font-black font-Cairo opacity-60">
                                        {{ mb_substr($service->provider->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="text-xs font-black font-Cairo text-start italic opacity-70">{{ $service->provider->name ?? __('غير محدد') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-start">
                                <span class="px-3 py-1.5 bg-[var(--main-bg)] border border-[var(--glass-border)] rounded-xl text-[12px] font-black font-Cairo opacity-60 whitespace-nowrap inline-flex items-center justify-center">
                                    {{ $service->category->name ?? __('بدون قسم') }}
                                </span>
                            </td>
                            <td class="px-10 py-6 text-start">
                                <div class="flex items-center gap-1.5 text-start font-Cairo italic">
                                    <span class="text-base font-black text-brand-primary font-mono text-start">{{ number_format($service->price, 2) }}</span>
                                    <span class="text-[12px] font-black uppercase font-Cairo text-start opacity-40">YER</span>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-start">
                                <div class="text-start">
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[12px] font-black {{ $service->is_available ? 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-600 border border-rose-500/20' }} font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $service->is_available ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                        {{ $service->is_available ? __('متاحة') : __('غير متاحة') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-start">
                                <div class="text-start font-Cairo">
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[12px] font-black {{ $service->is_active ? 'bg-indigo-500/10 text-indigo-600 border border-indigo-500/20' : 'bg-[var(--glass-bg)] text-[var(--text-muted)] border border-[var(--glass-border)] opacity-60' }} font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                                        {{ $service->is_active ? __('نشطة') : __('موقوفة') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-end">
                                <div class="flex items-center justify-end gap-3 text-start">
                                    <a href="{{ route('services.show', $service->id) }}" class="btn-action btn-action-view" title="{{ __('عرض التفاصيل') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('services.edit', $service->id) }}" class="btn-action bg-brand-primary/10 text-brand-primary" title="{{ __('تعديل') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-10 py-32 text-center text-start">
                                <div class="flex flex-col items-center justify-center opacity-40 text-start">
                                    <div class="w-20 h-20 bg-[var(--glass-border)] rounded-[2rem] flex items-center justify-center text-4xl mb-6 shadow-inner">🚫</div>
                                    <h5 class="text-xl font-black font-Cairo">{{ __('لا توجد خدمات متاحة حالياً') }}</h5>
                                    <p class="text-[13px] font-black mt-4 max-w-xs leading-relaxed uppercase tracking-[0.2em] font-Cairo opacity-60">
                                        {{ __('لا توجد خدمات مضافة حالياً. يمكنك إضافة خدمات جديدة من زر الإضافة أعلاه.') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($services->hasPages())
            <div class="px-10 py-8 bg-[var(--main-bg)] border-t border-[var(--glass-border)] text-start font-Cairo">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
