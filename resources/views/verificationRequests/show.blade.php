@extends('layouts.admin')

@section('title', __('تفاصيل طلب التوثيق') . ': ' . $provider->name)

@section('content')
<div class="max-w-6xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-3xl font-Cairo shadow-lg shadow-emerald-500/5 whitespace-nowrap inline-flex items-center justify-center">🏢</span>
                {{ __('تفاصيل طلب التوثيق') }}
            </h3>
            <div class="flex items-center gap-3 text-[13px] font-black mt-3 mr-20 uppercase tracking-[0.2em] font-Cairo text-start opacity-60">
                <span>{{ __('بيانات المستخدم') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('مراجعة الطلب') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-emerald-600 opacity-100">{{ __('بيانات المزود') }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
             <span class="px-6 py-2.5 rounded-2xl text-[13px] font-black uppercase tracking-[0.1em] font-Cairo @if($provider->verification_provider) bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 @else bg-amber-500/10 text-amber-600 border border-amber-500/20 animate-pulse @endif whitespace-nowrap inline-flex items-center justify-center">
                {{ $provider->verification_provider ? __('حساب موثق') : __('قيد المراجعة') }}
            </span>
                <a href="{{ route('verification-requests.index') }}" class="w-14 h-14 bg-[var(--glass-border)] rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-[var(--glass-border)] font-Cairo opacity-60 hover:opacity-100">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
        </div>
    </div>

    <!-- Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 text-start">
        <!-- Main Identity & Narrative Space -->
        <div class="lg:col-span-2 space-y-12 text-start">
            <!-- Core Identity Card -->
            <div class="card-premium glass-panel p-12 rounded-[2rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] relative border border-[var(--glass-border)] text-start font-Cairo overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl"></div>
                
                <div class="flex flex-col md:flex-row items-center gap-10 relative z-10 text-start">
                    <div class="w-28 h-28 bg-gradient-to-br from-emerald-500 to-indigo-600 rounded-[1.5rem] flex items-center justify-center text-white text-4xl font-black shadow-[0_20px_50px_-10px_rgba(16,185,129,0.4)] transition-all duration-700 hover:rotate-6 hover:scale-105 font-Cairo">
                         {{ mb_substr($provider->name, 0, 1) }}
                    </div>
                    <div class="flex-grow text-center md:text-start font-Cairo">
                        <h4 class="text-3xl font-black font-Cairo mb-4 text-start italic">{{ $provider->name }}</h4>
                        <div class="flex flex-wrap justify-center md:justify-start gap-6 text-start font-Cairo">
                            <span class="text-[14px] font-black flex items-center gap-3 font-mono text-start opacity-60">
                                <span class="w-8 h-8 bg-[var(--glass-border)] rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </span>
                                {{ $provider->email }}
                            </span>
                            <span class="inline-flex items-center gap-3 px-5 py-2 bg-amber-500/10 text-amber-600 rounded-xl text-[14px] font-black border border-amber-500/20 font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                                <svg class="w-4 h-4 fill-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                {{ __('التقييم') }}: {{ number_format($provider->rating_avg, 1) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-16 space-y-8 relative z-10 text-start">
                    <div class="flex items-center gap-4 text-start font-Cairo">
                        <span class="w-10 h-[2px] bg-slate-200"></span>
                        <span class="text-[12px] font-black uppercase tracking-[0.3em] font-Cairo text-start font-Cairo opacity-60">{{ __('محتوى الطلب') }}</span>
                    </div>
                    <div class="p-10 bg-[var(--main-bg)] rounded-[1.5rem] border border-[var(--glass-border)] relative group text-start font-Cairo">
                        <div class="absolute top-6 left-6 w-16 h-16 text-emerald-500/10 -scale-x-100 opacity-50 font-Cairo">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.851h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.433.917-4 3.613-4 5.851h4v10h-10z"></path></svg>
                        </div>
                        <p class="text-base font-bold leading-loose font-Cairo relative z-10 text-start opacity-70 italic">{{ $verificationRequest->content }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-start">
                <!-- Services -->
                <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-[var(--glass-border)] flex flex-col items-center gap-4 group hover:scale-[1.05] transition-all cursor-default shadow-sm text-start" dir="rtl">
                    <div class="w-14 h-14 bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center font-black text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">
                        {{ $servicesCount }}
                    </div>
                    <span class="text-[12px] font-black uppercase tracking-[0.2em] text-center font-Cairo text-start opacity-60">{{ __('الخدمات النشطة') }}</span>
                </div>
                <!-- Total Requests -->
                <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-[var(--glass-border)] flex flex-col items-center gap-4 group hover:scale-[1.05] transition-all cursor-default shadow-sm text-start" dir="rtl">
                    <div class="w-14 h-14 bg-[var(--glass-border)] text-[var(--main-text)] rounded-2xl flex items-center justify-center font-black text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo font-mono">
                        {{ $totalRequests }}
                    </div>
                    <span class="text-[12px] font-black uppercase tracking-[0.2em] text-center font-Cairo text-start opacity-60">{{ __('إجمالي الطلبات') }}</span>
                </div>
                <!-- Completed -->
                <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-emerald-500/20 flex flex-col items-center gap-4 group hover:scale-[1.05] transition-all cursor-default shadow-sm text-start bg-emerald-50/20 dark:bg-emerald-950/10" dir="rtl">
                    <div class="w-14 h-14 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center font-black text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo font-mono">
                        {{ $completedRequests }}
                    </div>
                    <span class="text-[12px] font-black text-emerald-500/80 uppercase tracking-[0.2em] text-center font-Cairo text-start">{{ __('الطلبات المكتملة') }}</span>
                </div>
                <!-- Complaints -->
                <div class="card-premium glass-panel p-8 rounded-[1.5rem] border {{ $complaintsCount > 0 ? 'border-rose-500/30 bg-rose-50/20 dark:bg-rose-950/10' : 'border-[var(--glass-border)]' }} flex flex-col items-center gap-4 group hover:scale-[1.05] transition-all cursor-default shadow-sm text-start" dir="rtl">
                    <div class="w-14 h-14 {{ $complaintsCount > 0 ? 'bg-rose-500/10 text-rose-600' : 'bg-[var(--glass-border)]' }} rounded-2xl flex items-center justify-center font-black text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo font-mono">
                         {{ $complaintsCount }}
                    </div>
                    <span class="text-[12px] font-black {{ $complaintsCount > 0 ? 'text-rose-500/80' : 'opacity-60' }} uppercase tracking-[0.2em] text-center font-Cairo text-start">{{ __('الشكاوى') }}</span>
                </div>
            </div>
        </div>

        <!-- Audit & Executive Controls Sidebar -->
        <div class="space-y-12 text-start">
            <!-- Financial Sovereignty Card -->
            <div class="card-premium glass-panel p-10 rounded-[2rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo">
                <div class="flex items-center gap-4 mb-10 text-start font-Cairo">
                    <span class="w-2 h-8 bg-slate-400 rounded-full shadow-sm font-Cairo"></span>
                    <h4 class="font-black text-sm font-Cairo uppercase tracking-[0.2em] text-start italic">{{ __('المعلومات المالية') }}</h4>
                </div>

                <div class="space-y-8 text-start">
                    <div class="flex justify-between items-center px-2 text-start font-Cairo">
                        <span class="text-[13px] font-black uppercase tracking-widest font-Cairo text-start opacity-60">{{ __('حالة العمولة') }}</span>
                        <span class="px-5 py-1.5 rounded-full text-[12px] font-black uppercase tracking-tighter font-Cairo {{ $provider->no_commission ? 'bg-rose-500/10 text-rose-600 border border-rose-500/20' : 'bg-emerald-500/10 text-emerald-600 border border-emerald-500/20' }} whitespace-nowrap inline-flex items-center justify-center">
                            {{ $provider->no_commission ? __('بدون عمولة') : __('يخضع للعمولة') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center px-2 text-start font-Cairo">
                        <span class="text-[13px] font-black uppercase tracking-widest font-Cairo text-start opacity-60">{{ __('طلبات غير محصلة') }}</span>
                        <span class="text-base font-black font-mono text-start italic">{{ str_pad($unpaidCommissionRequests, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="p-8 bg-brand-primary/[0.03] dark:bg-brand-primary/[0.05] rounded-[1.5rem] border border-brand-primary/10 text-center group hover:bg-brand-primary/[0.06] transition-all text-start">
                        <span class="text-[12px] font-black text-brand-primary uppercase tracking-[0.3em] block mb-3 font-Cairo text-start">{{ __('إجمالي العمولات') }}</span>
                        <div class="flex items-baseline justify-center gap-2 text-start">
                            <span class="text-3xl font-black text-brand-primary font-mono text-start">{{ number_format($totalCommission, 2) }}</span>
                            <span class="text-[14px] font-black text-brand-primary/60 font-Cairo text-start">{{ __('Y.R') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Executive Decision Terminal -->
            @if($verificationRequest->status === 'pending')
                <div class="card-premium glass-panel p-10 rounded-[2rem] shadow-2xl border border-indigo-500/20 text-start font-Cairo bg-indigo-50/[0.02] dark:bg-indigo-950/[0.02]">
                    <h4 class="font-black text-sm mb-10 text-center uppercase tracking-[0.2em] font-Cairo text-start italic">{{ __('اتخاذ قرار إداري') }}</h4>
                    <div class="space-y-5 text-start font-Cairo">
                        <form id="accept-verification-{{ $verificationRequest->id }}" method="POST" action="{{ route('verification-requests.accept', $verificationRequest->id) }}" class="text-start">
                            @csrf
                            <button type="button" 
                                onclick="confirmAction('accept-verification-{{ $verificationRequest->id }}', {
                                    title: '{{ __('توثيق هذا الحساب') }}',
                                    text: '{{ __('هل أنت متأكد من منح هذا الحساب صفة التوثيق (البادج الأزرق/الأخضر)؟') }}',
                                    icon: 'success',
                                    confirmButtonText: '{{ __('تأكيد التوثيق الآن') }}'
                                })" class="w-full py-5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-[1.5rem] text-[13px] font-black shadow-[0_20px_40px_-10px_rgba(16,185,129,0.3)] hover:scale-[1.03] transition-all font-Cairo flex items-center justify-center gap-3 uppercase tracking-widest text-start">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                {{ __('توثيق الحساب') }}
                            </button>
                        </form>
                        <form id="reject-verification-{{ $verificationRequest->id }}" method="POST" action="{{ route('verification-requests.reject', $verificationRequest->id) }}" class="text-start">
                            @csrf
                            <input type="hidden" name="rejection_reason" id="rejection_reason_field">
                            <button type="button" 
                                onclick="promptRejection('reject-verification-{{ $verificationRequest->id }}')" class="w-full py-5 bg-[var(--glass-bg)] text-rose-500 border border-[var(--glass-border)] rounded-[1.5rem] text-[13px] font-black hover:bg-rose-50 dark:hover:bg-rose-500/5 transition-all font-Cairo flex items-center justify-center gap-3 uppercase tracking-widest shadow-sm text-start">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                {{ __('رفض التوثيق') }}
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($verificationRequest->status === 'accepted')
                <div class="p-12 text-center bg-emerald-500/[0.04] rounded-[3.5rem] border border-emerald-500/10 shadow-inner flex flex-col items-center justify-center text-start">
                    <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mb-6 text-emerald-500 shadow-lg shadow-emerald-500/10 font-Cairo">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-xs font-black text-emerald-600 font-Cairo uppercase tracking-[0.2em] text-start">{{ __('هذا الحساب موثق حالياً') }}</p>
                </div>
            @endif

            @if($verificationRequest->status === 'rejected' && $verificationRequest->rejection_reason)
                <div class="card-premium glass-panel p-8 rounded-[2rem] border border-rose-500/20 bg-rose-500/5 mt-8 text-start font-Cairo">
                    <span class="text-[11px] font-black text-rose-500 uppercase tracking-widest block mb-3">{{ __('سبب الرفض الإداري') }}</span>
                    <p class="text-sm font-bold text-rose-700 dark:text-rose-400 italic">"{{ $verificationRequest->rejection_reason }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Specialized Prompt for Rejection Reason
     */
    function promptRejection(formId) {
        const isDark = document.documentElement.classList.contains('dark');
        
        Swal.fire({
            title: '{{ __('سبب رفض التوثيق') }}',
            text: '{{ __('يرجى كتابة سبب الرفض لتوضيحه للمستخدم (اختياري ولكن يفضل)') }}',
            input: 'textarea',
            inputPlaceholder: '{{ __('اكتب سبب الرفض هنا...') }}',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            confirmButtonText: '{{ __('تأكيد الرفض النهائي') }}',
            cancelButtonText: '{{ __('إلغاء') }}',
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#1e293b',
            customClass: {
                popup: 'rounded-[2.5rem] border border-rose-500 shadow-2xl font-Cairo',
                title: 'font-black text-xl font-Cairo !text-inherit',
                input: 'font-bold text-sm font-Cairo rounded-2xl border-[var(--glass-border)] focus:ring-rose-500 focus:border-rose-500',
                confirmButton: 'px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest font-Cairo shadow-lg shadow-rose-500/20',
                cancelButton: 'px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest font-Cairo'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(formId);
                const reasonField = document.getElementById('rejection_reason_field');
                if (form && reasonField) {
                    reasonField.value = result.value || '';
                    form.submit();
                }
            }
        });
    }
</script>
@endpush