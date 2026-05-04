@extends('layouts.admin')

@section('title', __('حسابات المنصة البنكية'))

@section('content')
<div class="max-w-7xl mx-auto space-y-16 mt-8 animate-fade-in text-start font-Cairo relative">
    <!-- Background Decoration -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-primary/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 -left-24 w-72 h-72 bg-indigo-500/5 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-10 relative z-10">
        <div class="space-y-4">
            <div class="inline-flex items-center gap-3 px-5 py-2 bg-brand-primary/10 text-brand-primary rounded-full border border-brand-primary/20">
                <span class="w-2 h-2 bg-brand-primary rounded-full animate-pulse"></span>
                <span class="text-[11px] font-black uppercase tracking-[0.3em] italic">{{ __('النظام المالي') }}</span>
            </div>
            <h3 class="text-4xl lg:text-5xl font-black text-[var(--main-text)] tracking-tight leading-tight">
                {{ __('حساباتنا') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-indigo-500">{{ __('البنكية') }}</span>
            </h3>
            <p class="text-sm font-bold text-[var(--text-secondary)] max-w-xl leading-relaxed italic opacity-80">
                {{ __('تحكم كامل في القنوات المالية المتاحة للمستخدمين، مع إمكانية التفعيل والتعطيل اللحظي لكل حساب.') }}
            </p>
        </div>
        @can('create' , \App\Models\BankSystemAccount::class)
            <a href="{{ route('admin.bank-accounts.create') }}" class="btn-action-primary px-12 py-6 !rounded-3xl !text-[12px] shadow-2xl hover:!scale-[1.02] active:!scale-95 transition-all duration-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                {{ __('إضافة قناة دفع جديدة') }}
        </a>
        @endcan
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="glass-panel bg-emerald-500/5 border-emerald-500/20 p-8 rounded-[3rem] flex items-center gap-6 animate-bounce-subtle">
            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-2xl flex items-center justify-center shadow-2xl shadow-emerald-500/20 text-2xl">✨</div>
            <p class="text-sm font-black text-emerald-600 italic tracking-wide">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Accounts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-12 relative z-10">
        @forelse($accounts as $account)
            <div class="group relative text-start font-Cairo">
                <!-- Glowing Aura -->
                <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/20 to-indigo-600/20 rounded-[3.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                
                <div class="relative glass-panel p-10 rounded-[3.5rem] border border-[var(--glass-border)] shadow-2xl hover:border-brand-primary/30 transition-all duration-700 flex flex-col min-h-[420px]">
                    
                    <!-- Card Top: Bank Identity -->
                    <div class="flex justify-between items-start mb-12">
                        <div class="w-20 h-20 rounded-3xl border-4 border-[var(--glass-border)] shadow-2xl overflow-hidden p-2 bg-white dark:bg-slate-800 group-hover:scale-110 transition-transform duration-700">
                            @if($account->bank->image_path)
                                <img src="{{ asset('storage/'.$account->bank->image_path) }}" class="w-full h-full object-contain rounded-xl">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-[var(--main-bg)] text-[var(--text-muted)] text-2xl">🏦</div>
                            @endif
                        </div>
                        
                        <div class="flex gap-4">
                            @can('update', $account)
                            <!-- Edit Action -->
                            <a href="{{ route('admin.bank-accounts.edit', $account->id) }}" class="w-12 h-12 bg-[var(--glass-bg)] border border-[var(--glass-border)] text-brand-primary rounded-full flex items-center justify-center hover:bg-brand-primary hover:text-white hover:scale-110 active:scale-95 transition-all duration-500 shadow-xl group/btn" title="{{ __('تعديل البيانات') }}">
                                <svg class="w-5 h-5 transform group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            @endcan

                            @can('delete', $account)
                            <!-- Delete Action -->
                            <form id="delete-account-{{ $account->id }}" action="{{ route('admin.bank-accounts.destroy', $account->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" 
                                    onclick="confirmAction('delete-account-{{ $account->id }}', {
                                        title: '{{ __('حذف الحساب') }}',
                                        icon: 'warning',
                                        isDanger: true
                                    })" class="w-12 h-12 bg-rose-500/5 border border-rose-500/20 text-rose-500 rounded-full flex items-center justify-center hover:bg-rose-500 hover:text-white hover:scale-110 active:scale-95 transition-all duration-500 shadow-xl group/btn-del" title="{{ __('حذف الحساب') }}">
                                    <svg class="w-5 h-5 transform group-hover/btn-del:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>

                    <!-- Card Middle: Account Info -->
                    <div class="flex-grow space-y-6">
                        <div class="space-y-1">
                            <h4 class="text-2xl font-black text-[var(--main-text)] italic tracking-tight">{{ $account->bank->bank_name }}</h4>
                            <div class="flex items-center gap-3">
                                @if($account->is_active)
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">{{ __('مفعل للاستخدام') }}</span>
                                @else
                                    <span class="w-2 h-2 bg-rose-500 rounded-full shadow-[0_0_10px_rgba(244,63,94,0.5)]"></span>
                                    <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest">{{ __('متوقف مؤقتاً') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] italic opacity-80 block mb-2">{{ __('رقم الحساب الرقمي') }}</label>
                            <div class="relative group/num">
                                <div class="w-full bg-[var(--main-text)] text-emerald-400 font-mono text-xl py-6 px-8 rounded-3xl tracking-[0.3em] shadow-inner flex items-center justify-between group-hover/num:text-[var(--main-bg)] transition-colors duration-500 border border-white/5 cursor-pointer" onclick="copyToClipboard('{{ $account->account_number }}', this)">
                                    <span>{{ $account->account_number }}</span>
                                    <div class="relative w-5 h-5 flex items-center justify-center">
                                        <!-- Copy Icon -->
                                        <svg class="copy-icon w-5 h-5 text-[var(--text-muted)] hover:text-emerald-400 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        <!-- Success Icon (Hidden) -->
                                        <svg class="success-icon absolute inset-0 w-5 h-5 text-emerald-500 opacity-0 scale-50 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <label class="text-[11px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] italic opacity-80 block mb-3">{{ __('اسم صاحب الحساب') }}</label>
                            <p class="text-sm font-bold text-[var(--main-text)] italic tracking-wide">{{ $account->account_name }}</p>
                        </div>
                    </div>

                    <!-- Card Bottom: Footer -->
                    @if($account->note)
                        <div class="mt-8 pt-8 border-t border-dashed border-[var(--glass-border)]">
                            <div class="flex gap-4 italic opacity-60">
                                <svg class="w-5 h-5 flex-shrink-0 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-[12px] font-bold leading-relaxed line-clamp-2">{{ $account->note }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 glass-panel rounded-[4rem] border-2 border-dashed border-[var(--glass-border)] flex flex-col items-center justify-center gap-8 opacity-40">
                <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center text-5xl">🏦</div>
                <h5 class="text-lg font-black uppercase tracking-[0.3em] italic">{{ __('لا توجد قنوات مالية حالياً') }}</h5>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $accounts->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyToClipboard(text, element) {
        navigator.clipboard.writeText(text).then(() => {
            const copyIcon = element.querySelector('.copy-icon');
            const successIcon = element.querySelector('.success-icon');
            
            // Show Success Icon
            copyIcon.classList.add('opacity-0', 'scale-50');
            successIcon.classList.remove('opacity-0', 'scale-50');
            successIcon.classList.add('opacity-100', 'scale-110');
            
            // Toast notification
            if (window.showToast) {
                window.showToast('{{ __('تم نسخ رقم الحساب بنجاح') }}', 'success');
            }
            
            // Revert after 2 seconds
            setTimeout(() => {
                copyIcon.classList.remove('opacity-0', 'scale-50');
                successIcon.classList.add('opacity-0', 'scale-50');
                successIcon.classList.remove('opacity-100', 'scale-110');
            }, 2000);
        });
    }
</script>
@endpush
