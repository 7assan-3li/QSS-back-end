@extends('layouts.admin')

@section('title', __('إضافة بنك جديد'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start font-Cairo">
        <div class="text-start font-Cairo">
            <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                <a href="{{ route('banks.index') }}" class="w-14 h-14 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-[var(--glass-border)] font-Cairo">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl text-[var(--main-text)] flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl font-Cairo shadow-lg shadow-emerald-500/5 font-Cairo underline-offset-8 italic whitespace-nowrap inline-flex items-center justify-center">➕</span>
                    {{ __('إضافة بنك جديد للنظام') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[13px] font-black text-[var(--text-muted)] mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('إدارة البنوك') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('بيانات البنك الجديد') }}</span>
            </div>
        </div>
    </div>

    <!-- Creation Form -->
    <form action="{{ route('banks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12 text-start font-Cairo">
        @csrf

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="card-premium glass-panel bg-rose-500/5 border-rose-500/20 p-10 rounded-[3.5rem] animate-shake text-start font-Cairo">
                <div class="flex items-center gap-5 mb-6 text-start font-Cairo">
                    <span class="w-12 h-12 bg-rose-500 text-white rounded-2xl flex items-center justify-center text-xl shadow-xl shadow-rose-500/20 font-Cairo whitespace-nowrap inline-flex items-center justify-center">⚠️</span>
                    <h5 class="text-xs font-black text-rose-600 uppercase tracking-[0.2em] font-Cairo text-start italic">{{ __('يرجى تصحيح الأخطاء التالية:') }}</h5>
                </div>
                <ul class="mr-16 space-y-3 text-start font-Cairo">
                    @foreach ($errors->all() as $error)
                        <li class="text-[14px] font-bold text-rose-500/80 font-Cairo tracking-wide flex items-center gap-3 italic text-start">
                            <span class="w-2 h-2 bg-rose-400 rounded-full font-Cairo"></span> {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo">
            <!-- Core Parameters Column -->
            <div class="lg:col-span-8 space-y-12">
                <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-primary/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60 font-Cairo"></div>
                    
                    <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                        <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30 font-Cairo"></span>
                        <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('البيانات الأساسية للبنك') }}</h4>
                    </div>

                    <div class="space-y-12 relative z-10 text-start font-Cairo">
                        <!-- Entity Name Input -->
                        <div class="flex flex-col gap-5 text-start font-Cairo">
                            <label class="flex items-center gap-3 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] px-4 font-Cairo text-start font-Cairo">
                                <span class="w-2 h-2 bg-indigo-500 rounded-full font-Cairo"></span>
                                {{ __('اسم البنك المعتمد') }}
                            </label>
                            <div class="relative group font-Cairo">
                                <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="{{ __('أدخل الاسم الرسمي المعتمد...') }}" class="w-full bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] px-10 py-7 text-sm font-black text-[var(--main-text)] text-[var(--main-text)] focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all outline-none italic shadow-inner text-start font-Cairo" required>
                                <div class="absolute left-10 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-brand-primary transition-colors font-Cairo">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1-1v-2l1 1v5m-4 0h4"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Abstract Descriptor TextArea -->
                        <div class="flex flex-col gap-5 text-start font-Cairo">
                            <label class="flex items-center gap-3 text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] px-4 font-Cairo text-start font-Cairo">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full font-Cairo"></span>
                                {{ __('وصف البنك وتعليمات التحويل') }}
                            </label>
                            <textarea name="description" rows="6" placeholder="{{ __('اكتب نبذة تفصيلية أو تعليمات التحويل الفني لهذا البنك...') }}" class="w-full bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[3.5rem] px-10 py-8 text-sm font-black text-[var(--main-text)] text-[var(--main-text)] focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all outline-none resize-none leading-relaxed italic text-start font-Cairo shadow-inner">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Identity Vector & Execution Sidebar -->
            <div class="lg:col-span-4 space-y-12">
                <!-- Bank Logo Section -->
                <div class="card-premium glass-panel p-10 rounded-[4rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo">
                    <div class="flex items-center gap-5 mb-10 text-start font-Cairo">
                        <span class="w-3 h-10 bg-indigo-600 rounded-full shadow-lg shadow-indigo-600/30 font-Cairo"></span>
                        <h4 class="text-[13px] font-black text-[var(--main-text)] font-Cairo uppercase tracking-[0.3em] text-start italic font-Cairo">{{ __('شعار البنك') }}</h4>
                    </div>
                    
                    <div class="relative group font-Cairo">
                        <div id="preview" class="w-full aspect-square rounded-[3.5rem] border-8 border-dashed border-[var(--glass-border)] flex flex-col items-center justify-center bg-[var(--main-bg)] overflow-hidden transition-all group-hover:border-brand-primary/40 shadow-inner p-4 font-Cairo">
                            <div class="w-20 h-20 bg-[var(--glass-bg)]/50 dark:bg-[var(--glass-bg)]/5 rounded-3xl flex items-center justify-center mb-6 shadow-sm font-Cairo">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a1 1 0 011.414 0L15 16m-6-6h.01M4 21h16a2 2 0 002-2V5a2 2 0 00-2-2H4a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] font-Cairo italic text-center font-Cairo">{{ __('رفع شعار البنك') }}</span>
                        </div>
                        
                        <label class="absolute inset-0 cursor-pointer flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 backdrop-blur-sm bg-slate-900/20 rounded-[3.5rem] font-Cairo">
                            <input type="file" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                            <div class="px-10 py-5 bg-[var(--glass-bg)] text-brand-dark rounded-2xl text-[14px] font-black uppercase tracking-[0.2em] shadow-2xl font-Cairo italic">{{ __('اختيار صورة') }}</div>
                        </label>
                    </div>
                    
                    <p class="mt-8 text-[12px] font-black text-[var(--text-muted)] text-center uppercase tracking-[0.2em] leading-relaxed italic font-Cairo">{{ __('المتطلبات: يفضل استخدام شعار بمقاسات متساوية وصيغة PNG.') }}</p>
                </div>

                <!-- Action Buttons Sidebar -->
                <div class="p-10 bg-slate-950 rounded-[4rem] border border-slate-900 shadow-3xl text-start font-Cairo">
                    <button type="submit" class="w-full py-7 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-[2.5rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-[0_20px_40px_-10px_rgba(16,185,129,0.4)] hover:scale-[1.05] transition-all duration-500 font-Cairo flex items-center justify-center gap-5 italic text-start font-Cairo">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        {{ __('إضافة البنك') }}
                    </button>
                    <a href="{{ route('banks.index') }}" class="w-full mt-6 py-6 border border-white/5 text-[var(--text-muted)] rounded-[2rem] text-[13px] font-black uppercase tracking-[0.4em] flex items-center justify-center hover:text-white hover:bg-[var(--glass-bg)]/5 transition-all font-Cairo italic font-Cairo">{{ __('إلغاء') }}</a>
                </div>
            </div>
        </div>
    </form>
@endsection
