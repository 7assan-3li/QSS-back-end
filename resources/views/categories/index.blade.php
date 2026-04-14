@extends('layouts.admin')

@section('title', __('إدارة التصنيفات'))

@section('content')
<div class="space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-2xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-14 h-14 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-2xl font-Cairo shadow-lg shadow-brand-primary/5 whitespace-nowrap inline-flex items-center justify-center">📂</span>
                {{ __('إدارة أقسام الخدمات') }}
            </h3>
            <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-2 mr-16 text-start font-Cairo">
                {{ __('إدارة وتنظيم أقسام الخدمات في المنصة لضمان سهولة الوصول إليها.') }}
            </p>
        </div>
        <a href="{{ route('categories.create') }}" class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-brand-primary text-white rounded-[1.75rem] text-xs font-black shadow-[0_20px_40px_-5px_rgba(var(--brand-primary-rgb),0.3)] hover:scale-[1.05] transition-all font-Cairo">
            <div class="w-6 h-6 bg-[var(--glass-bg)]/20 rounded-lg flex items-center justify-center group-hover:rotate-90 transition-transform">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            </div>
            {{ __('إضافة قسم جديد') }}
        </a>
    </div>

    <!-- Category Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-start">
        <!-- Total Terminal -->
        <div class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group border border-[var(--glass-border)] text-start">
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-brand-primary/10 rounded-full blur-[80px] group-hover:bg-brand-primary/20 transition-all duration-700"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-brand-primary text-white rounded-2xl flex items-center justify-center shadow-2xl shadow-brand-primary/30 group-hover:rotate-12 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black leading-none font-mono">{{ str_pad($categories->count(), 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-2 font-Cairo">{{ __('عدد الأقسام') }}</span>
                </div>
            </div>
        </div>

        <!-- Main Categories Terminal -->
        <div class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group border border-[var(--glass-border)] text-start">
            <div class="absolute -top-20 -right-20 w-48 h-48 bg-brand-secondary/10 rounded-full blur-[80px] group-hover:bg-brand-secondary/20 transition-all duration-700"></div>
            <div class="flex items-center gap-6 relative z-10 text-start">
                <div class="w-16 h-16 bg-brand-secondary text-white rounded-2xl flex items-center justify-center shadow-2xl shadow-brand-secondary/30 group-hover:-rotate-12 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                </div>
                <div class="flex flex-col text-start">
                    <span class="text-3xl font-black leading-none font-mono">{{ str_pad($categories->whereNull('category_id')->count(), 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-2 font-Cairo">{{ __('الأقسام الرئيسية') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories List -->
    @if ($categories->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 text-start font-Cairo">
            @foreach ($categories->whereNull('category_id') as $category)
                <div class="card-premium glass-panel rounded-[3rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] relative group overflow-hidden border border-[var(--glass-border)] transform transition-all duration-700 hover:-translate-y-4 hover:shadow-2xl text-start">
                    <!-- High-Impact Image/Visual Header -->
                    <div class="h-60 relative overflow-hidden text-start">
                        @if ($category->image_path)
                            <img src="{{ asset('storage/' . $category->image_path) }}" class="w-full h-full object-cover group-hover:scale-125 transition-transform duration-1000 ease-in-out">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 flex items-center justify-center text-7xl opacity-40 group-hover:scale-125 transition-transform duration-700">
                                🏢
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                        
                        <div class="absolute bottom-8 right-8 left-8 text-start">
                            <div class="flex flex-col gap-1 text-start">
                                <span class="text-[12px] font-black text-brand-primary uppercase tracking-[0.3em] font-Cairo mb-1 drop-shadow-lg">{{ __('تصنيف رئيسي') }}</span>
                                <h3 class="text-2xl font-black text-white leading-tight font-Cairo drop-shadow-2xl">{{ $category->name }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Interaction Content -->
                    <div class="p-10 space-y-8 text-start">
                        <div class="min-h-[60px] text-start">
                            <p class="text-xs font-black leading-relaxed font-Cairo line-clamp-3 italic text-start">"{{ $category->description ?? __('لا يوجد وصف متاح لهذا القسم.') }}"
                            </p>
                        </div>

                        <div class="flex items-center gap-3 pt-6 border-t border-[var(--glass-border)] text-start">
                            <a href="{{ route('categories.show', $category->id) }}" class="btn-action-primary flex-1">
                                <span>{{ __('عرض التفاصيل') }}</span>
                                <svg class="w-4 h-4 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn-action btn-action-view" title="{{ __('تعديل') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Decorative Nodes -->
                    <div class="absolute top-6 left-6 opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="w-3 h-3 bg-brand-primary rounded-full animate-ping"></span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card-premium glass-panel p-24 rounded-[4rem] text-center font-Cairo shadow-2xl relative overflow-hidden border border-dashed border-[var(--glass-border)]">
            <div class="absolute inset-0 bg-blue-500/5 pointer-events-none"></div>
            <div class="relative z-10 text-center">
                <div class="w-24 h-24 bg-[var(--glass-border)] rounded-[2rem] flex items-center justify-center text-5xl mx-auto mb-8 shadow-inner animate-bounce">📦</div>
                <h4 class="text-2xl font-black font-Cairo">{{ __('لا توجد أقسام') }}</h4>
                <p class="text-xs font-black text-[var(--text-muted)] mt-4 max-w-sm mx-auto leading-relaxed">
                    {{ __('لا توجد أقسام خدمات حالياً. يمكنك إضافة قسم جديد من الزر أعلاه.') }}
                </p>
                <a href="{{ route('categories.create') }}" class="mt-10 inline-flex items-center gap-3 px-10 py-5 bg-brand-primary text-white rounded-[1.75rem] text-xs font-black shadow-2xl shadow-brand-primary/30 hover:scale-[1.05] transition-all">
                    {{ __('إضافة القسم الأول') }}
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
