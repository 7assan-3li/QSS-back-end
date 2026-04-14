@extends('layouts.admin')

@section('title', __('إدارة الإعلانات الترويجية'))

@section('content')
<div class="h-full flex flex-col gap-8 font-Cairo py-6 animate-in fade-in duration-700">
    
    <!-- Top Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 px-2">
        <div class="space-y-2">
            <h1 class="text-4xl font-black tracking-tighter italic text-[var(--main-text)] uppercase leading-tight">
                {{ __('مركز الترويج') }} <span class="text-brand-primary italic">{{ __('الذكي') }}</span>
            </h1>
            <p class="text-[var(--text-muted)] font-bold text-sm flex items-center gap-2 italic">
                <span class="w-8 h-[2px] bg-brand-primary inline-block"></span>
                {{ __('إدارة البنرات الإعلانية والحملات الترويجية داخل التطبيق') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="exportTableToCSV('ads-table', 'advertisements-report.csv')" class="group px-6 py-4 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 text-[var(--main-text)] text-[var(--main-text)] rounded-2xl font-black text-sm transition-all duration-500 hover:bg-[var(--glass-bg)] border border-[var(--glass-border)] flex items-center gap-2">
                <svg class="w-5 h-5 opacity-40 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>{{ __('تصدير التقرير') }}</span>
            </button>

            <a href="{{ route('advertisements.create') }}" class="group relative px-8 py-4 bg-brand-primary text-white rounded-2xl font-black text-sm transition-all duration-500 hover:scale-105 shadow-xl shadow-brand-primary/20 overflow-hidden">
                <div class="absolute inset-0 bg-[var(--glass-bg)]/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                <div class="relative flex items-center gap-2">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>{{ __('إضافة حملة جديدة') }}</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Analytics Dashboard Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-2">
        <!-- Total Ads -->
        <div class="card-premium p-6 flex items-center gap-6 group hover:border-indigo-500/50 transition-all duration-500">
            <div class="w-16 h-16 rounded-[1.5rem] bg-indigo-500/10 text-indigo-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div>
                <span class="block text-[13px] font-black uppercase tracking-[0.2em] opacity-40 mb-1">{{ __('إجمالي الحملات') }}</span>
                <span class="text-3xl font-black text-[var(--main-text)] tabular-nums">{{ $stats['total'] }}</span>
            </div>
        </div>

        <!-- Active Ads -->
        <div class="card-premium p-6 flex items-center gap-6 group hover:border-emerald-500/50 transition-all duration-500">
            <div class="w-16 h-16 rounded-[1.5rem] bg-emerald-500/10 text-emerald-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <span class="block text-[13px] font-black uppercase tracking-[0.2em] opacity-40 mb-1">{{ __('نشط حالياً') }}</span>
                <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $stats['active'] }}</span>
            </div>
        </div>

        <!-- Impressions -->
        <div class="card-premium p-6 flex items-center gap-6 group hover:border-amber-500/50 transition-all duration-500">
            <div class="w-16 h-16 rounded-[1.5rem] bg-amber-500/10 text-amber-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            <div>
                <span class="block text-[13px] font-black uppercase tracking-[0.2em] opacity-40 mb-1">{{ __('إجمالي الظهور') }}</span>
                <span class="text-3xl font-black text-[var(--main-text)] tabular-nums">{{ number_format($stats['views']) }}</span>
            </div>
        </div>

        <!-- Engagement -->
        <div class="card-premium p-6 flex items-center gap-6 group hover:border-brand-primary/50 transition-all duration-500">
            <div class="w-16 h-16 rounded-[1.5rem] bg-brand-primary/10 text-brand-primary flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                </svg>
            </div>
            <div>
                <span class="block text-[13px] font-black uppercase tracking-[0.2em] opacity-40 mb-1">{{ __('إجمالي التفاعل') }}</span>
                <span class="text-3xl font-black text-brand-primary tabular-nums">{{ number_format($stats['clicks']) }}</span>
            </div>
        </div>
    </div>

    @if($advertisements->isEmpty())
        <!-- Empty State -->
        <div class="flex-1 flex flex-col items-center justify-center py-20 px-4">
            <div class="w-40 h-40 bg-brand-primary/5 rounded-[3rem] flex items-center justify-center mb-8 relative">
                <div class="absolute inset-0 bg-brand-primary/10 rounded-[3rem] animate-ping opacity-20"></div>
                <svg class="w-20 h-20 text-brand-primary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-[var(--main-text)] mb-2 italic">{{ __('لا توجد إعلانات حالياً') }}</h3>
            <p class="text-[var(--text-muted)] font-bold max-w-md text-center italic">{{ __('ابدأ بإضافة أول بنر إعلاني ليظهر لمستخدمي تطبيق الجوال فوراً') }}</p>
        </div>
    @else
        <!-- Ads Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-2">
            @foreach($advertisements as $ad)
                <div class="group relative card-premium overflow-hidden">
                    
                    <!-- Ad Preview Image -->
                    <div class="aspect-[16/9] relative overflow-hidden">
                        <img src="{{ asset('storage/' . $ad->image_path) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" 
                             alt="{{ $ad->title }}">
                        
                        <!-- Badges/Tags -->
                        <div class="absolute top-6 left-6 flex flex-col gap-2">
                            <span class="badge-soft shadow-xl !bg-[var(--glass-bg)]/90 dark:!bg-slate-900/90 backdrop-blur-md">
                                {{ __($ad->type) }}
                            </span>
                            <span class="badge-soft shadow-xl !bg-brand-primary !text-white !border-none">
                                {{ __($ad->user_type) }}
                            </span>
                        </div>

                        <!-- Status Toggle Overlay (Admin Quick Control) -->
                        <div class="absolute inset-0 bg-brand-primary/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center backdrop-blur-sm">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('advertisements.edit', $ad->id) }}" class="w-12 h-12 bg-[var(--glass-bg)] text-brand-primary rounded-2xl flex items-center justify-center hover:scale-110 transition-transform shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </a>
                                <button onclick="confirmAction('delete-form-{{ $ad->id }}', { isDanger: true })" class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center hover:scale-110 transition-transform shadow-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                <form id="delete-form-{{ $ad->id }}" action="{{ route('advertisements.destroy', $ad->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Ad Details -->
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-black text-[var(--main-text)] line-clamp-1 italic tracking-tight uppercase">
                                {{ $ad->title ?? __('بدون عنوان') }}
                            </h3>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $ad->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                                <span class="text-[12px] font-black uppercase tracking-widest opacity-60">
                                    {{ $ad->is_active ? __('نشط') : __('متوقف') }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <!-- Targeting Info -->
                            <div class="flex flex-col gap-1.5 p-4 rounded-3xl bg-[var(--glass-bg)]/50 dark:bg-[var(--glass-bg)]/5 border border-[var(--glass-border)] shadow-sm transition-colors duration-500">
                                <div class="flex items-center gap-2 text-[14px] font-black uppercase tracking-widest opacity-40 italic text-[var(--text-muted)]">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    {{ __('نوع التوجيه') }}
                                </div>
                                <div class="flex flex-col min-h-[30px] justify-center">
                                    <span class="text-[14px] font-black text-brand-primary italic uppercase leading-none">{{ __($ad->target_type) }}</span>
                                    @if($ad->target_type == 'service' || $ad->target_type == 'category')
                                        <span class="text-[12px] font-bold text-[var(--text-muted)] line-clamp-1 mt-1">{{ $ad->target?->name ?? 'N/A' }}</span>
                                    @elseif($ad->target_type == 'external')
                                        <span class="text-[12px] font-bold text-[var(--text-muted)] line-clamp-1 mt-1">{{ $ad->external_link }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Sort/Priority Info -->
                            <div class="flex flex-col gap-1.5 p-4 rounded-3xl bg-[var(--glass-bg)]/50 dark:bg-[var(--glass-bg)]/5 border border-[var(--glass-border)] shadow-sm transition-colors duration-500">
                                <div class="flex items-center gap-2 text-[14px] font-black uppercase tracking-widest opacity-40 italic text-[var(--text-muted)]">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    {{ __('ترتيب الظهور') }}
                                </div>
                                <div class="flex items-center min-h-[30px]">
                                    <span class="text-[16px] font-black text-[var(--main-text)] italic">#{{ $ad->sort_order }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline & Individual Metrics -->
                        <div class="space-y-4 bg-[var(--glass-bg)]/30 dark:bg-[var(--glass-bg)]/5 p-4 rounded-3xl border border-transparent border-[var(--glass-border)]">
                            <!-- Campaign Schedule -->
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[14px] font-black uppercase tracking-wider opacity-40 italic text-[var(--text-muted)] mb-0.5">{{ __('الفترة الزمنية') }}</span>
                                    <span class="text-[13px] font-black text-[var(--text-secondary)] tracking-tighter">
                                        {{ $ad->starts_at->format('Y/m/d') }} <span class="mx-1 opacity-30">→</span> {{ $ad->ends_at ? $ad->ends_at->format('Y/m/d') : __('بلا نهاية') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Individual Performance -->
                            <div class="flex items-center justify-between pt-4 border-t border-[var(--glass-border)]">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <span class="text-xs font-black tabular-nums">{{ number_format($ad->views_count) }}</span>
                                    <span class="text-[14px] font-bold opacity-40 uppercase">{{ __('مشاهدة') }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-brand-primary">
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                                    <span class="text-xs font-black tabular-nums">{{ number_format($ad->clicks_count) }}</span>
                                    <span class="text-[14px] font-bold opacity-60 uppercase">{{ __('نقرة') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <!-- Pagination -->
        <div class="mt-12 px-2">
            {{ $advertisements->links('pagination::tailwind') }}
        </div>
    @endif
</div>

    <!-- Hidden Table for Export -->
    <table id="ads-table" class="hidden">
        <thead>
            <tr>
                <th>{{ __('العنوان') }}</th>
                <th>{{ __('النوع') }}</th>
                <th>{{ __('المستهدف') }}</th>
                <th>{{ __('الترتيب') }}</th>
                <th>{{ __('المشاهدات') }}</th>
                <th>{{ __('النقرات') }}</th>
                <th>{{ __('الحالة') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($advertisements as $ad)
                <tr>
                    <td>{{ $ad->title }}</td>
                    <td>{{ $ad->type }}</td>
                    <td>{{ $ad->target_type }}</td>
                    <td>{{ $ad->sort_order }}</td>
                    <td>{{ $ad->views_count }}</td>
                    <td>{{ $ad->clicks_count }}</td>
                    <td>{{ $ad->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
