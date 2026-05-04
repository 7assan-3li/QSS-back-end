@extends('layouts.admin')

@section('title', __('تعديل القناة المالية'))

@section('content')
<div class="max-w-6xl mx-auto space-y-16 mt-8 animate-fade-in text-start font-Cairo relative">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-10">
        <div class="space-y-4">
            <div class="flex items-center gap-4 mb-2">
                <a href="{{ route('admin.bank-accounts.index') }}" class="w-12 h-12 bg-[var(--glass-bg)] border border-[var(--glass-border)] rounded-2xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-xl group">
                    <svg class="w-5 h-5 rtl:rotate-0 ltr:rotate-180 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <span class="text-[11px] font-black uppercase tracking-[0.4em] italic text-brand-primary">{{ __('العودة للقائمة') }}</span>
            </div>
            <h3 class="text-4xl font-black text-[var(--main-text)] tracking-tight">
                {{ __('تحديث') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-orange-600">{{ __('بيانات القناة') }}</span>
            </h3>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.bank-accounts.update', $bankAccount->id) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-16 relative z-10">
        @csrf
        @method('PUT')

        <!-- Main Form Column -->
        <div class="lg:col-span-8 space-y-12">
            @if ($errors->any())
                <div class="glass-panel bg-rose-500/5 border-rose-500/20 p-8 rounded-[3rem] animate-shake">
                    <ul class="space-y-2 mr-10">
                        @foreach ($errors->all() as $error)
                            <li class="text-[13px] font-bold text-rose-500/80 italic flex items-center gap-3">
                                <span class="w-1.5 h-1.5 bg-rose-400 rounded-full"></span> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="glass-panel p-12 lg:p-16 rounded-[4rem] border border-[var(--glass-border)] shadow-2xl space-y-12">
                
                <!-- Input Group: Bank -->
                <div class="space-y-6">
                    <label class="flex items-center gap-4 text-[11px] font-black text-[var(--text-secondary)] uppercase tracking-[0.4em] italic px-2">
                        <div class="w-2 h-2 bg-blue-600 rounded-full shadow-lg shadow-blue-600/50"></div>
                        {{ __('البنك أو المحفظة') }}
                    </label>
                    <div class="relative group">
                        <select name="bank_id" class="w-full bg-[var(--main-bg)] border-2 border-transparent focus:border-blue-500/30 rounded-[2.5rem] px-10 py-7 text-sm font-black text-[var(--main-text)] appearance-none focus:ring-[15px] focus:ring-blue-500/5 transition-all outline-none shadow-xl italic" required>
                            @foreach($banks as $bank)
                                <option value="{{ $bank->id }}" {{ (old('bank_id', $bankAccount->bank_id) == $bank->id) ? 'selected' : '' }}>{{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute left-8 top-1/2 -translate-y-1/2 pointer-events-none text-[var(--text-muted)]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Input Group: Account Number -->
                <div class="space-y-6">
                    <label class="flex items-center gap-4 text-[11px] font-black text-[var(--text-secondary)] uppercase tracking-[0.4em] italic px-2">
                        <div class="w-2 h-2 bg-emerald-600 rounded-full shadow-lg shadow-emerald-600/50"></div>
                        {{ __('رقم الحساب أو المحفظة') }}
                    </label>
                    <div class="relative group">
                        <input type="text" name="account_number" value="{{ old('account_number', $bankAccount->account_number) }}" placeholder="{{ __('أدخل الرقم هنا...') }}" class="w-full bg-[var(--main-bg)] border-2 border-transparent focus:border-emerald-500/30 rounded-[2.5rem] px-10 py-7 text-sm font-black text-[var(--main-text)] focus:ring-[15px] focus:ring-emerald-500/5 transition-all outline-none shadow-xl italic tracking-[0.1em]" required>
                        <div class="absolute left-8 top-1/2 -translate-y-1/2 text-[var(--text-muted)] group-focus-within:text-emerald-500 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 011-1h2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1V5a1 1 0 011-1h2a1 1 0 011 1v2"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Input Group: Account Name -->
                <div class="space-y-6">
                    <label class="flex items-center gap-4 text-[11px] font-black text-[var(--text-secondary)] uppercase tracking-[0.4em] italic px-2">
                        <div class="w-2 h-2 bg-amber-600 rounded-full shadow-lg shadow-amber-600/50"></div>
                        {{ __('الاسم القانوني لصاحب الحساب') }}
                    </label>
                    <div class="relative group">
                        <input type="text" name="account_name" value="{{ old('account_name', $bankAccount->account_name) }}" placeholder="{{ __('مثلاً: مؤسسة QSS للتجارة') }}" class="w-full bg-[var(--main-bg)] border-2 border-transparent focus:border-amber-500/30 rounded-[2.5rem] px-10 py-7 text-sm font-black text-[var(--main-text)] focus:ring-[15px] focus:ring-amber-500/5 transition-all outline-none shadow-xl italic" required>
                    </div>
                </div>

                <!-- Input Group: Notes -->
                <div class="space-y-6">
                    <label class="flex items-center gap-4 text-[11px] font-black text-[var(--text-secondary)] uppercase tracking-[0.4em] italic px-2">
                        <div class="w-2 h-2 bg-purple-600 rounded-full shadow-lg shadow-purple-600/50"></div>
                        {{ __('تعليمات الدفع') }}
                    </label>
                    <textarea name="note" rows="5" placeholder="{{ __('اكتب هنا أي تعليمات إضافية تظهر للمستخدم...') }}" class="w-full bg-[var(--main-bg)] border-2 border-transparent focus:border-purple-500/30 rounded-[3.5rem] px-10 py-8 text-sm font-black text-[var(--main-text)] focus:ring-[15px] focus:ring-purple-500/5 transition-all outline-none resize-none leading-relaxed italic shadow-xl">{{ old('note', $bankAccount->note) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-4 space-y-12">
            <div class="glass-panel p-12 rounded-[4rem] border border-[var(--glass-border)] shadow-3xl sticky top-8">
                <div class="space-y-12">
                    <div class="space-y-6">
                        <label class="block text-[11px] font-black text-[var(--text-muted)] uppercase tracking-[0.4em] italic text-center">{{ __('حالة القناة المالية') }}</label>
                        <div class="flex items-center justify-center pt-4">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $bankAccount->is_active ? 'checked' : '' }}>
                                <div class="w-20 h-11 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] peer-focus:outline-none peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:dark:bg-slate-200 after:border-var(--glass-border) after:border after:rounded-full after:h-9 after:w-9 after:transition-all dark:border-var(--glass-border) peer-checked:bg-gradient-to-r peer-checked:from-brand-primary peer-checked:to-indigo-600 rounded-full group-hover:scale-110 transition-all shadow-inner"></div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-6 pt-12 border-t border-[var(--glass-border)]">
                        <button type="submit" class="btn-action-primary w-full py-8 !rounded-3xl !bg-gradient-to-r !from-amber-500 !to-orange-600 shadow-2xl hover:!scale-[1.02] active:!scale-95 transition-all duration-500 !text-[12px]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            {{ __('تحديث البيانات الآن') }}
                        </button>
                        
                        <a href="{{ route('admin.bank-accounts.index') }}" class="w-full flex items-center justify-center py-6 text-[11px] font-black text-[var(--text-muted)] hover:text-brand-primary uppercase tracking-[0.4em] italic transition-colors">
                            {{ __('تجاهل التغييرات') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
