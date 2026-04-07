@extends('layouts.admin')

@section('title', __('إعدادات النظام'))

@section('content')
<div class="max-w-7xl mx-auto space-y-16 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-10 text-start font-Cairo">
        <div class="text-start font-Cairo">
            <h3 class="font-black text-4xl flex items-center gap-5 text-start font-Cairo shadow-indigo-500/10">
                <span class="w-16 h-16 bg-indigo-600/10 rounded-2xl flex items-center justify-center text-indigo-600 text-3xl font-Cairo shadow-lg shadow-indigo-600/5">⚙️</span>
                {{ __('إعدادات العمولات والنسب') }}
            </h3>
            <p class="text-[11px] font-black uppercase tracking-[0.3em] mt-5 mr-24 text-start font-Cairo italic opacity-60">
                {{ __('تعديل نسب العمولات، ثوابت الربح، والقواعد المالية العامة للمنصة.') }}
            </p>
        </div>
        <div class="flex items-center gap-5 px-10 py-5 bg-emerald-500/5 rounded-[2rem] border border-emerald-500/20 text-emerald-600 text-[10px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm">
            <span class="w-3 h-3 bg-emerald-500 rounded-full animate-ping font-Cairo"></span>
            {{ __('حالة النظام') }}: نشط 🛡️
        </div>
    </div>

    <!-- Success Notification -->
    @if(session('success'))
        <div class="card-premium glass-panel bg-emerald-500/5 border-emerald-500/20 p-10 rounded-[3.5rem] flex items-center gap-8 animate-fade-in shadow-2xl shadow-emerald-500/10 text-start font-Cairo">
            <div class="w-16 h-16 bg-emerald-500 text-white rounded-[1.5rem] flex items-center justify-center shadow-2xl shadow-emerald-500/30 text-2xl ring-8 ring-emerald-500/10 font-Cairo italic">✨</div>
            <div class="text-start font-Cairo">
                <h4 class="text-lg font-black text-emerald-700 dark:text-emerald-400 font-Cairo mb-2 text-start italic">{{ __('تم حفظ التغييرات بنجاح!') }}</h4>
                <p class="text-[11px] font-bold text-emerald-600 font-Cairo text-start italic opacity-80">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Settings Form -->
    <form action="{{ route('settings.update') }}" method="POST" class="space-y-16 text-start font-Cairo">
        @csrf
        @method('PUT')

        <!-- Settings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 text-start font-Cairo">
            @foreach ($settings as $setting)
                @php
                    $isPolicy = in_array($setting->key, ['seeker_policy_content', 'provider_policy_content']);
                @endphp
                <div class="{{ $isPolicy ? 'lg:col-span-3' : '' }} card-premium glass-panel p-12 rounded-[4.5rem] shadow-2xl relative border border-white dark:border-white/5 flex flex-col group hover:-translate-y-4 transition-all duration-1000 text-start overflow-hidden font-Cairo shadow-indigo-500/5">
                    <!-- Vector Glow Nodes -->
                    <div class="absolute -top-16 -right-16 w-32 h-32 bg-indigo-600/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000 font-Cairo"></div>
                    
                    <div class="flex items-start justify-between mb-12 text-start font-Cairo">
                        <div class="text-start font-Cairo">
                            <h4 class="text-base font-black font-Cairo leading-none mb-4 italic text-start uppercase">{{ __($setting->display_name) }}</h4>
                            <span class="px-4 py-1.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl text-[8px] font-black font-mono tracking-[0.3em] uppercase shadow-lg shadow-slate-950/20 italic">
                                {{ $isPolicy ? 'POLICY_STRATEGY' : 'FINANCIAL_SETTING_' . str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <div class="w-14 h-14 bg-white dark:bg-slate-900 rounded-[1.5rem] flex items-center justify-center text-slate-400 group-hover:text-indigo-600 group-hover:bg-indigo-600/10 transition-all duration-700 shadow-sm border border-slate-100 dark:border-white/5 font-Cairo italic">
                            @if($isPolicy)
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            @else
                                <svg class="w-7 h-7 transform group-hover:rotate-180 transition-transform duration-1000" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            @endif
                        </div>
                    </div>

                    <!-- Input Engine Architecture -->
                    <div class="relative mt-auto text-start font-Cairo">
                        @if($isPolicy)
                            <div class="absolute top-6 right-8 pointer-events-none font-Cairo opacity-40">
                                <span class="text-[9px] font-black font-Cairo tracking-[0.3em] uppercase italic">{{ __('محتوى السياسة') }}</span>
                            </div>
                            <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" required rows="8"
                                class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800 rounded-[2.5rem] px-10 py-10 text-sm font-bold focus:border-brand-primary focus:ring-[20px] focus:ring-brand-primary/5 transition-all outline-none font-Cairo italic leading-relaxed shadow-inner resize-none">{{ $setting->value }}</textarea>
                        @else
                            <div class="absolute inset-y-0 right-0 flex items-center pr-10 pointer-events-none font-Cairo">
                                <span class="text-[10px] font-black font-Cairo tracking-[0.4em] uppercase italic opacity-60">{{ __('القيمة') }}</span>
                            </div>
                            <input type="number" step="0.01" min="0" max="1000000" 
                                id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $setting->value }}" required
                                class="w-full bg-slate-50 dark:bg-slate-950 border-2 border-slate-100 dark:border-slate-800 rounded-[2.5rem] px-14 py-8 text-4xl font-black focus:border-brand-primary focus:ring-[20px] focus:ring-brand-primary/5 transition-all outline-none font-mono italic shadow-inner text-center">
                            @if(str_contains($setting->key, 'commission') || str_contains($setting->key, 'bonus'))
                                <div class="absolute left-8 top-1/2 -translate-y-1/2 w-12 h-12 bg-gradient-to-br from-indigo-600 to-indigo-500 text-white rounded-2xl flex items-center justify-center font-black text-base shadow-2xl shadow-indigo-600/30 italic">%</div>
                            @endif
                        @endif
                    </div>

                    <!-- Micro-Intelligence Feedback -->
                    <div class="mt-10 pt-10 border-t border-slate-100 dark:border-slate-800/80 opacity-60 group-hover:opacity-100 transition-all duration-1000 transform translate-y-2 group-hover:translate-y-0 text-start font-Cairo text-center">
                        <p class="text-[10px] font-black font-Cairo leading-[1.8] italic">
                            @if($isPolicy)
                                <span class="text-amber-600 dark:text-amber-400">⚠️ {{ __('تنبيه: أي تعديل في نص السياسة سيقوم بإلغاء موافقة جميع المستخدمين الحالية، مما يتطلب منهم إعادة الموافقة.') }}</span>
                            @else
                                {{ __('ملاحظة: تعديل هذه القيمة سيؤثر على حساب العمولات والأرباح في كافة العمليات الجديدة في النظام.') }}
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Save Settings Section -->
        <div class="card-premium glass-panel p-16 rounded-[5rem] shadow-[0_60px_120px_-20px_rgba(79,70,229,0.2)] relative border-4 border-white dark:border-white/5 overflow-hidden mt-20 text-start font-Cairo">
            <div class="absolute top-0 right-0 w-80 h-80 bg-brand-primary/5 rounded-bl-[15rem] -mr-20 -mt-20 blur-3xl opacity-60 font-Cairo"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-600/5 rounded-tr-[12rem] -ml-20 -mb-20 blur-3xl opacity-60 font-Cairo"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-16 text-start font-Cairo">
                <div class="text-start font-Cairo">
                    <div class="flex items-center gap-5 mb-5 text-start font-Cairo">
                        <span class="w-4 h-4 bg-emerald-500 rounded-full animate-pulse shadow-xl shadow-emerald-500/50 font-Cairo"></span>
                        <h5 class="text-2xl font-black font-Cairo text-start italic uppercase tracking-tighter">{{ __('حفظ إعدادات النظام') }}</h5>
                    </div>
                    <p class="text-xs font-bold font-Cairo leading-[2.2] max-w-2xl text-start italic opacity-60">
                        {{ __('عند حفظ هذه الإعدادات، سيتم تطبيق القيم المالية الجديدة فوراً على كافة المعاملات والعمليات المستقبلية في المنصة.') }}
                    </p>
                </div>
                
                <button type="submit" class="w-full lg:w-auto px-20 py-8 bg-gradient-to-r from-brand-primary to-indigo-700 text-white rounded-[3rem] text-[13px] font-black uppercase tracking-[0.3em] shadow-[0_30px_60px_-15px_rgba(79,70,229,0.5)] hover:scale-[1.05] active:scale-95 transition-all duration-700 font-Cairo flex items-center justify-center gap-6 group shadow-indigo-600/20 italic text-start font-Cairo">
                    <svg class="w-7 h-7 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    {{ __('حفـــــظ الإعـــــدادات') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
