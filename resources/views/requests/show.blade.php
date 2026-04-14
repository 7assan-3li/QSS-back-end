@extends('layouts.admin')

@section('title', __('تفاصيل الطلب #') . $request->id)

@section('content')
<div class="max-w-6xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl text-[var(--main-text)] flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5 whitespace-nowrap inline-flex items-center justify-center">📄</span>
                {{ __('بيانات الطلب والتقرير المالي') }}
            </h3>
            <div class="flex items-center gap-3 text-[13px] font-black text-[var(--text-muted)] mt-3 mr-20 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('سجل المدفوعات') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('متابعة العمولات') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary">{{ __('رقم المعاملة') }} #{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
             <span class="px-6 py-2.5 rounded-2xl text-[13px] font-black uppercase tracking-[0.1em] font-Cairo @if($request->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 @elseif($request->status == 'completed') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 @elseif($request->status == 'canceled') bg-rose-500/10 text-rose-600 border border-rose-500/20 @else bg-[var(--glass-bg)] text-[var(--text-secondary)] border border-[var(--glass-border)] @endif whitespace-nowrap inline-flex items-center justify-center">
                {{ __('حالة الطلب') }}: {{ __($request->status) }}
            </span>
            <a href="{{ route('requests.index') }}" class="w-12 h-12 flex items-center justify-center bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl hover:text-brand-primary transition-all shadow-sm">
                <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
        </div>
    </div>

    <!-- Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 text-start">
        <!-- Main Request Analysis Space -->
        <div class="lg:col-span-2 space-y-12 text-start">
            <!-- Information Matrix Card -->
            <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] relative border border-[var(--glass-border)] text-start font-Cairo">
                <div class="flex items-center gap-4 mb-14 text-start">
                    <span class="w-2.5 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30"></span>
                    <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start">{{ __('المعلومات الأساسية للطلب') }}</h4>
                </div>
 beach_access                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-12 gap-x-10 text-start">
                    <div class="flex items-center gap-5 group text-start">
                        <div class="w-14 h-14 bg-indigo-500/10 text-indigo-600 rounded-[1.3rem] flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm font-Cairo">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-2 font-Cairo text-start">{{ __('صاحب الطلب (العميل)') }}</span>
                            <span class="text-lg font-black text-[var(--main-text)] font-Cairo text-start">{{ $request->user->name }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-5 group text-start">
                        <div class="w-14 h-14 bg-emerald-500/10 text-emerald-600 rounded-[1.3rem] flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm font-Cairo">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-2 font-Cairo text-start">{{ __('وقت إنشاء المعاملة') }}</span>
                            <span class="text-lg font-black text-[var(--main-text)] font-mono text-start">{{ $request->created_at->format('Y/m/d - H:i') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-5 group text-start">
                        <div class="w-14 h-14 bg-amber-500/10 text-amber-600 rounded-[1.3rem] flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm font-Cairo">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V15"></path></svg>
                        </div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-2 font-Cairo text-start">{{ __('إجمالي قيمة الخدمات') }}</span>
                            <div class="flex items-baseline gap-1 text-start">
                                <span class="text-2xl font-black text-[var(--main-text)] font-mono text-start">{{ number_format($request->total_price, 2) }}</span>
                                <span class="text-[13px] font-black text-[var(--text-muted)] font-Cairo text-start">YER</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-5 group text-start">
                        <div class="w-14 h-14 bg-brand-primary/10 text-brand-primary rounded-[1.3rem] flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-sm font-Cairo">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div class="flex flex-col text-start">
                            <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-2 font-Cairo text-start">{{ __('عمولة المنصة (10%)') }}</span>
                             <div class="flex items-baseline gap-1 text-start">
                                <span class="text-2xl font-black text-brand-primary font-mono text-start">{{ number_format($request->total_price * 0.10, 2) }}</span>
                                <span class="text-[13px] font-black text-[var(--text-muted)] font-Cairo text-start">YER</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-14 pt-10 border-t border-[var(--glass-border)] text-start">
                    <div class="inline-flex items-center gap-4 px-6 py-3 rounded-2xl text-[14px] font-black uppercase tracking-[0.1em] font-Cairo text-start @if ($request->commission_paid) bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 animate-pulse @endif text-start">
                        <span class="w-3 h-3 rounded-full @if($request->commission_paid) bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.5)] @else bg-rose-500 shadow-[0_0_15px_rgba(244,63,94,0.5)] @endif"></span>
                        {{ __('حالة سداد العمولة: ') }}{{ $request->commission_paid ? __('تم الاستلام بنجاح') : __('بانتظار التحصيل المالي') }}
                    </div>
                </div>
            </div>

            <!-- Asset manifestation Matrix (Services) -->
            <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/[0.03] to-transparent pointer-events-none"></div>
                <div class="flex items-center gap-4 mb-12 text-start">
                    <span class="w-2.5 h-10 bg-indigo-600 rounded-full shadow-lg shadow-indigo-600/30"></span>
                    <h4 class="text-2xl font-black text-[var(--main-text)] font-Cairo text-start">{{ __('تفاصيل الخدمات المطلوبة') }}</h4>
                </div>
 beach_access
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-start">
                    @foreach ($request->services as $service)
                        <div class="flex flex-col gap-6 p-8 bg-[var(--glass-bg)]/40 rounded-[2.5rem] border border-[var(--glass-border)] hover:bg-[var(--glass-bg)] dark:hover:bg-[var(--glass-border)] text-white transition-all duration-500 group shadow-sm text-start">
                            <div class="flex items-center gap-5 text-start">
                                <div class="w-12 h-12 bg-[var(--glass-bg)] rounded-2xl flex items-center justify-center text-[var(--text-muted)] group-hover:text-brand-primary group-hover:scale-110 transition-all shadow-inner font-Cairo">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                                </div>
                                <div class="flex flex-col text-start">
                                    <h5 class="font-black text-[var(--main-text)] text-base font-Cairo text-start">{{ $service->name }}</h5>
                                    <div class="flex items-center gap-3 mt-2 text-start">
                                        @if ($service->pivot->is_main)
                                            <span class="text-[14px] font-black bg-indigo-500 text-white px-2 py-1 rounded-lg uppercase tracking-widest font-Cairo whitespace-nowrap inline-flex items-center justify-center">{{ __('خدمة أساسية') }}</span>
                                        @endif
                                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-[var(--glass-border)] rounded-lg text-[12px] font-black text-[var(--text-muted)] lowercase font-Cairo whitespace-nowrap inline-flex items-center justify-center">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                            {{ __('الكمية المطلوبة') }}: {{ str_pad($service->pivot->quantity, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-6 border-t border-[var(--glass-border)] flex justify-between items-center text-start">
                                <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo text-start font-Cairo">{{ __('سعر الخدمة الفردي') }}</span>
                                <div class="flex items-baseline gap-1 text-start">
                                    <span class="text-xl font-black text-brand-primary font-mono text-start">{{ number_format($service->price, 2) }}</span>
                                    <span class="text-[14px] font-black text-[var(--text-muted)] font-Cairo text-start">YER</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Audit & Compliance Sidebar -->
        <div class="space-y-12 text-start">
            @if (!$request->commission_paid)
                <div class="card-premium glass-panel p-10 rounded-[3rem] shadow-2xl border border-rose-500/20 relative overflow-hidden group text-start font-Cairo">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-500/[0.05] to-transparent pointer-events-none animate-pulse"></div>
                    <div class="relative z-10 space-y-8 text-start">
                        <div class="flex items-center gap-4 text-start">
                            <div class="w-12 h-12 bg-rose-500/10 text-rose-600 rounded-2xl flex items-center justify-center shadow-lg shadow-rose-500/10 font-Cairo">
                                <svg class="w-6 h-6 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="font-black text-[var(--main-text)] text-lg font-Cairo text-start">{{ __('تأكيد استلام العمولة') }}</h4>
                        </div>
                        <p class="text-[14px] font-black text-[var(--text-muted)] leading-[1.8] font-Cairo text-start" dir="rtl">
                            ⚠️ تنبيه الإدارة: الضغط على الزر أدناه يعني أن المنصة قد استلمت مبلغ العمولة نقدياً أو بنكياً بشكل نهائي.
                        </p>
                        
                        <form id="mark-paid-form" action="{{ route('requests.markPaid', $request->id) }}" method="POST" class="text-start">
                            @csrf
                            @method('PATCH')
                            <button type="button" 
                                onclick="confirmCommissionPayment()" class="w-full py-5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-[1.5rem] text-[13px] font-black shadow-[0_20px_40px_-5px_rgba(16,185,129,0.3)] hover:scale-[1.05] transition-all font-Cairo flex items-center justify-center gap-3">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                {{ __('تأكيد استلام المبلغ وإغلاق الملف') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Audit Trail: Financial Bonds -->
            <div class="card-premium glass-panel p-10 rounded-[3rem] shadow-2xl border border-[var(--glass-border)] text-start font-Cairo">
                <div class="flex items-center gap-4 mb-10 text-start">
                    <span class="w-2 h-8 bg-slate-400 rounded-full shadow-sm"></span>
                    <h4 class="font-black text-[var(--main-text)] text-sm font-Cairo uppercase tracking-[0.2em] text-start">{{ __('سندات الدفع المرفقة') }}</h4>
                </div>

                @if ($request->commissionBonds->count())
                    <div class="space-y-10 text-start">
                        @foreach ($request->commissionBonds as $bond)
                            <div class="group/bond space-y-6 text-start font-Cairo">
                                <div class="relative aspect-video rounded-[2rem] overflow-hidden shadow-inner border border-[var(--glass-border)] group-hover/bond:shadow-xl transition-all duration-500 text-start">
                                    <img src="{{ asset('storage/' . $bond->image_path) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover/bond:scale-110">
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover/bond:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                        <a href="{{ asset('storage/' . $bond->image_path) }}" target="_blank" class="w-14 h-14 bg-[var(--glass-bg)]/20 rounded-full flex items-center justify-center text-white backdrop-blur-xl hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                        </a>
                                    </div>
                                </div>
                                <div class="space-y-3 px-2 text-start">
                                    <div class="flex justify-between items-center text-start">
                                        <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest font-Cairo text-start">{{ __('رقم الإيصال / السند') }}</span>
                                        <span class="text-[14px] font-black text-[var(--main-text)] font-mono text-start"># {{ $bond->bond_number ?? '—' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-start">
                                        <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest font-Cairo text-start">{{ __('حالة مراجعة السند') }}</span>
                                        <span class="px-4 py-1 rounded-full text-[12px] font-black uppercase tracking-tighter font-Cairo @if($bond->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 @elseif($bond->status == 'approved') bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 @else bg-rose-500/10 text-rose-600 border border-rose-500/20 @endif whitespace-nowrap inline-flex items-center justify-center">
                                            {{ __($bond->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                @if ($bond->status === 'pending')
                                    <div class="grid grid-cols-2 gap-4 pt-4 text-start font-Cairo">
                                        <form id="approve-bond-{{ $bond->id }}" action="{{ route('commission-bonds.approve', $bond) }}" method="POST" class="text-start">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" 
                                                onclick="confirmAction('approve-bond-{{ $bond->id }}', {
                                                    title: '{{ __('قبول السند المالي') }}',
                                                    text: '{{ __('هل تأكدت من صحة بيانات السند البنكي؟ سيتم اعتماد التحصيل المالي لهذا السجل.') }}',
                                                    icon: 'success',
                                                    confirmButtonText: '{{ __('تأكيد القبول') }}'
                                                })" class="w-full py-4 bg-emerald-500/10 text-emerald-600 rounded-[1.2rem] text-[12px] font-black hover:bg-emerald-500 hover:text-white transition-all font-Cairo shadow-sm">{{ __('موافقــــــــة') }}</button>
                                        </form>
                                        <form id="reject-bond-{{ $bond->id }}" action="{{ route('commission-bonds.reject', $bond) }}" method="POST" class="text-start">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" 
                                                onclick="confirmAction('reject-bond-{{ $bond->id }}', {
                                                    title: '{{ __('رفض السند المالي') }}',
                                                    text: '{{ __('هل أنت متأكد من عدم صحة هذا السند؟ سيتم إخطار الطرف الأخر بالرفض.') }}',
                                                    icon: 'error',
                                                    confirmButtonText: '{{ __('تأكيد الرفض') }}'
                                                })" class="w-full py-4 bg-rose-500/10 text-rose-600 rounded-[1.2rem] text-[12px] font-black hover:bg-rose-500 hover:text-white transition-all font-Cairo shadow-sm">{{ __('رفــــــــض') }}</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-16 text-center opacity-30 flex flex-col items-center justify-center text-start" dir="rtl">
                        <div class="w-16 h-16 bg-[var(--glass-border)] rounded-2xl flex items-center justify-center text-3xl mb-4 font-Cairo">🔕</div>
                        <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] font-Cairo text-start" dir="rtl">لا توجد سندات مرفقة</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function confirmCommissionPayment() {
            confirmAction('mark-paid-form', {
                title: '{{ __('تأكيد استلام العمولة') }}',
                text: '{{ __('هل تؤكد استلام مبلغ العمولة نقدياً أو بنكياً؟ سيتم تحديث حالة الطلب إلى -مدفوع- نهائياً.') }}',
                icon: 'warning',
                confirmButtonText: '{{ __('تأكيد التحصيل') }}'
            });
        }
    </script>
@endpush
