@extends('layouts.admin')

@section('title', __('تفاصيل طلب شحن الرصيد'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                <a href="{{ route('admin.user-points-packages.index') }}" class="w-14 h-14 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-800 font-Cairo">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl font-Cairo shadow-lg shadow-emerald-500/5 font-Cairo underline-offset-8 italic">📊</span>
                    {{ __('مراجعة طلب شحن النقاط') }}
                </h3>
            </div>
        <div class="flex items-center gap-3 text-[10px] font-black mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start opacity-60">
                <span>{{ __('اقتصاد المنصة') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('التحكم المالي') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary opacity-100">{{ __('رقم الطلب') }} #{{ str_pad($subscription->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        @php
            $statusColor = match($subscription->status) {
                'pending' => 'bg-amber-500/10 text-amber-600 border-amber-500/20 shadow-amber-500/5',
                'approved' => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20 shadow-emerald-500/5',
                'rejected' => 'bg-rose-500/10 text-rose-600 border-rose-500/20 shadow-rose-500/5',
                default => 'bg-slate-500/10 text-slate-600 border-slate-500/20'
            };
            $statusLabel = match($subscription->status) {
                'pending' => __('قيد الانتظار'),
                'approved' => __('مقبول'),
                'rejected' => __('مرفوض'),
                default => $subscription->status
            };
        @endphp

        <div class="flex items-center gap-4 text-start font-Cairo">
            <span class="px-8 py-3 rounded-[2rem] text-[10px] font-black uppercase tracking-[0.2em] font-Cairo text-start shadow-xl border {{ $statusColor }} font-Cairo">
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    <!-- Request Details -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo">
        <!-- Verification Section -->
        <div class="lg:col-span-8 space-y-12 text-start font-Cairo">
            <!-- Bank Transfer Data -->
            <div class="card-premium glass-panel p-14 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-primary/[0.03] rounded-bl-[4rem] -mr-20 -mt-20 blur-3xl opacity-60 font-Cairo"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/30 font-Cairo"></span>
                    <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('بيانات الحوالة البنكية') }}</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-14 text-start font-Cairo">
                    <!-- Bank Name -->
                    <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-white dark:border-white/5 flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-900 text-slate-500 rounded-[1.2rem] flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo italic">🏦</div>
                        <div class="flex flex-col text-start font-Cairo">
                            <span class="text-[9px] font-black uppercase tracking-[0.3em] mb-2 font-Cairo text-start opacity-60">{{ __('البنك المُحول منه') }}</span>
                            <span class="text-sm font-black font-Cairo text-start italic">{{ $subscription->bank_name }}</span>
                        </div>
                    </div>

                    <!-- Transfer Number -->
                    <div class="card-premium glass-panel p-8 rounded-[1.5rem] border border-white dark:border-white/5 flex items-center gap-6 group hover:scale-[1.03] transition-all shadow-sm text-start font-Cairo shadow-amber-500/5">
                        <div class="w-16 h-16 bg-amber-500/10 text-amber-600 rounded-[1.2rem] flex items-center justify-center text-2xl shadow-inner group-hover:rotate-6 transition-transform font-Cairo">🧾</div>
                        <div class="flex flex-col text-start font-Cairo">
                            <span class="text-[9px] font-black uppercase tracking-[0.3em] mb-2 font-Cairo text-start opacity-60">{{ __('رقم الحوالة / السند') }}</span>
                            <span class="text-sm font-black text-amber-600 dark:text-amber-400 font-mono tracking-widest text-start">#{{ $subscription->bond_number }}</span>
                        </div>
                    </div>
                </div>

                <!-- Transfer Bond Image -->
                <div class="space-y-6 mb-14 text-start font-Cairo">
                    <label class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">
                        <span class="w-2 h-2 bg-slate-400 rounded-full shadow-sm font-Cairo"></span>
                        {{ __('صورة سند التحويل') }}
                    </label>
                    <div class="relative group rounded-[2rem] overflow-hidden border-8 border-white dark:border-slate-900 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)] bg-slate-100 dark:bg-slate-950 font-Cairo">
                         <a href="{{ asset('storage/' . $subscription->bond_image) }}" target="_blank" class="block font-Cairo text-start">
                             <img src="{{ asset('storage/' . $subscription->bond_image) }}" alt="Bond Evidence" class="w-full h-auto object-cover transition-transform duration-1000 group-hover:scale-110 grayscale-[0.1] group-hover:grayscale-0">
                             <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-all duration-700 flex flex-col items-center justify-center p-12 backdrop-blur-md">
                                 <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-6 border border-white/30 animate-pulse font-Cairo">
                                     <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                 </div>
                                 <span class="text-white text-xs font-black uppercase tracking-[0.4em] font-Cairo shadow-lg">{{ __('عرض الصورة بالكامل') }}</span>
                             </div>
                         </a>
                    </div>
                </div>

                <!-- Actions -->
                @if($subscription->status == 'pending')
                    <div class="pt-14 border-t border-slate-100 dark:border-slate-800/50 text-start font-Cairo">
                        <div class="flex flex-col sm:flex-row gap-8 text-start font-Cairo">
                            <form id="approve-points-subscription-{{ $subscription->id }}" action="{{ route('admin.user-points-packages.approve', $subscription->id) }}" method="POST" class="flex-[3] text-start">
                                @csrf
                                @method('PATCH')
                                <button type="button" 
                                    onclick="confirmAction('approve-points-subscription-{{ $subscription->id }}', {
                                        title: '{{ __('تفعيل شحن النقاط') }}',
                                        text: '{{ __('تأكيد: هل أنت متأكد من صحة بيانات الحوالة وتفعيل الشحن للمستخدم؟') }}',
                                        icon: 'success',
                                        confirmButtonText: '{{ __('تأكيد الشحن الآن') }}'
                                    })"
                                    class="w-full py-7 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white rounded-[1.5rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-[0_20px_40px_-10px_rgba(16,185,129,0.4)] hover:scale-[1.03] active:scale-95 transition-all duration-500 font-Cairo flex items-center justify-center gap-5 text-start">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    {{ __('موافقة وتفعيل الشحن') }}
                                </button>
                            </form>
                            <button type="button" class="flex-1 px-10 py-7 bg-rose-500/5 text-rose-600 border border-rose-500/20 rounded-[1.5rem] text-[11px] font-black uppercase tracking-[0.3em] hover:bg-rose-600 hover:text-white transition-all duration-500 font-Cairo flex items-center justify-center gap-3 text-start" onclick="document.getElementById('reject-form').classList.toggle('hidden')">
                                <svg class="w-5 h-5 font-black uppercase" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                {{ __('رفض الطلب') }}
                            </button>
                        </div>

                        <!-- Enhanced Rejection Interface -->
                        <div id="reject-form" class="mt-10 p-12 bg-rose-50 dark:bg-rose-950/10 border-2 border-rose-500/20 rounded-[2rem] hidden animate-fade-in text-start font-Cairo">
                            <form action="{{ route('admin.user-points-packages.reject', $subscription->id) }}" method="POST" class="space-y-8 text-start font-Cairo">
                                @csrf
                                @method('PATCH')
                                <div class="space-y-4 text-start font-Cairo">
                                    <label class="flex items-center gap-3 text-[10px] font-black text-rose-500 uppercase tracking-[0.3em] px-3 font-Cairo text-start font-Cairo">
                                        <span class="w-2 h-2 bg-rose-500 rounded-full font-Cairo"></span>
                                        {{ __('سبب رفض الطلب') }}
                                    </label>
                                    <textarea name="admin_note" rows="4" required placeholder="{{ __('مثال: يرجى إرفاق نسخة أكثر وضوحاً من السند البنكي، أو التحقق من تطابق رقم العملية...') }}" 
                                              class="w-full px-10 py-8 bg-white dark:bg-slate-900 border-2 border-slate-100 dark:border-slate-800 rounded-[1.5rem] text-sm font-black outline-none focus:border-rose-500 focus:ring-[20px] focus:ring-rose-500/5 transition-all dark:text-white font-Cairo shadow-inner italic text-start"></textarea>
                                </div>
                                <div class="flex gap-6 text-start font-Cairo">
                                    <button type="submit" class="flex-1 bg-rose-600 text-white py-6 rounded-[1.2rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-xl shadow-rose-600/20 hover:scale-[1.02] transition-all font-Cairo text-start font-Cairo">{{ __('تأكيد الرفض النهائي') }}</button>
                                    <button type="button" class="px-12 py-6 bg-slate-200 dark:bg-slate-800 text-slate-500 rounded-[1.2rem] text-[11px] font-black uppercase tracking-[0.2em] font-Cairo text-start" onclick="document.getElementById('reject-form').classList.add('hidden')">{{ __('إلغاء') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Post-Process Reveal State -->
                    <div class="mt-14 p-12 bg-slate-50 dark:bg-slate-950/60 rounded-[2rem] border border-slate-100 dark:border-slate-800/80 shadow-inner text-start font-Cairo">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-10 mb-12 text-start font-Cairo">
                            <div class="flex items-center gap-5 text-start font-Cairo">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em] font-Cairo text-start opacity-60">{{ __('حالة الطلب') }}</span>
                                @if($subscription->status == 'approved')
                                    <span class="px-8 py-3 bg-emerald-500/10 text-emerald-600 rounded-[2rem] text-[11px] font-black border border-emerald-500/20 shadow-xl shadow-emerald-500/10 font-Cairo italic text-start">{{ __('تم القبول واعتماد الشحن') }} ✓</span>
                                @else
                                    <span class="px-8 py-3 bg-rose-500/10 text-rose-600 rounded-[2rem] text-[11px] font-black border border-rose-500/20 shadow-xl shadow-rose-500/5 font-Cairo italic text-start">{{ __('رفض الطلب') }} ✋</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-4 text-start font-Cairo">
                                <span class="text-[9px] font-black font-Cairo text-start italic opacity-60">{{ __('المسؤول المراجع') }}:</span>
                                <span class="text-xs font-black dark:text-brand-primary font-Cairo underline decoration-brand-primary decoration-[3px] underline-offset-8 italic text-start font-Cairo">{{ $subscription->admin->name ?? __('مشرف النظام') }}</span>
                            </div>
                        </div>
                        @if($subscription->admin_note)
                            <div class="space-y-4 bg-white dark:bg-slate-900 p-10 rounded-[1.5rem] border border-slate-100 dark:border-slate-800 shadow-sm text-start font-Cairo italic">
                                <span class="text-[9px] font-black uppercase tracking-[0.3em] block font-Cairo text-start font-Cairo opacity-60">{{ __('ملاحظات الإدارة') }}:</span>
                                <p class="text-lg font-bold font-Cairo leading-relaxed text-start opacity-70">" {{ $subscription->admin_note }} "</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- User and Package details -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <!-- Beneficiary Anchor Card -->
            <div class="card-premium glass-panel p-10 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 left-0 w-32 h-32 bg-indigo-500/[0.03] rounded-br-[2rem] -ml-10 -mt-10 font-Cairo"></div>
                <h4 class="font-black text-[10px] uppercase tracking-[0.3em] mb-10 px-4 font-Cairo text-start opacity-60">👤 {{ __('بيانات صاحب الطلب') }}</h4>
                <div class="flex items-center gap-6 text-start font-Cairo">
                    <div class="w-20 h-20 bg-slate-950 dark:bg-brand-primary text-white rounded-[1.2rem] flex items-center justify-center text-3xl font-black shadow-2xl font-Cairo italic font-mono">
                        {{ mb_substr($subscription->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex flex-col text-start font-Cairo">
                        <span class="text-xl font-black font-Cairo leading-tight text-start italic">{{ $subscription->user->name ?? __('مستخدم محذوف') }}</span>
                        <span class="text-[10px] font-bold font-mono mt-2 text-start italic opacity-60">{{ $subscription->user->email ?? __('لا يوجد بريد') }}</span>
                    </div>
                </div>
            </div>

            <!-- Package Details -->
            <div class="card-premium glass-panel p-10 rounded-[2rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-brand-primary/[0.04] rounded-tl-[4rem] -mr-16 -mb-16 font-Cairo"></div>
                <h4 class="font-black text-[10px] uppercase tracking-[0.3em] mb-10 px-4 font-Cairo text-start font-Cairo opacity-60">💎 {{ __('تفاصيل باقة النقاط') }}</h4>
                
                <h5 class="text-lg font-black font-Cairo mb-8 text-start italic opacity-80">{{ $subscription->package->name ?? __('باقة النقاط الأساسية') }}</h5>
                
                <div class="p-12 bg-slate-950 dark:bg-white rounded-[2rem] text-center mb-10 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.4)] transform hover:scale-[1.05] transition-all duration-700 text-start group font-Cairo">
                    <p class="text-6xl font-black text-brand-primary dark:text-slate-900 leading-none mb-4 font-mono group-hover:rotate-3 transition-transform text-center font-Cairo">{{ number_format(($subscription->package->points ?? 0) + ($subscription->package->bonus_points ?? 0)) }}</p>
                    <p class="text-[10px] font-black text-white/40 dark:text-slate-500 uppercase tracking-[0.3em] font-Cairo text-center font-Cairo opacity-40">{{ __('إجمالي النقاط المضافة') }}</p>
                </div>

                <div class="flex justify-between items-center px-6 text-start font-Cairo">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] font-Cairo text-start opacity-60">{{ __('المبلغ المدفوع') }}:</span>
                    <div class="text-start font-Cairo">
                        <span class="text-3xl font-black text-emerald-600 font-mono italic text-start font-Cairo">{{ number_format($subscription->package->price ?? 0, 0) }}</span>
                        <span class="text-xs font-black font-Cairo mr-2 tracking-widest text-start opacity-60">{{ __('ريال') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
