@extends('layouts.admin')

@section('title', __('تدقيق تسوية مستحقات المزود'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                <a href="{{ route('admin.withdrawals.index') }}" class="w-14 h-14 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-[var(--glass-border)] font-Cairo">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl font-Cairo shadow-lg shadow-emerald-500/5 font-Cairo underline-offset-8 italic whitespace-nowrap inline-flex items-center justify-center">💸</span>
                    {{ __('تفاصيل تسوية أرباح المزود') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[13px] font-black mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start opacity-60">
                <span>{{ __('تصفية السيولة') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('الميزانية الصادرة') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary opacity-100">{{ __('مرجع التسوية') }} #{{ str_pad($withdrawal->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <div class="flex items-center gap-4 text-start font-Cairo">
            <span class="px-8 py-3 rounded-2xl text-[13px] font-black uppercase tracking-[0.2em] font-Cairo shadow-xl @if($withdrawal->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 shadow-amber-500/5 @elseif($withdrawal->status == 'approved') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-emerald-500/5 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 shadow-rose-500/5 @endif font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                STATUS: {{ strtoupper($withdrawal->status) }}
            </span>
        </div>
    </div>

    <!-- Settlement Details -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo">
        <!-- Main Content -->
        <div class="lg:col-span-8 space-y-12 text-start font-Cairo">
            <!-- Financial Claim Data -->
            <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60 font-Cairo"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-emerald-600 rounded-full shadow-lg shadow-emerald-600/30 font-Cairo"></span>
                    <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('بيانات طلب السحب') }}</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-14 text-start font-Cairo">
                    <!-- Net Amount -->
                    <div class="space-y-6 text-start font-Cairo">
                        <label class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                            <span class="w-2 h-2 bg-rose-500 rounded-full shadow-sm"></span>
                            {{ __('المبلغ الصافي واجب التصفية') }}
                        </label>
                        <div class="flex items-baseline gap-4 p-8 bg-[var(--main-bg)] rounded-[2.5rem] border border-[var(--glass-border)] shadow-inner text-start italic font-mono">
                            <span class="text-5xl font-black text-rose-600 dark:text-rose-400 tracking-tighter text-start">{{ number_format($withdrawal->amount, 0) }}</span>
                            <span class="text-xs font-black uppercase tracking-[0.2em] font-Cairo italic text-start opacity-60">{{ __('ريال يمني') }}</span>
                        </div>
                    </div>

                    <!-- Submission Chronology -->
                    <div class="space-y-6 text-start font-Cairo">
                        <label class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                            <span class="w-2 h-2 bg-indigo-500 rounded-full shadow-sm font-Cairo"></span>
                            {{ __('تاريخ استلام حزمة المتطلبات') }}
                        </label>
                        <div class="p-8 bg-[var(--main-bg)] rounded-[2.5rem] border border-[var(--glass-border)] shadow-inner text-start font-mono italic">
                             <div class="flex flex-col gap-2 text-start font-Cairo">
                                 <span class="text-xl font-black text-start italic">{{ $withdrawal->created_at->format('Y-m-d') }}</span>
                                 <span class="text-[13px] font-black uppercase tracking-widest text-start font-Cairo opacity-60">{{ $withdrawal->created_at->format('H:i:s A - T') }}</span>
                             </div>
                        </div>
                    </div>
                </div>

                @if($withdrawal->status == 'pending')
                    <div class="pt-14 border-t border-[var(--glass-border)] text-start font-Cairo">
                        <div class="mb-12 p-10 bg-amber-500/[0.03] dark:bg-amber-500/[0.05] rounded-[3.5rem] border-2 border-dashed border-amber-500/20 text-start relative ov <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                                <span class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-600 text-xl font-Cairo whitespace-nowrap inline-flex items-center justify-center">⚡</span>
                                <h5 class="text-xs font-black text-amber-600 uppercase tracking-[0.3em] font-Cairo text-start font-Cairo italic">{{ __('إثبات عملية التحويل الخارجي') }}</h5>
                            </div>
                            <p class="text-[14px] font-bold font-Cairo leading-[1.8] mb-0 text-start italic font-Cairo opacity-60">
                                {{ __('يرجى مراجعة {{ __('بيانات"الآيبان" للمزود بدقة. عند إتمام الحوالة، يجب إرفاق مستند الإثبات المالي الصادر من البنك مع رقم السند المرجعي لإغلاق ملف التسوية بشكل آمن.') }}') }}
                            </p>
{{ __('بيانات"الآيبان" للمزود بدقة. عند إتمام الحوالة، يجب إرفاق مستند الإثبات المالي الصادر من البنك مع رقم السند المرجعي لإغلاق ملف التسوية بشكل آمن.') }}') }}
                            </p>
                        </div>
                        
                        <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" enctype="multipart/form-data" class="space-y-12 text-start font-Cairo">
                            @csrf
                            @method('PATCH')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo">
                                <div class="space-y-4 text-start font-Cairo">
                                    <label class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                                        <span class="w-2 h-2 bg-indigo-600 rounded-full font-Cairo"></span>
                                        {{ __('رقم السند البنكي الصادر') }}
                                    </label>
                                    <input type="text" name="bond_number" required placeholder="REFERENCE_CODE_00X" class="w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-[15px] focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-mono tracking-widest text-start italic shadow-inner">
                                </div>

                                <div class="space-y-4 text-start font-Cairo">
                                    <label class="flex items-center gap-3 text-[13px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo opacity-60">
                                        <span class="w-2 h-2 bg-emerald-600 rounded-full font-Cairo"></span>
                                        {{ __('مستند الإثبات المالي') }} (IMAGE/PDF)
                                    </label>
                                    <div class="relative group text-start font-Cairo">
                                        <input type="file" name="bond_image" required accept="image/*" class="w-full px-10 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2rem] text-[13px] font-black outline-none cursor-pointer file:hidden text-[var(--text-muted)] focus:border-emerald-500 transition-all font-Cairo text-start italic shadow-inner">
                                        <div class="absolute left-8 top-1/2 -translate-y-1/2 pointer-events-none text-[var(--text-muted)] font-Cairo">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-8 flex flex-col sm:flex-row gap-8 text-start font-Cairo">
                                <button type="button" 
                                    onclick="confirmAction('approve-withdrawal-{{ $withdrawal->id }}', {
                                        title: '{{ __('مصادقة تصفية السيولة') }}',
                                        text: '{{ __('هل أنت متأكد من اعتماد هذه الحوالة؟ سيتم خصم المبلغ من ميزانية المنصة وتأكيد الاستلام للمزود.') }}',
                                        icon: 'success',
                                        confirmButtonText: '{{ __('تأكيد الصرف المالي') }}'
                                    })" class="flex-[3] px-12 py-7 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-[2.5rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-[0_25px_50px_-15px_rgba(16,185,129,0.4)] hover:scale-[1.03] transition-all duration-500 font-Cairo flex items-center justify-center gap-5 text-start font-Cairo">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ __('اعتماد الحوالة وتصفية الاستحقاق') }}
                                </button>
                                <button type="button" class="flex-1 px-10 py-7 bg-rose-500/5 text-rose-600 border border-rose-500/20 rounded-[2.5rem] text-[14px] font-black uppercase tracking-[0.3em] hover:bg-rose-600 hover:text-white transition-all duration-500 font-Cairo flex items-center justify-center gap-4 text-start shadow-sm font-Cairo" onclick="document.getElementById('reject-form').classList.toggle('hidden')">
                                    <svg class="w-5 h-5 font-black uppercase" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    {{ __('تعليق الصرف') }}
                                </button>
                            </div>
                        </form>
                        <form id="approve-withdrawal-{{ $withdrawal->id }}" action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" enctype="multipart/form-data" class="hidden">
                            @csrf
                            @method('PATCH')
                        </form>
 
                        <!-- Enhanced Rejection Interface -->
                        <div id="reject-form" class="mt-12 p-12 bg-rose-50 dark:bg-rose-950/10 border-2 border-rose-500/20 rounded-[4rem] hidden animate-fade-in text-start font-Cairo">
                            <form id="reject-withdrawal-{{ $withdrawal->id }}" action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST" class="space-y-8 text-start font-Cairo">
                                @csrf
                                @method('PATCH')
                                <div class="space-y-4 text-start font-Cairo">
                                    <label class="flex items-center gap-3 text-[13px] font-black text-rose-500 uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo">
                                        <span class="w-2 h-2 bg-rose-500 rounded-full font-Cairo"></span>
                                        {{ __('صياغة مسوغات تعليق الصرف المالي') }}
                                    </label>
                                    <textarea name="admin_note" rows="4" required placeholder="{{ __('توضيح النواقص أو أسباب الرفض الفني...') }}" class="w-full px-10 py-8 bg-[var(--glass-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-rose-500 focus:ring-[20px] focus:ring-rose-500/5 transition-all text-[var(--main-text)] font-Cairo shadow-inner italic text-start"></textarea>
                                </div>
                                <div class="flex gap-6 text-start font-Cairo">
                                    <button type="button" 
                                        onclick="confirmAction('reject-withdrawal-{{ $withdrawal->id }}', {
                                            title: '{{ __('إيقاف عملية الصرف') }}',
                                            text: '{{ __('هل أنت متأكد من تجميد هذا الطلب؟ سيتم إخطار المزود بالأسباب المذكورة.') }}',
                                            icon: 'error',
                                            confirmButtonText: '{{ __('تأكيد التجميد') }}'
                                        })" class="flex-1 bg-rose-600 text-white py-6 rounded-[2rem] text-[14px] font-black uppercase tracking-[0.3em] shadow-xl shadow-rose-600/20 hover:scale-[1.02] transition-all font-Cairo text-start">{{ __('تجميد المطالبة نهائياً') }}</button>
                                    <button type="button" class="px-12 py-6 bg-slate-200 text-[var(--text-muted)] rounded-[2rem] text-[14px] font-black uppercase tracking-[0.2em] font-Cairo text-start" onclick="document.getElementById('reject-form').classList.add('hidden')">{{ __('إلغاء المعارضة') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Final Settlement Reveal State -->
                    <div class="mt-14 p-14 bg-[var(--main-bg)] rounded-[4.5rem] border border-[var(--glass-border)] shadow-inner text-start font-Cairo">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-10 mb-14 text-start font-Cairo">
                            <div class="flex items-center gap-6 text-start font-Cairo">
                                <span class="text-[13px] font-black uppercase tracking-[0.3em] font-Cairo text-start opacity-60">{{ __('الحالة النهائية للطلب') }}</span>
                                @if($withdrawal->status == 'approved')
                                    <span class="px-10 py-4 bg-emerald-500/10 text-emerald-600 rounded-[2.5rem] text-[14px] font-black border border-emerald-500/20 shadow-xl shadow-emerald-500/10 font-Cairo italic text-start">{{ __('تمت التصفية البنكية بنجاح') }} ✓</span>
                                @else
                                    <span class="px-10 py-4 bg-rose-500/10 text-rose-600 rounded-[2.5rem] text-[14px] font-black border border-rose-500/20 shadow-xl shadow-rose-500/5 font-Cairo italic text-start">{{ __('المطالبة مجمدة إدارياً') }} 🚫</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-4 text-start font-Cairo">
                                <span class="text-[13px] font-black font-Cairo uppercase tracking-widest text-start italic opacity-60">{{ __('المصادق') }}:</span>
                                <span class="text-xs font-black dark:text-emerald-500 font-Cairo underline decoration-emerald-500 decoration-[3px] underline-offset-8 italic text-start font-Cairo">{{ $withdrawal->admin->name ?? __('محقق الميزانية') }}</span>
                            </div>
                        </div>
                        
                        @if($withdrawal->status == 'approved')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-14 items-start text-start font-Cairo">
                                <div class="space-y-10 text-start font-Cairo">
                                    <div class="space-y-4 text-start font-Cairo">
                                        <span class="text-[13px] font-black uppercase tracking-[0.3em] font-Cairo text-start italic opacity-60">{{ __('المرجع المالي للتحويل') }}</span>
                                        <code class="text-lg font-black text-brand-primary block px-6 py-4 bg-brand-primary/5 rounded-2xl border border-brand-primary/10 tracking-[0.2em] font-mono italic text-start font-Cairo shadow-sm">{{ $withdrawal->bond_number }}</code>
                                    </div>
                                    @if($withdrawal->admin_note)
                                        <div class="space-y-4 text-start font-Cairo">
                                            <span class="text-[13px] font-black uppercase tracking-[0.3em] font-Cairo text-start italic font-Cairo opacity-60">{{ __('إفادة المصادقة النهائية') }}</span>
                                            <div class="bg-[var(--glass-bg)] p-8 rounded-[2.5rem] border border-[var(--glass-border)] shadow-sm text-start italic">
                                                <p class="text-sm font-black font-Cairo leading-relaxed text-start opacity-70">" {{ $withdrawal->admin_note }}"</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="space-y-6 text-start font-Cairo group">
                                    <span class="text-[13px] font-black uppercase tracking-[0.3em] font-Cairo block text-start italic opacity-60">{{ __('أرشيف إثبات الحوالة') }}</span>
                                    <div class="relative rounded-[3rem] overflow-hidden border-8 border-[var(--glass-border)] shadow-2xl text-start font-Cairo bg-slate-950">
                                        <a href="{{ asset('storage/' . $withdrawal->bond_image) }}" target="_blank" class="block text-start font-Cairo">
                                            <img src="{{ asset('storage/' . $withdrawal->bond_image) }}" alt="Digital Evidence" class="w-full h-auto object-cover transform group-hover:scale-110 transition-transform duration-1000 opacity-90 group-hover:opacity-100">
                                            <div class="absolute inset-0 bg-emerald-600/30 opacity-0 group-hover:opacity-100 transition-all duration-700 backdrop-blur-sm flex items-center justify-center font-Cairo">
                                                <div class="bg-[var(--glass-bg)] text-[var(--main-text)] px-8 py-4 rounded-2xl text-[14px] font-black shadow-3xl font-Cairo rotate-3">{{ __('تحليل السند') }} 🔎</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="space-y-6 bg-rose-500/[0.03] p-12 rounded-[3.5rem] border border-rose-500/10 text-start font-Cairo italic shadow-inner">
                                <span class="text-[13px] font-black text-rose-500 uppercase tracking-[0.3em] block font-Cairo text-start opacity-60">{{ __('مسببات تجميد المطالبة المالية') }}:</span>
                                <p class="text-xl font-bold font-Cairo leading-[1.8] text-start font-Cairo opacity-70">" {{ $withdrawal->admin_note }}"</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Provider Insights Sidebar -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <!-- Provider Profile -->
            <div class="card-premium glass-panel p-10 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 left-0 w-32 h-32 bg-brand-secondary/[0.04] rounded-br-[6rem] -ml-10 -mt-10 font-Cairo"></div>
                <h4 class="font-black text-[13px] uppercase tracking-[0.3em] mb-10 px-4 font-Cairo text-start opacity-60">👤 {{ __('بيانات المزود') }}</h4>
                <div class="flex items-center gap-6 mb-12 text-start font-Cairo">
                    <div class="w-20 h-20 bg-slate-950 text-white rounded-[2rem] flex items-center justify-center text-3xl font-black shadow-2xl font-Cairo italic font-mono">
                        {{ mb_substr($withdrawal->user->name ?? 'P', 0, 1) }}
                    </div>
                    <div class="flex flex-col text-start font-Cairo">
                        <span class="text-xl font-black font-Cairo leading-tight text-start italic">{{ $withdrawal->user->name ?? __('مزود مفقود') }}</span>
                        <span class="text-[13px] font-bold font-mono mt-2 text-start italic opacity-60">{{ $withdrawal->user->email ?? 'no-email-anchor' }}</span>
                    </div>
                </div>
                
                <div class="space-y-4 p-8 bg-[var(--main-bg)] rounded-[2.5rem] border border-[var(--glass-border)] shadow-inner text-start font-Cairo">
                    <span class="text-[12px] font-black uppercase tracking-[0.3em] block font-Cairo text-start italic opacity-60">{{ __('رصيد الأرباح المحجوز حالياً') }}</span>
                    <div class="flex items-baseline gap-3 text-start font-Cairo font-mono">
                        <span class="text-4xl font-black text-emerald-600 italic text-start">{{ number_format($withdrawal->user->paid_points ?? 0, 0) }}</span>
                        <span class="text-xs font-black tracking-widest text-start font-Cairo opacity-60">YER</span>
                    </div>
                </div>
            </div>

            <!-- Safety Alert -->
            <div class="card-premium bg-gradient-to-br from-amber-500 to-amber-600 text-white p-12 rounded-[4.5rem] shadow-[0_40px_80px_-20px_rgba(245,158,11,0.4)] relative overflow-hidden group text-start font-Cairo">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-[var(--glass-bg)]/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000 font-Cairo"></div>
                <div class="relative z-10 font-Cairo">
                    <h4 class="font-black text-white text-[14px] uppercase tracking-[0.4em] mb-6 flex items-center gap-4 font-Cairo text-start">
                        <div class="w-10 h-10 bg-[var(--glass-bg)]/20 rounded-xl flex items-center justify-center font-Cairo">
                            <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        {{ __('إرشادات السلامة المالية') }}
                    </h4>
                    <p class="text-[14px] leading-[2] font-black text-white/95 font-Cairo text-start italic">
                        {{ __('يُمنع قاطعاً اعتماد صرف أي سيولة دون التثبت من صحة مستند الحوالة المرفق. قرار التصفية FINAL_DECENTRALIZED وغير قابل للتراجع. يرجى مطابقة بيانات الطرف الثاني بالدقة المطلقة.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
