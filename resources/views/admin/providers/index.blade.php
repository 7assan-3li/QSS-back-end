@extends('layouts.admin')

@section('title', __('إدارة مزودي الخدمات'))

@section('content')
<div class="max-w-7xl mx-auto space-y-10 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5">🛠️</span>
                {{ __('مزودي الخدمات') }}
            </h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('إدارة وتقييم شركاء النجاح، متابعة أدائهم وخدماتهم ونشاطهم المالي.') }}
            </p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('admin.providers.index') }}" method="GET" class="relative group w-full lg:w-96 text-start">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('ابحث عن مزود (الاسم أو البريد)...') }}" 
                   class="w-full bg-white dark:bg-white/5 border border-slate-100 dark:border-white/5 rounded-2xl px-14 py-4 text-xs font-black focus:ring-4 focus:ring-brand-primary/10 transition-all outline-none shadow-xl shadow-slate-200/20 dark:shadow-none placeholder:text-slate-400">
            <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-brand-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </form>
    </div>

    <!-- Providers Grid / Table -->
    <div class="card-premium glass-panel rounded-[3.5rem] shadow-2xl overflow-hidden font-Cairo text-start min-h-[500px]">
        <div class="p-10 border-b border-slate-100 dark:border-white/5 flex justify-between items-center text-start">
            <div class="text-start">
                <h4 class="text-lg font-black font-Cairo text-start italic">{{ __('قائمة الشركاء المعتمدين') }}</h4>
                <p class="text-[9px] font-black text-slate-400 mt-1 uppercase tracking-widest">{{ __('إجمالي المسجلين حالياً: ') }} {{ $providers->total() }}</p>
            </div>
        </div>

        <div class="overflow-x-auto h-full">
            <table class="w-full text-start">
                <thead>
                    <tr class="bg-slate-50/40 dark:bg-slate-900/40">
                        <th class="table-header-cell px-10 py-6">{{ __('المزود') }}</th>
                        <th class="table-header-cell px-10 py-6">{{ __('الخدمات المتاحة') }}</th>
                        <th class="table-header-cell px-10 py-6">{{ __('حالة التوثيق') }}</th>
                        <th class="table-header-cell px-10 py-6">{{ __('تاريخ الانضمام') }}</th>
                        <th class="table-header-cell px-10 py-6 text-center">{{ __('الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/3 transition-all h-full">
                    @forelse($providers as $provider)
                    <tr class="hover:bg-brand-primary/[0.02] transition-all group h-full">
                        <td class="px-10 py-6 text-start">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-[14px] font-black text-brand-primary shadow-sm uppercase">{{ mb_substr($provider->name, 0, 1) }}</div>
                                <div class="flex flex-col text-start">
                                    <span class="text-[12px] font-black group-hover:text-brand-primary transition-colors">{{ $provider->name }}</span>
                                    <span class="text-[10px] font-black text-slate-400 opacity-80">{{ $provider->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-[11px] font-black text-slate-500">
                             <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-brand-primary/10 text-brand-primary rounded-lg">{{ $provider->services->count() }} {{ __('خدمة') }}</span>
                             </div>
                        </td>
                        <td class="px-10 py-6 text-start">
                            @if($provider->provider_verified_until && \Carbon\Carbon::parse($provider->provider_verified_until)->isFuture())
                                <span class="px-4 py-2 bg-emerald-500/10 text-emerald-600 text-[9px] font-black rounded-xl border border-emerald-500/20 flex items-center gap-2 w-fit">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    {{ __('موثق') }}
                                </span>
                            @else
                                <span class="px-4 py-2 bg-slate-100 dark:bg-white/5 text-slate-400 text-[9px] font-black rounded-xl flex items-center gap-2 w-fit">
                                    {{ __('غير موثق') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-10 py-6 text-[10px] font-black text-slate-500 font-Cairo tracking-wide opacity-70">
                            {{ $provider->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-10 py-6 text-center">
                            <a href="{{ route('admin.providers.show', $provider->id) }}" class="inline-flex items-center justify-center w-10 h-10 bg-brand-primary/10 text-brand-primary hover:bg-brand-primary hover:text-white rounded-xl transition-all shadow-lg shadow-brand-primary/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-32 text-center text-slate-400 font-black italic">
                            <div class="flex flex-col items-center gap-4">
                                <span class="text-6xl opacity-20">🔍</span>
                                {{ __('لا يوجد مزودين يطابقون بحثك حالياً.') }}
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-10 border-t border-slate-100 dark:border-white/5">
            {{ $providers->links() }}
        </div>
    </div>
</div>
@endsection
