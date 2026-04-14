@extends('layouts.admin')

@section('title', __('مراجعة طلب المزود') . ': ' . $providerRequest->name)

@section('content')
<div class="max-w-6xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-5 mb-5 text-start">
                <a href="{{ route('provider-requests.index') }}" class="w-14 h-14 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-[var(--glass-border)]">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl text-[var(--main-text)] flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl font-Cairo shadow-lg shadow-indigo-500/5 whitespace-nowrap inline-flex items-center justify-center">👨‍🔧</span>
                    {{ __('مراجعة بيانات المتقدم للانضمام') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[13px] font-black text-[var(--text-muted)] mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('طلبات انضمام المزودين') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('تدقيق الوثائق') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary">{{ __('طلب المعرف') }} #{{ str_pad($providerRequest->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
             <span class="px-8 py-3 rounded-2xl text-[13px] font-black uppercase tracking-[0.1em] font-Cairo shadow-xl @if($providerRequest->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 shadow-amber-500/5 @elseif($providerRequest->status == 'accepted') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-emerald-500/5 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 shadow-rose-500/5 @endif font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                {{ __('الحالة') }}: {{ __($providerRequest->status) }}
            </span>
        </div>
    </div>

    <!-- Request Details -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo">
        <!-- Candidate Profiles Space -->
        <div class="lg:col-span-8 space-y-12 text-start">
            <!-- Identity specifications Card -->
            <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-indigo-600 rounded-full shadow-lg shadow-indigo-600/30"></span>
                    <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('البيانات التعريفية للمتقدم') }}</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 text-start font-Cairo">
                    <!-- Legal Name -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start">
                        <div class="w-16 h-16 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">👤</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('الاسم القانوني الكامل') }}</span>
                            <span class="text-sm font-black text-[var(--main-text)] font-Cairo text-start">{{ $providerRequest->name }}</span>
                        </div>
                    </div>

                    <!-- User Account -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start">
                        <div class="w-16 h-16 bg-brand-primary/10 text-brand-primary rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo italic">ID</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('اسم المستخدم المرتبط') }}</span>
                            <span class="text-sm font-black text-[var(--main-text)] font-Cairo text-start italic font-mono">{{ $providerRequest->user->name }}</span>
                        </div>
                    </div>

                    <!-- Submission Date -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">📅</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('تاريخ التقديم') }}</span>
                            <span class="text-sm font-black text-[var(--main-text)] font-mono text-start">{{ $providerRequest->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>

                    <!-- Administrative Reviewer -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-amber-500/10 text-amber-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo font-mono">⚖️</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('الموظف المسؤول عن المراجعة') }}</span>
                            <span class="text-xs font-black text-[var(--main-text)] font-Cairo text-start">{{ $providerRequest->admin->name ?? '— ' . __('قيد المراجعة') . ' —' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Application Rationale Card -->
            <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo min-h-[350px]">
                <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/[0.03] to-transparent pointer-events-none"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30 font-Cairo"></span>
                    <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('مبررات طلب الانضمام والمؤهلات') }}</h4>
                </div>

                <div class="bg-[var(--main-bg)] p-12 rounded-[3.5rem] border border-[var(--glass-border)] mb-8 relative group text-start font-Cairo shadow-inner">
                    <div class="absolute -top-8 -right-8 w-20 h-20 bg-[var(--glass-bg)] rounded-3xl shadow-2xl flex items-center justify-center text-4xl group-hover:rotate-12 transition-all duration-500 font-Cairo italic">💬</div>
                    <p class="text-lg font-bold text-[var(--main-text)] leading-[2.2] font-Cairo italic text-start font-Cairo">" {{ $providerRequest->requestContent }}"
                    </p>
                </div>
            </div>
        </div>

        <!-- Documents and Actions -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <!-- ID Card Vault -->
            <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo overflow-hidden relative">
                <div class="flex items-center gap-4 mb-8 text-start">
                    <span class="w-2 h-8 bg-slate-400 rounded-full shadow-md font-Cairo"></span>
                    <h4 class="font-black text-[var(--main-text)] font-Cairo text-sm uppercase tracking-[0.2em] text-start">{{ __('الوثائق الثبوتية') }}</h4>
                </div>
                
                <div class="group relative rounded-[2.5rem] overflow-hidden cursor-zoom-in border-4 border-[var(--glass-border)] shadow-2xl bg-slate-200">
                    <img src="{{ asset('storage/' . $providerRequest->id_card) }}" alt="Identity Evidence" class="w-full h-auto object-cover transition-transform duration-1000 group-hover:scale-125">
                    <div class="absolute inset-0 bg-brand-primary/40 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-center p-8 backdrop-blur-sm">
                        <div class="w-16 h-16 bg-[var(--glass-bg)]/20 rounded-full flex items-center justify-center mb-4 border border-white/30 animate-pulse font-Cairo">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <span class="text-white text-[13px] font-black uppercase tracking-[0.2em]">{{ __('تحليل الوثيقة بملء الشاشة') }}</span>
                    </div>
                </div>
                <p class="mt-8 text-[12px] font-black text-[var(--text-muted)] text-center uppercase tracking-[0.3em] font-Cairo leading-relaxed opacity-60">
                    {{ __('ملاحظة أمنية: يمنع تداول هذه الصورة خارج الإطار الإداري.') }}
                </p>
            </div>

            <!-- Take Action -->
            @if ($providerRequest->status === \App\constant\providerRequestStatus::PENDING)
                <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-brand-primary/30 text-start font-Cairo overflow-hidden relative">
                    <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-emerald-500 via-brand-primary to-rose-600 opacity-60 font-Cairo"></div>
                     
                    <div class="flex items-center gap-4 mb-10 text-start font-Cairo">
                        <span class="w-2 h-8 bg-brand-primary rounded-full shadow-md font-Cairo"></span>
                        <h4 class="font-black text-[var(--main-text)] font-Cairo text-sm uppercase tracking-[0.2em] text-start font-Cairo">{{ __('اتخاذ قرار إداري') }}</h4>
                    </div>

                    <div class="space-y-6 text-start font-Cairo">
                        <form id="approve-form-{{ $providerRequest->id }}" method="POST" action="{{ route('provider-requests.update.status', $providerRequest->id) }}" class="text-start">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="accepted">
                            <button type="button" 
                                onclick="confirmAction('approve-form-{{ $providerRequest->id }}', {
                                    title: '{{ __('الموافقة على الانضمام') }}',
                                    text: '{{ __('هل أنت متأكد من قبول هذا المزود؟ سيتم منحه صلاحيات العمل على المنصة فوراً.') }}',
                                    icon: 'success',
                                    confirmButtonText: '{{ __('تأكيد القبول') }}'
                                })" class="w-full py-6 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-[2rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-[0_20px_40px_-10px_rgba(16,185,129,0.4)] hover:scale-[1.03] transition-all duration-500 font-Cairo flex items-center justify-center gap-4 text-start font-Cairo">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                {{ __('الموافقة على طلب الانضمام') }}
                            </button>
                        </form>
                        
                        <form id="reject-form-{{ $providerRequest->id }}" method="POST" action="{{ route('provider-requests.update.status', $providerRequest->id) }}" class="text-start">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="rejected">
                            <button type="button" 
                                onclick="confirmAction('reject-form-{{ $providerRequest->id }}', {
                                    title: '{{ __('رفض طلب الانضمام') }}',
                                    text: '{{ __('هل أنت متأكد من رفض هذا الطلب؟ سيتم إخطار المتقدم بالرفض وإغلاق الملف.') }}',
                                    icon: 'error',
                                    confirmButtonText: '{{ __('تأكيد الرفض') }}'
                                })" class="w-full py-6 bg-[var(--glass-bg)] text-rose-500 border border-[var(--glass-border)] rounded-[2rem] text-[14px] font-black hover:bg-rose-50 dark:hover:bg-rose-500/5 transition-all font-Cairo flex items-center justify-center gap-4 uppercase tracking-[0.3em] shadow-sm text-start font-Cairo">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                {{ __('رفض الملف وإغلاق الطلب') }}
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] flex flex-col items-center justify-center text-center gap-6 opacity-80 font-Cairo">
                    <div class="w-20 h-20 bg-[var(--main-bg)] rounded-[2rem] flex items-center justify-center text-slate-300 shadow-inner font-Cairo">
                         <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="flex flex-col gap-2 font-Cairo">
                        <span class="text-xs font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo">{{ __('أرشيف معالج') }}</span>
                        <p class="text-[14px] font-bold text-[var(--text-muted)] font-Cairo">{{ __('هذا الطلب تم إغلاقه والبت فيه مسبقاً.') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
