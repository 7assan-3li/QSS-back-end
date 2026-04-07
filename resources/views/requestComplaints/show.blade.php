@extends('layouts.admin')

@section('title', __('تفاصيل الشكوى والنزاع'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-5 mb-5 text-start">
                <a href="{{ route('request-complaints.index') }}" class="w-14 h-14 bg-slate-100 dark:bg-slate-800 text-slate-500 rounded-2xl flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all shadow-sm border border-slate-200 dark:border-slate-800">
                    <svg class="w-6 h-6 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-3xl text-slate-800 dark:text-white flex items-center gap-4 text-start font-Cairo">
                    <span class="w-12 h-12 bg-pink-500/10 rounded-2xl flex items-center justify-center text-pink-600 text-2xl font-Cairo shadow-lg shadow-pink-500/5">⚖️</span>
                    {{ __('تفاصيل الشكوى والمراجعة') }}
                </h3>
            </div>
            <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 mt-3 mr-24 uppercase tracking-[0.2em] font-Cairo text-start">
                <span>{{ __('سجل الشكاوى') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span>{{ __('معالجة الطلب') }}</span>
                <svg class="w-2 h-2 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-pink-600">{{ __('رقم الشكوى') }} #{{ str_pad($requestComplaint->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
             <span class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-[0.1em] font-Cairo text-start shadow-xl
                @if($requestComplaint->status == 'pending') bg-amber-500/10 text-amber-600 border border-amber-500/20 shadow-amber-500/5
                @elseif($requestComplaint->status == 'in_progress') bg-blue-500/10 text-blue-600 border border-blue-500/20 shadow-blue-500/5
                @else bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-emerald-500/5 @endif text-start">
                {{ __('حالة الشكوى') }}: {{ __($requestComplaint->status) }}
            </span>
        </div>
    </div>

    <!-- Conflict Mediation Protocol Ledger -->
    <div class="card-premium glass-panel p-12 rounded-[4rem] shadow-2xl border border-white dark:border-slate-800/50 overflow-hidden relative text-start font-Cairo">
        <div class="absolute inset-0 bg-gradient-to-r from-pink-500/[0.04] to-transparent pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-12 text-start font-Cairo">
            @php $statusSteps = ['pending', 'in_progress', 'resolved']; @endphp
            @foreach ($statusSteps as $step)
                @php
                    $isCurrent = $requestComplaint->status == $step;
                    $isCompleted = array_search($requestComplaint->status, $statusSteps) > array_search($step, $statusSteps);
                @endphp
                <div class="flex-1 flex flex-col items-center gap-5 group relative text-center font-Cairo">
                    <div class="w-16 h-16 rounded-[1.5rem] flex items-center justify-center transition-all duration-700 relative z-10 font-Cairo
                        @if($isCurrent) bg-pink-600 text-white shadow-[0_20px_40px_-5px_rgba(236,72,153,0.4)] scale-110 ring-8 ring-pink-500/10
                        @elseif($isCompleted) bg-emerald-500 text-white shadow-lg shadow-emerald-500/20
                        @else bg-slate-100 dark:bg-slate-900/60 text-slate-400 border border-slate-200 dark:border-slate-800/80 shadow-inner @endif font-black text-lg">
                        @if($isCompleted)
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        @endif
                    </div>
                    <div class="flex flex-col items-center text-center font-Cairo">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] font-Cairo mb-2
                            @if($isCurrent) text-pink-600 @elseif($isCompleted) text-emerald-600 @else text-slate-400/80 @endif">
                            @if($step == 'pending') {{ __('الحالة') }}: {{ __('بانتظار المراجعة') }} @endif
                            @if($step == 'in_progress') {{ __('الحالة') }}: {{ __('قيد المعالجة') }} @endif
                            @if($step == 'resolved') {{ __('الحالة') }}: {{ __('تم الحل') }} @endif
                        </span>
                        <span class="text-xs font-black text-slate-800 dark:text-white font-Cairo">
                            @if($step == 'pending') {{ __('بانتظار المراجعة') }} @endif
                            @if($step == 'in_progress') {{ __('قيد المعالجة حالياً') }} @endif
                            @if($step == 'resolved') {{ __('تم الحل والإغلاق نهائياً') }} @endif
                        </span>
                    </div>
                    
                    @if(!$loop->last)
                        <div class="hidden md:block absolute h-[2px] w-[calc(100%-4rem)] top-8 -right-[calc(50%-2rem)] bg-slate-100 dark:bg-slate-800/50 -z-0 overflow-hidden text-start">
                            <div class="h-full bg-emerald-500 transition-all duration-1000" style="width: {{ $isCompleted ? '100%' : '0%' }}"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Main Investigation Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 text-start font-Cairo">
        <!-- Content & Evidence Space -->
        <div class="lg:col-span-8 space-y-12 text-start">
            <div class="card-premium glass-panel p-14 rounded-[4.5rem] shadow-2xl relative border border-white dark:border-slate-800/50 overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-64 h-64 bg-pink-500/[0.03] rounded-bl-[10rem] -mr-20 -mt-20 blur-3xl opacity-60"></div>
                
                <div class="flex items-center gap-5 mb-14 text-start font-Cairo">
                    <span class="w-3 h-10 bg-pink-600 rounded-full shadow-lg shadow-pink-600/30"></span>
                    <h4 class="text-2xl font-black text-slate-800 dark:text-white font-Cairo text-start">{{ __('تفاصيل الشكوى المقدمة') }}</h4>
                </div>
                
                <div class="bg-slate-50/50 dark:bg-slate-950/40 p-12 rounded-[3.5rem] border border-slate-100 dark:border-slate-800/80 mb-16 relative group text-start font-Cairo shadow-inner">
                    <div class="absolute -top-8 -right-8 w-20 h-20 bg-white dark:bg-slate-900 rounded-3xl shadow-2xl flex items-center justify-center text-4xl group-hover:rotate-12 transition-all duration-500 font-Cairo">⚖️</div>
                    <p class="text-xl font-bold text-slate-700 dark:text-slate-200 leading-[2.2] font-Cairo italic text-start">
                        " {{ $requestComplaint->content }} "
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 text-start font-Cairo">
                    <!-- Petitioner Node (Reporter) -->
                    <div class="bg-white/40 dark:bg-slate-900/60 p-10 rounded-[3rem] border border-slate-100 dark:border-slate-800/50 shadow-xl group/node hover:scale-[1.02] transition-all text-start">
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] block mb-6 font-Cairo text-start">{{ __('مقدم الشكوى') }}</span>
                        <div class="flex items-center gap-5 text-start">
                            <div class="w-16 h-16 rounded-[1.3rem] bg-gradient-to-br from-pink-600 to-rose-700 text-white flex items-center justify-center font-black text-2xl shadow-xl shadow-pink-600/20 group-hover/node:rotate-6 transition-all font-Cairo">
                                {{ mb_substr($requestComplaint->user->name, 0, 1) }}
                            </div>
                            <div class="flex flex-col text-start">
                                <span class="text-base font-black text-slate-800 dark:text-white font-Cairo leading-tight text-start">{{ $requestComplaint->user->name ?? 'NON-OBJECTIVE DATA' }}</span>
                                <span class="text-[9px] font-black uppercase tracking-widest mt-2 font-Cairo text-start p-1 bg-pink-500/10 text-pink-600 rounded-lg w-max">
                                     {{ __('نوع المستخدم') }}: {{ $requestComplaint->user_id == $requestComplaint->request->user_id ? __('عميل') : __('مزود') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Respondent Roles Matrix -->
                    <div class="flex flex-col gap-8 justify-center text-start">
                        <div class="flex items-center gap-6 group/item text-start">
                            <div class="w-14 h-14 bg-pink-500/10 text-pink-600 rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-pink-500/5 group-hover/item:scale-110 transition-transform font-mono font-black italic">S</div>
                            <div class="flex flex-col text-start">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1 font-Cairo text-start">{{ __('صاحب الطلب (العميل)') }}</span>
                                <span class="text-sm font-black text-slate-800 dark:text-white font-Cairo text-start">{{ $requestComplaint->request->user->name ?? 'غير موجود' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-6 group/item text-start">
                            <div class="w-14 h-14 bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-indigo-500/5 group-hover/item:scale-110 transition-transform font-mono font-black italic">P</div>
                            <div class="flex flex-col text-start">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1 font-Cairo text-start">{{ __('مزود الخدمة (الطرف الآخر)') }}</span>
                                <span class="text-sm font-black text-slate-800 dark:text-white font-Cairo text-start">{{ $requestComplaint->request->serviceProvider()->name ?? 'غير محدد' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-14 pt-10 border-t border-slate-100 dark:border-slate-800/50 flex flex-col md:flex-row justify-between items-center gap-6 text-start">
                    <span class="inline-flex items-center gap-3 px-6 py-3 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 text-[10px] font-black text-slate-500 font-mono text-start">
                        <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                        {{ __('وقت تقديم الشكوى') }}: {{ $requestComplaint->created_at->format('Y-m-d H:i') }}
                    </span>
                    <a href="{{ route('requests.show', $requestComplaint->request_id) }}" class="inline-flex items-center gap-3 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-indigo-600/20 hover:scale-105 active:scale-95 transition-all font-Cairo text-start">
                         {{ __('عرض تفاصيل الطلب الأصلي') }} #{{ $requestComplaint->request_id }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Mediation Action Terminal Sidebar -->
        <div class="lg:col-span-4 space-y-12 text-start font-Cairo">
            <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50 text-start font-Cairo overflow-hidden relative">
                 <div class="absolute inset-x-0 top-0 h-2 bg-gradient-to-r from-pink-500 via-rose-500 to-indigo-600 opacity-60"></div>
                 
                <div class="flex items-center gap-4 mb-10 text-start">
                    <span class="w-2 h-8 bg-pink-600 rounded-full shadow-md"></span>
                    <h4 class="font-black text-slate-800 dark:text-white font-Cairo text-sm uppercase tracking-[0.2em] text-start">{{ __('اتخاذ إجراء بالشكوى') }}</h4>
                </div>

                @if(session('success'))
                    <div class="p-6 bg-emerald-500/10 text-emerald-600 text-[11px] font-black rounded-[2rem] mb-10 border border-emerald-500/20 text-center animate-pulse font-Cairo shadow-sm">
                         ⚠️ {{ __('نظام') }}: {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('request-complaints.update-status', $requestComplaint) }}" class="space-y-10 text-start font-Cairo">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4 text-start font-Cairo">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] px-3 font-Cairo text-start">{{ __('تعديل حالة الشكوى') }}</label>
                        <div class="relative text-start font-Cairo">
                            <select name="status" class="w-full px-10 py-6 bg-slate-50 dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800/80 rounded-[2.5rem] text-sm font-black outline-none focus:border-pink-600 focus:ring-[12px] focus:ring-pink-500/5 appearance-none font-Cairo transition-all dark:text-white text-center shadow-inner">
                                <option value="pending" {{ $requestComplaint->status == 'pending' ? 'selected' : '' }}>{{ __('بانتظار المراجعة') }}</option>
                                <option value="in_progress" {{ $requestComplaint->status == 'in_progress' ? 'selected' : '' }}>{{ __('قيد المعالجة والتحقيق') }}</option>
                                <option value="resolved" {{ $requestComplaint->status == 'resolved' ? 'selected' : '' }}>{{ __('تم حل الشكوى وإغلاقها') }}</option>
                            </select>
                            <div class="absolute left-8 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 font-Cairo">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 text-start font-Cairo">
                        <button type="submit" class="w-full py-6 bg-gradient-to-r from-pink-600 to-rose-700 text-white rounded-[2.5rem] text-[11px] font-black uppercase tracking-[0.3em] shadow-[0_25px_50px_-10px_rgba(236,72,153,0.4)] hover:scale-[1.03] active:scale-95 hover:shadow-pink-600/50 transition-all duration-500 font-Cairo flex items-center justify-center gap-4">
                            {{ __('تثبيت الحالة وحفظ التعديلات') }} ⚖️
                        </button>
                    </div>
                </form>
                
                <p class="mt-8 text-[9px] font-black text-slate-400 text-center leading-relaxed font-Cairo uppercase tracking-widest px-6">
                    {{ __('ملاحظة: سيتم حفظ هذا القرار وتحديث حالة الشكوى في سجلات النظام بشكل نهائي.') }}
                </p>
            </div>
            
            <!-- Audit Tip Card -->
            <div class="p-8 bg-slate-900 text-white rounded-[3rem] shadow-2xl relative overflow-hidden text-start font-Cairo">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-[5rem] -mr-10 -mt-10"></div>
                <h5 class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 flex items-center gap-3 font-Cairo text-start">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    {{ __('إرشادات المراجعة') }}
                </h5>
                <p class="text-[11px] font-bold text-slate-400 leading-relaxed font-Cairo text-start">
                    {{ __('تأكد من مراجعة سجل الرسائل والوثائق المرفقة في الطلب الأصلي قبل اتخاذ قرار "حل الشكوى". العدالة وسرعة الاستجابة هي هدفنا الأساسي.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection