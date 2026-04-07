@extends('layouts.admin')

@section('title', __('مراجعة طلب التوثيق'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header & Action Buttons -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-10 text-start font-Cairo">
        <div class="text-start font-Cairo">
            <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                <a href="{{ route('user-verification-packages.index') }}" class="w-14 h-14 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-[1.2rem] flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-800 font-Cairo">
                    <svg class="w-6 h-6 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl text-slate-800 dark:text-white flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-brand-primary/10 rounded-[1.2rem] flex items-center justify-center text-brand-primary text-2xl font-Cairo shadow-lg shadow-brand-primary/5 font-Cairo">💎</span>
                    {{ __('تفاصيل طلب اشتراك التوثيق') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[10px] font-black text-slate-500 mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('نظام التوثيق') }}</span>
                <svg class="w-2 h-2 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('مراجعة السند المالي') }}</span>
                <svg class="w-2 h-2 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary">{{ __('رقم الطلب') }} #{{ str_pad($userPackage->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        @if($userPackage->status === \App\constant\BondStatus::PENDING)
            <div class="flex items-center gap-5 text-start font-Cairo">
                <form id="approve-form-{{ $userPackage->id }}" action="{{ route('user-verification-packages.approve', $userPackage->id) }}" method="POST" class="font-Cairo">
                    @csrf
                    @method('PATCH')
                    <button type="button" 
                        onclick="confirmAction('approve-form-{{ $userPackage->id }}', {
                            title: '{{ __('قبول طلب الاشتراك') }}',
                            text: '{{ __('هل أنت متأكد من صحة السند المالي وتريد تفعيل التوثيق لهذا المستخدم؟') }}',
                            icon: 'success',
                            confirmButtonText: '{{ __('تأكيد التفعيل الآن') }}'
                        })"
                        class="px-10 py-5 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-[1.2rem] text-[11px] font-black uppercase tracking-[0.2em] shadow-xl shadow-emerald-600/20 hover:scale-[1.05] active:scale-95 transition-all font-Cairo flex items-center gap-3 text-start font-Cairo">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        {{ __('قبول الطلب') }}
                    </button>
                </form>
                <form id="reject-form-{{ $userPackage->id }}" action="{{ route('user-verification-packages.reject', $userPackage->id) }}" method="POST" class="font-Cairo">
                    @csrf
                    @method('PATCH')
                    <button type="button" 
                        onclick="confirmAction('reject-form-{{ $userPackage->id }}', {
                            title: '{{ __('رفض طلب الاشتراك') }}',
                            text: '{{ __('هل أنت متأكد من رفض هذا الطلب؟ يرجى التأكد من عدم صحة البيانات المرسلة قبل الرفض.') }}',
                            icon: 'warning',
                            isDanger: true,
                            confirmButtonText: '{{ __('تأكيد الرفض النهائي') }}'
                        })"
                        class="px-10 py-5 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-[1.2rem] text-[11px] font-black uppercase tracking-[0.2em] hover:bg-rose-600 hover:text-white transition-all duration-500 font-Cairo flex items-center gap-3 text-start font-Cairo">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        {{ __('رفض الطلب') }}
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Request Information -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 font-Cairo text-start">
        <!-- Main Details Column -->
        <div class="lg:col-span-8 space-y-12 text-start font-Cairo">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo">
                <!-- User Information -->
                <div class="card-premium glass-panel p-12 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
                    <div class="absolute top-0 left-0 w-32 h-32 bg-indigo-500/[0.04] rounded-br-[8rem] -ml-16 -mt-16 font-Cairo"></div>
                    <div class="flex items-center gap-4 mb-12 text-start font-Cairo">
                        <span class="w-3 h-10 bg-indigo-600 rounded-full shadow-lg shadow-indigo-600/30 font-Cairo"></span>
                        <h4 class="text-xl font-black text-slate-800 dark:text-white font-Cairo text-start italic">{{ __('معلومات مقدم الطلب') }}</h4>
                    </div>
                    <div class="space-y-10 relative z-10 text-start font-Cairo">
                        <div class="flex items-center gap-6 group font-Cairo">
                            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-950 text-indigo-500 rounded-[1.2rem] flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform font-Cairo italic">👤</div>
                            <div class="flex flex-col text-start font-Cairo">
                                <span class="text-[10px] font-black text-slate-500 mb-2 font-Cairo text-start">{{ __('الاسم الكامل') }}</span>
                                <span class="text-sm font-black text-slate-800 dark:text-white font-Cairo text-start">{{ $userPackage->user->name ?? __('مستخدم غير معروف') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 group text-start font-Cairo">
                            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-950 text-purple-500 rounded-[1.2rem] flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform font-Cairo italic">📧</div>
                            <div class="flex flex-col text-start font-Cairo">
                                <span class="text-[10px] font-black text-slate-500 mb-2 font-Cairo text-start">{{ __('البريد الإلكتروني') }}</span>
                                <span class="text-sm font-black text-slate-800 dark:text-white font-mono tracking-widest text-start font-Cairo">{{ $userPackage->user->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Package Information -->
                <div class="card-premium glass-panel p-12 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo shadow-indigo-500/5">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-primary/[0.04] rounded-bl-[8rem] -mr-16 -mt-16 font-Cairo"></div>
                    <div class="flex items-center gap-4 mb-12 text-start font-Cairo">
                        <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30 font-Cairo"></span>
                        <h4 class="text-xl font-black text-slate-800 dark:text-white font-Cairo text-start italic">{{ __('الباقة المطلوبة') }}</h4>
                    </div>
                    <div class="space-y-10 relative z-10 text-start font-Cairo">
                        <div class="flex items-center gap-6 group font-Cairo">
                            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-950 text-brand-primary rounded-[1.2rem] flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform font-Cairo italic">🏷️</div>
                            <div class="flex flex-col text-start font-Cairo">
                                <span class="text-[10px] font-black text-slate-500 mb-2 font-Cairo text-start">{{ __('اسم الباقة') }}</span>
                                <span class="text-sm font-black text-brand-primary font-Cairo text-start">{{ $userPackage->verificationPackage->name ?? __('باقة ملغاة') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 group text-start font-Cairo">
                            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-950 text-emerald-500 rounded-[1.2rem] flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform font-Cairo italic">💰</div>
                            <div class="flex flex-col text-start font-Cairo">
                                <span class="text-[10px] font-black text-slate-500 mb-2 font-Cairo text-start">{{ __('سعر الباقة') }}</span>
                                <span class="text-sm font-black text-emerald-600 font-mono text-start font-Cairo">{{ $userPackage->verificationPackage ? number_format($userPackage->verificationPackage->price, 0) . ' ' . __('ريال') : '--' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="card-premium glass-panel p-14 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo shadow-emerald-500/5">
                <div class="flex items-center justify-between mb-14 text-start font-Cairo">
                    <div class="flex items-center gap-5 text-start font-Cairo">
                        <span class="w-3 h-10 bg-slate-900 dark:bg-white rounded-full shadow-lg font-Cairo"></span>
                        <h4 class="text-2xl font-black text-slate-800 dark:text-white font-Cairo text-start italic">{{ __('بيانات الدفع وسند التحويل') }}</h4>
                    </div>
                    @php
                        $statusColor = match($userPackage->status) {
                            \App\constant\BondStatus::PENDING => 'bg-amber-500/10 text-amber-600 border-amber-500/20',
                            \App\constant\BondStatus::APPROVED => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
                            \App\constant\BondStatus::REJECTED => 'bg-rose-500/10 text-rose-600 border-rose-500/20',
                            default => 'bg-slate-500/10 text-slate-600 border-slate-500/20'
                        };
                        $statusLabel = match($userPackage->status) {
                            \App\constant\BondStatus::PENDING => __('قيد الانتظار'),
                            \App\constant\BondStatus::APPROVED => __('مقبول'),
                            \App\constant\BondStatus::REJECTED => __('مرفوض'),
                            default => $userPackage->status
                        };
                    @endphp
                    <span class="px-8 py-3 rounded-[2rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-sm border {{ $statusColor }} font-Cairo text-start">
                        {{ $statusLabel }}
                    </span>
                </div>

                <div class="p-12 bg-slate-50/50 dark:bg-slate-950/40 rounded-[1.5rem] border border-slate-100 dark:border-slate-800/80 shadow-inner flex flex-col md:flex-row items-center gap-14 text-start font-Cairo shadow-brand-primary/5">
                    <div class="flex flex-col items-center gap-3 text-start font-Cairo">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.4em] font-Cairo text-start">{{ __('رقم السند') }}</span>
                        <span class="text-3xl font-black text-brand-primary tracking-[0.2em] font-mono text-start font-Cairo">#{{ $userPackage->number_bond }}</span>
                    </div>
                    <div class="hidden md:block w-px h-24 bg-gradient-to-b from-transparent via-slate-200 dark:via-slate-800 to-transparent font-Cairo"></div>
                    <div class="flex-1 text-center md:text-start space-y-4 font-Cairo">
                        @if($userPackage->admin)
                            <div class="flex flex-col gap-2 font-Cairo">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('تمت المراجعة بواسطة') }}</span>
                                <span class="text-lg font-black text-slate-800 dark:text-slate-200 font-Cairo text-start">👤 {{ $userPackage->admin->name }}</span>
                            </div>
                        @else
                            <div class="flex flex-col gap-2 animate-pulse text-start font-Cairo font-Cairo">
                                <span class="text-[10px] font-black text-amber-500 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('بانتظار المراجعة') }}</span>
                                <span class="text-base font-black text-amber-600 font-Cairo text-start">⏳ {{ __('الطلب بانتظار المراجعة الإدارية') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Attachment -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <div class="card-premium glass-panel p-10 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-500/[0.04] rounded-tr-[8rem] -ml-16 -mb-16 font-Cairo"></div>
                
                <h4 class="font-black text-slate-500 text-[10px] uppercase tracking-[0.3em] mb-12 px-6 font-Cairo text-start">📸 {{ __('صورة السند المالي') }}</h4>
                
                @if($userPackage->image_bond)
                    <div class="group relative font-Cairo">
                        <div class="w-full aspect-[3/4] rounded-[1.5rem] overflow-hidden bg-slate-900 border-8 border-white dark:border-slate-950 shadow-[0_45px_90px_-20px_rgba(0,0,0,0.4)] transition-all duration-1000 group-hover:scale-[1.03] group-hover:rotate-2 font-Cairo shadow-emerald-500/5">
                            <img src="{{ asset('storage/' . $userPackage->image_bond) }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100" alt="{{ __('سند الدفع') }}">
                            <div class="absolute inset-0 bg-brand-primary/40 opacity-0 group-hover:opacity-100 transition-all duration-700 flex items-center justify-center backdrop-blur-md">
                                <a href="{{ asset('storage/' . $userPackage->image_bond) }}" target="_blank" class="px-10 py-5 bg-white text-brand-dark rounded-[1.2rem] text-[11px] font-black uppercase tracking-[0.2em] shadow-2xl transform translate-y-10 group-hover:translate-y-0 transition-all duration-700 font-Cairo">{{ __('عرض صورة السند') }}</a>
                            </div>
                        </div>
                        <div class="mt-8 flex items-center justify-center gap-3 text-start font-Cairo">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse font-Cairo"></span>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('تم رفع الصورة بواسطة المستخدم.') }}</span>
                        </div>
                    </div>
                @else
                    <div class="w-full aspect-[3/4] rounded-[1.5rem] border-8 border-dashed border-slate-100 dark:border-slate-900 flex flex-col items-center justify-center bg-slate-50/50 dark:bg-slate-950/40 gap-8 shadow-inner font-Cairo">
                        <div class="w-24 h-24 bg-white/50 dark:bg-white/5 rounded-3xl flex items-center justify-center shadow-inner font-Cairo">
                            <svg class="w-12 h-12 text-slate-300 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a1 1 0 011.414 0L15 16m-6-6h.01M4 21h16a2 2 0 002-2V5a2 2 0 00-2-2H4a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex flex-col gap-2 font-Cairo">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] text-center font-Cairo">{{ __('لا يوجد مرفق') }}</span>
                            <span class="text-[11px] font-bold text-rose-500/60 font-Cairo text-center">{{ __('لا توجد صورة للسند مرفقة مع هذا الطلب.') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Administrative Remarks -->
            <div class="card-premium bg-slate-950 text-white p-12 rounded-[2rem] shadow-xl relative overflow-hidden group text-start font-Cairo font-Cairo">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000 font-Cairo"></div>
                <div class="relative z-10 font-Cairo text-start">
                    <h4 class="font-black text-white text-[11px] uppercase tracking-[0.4em] mb-6 flex items-center gap-4 font-Cairo text-start">
                        <span class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-indigo-400 font-Cairo">⚖️</span>
                        {{ __('ملاحظات إدارية هامة') }}
                    </h4>
                    <p class="text-[11px] leading-[2.2] font-black text-white/50 font-Cairo text-start italic">
                        {{ __('يرجى التأكد من وصول المبلغ المالي إلى الحساب المصرفي قبل اتخاذ قرار القبول. جميع قرارات القبول والرفض يتم تسجيلها في النظام ولا يمكن التراجع عنها.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
