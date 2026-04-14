@extends('layouts.admin')

@section('title', __('تفاصيل الحساب البنكي'))

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
                    <span class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl font-Cairo shadow-lg shadow-emerald-500/5 font-Cairo underline-offset-8 italic whitespace-nowrap inline-flex items-center justify-center">🏦</span>
                    {{ __('عرض بيانات البنك') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[13px] font-black text-[var(--text-muted)] mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('إدارة البنوك') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('الحسابات المعتمدة') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary italic">{{ __('رقم البنك #') }}{{ str_pad($bank->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <div class="flex items-center gap-4 text-start font-Cairo">
            <a href="{{ route('banks.edit', $bank->id) }}" class="px-10 py-5 bg-gradient-to-r from-brand-primary to-indigo-600 text-white rounded-[2rem] text-[14px] font-black uppercase tracking-[0.2em] shadow-xl shadow-brand-primary/20 hover:scale-[1.05] transition-all font-Cairo flex items-center gap-3 text-start font-Cairo">
                <svg class="w-5 h-5 font-black uppercase" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                {{ __('تعديل بيانات البنك') }}
            </a>
        </div>
    </div>

    <!-- Bank Information -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 font-Cairo text-start">
        <!-- Technical Specifications Column -->
        <div class="lg:col-span-8 space-y-12 text-start font-Cairo">
            <!-- Specification Matrix Card -->
            <div class="card-premium glass-panel p-14 rounded-[2rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/[0.03] rounded-bl-[4rem] -mr-20 -mt-20 blur-3xl opacity-60 font-Cairo font-mono"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-emerald-600 rounded-full shadow-lg shadow-emerald-600/30 font-black uppercase font-Cairo"></span>
                    <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('البيانات الأساسية') }}</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10 text-start font-Cairo">
                    <!-- Bank Identity Node -->
                    <div class="flex items-center gap-6 group p-8 bg-[var(--main-bg)] rounded-[1.5rem] border border-[var(--glass-border)] shadow-inner group transition-all font-Cairo">
                        <div class="w-16 h-16 bg-[var(--glass-bg)] text-emerald-500 rounded-[1.2rem] flex items-center justify-center text-2xl shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-all font-Cairo italic">🏦</div>
                        <div class="flex flex-col text-start font-Cairo">
                            <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('المسمى المصرفي') }}</span>
                            <span class="text-sm font-black text-[var(--main-text)] font-Cairo italic text-start">{{ $bank->bank_name }}</span>
                        </div>
                    </div>

                    <!-- Certification Node -->
                    <div class="flex items-center gap-6 group p-8 bg-[var(--main-bg)] rounded-[1.5rem] border border-[var(--glass-border)] shadow-inner group transition-all font-Cairo">
                        <div class="w-16 h-16 bg-[var(--glass-bg)] text-indigo-500 rounded-[1.2rem] flex items-center justify-center text-2xl shadow-xl group-hover:scale-110 group-hover:rotate-6 transition-all font-Cairo italic">🗓️</div>
                        <div class="flex flex-col text-start font-Cairo">
                            <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('تاريخ الإضافة') }}</span>
                            <span class="text-sm font-black text-[var(--main-text)] font-mono tracking-widest text-start italic font-Cairo">{{ $bank->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conceptual Documentation -->
            <div class="card-premium glass-panel p-14 rounded-[2rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                <div class="flex items-center gap-5 mb-10 text-start font-Cairo">
                    <span class="w-3 h-10 bg-indigo-600 rounded-full shadow-lg shadow-indigo-600/30 font-Cairo"></span>
                    <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('وصف البنك') }}</h4>
                </div>
                <div class="p-10 bg-[var(--main-bg)] rounded-[1.5rem] border border-[var(--glass-border)] shadow-inner text-start font-Cairo">
                    <p class="text-lg font-bold text-[var(--text-secondary)] leading-[2] font-Cairo text-start italic">" {{ $bank->description ?? __('لا توجد بيانات وصفية لهذا البنك حالياً.') }}"
                    </p>
                </div>
            </div>
        </div>

        <!-- Visual Identity & Control Sidebar -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <!-- Brand Iconography Vault -->
            <div class="card-premium glass-panel p-8 rounded-[2rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 left-0 w-32 h-32 bg-emerald-500/[0.04] rounded-br-[4rem] -ml-10 -mt-10 font-Cairo"></div>
                
                <h4 class="font-black text-[var(--text-muted)] text-[13px] uppercase tracking-[0.3em] mb-10 px-6 font-Cairo text-start italic font-Cairo">💎 {{ __('شعار البنك المعتمد') }}</h4>

                <div class="relative w-full aspect-square rounded-[2rem] border-8 border-[var(--glass-border)] shadow-[0_40px_80px_-15px_rgba(0,0,0,0.3)] bg-[var(--main-bg)] overflow-hidden group font-Cairo">
                    @if($bank->image_path)
                        <img src="{{ asset('storage/' . $bank->image_path) }}" alt="{{ $bank->bank_name }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 opacity-90 group-hover:opacity-100">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-900 dark:to-slate-900 text-slate-300 gap-8 font-Cairo">
                            <div class="w-24 h-24 bg-[var(--glass-bg)]/50 dark:bg-[var(--glass-bg)]/5 rounded-[1.2rem] flex items-center justify-center shadow-inner font-Cairo">
                                <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <span class="text-[13px] font-black uppercase tracking-[0.4em] font-Cairo opacity-40 font-Cairo">NO_LOGO</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Administrative Actions Sidebar -->
            <div class="p-10 bg-slate-950 rounded-[2rem] border border-slate-900 shadow-3xl text-start font-Cairo">
                <h4 class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.4em] text-center mb-10 font-Cairo italic">{{ __('إجراءات إدارية') }}</h4>
                <div class="space-y-6 text-start font-Cairo">
                    <a href="{{ route('banks.edit', $bank->id) }}" class="w-full py-6 bg-[var(--glass-bg)]/5 text-brand-primary border border-brand-primary/20 rounded-[1.5rem] text-[14px] font-black flex items-center justify-center gap-4 hover:bg-brand-primary hover:text-white transition-all shadow-xl shadow-brand-primary/5 font-Cairo italic font-Cairo">
                        <svg class="w-5 h-5 font-black uppercase" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        {{ __('تعديل بيانات البنك') }}
                    </a>
                    
                    <form id="delete-bank-{{ $bank->id }}" action="{{ route('banks.destroy', $bank->id) }}" method="POST" class="w-full font-Cairo text-start">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                            onclick="confirmAction('delete-bank-{{ $bank->id }}', {
                                title: '{{ __('حذف السجل المصرفي نهائياً') }}',
                                text: '{{ __('تحذير: أنت على وشك مسح هذا السجل البنكي وكافة الحوالات المرتبطة به من قاعدة البيانات. هذا الإجراء نهائي.') }}',
                                icon: 'warning',
                                isDanger: true,
                                confirmButtonText: '{{ __('تأكيد المسح النهائي') }}'
                            })" class="w-full py-6 bg-rose-500/10 text-rose-500 border border-rose-500/20 rounded-[1.5rem] text-[14px] font-black flex items-center justify-center gap-4 hover:bg-rose-500 hover:text-white transition-all shadow-xl shadow-rose-500/5 font-Cairo uppercase tracking-[0.2em] italic font-Cairo">
                            <svg class="w-5 h-5 font-black uppercase" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            {{ __('حذف الحساب البنكي') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
