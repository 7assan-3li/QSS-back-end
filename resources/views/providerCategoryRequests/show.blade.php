@extends('layouts.admin')

@section('title', __('مراجعة طلب قسم') . ': ' . $categoryRequest->category->name)

@section('content')
<div class="max-w-6xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-5 mb-5 text-start">
                <a href="{{ route('provider-category-requests.index') }}" class="w-14 h-14 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-[var(--glass-border)]">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl text-[var(--main-text)] flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl font-Cairo shadow-lg shadow-indigo-500/5 whitespace-nowrap inline-flex items-center justify-center">📂</span>
                    {{ __('مراجعة طلب قسم إضافي') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[13px] font-black text-[var(--text-muted)] mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('إدارة طلبات الأقسام الإضافية') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('تدقيق الطلب') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary">{{ __('رقم الطلب') }} #{{ str_pad($categoryRequest->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
             <span class="px-8 py-3 rounded-2xl text-[13px] font-black uppercase tracking-[0.1em] font-Cairo shadow-xl @if($categoryRequest->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 shadow-amber-500/5 @elseif($categoryRequest->status == 'accepted') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-emerald-500/5 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 shadow-rose-500/5 @endif font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                {{ __('الحالة') }}: {{ __($categoryRequest->status) }}
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
                    <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('تفاصيل المزود والقسم المطلوب') }}</h4>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 text-start font-Cairo">
                    <!-- Provider Name -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start">
                        <div class="w-16 h-16 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">👤</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('اسم المزود') }}</span>
                            <span class="text-sm font-black text-[var(--main-text)] font-Cairo text-start">{{ $categoryRequest->user->name }}</span>
                        </div>
                    </div>

                    <!-- Category Requested -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start">
                        <div class="w-16 h-16 bg-brand-primary/10 text-brand-primary rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo italic">📁</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('القسم المطلوب') }}</span>
                            <span class="text-sm font-black text-[var(--main-text)] font-Cairo text-start italic">{{ $categoryRequest->category->name }}</span>
                        </div>
                    </div>

                    <!-- Submission Date -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">📅</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('تاريخ التقديم') }}</span>
                            <span class="text-sm font-black text-[var(--main-text)] font-mono text-start">{{ $categoryRequest->created_at->format('Y-m-d') }}</span>
                        </div>
                    </div>

                    <!-- Administrative Reviewer -->
                    <div class="card-premium glass-panel p-8 rounded-[2.5rem] border border-[var(--glass-border)] flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-amber-500/10 text-amber-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo font-mono">⚖️</div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] mb-2 font-Cairo text-start">{{ __('الموظف المسؤول عن المراجعة') }}</span>
                            <span class="text-xs font-black text-[var(--main-text)] font-Cairo text-start">{{ $categoryRequest->admin->name ?? '— ' . __('قيد المراجعة') . ' —' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if ($categoryRequest->status === \App\constant\ProviderRequestStatus::REJECTED && $categoryRequest->rejection_reason)
                <!-- Rejection Reason Card -->
                <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-rose-500/20 overflow-hidden text-start font-Cairo bg-rose-50/10 dark:bg-rose-950/5">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60"></div>
                    <div class="flex items-center gap-5 mb-8 text-start font-Cairo">
                        <span class="w-3 h-10 bg-rose-600 rounded-full shadow-lg shadow-rose-600/30"></span>
                        <h4 class="text-2xl font-black text-rose-600 font-Cairo text-start italic">{{ __('سبب الرفض الإداري') }}</h4>
                    </div>
                    <div class="bg-rose-500/5 p-8 rounded-[2.5rem] border border-rose-500/10 text-start font-Cairo">
                        <p class="text-sm font-bold text-rose-600 dark:text-rose-400 leading-relaxed font-Cairo">
                            {{ $categoryRequest->rejection_reason }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Application Rationale Card -->
            <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo min-h-[350px]">
                <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/[0.03] to-transparent pointer-events-none"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30 font-Cairo"></span>
                    <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start italic">{{ __('تفاصيل الخبرة في القسم المطلوب') }}</h4>
                </div>

                <div class="bg-[var(--main-bg)] p-12 rounded-[3.5rem] border border-[var(--glass-border)] mb-8 relative group text-start font-Cairo shadow-inner">
                    <div class="absolute -top-8 -right-8 w-20 h-20 bg-[var(--glass-bg)] rounded-3xl shadow-2xl flex items-center justify-center text-4xl group-hover:rotate-12 transition-all duration-500 font-Cairo italic">💬</div>
                    <p class="text-lg font-bold text-[var(--main-text)] leading-[2.2] font-Cairo italic text-start font-Cairo">" {{ $categoryRequest->description ?? __('لم يقم المزود بإضافة وصف للطلب.') }} "
                    </p>
                </div>
            </div>
        </div>

        <!-- Documents and Actions -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <!-- Document Vault -->
            <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo overflow-hidden relative">
                <div class="flex items-center gap-4 mb-8 text-start">
                    <span class="w-2 h-8 bg-slate-400 rounded-full shadow-md font-Cairo"></span>
                    <h4 class="font-black text-[var(--main-text)] font-Cairo text-sm uppercase tracking-[0.2em] text-start">{{ __('شهادة الخبرة أو الكفاءة المرفقة') }}</h4>
                </div>
                
                <div class="group relative rounded-[2.5rem] overflow-hidden border-4 border-[var(--glass-border)] shadow-2xl bg-slate-200">
                    <a href="{{ asset('storage/' . $categoryRequest->document_path) }}" target="_blank" class="block">
                        @php
                            $ext = pathinfo($categoryRequest->document_path, PATHINFO_EXTENSION);
                        @endphp
                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/' . $categoryRequest->document_path) }}" alt="Experience Evidence" class="w-full h-auto object-cover transition-transform duration-1000 group-hover:scale-110">
                        @else
                            <div class="w-full h-48 flex flex-col items-center justify-center bg-gray-100 text-gray-500 group-hover:bg-gray-200 transition-all">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span class="font-bold text-lg uppercase">{{ $ext }} Document</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-brand-primary/40 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-center p-8 backdrop-blur-sm">
                            <div class="w-16 h-16 bg-[var(--glass-bg)]/20 rounded-full flex items-center justify-center mb-4 border border-white/30 animate-pulse font-Cairo">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="text-white text-[13px] font-black uppercase tracking-[0.2em]">{{ __('عرض المرفق') }}</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Take Action -->
            @if ($categoryRequest->status === \App\constant\ProviderRequestStatus::PENDING)
                <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-brand-primary/30 text-start font-Cairo overflow-hidden relative">
                    <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-emerald-500 via-brand-primary to-rose-600 opacity-60 font-Cairo"></div>
                     
                    <div class="flex items-center gap-4 mb-10 text-start font-Cairo">
                        <span class="w-2 h-8 bg-brand-primary rounded-full shadow-md font-Cairo"></span>
                        <h4 class="font-black text-[var(--main-text)] font-Cairo text-sm uppercase tracking-[0.2em] text-start font-Cairo">{{ __('اتخاذ قرار إداري') }}</h4>
                    </div>

                    <div class="space-y-6 text-start font-Cairo">
                        <form id="approve-form-{{ $categoryRequest->id }}" method="POST" action="{{ route('provider-category-requests.update.status', $categoryRequest->id) }}" class="text-start">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="accepted">
                            <div class="mb-4">
                                <label for="max_services" class="block text-sm font-bold text-[var(--text-muted)] mb-2">{{ __('عدد الخدمات المسموح بها كحد أقصى') }}</label>
                                <input type="number" id="max_services" name="max_services" value="5" min="1" class="w-full bg-[var(--main-bg)] border border-[var(--glass-border)] rounded-xl px-4 py-3 text-[var(--main-text)] focus:outline-none focus:ring-2 focus:ring-brand-primary">
                            </div>
                            <button type="button" 
                                onclick="confirmAction('approve-form-{{ $categoryRequest->id }}', {
                                    title: '{{ __('الموافقة على القسم') }}',
                                    text: '{{ __('هل أنت متأكد من قبول الطلب؟ سيتم منحه صلاحية إضافة الخدمات في هذا القسم.') }}',
                                    icon: 'success',
                                    confirmButtonText: '{{ __('تأكيد القبول') }}'
                                })" class="w-full py-6 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-[2rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-[0_20px_40px_-10px_rgba(16,185,129,0.4)] hover:scale-[1.03] transition-all duration-500 font-Cairo flex items-center justify-center gap-4 text-start font-Cairo">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                {{ __('الموافقة على القسم') }}
                            </button>
                        </form>
                        
                        <form id="reject-form-{{ $categoryRequest->id }}" method="POST" action="{{ route('provider-category-requests.update.status', $categoryRequest->id) }}" class="text-start">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="rejected">
                            <input type="hidden" name="rejection_reason" id="rejection_reason_field">
                            <button type="button" 
                                onclick="promptCategoryRejection('reject-form-{{ $categoryRequest->id }}')" class="w-full py-6 bg-[var(--glass-bg)] text-rose-500 border border-[var(--glass-border)] rounded-[2rem] text-[14px] font-black hover:bg-rose-50 dark:hover:bg-rose-500/5 transition-all font-Cairo flex items-center justify-center gap-4 uppercase tracking-[0.3em] shadow-sm text-start font-Cairo">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                {{ __('رفض الطلب') }}
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

@push('scripts')
    <script>
        function promptCategoryRejection(formId) {
            const isDark = document.documentElement.classList.contains('dark');

            Swal.fire({
                title: '{{ __('سبب رفض إضافة القسم') }}',
                text: '{{ __('يرجى كتابة سبب الرفض لتوضيحه للمستخدم:') }}',
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
                },
                inputValidator: (value) => {
                    if (!value || !value.trim()) {
                        return '{{ __('يجب إدخال سبب الرفض!') }}';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const form = document.getElementById(formId);
                    const reasonField = document.getElementById('rejection_reason_field');
                    if (form && reasonField) {
                        reasonField.value = result.value.trim();
                        form.submit();
                    }
                }
            });
        }
    </script>
@endpush
