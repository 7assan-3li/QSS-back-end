@extends('layouts.admin')

@section('title', __('تفاصيل التصنيف'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-4 mb-3 text-start">
                <a href="{{ route('categories.index') }}" class="w-10 h-10 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm">
                    <svg class="w-5 h-5 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-2xl text-[var(--main-text)] flex items-center gap-3 text-start font-Cairo">
                    <span class="w-10 h-10 bg-brand-primary/10 rounded-xl flex items-center justify-center text-brand-primary text-xl font-Cairo whitespace-nowrap inline-flex items-center justify-center">🔍</span>
                    {{ __('تفاصيل القسم') }}: {{ $category->name }}
                </h3>
            </div>
            <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mr-14 text-start font-Cairo">
                {{ __('مراجعة البيانات الأساسية والأقسام الفرعية لهذا التصنيف.') }}
            </p>
        </div>
        <div class="flex items-center gap-4 text-start font-Cairo">
            <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-brand-primary/10 text-brand-primary border border-brand-primary/20 rounded-[1.5rem] text-xs font-black hover:bg-brand-primary hover:text-white transition-all font-Cairo shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                {{ __('تعديل البيانات') }}
            </a>
            
            <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline text-start">
                @csrf
                @method('DELETE')
                <button type="button" 
                    onclick="confirmAction('delete-category-{{ $category->id }}', {
                        title: '{{ __('حذف هذا القسم نهائياً') }}',
                        text: '{{ __('تحذير: أنت على وشك حذف هذا القسم وكافة البيانات والارتباطات التابعة له. هذا الإجراء لا يمكن التراجع عنه.') }}',
                        icon: 'warning',
                        isDanger: true,
                        confirmButtonText: '{{ __('تأكيد المسح النهائي') }}'
                    })" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-rose-500 text-white rounded-[1.5rem] text-xs font-black shadow-[0_20px_40px_-5px_rgba(244,63,94,0.3)] hover:scale-[1.05] transition-all font-Cairo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    {{ __('حذف القسم') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Main Architecture Terminal -->
    <div class="card-premium glass-panel rounded-[4rem] overflow-hidden shadow-2xl relative border border-[var(--glass-border)] font-Cairo text-start">
        <div class="flex flex-col lg:flex-row text-start">
            <!-- High-Impact Visual Showcase -->
            <div class="lg:w-[40%] h-96 lg:h-auto relative overflow-hidden bg-[var(--main-bg)] text-start">
                @if ($category->image_path)
                    <img src="{{ asset('storage/' . $category->image_path) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-200 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-950">
                        <span class="text-8xl mb-6">📁</span>
                        <span class="text-[12px] font-black uppercase tracking-[0.3em] opacity-40">{{ __('لا توجد صورة') }}</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-slate-900/60 to-transparent"></div>
                
                <div class="absolute bottom-10 right-10 text-start">
                    <span class="px-5 py-2 bg-[var(--glass-bg)]/10 backdrop-blur-xl border border-white/20 rounded-full text-[13px] font-black text-white uppercase tracking-widest font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                        {{ __('اسم القسم المسجل') }}
                    </span>
                </div>
            </div>

            <!-- Metadata Exploration Matrix -->
            <div class="flex-1 p-14 space-y-12 text-start">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-12 text-start">
                    <div class="space-y-2 text-start">
                        <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo text-start">{{ __('المعرف الرسمي') }}</span>
                        <p class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start">{{ $category->name }}</p>
                    </div>
                    <div class="space-y-2 text-start">
                        <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo text-start">{{ __('نوع القسم') }}</span>
                        <div class="text-start">
                            <span class="px-4 py-2 rounded-xl text-[13px] font-black {{ $category->parent_id ? 'bg-indigo-500/10 text-indigo-600 border border-indigo-500/20' : 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20' }} font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                                {{ $category->parent?->name ?? __('قسم رئيسي') }}
                            </span>
                        </div>
                    </div>
                    <div class="space-y-2 text-start">
                        <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo text-start">{{ __('تاريخ التأسيس') }}</span>
                        <p class="text-sm font-black text-[var(--main-text)] font-mono text-start">{{ $category->created_at->format('Y-m-d') }}</p>
                    </div>
                    <div class="space-y-2 text-start">
                        <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo text-start">{{ __('الأقسام الفرعية') }}</span>
                        <p class="text-sm font-black text-[var(--main-text)] font-Cairo text-start">{{ $category->children->count() }} {{ __('تفرعات مسجلة') }}</p>
                    </div>
                </div>

                <div class="pt-10 border-t border-[var(--glass-border)] text-start">
                    <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-4 block font-Cairo text-start">{{ __('وصف القسم') }}</span>
                    <div class="bg-[var(--main-bg)] p-8 rounded-[2rem] border border-[var(--glass-border)] text-start">
                        <p class="text-sm font-black text-[var(--text-secondary)] leading-[2] italic font-Cairo text-start">" {{ $category->description ?? __('لا يوجد وصف مضاف حالياً.') }}"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hierarchy Sub-Architecture -->
    @if ($category->children->count())
        <div class="space-y-8 text-start">
            <div class="flex items-center gap-4 px-6 text-start">
                <span class="w-2.5 h-8 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/40"></span>
                <h4 class="text-xl font-black text-[var(--main-text)] font-Cairo text-start">{{ __('الأقسام الفرعية التابعة') }}</h4>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 font-Cairo text-start">
                @foreach ($category->children as $child)
                    <a href="{{ route('categories.show', $child->id) }}" class="card-premium glass-panel p-8 rounded-[2.5rem] shadow-xl hover:-translate-y-2 transition-all group border border-[var(--glass-border)] text-start relative overflow-hidden">
                        <div class="absolute inset-x-0 top-0 h-1 bg-brand-primary/10 group-hover:bg-brand-primary transition-colors"></div>
                        <div class="flex flex-col gap-3 text-start">
                            <span class="text-lg font-black text-[var(--main-text)] group-hover:text-brand-primary transition-colors leading-tight font-Cairo text-start">{{ $child->name }}</span>
                            <p class="text-[13px] font-black text-[var(--text-muted)] line-clamp-2 leading-relaxed font-Cairo text-start">
                                {{ $child->description ?? __('لا يوجد وصف.') }}
                            </p>
                        </div>
                        <div class="mt-8 flex items-center justify-between text-[13px] font-black text-brand-primary uppercase tracking-[0.2em] font-Cairo opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-4 group-hover:translate-x-0">
                            <span>{{ __('عرض التفاصيل') }}</span>
                            <svg class="w-4 h-4 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
