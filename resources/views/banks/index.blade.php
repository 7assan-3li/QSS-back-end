@extends('layouts.admin')

@section('title', __('إدارة الحسابات البنكية'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start font-Cairo">
        <div class="text-start font-Cairo">
            <h3 class="font-black text-3xl text-slate-800 dark:text-white flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-600 text-3xl font-Cairo shadow-lg shadow-emerald-500/5">🏦</span>
                {{ __('إدارة البنوك') }}
            </h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('إدارة الحسابات البنكية المعتمدة لاستقبال وتحويل المدفوعات في المنصة.') }}
            </p>
        </div>
        <a href="{{ route('banks.create') }}" class="px-10 py-5 bg-gradient-to-r from-brand-primary to-indigo-600 text-white rounded-[2rem] text-[11px] font-black uppercase tracking-[0.2em] shadow-[0_20px_40px_-10px_rgba(79,70,229,0.3)] hover:scale-[1.05] active:scale-95 transition-all font-Cairo flex items-center gap-3 text-start font-Cairo">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            {{ __('إضافة بنك جديد') }}
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="card-premium glass-panel bg-emerald-500/5 border-emerald-500/20 p-8 rounded-[3rem] flex items-center gap-6 animate-bounce-subtle text-start font-Cairo">
            <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-xl shadow-emerald-500/20 text-xl font-Cairo">✨</div>
            <p class="text-xs font-black text-emerald-600 font-Cairo tracking-wide text-start font-Cairo">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Banks List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 text-start font-Cairo">
        @forelse($banks as $bank)
            <div class="card-premium glass-panel p-10 rounded-[2rem] shadow-2xl relative border border-white dark:border-white/5 flex flex-col group hover:-translate-y-3 transition-all duration-700 text-start font-Cairo">
                <!-- ID Micro-Badge -->
                <div class="absolute top-8 left-8 px-3 py-1.5 bg-slate-100 dark:bg-slate-900 text-slate-500 rounded-xl text-[8px] font-black font-mono italic tracking-widest font-Cairo text-start">BANK_{{ str_pad($bank->id, 3, '0', STR_PAD_LEFT) }}</div>
                
                <!-- Gateway Identity Sector -->
                <div class="flex flex-col items-center text-center mb-10 pt-4 font-Cairo">
                    <div class="w-28 h-28 rounded-[2rem] border-[6px] border-white dark:border-slate-800 shadow-2xl overflow-hidden bg-slate-50 dark:bg-slate-950 group-hover:rotate-6 transition-all duration-700 p-1 font-Cairo shadow-emerald-500/5">
                        @if($bank->image_path)
                            <img src="{{ asset('storage/'.$bank->image_path) }}" alt="{{ $bank->bank_name }}" class="w-full h-full object-cover rounded-[1.5rem]">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-950 text-slate-300 font-Cairo">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                        @endif
                    </div>
                    <h4 class="mt-8 text-xl font-black text-slate-800 dark:text-white font-Cairo leading-none italic text-start">{{ $bank->bank_name }}</h4>
                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em] mt-4 font-Cairo text-start italic">{{ __('بنك معتمد') }}</span>
                </div>

                <!-- Abstract Descriptor -->
                <div class="flex-grow text-start font-Cairo">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-500 font-Cairo leading-[1.8] line-clamp-3 text-center italic text-start font-Cairo">
                        {{ $bank->description ?? __('لا يوجد وصف متاح لهذا البنك حالياً.') }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-10 flex items-center justify-center gap-4 pt-8 border-t border-slate-100 dark:border-slate-800/60 text-start font-Cairo">
                    <a href="{{ route('banks.show', $bank->id) }}" class="w-12 h-12 bg-slate-50 dark:bg-slate-900 text-slate-500 hover:text-emerald-500 hover:bg-emerald-500/10 rounded-[1.2rem] transition-all flex items-center justify-center shadow-sm border border-slate-100 dark:border-white/5 font-Cairo text-start" title="{{ __('عرض التفاصيل') }}">
                        <svg class="w-5 h-5 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </a>
                    <a href="{{ route('banks.edit', $bank->id) }}" class="w-12 h-12 bg-slate-50 dark:bg-slate-900 text-slate-500 hover:text-amber-500 hover:bg-amber-500/10 rounded-[1.2rem] transition-all flex items-center justify-center shadow-sm border border-slate-100 dark:border-white/5 font-Cairo text-start font-Cairo" title="{{ __('تعديل البيانات') }}">
                        <svg class="w-5 h-5 font-black uppercase" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <form id="delete-bank-{{ $bank->id }}" action="{{ route('banks.destroy', $bank->id) }}" method="POST" class="inline font-Cairo">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                            onclick="confirmAction('delete-bank-{{ $bank->id }}', {
                                title: '{{ __('حذف بيانات البنك نهائياً') }}',
                                text: '{{ __('تحذير: أنت على وشك حذف هذا البنك وكافة السجلات المالية المرتبطة به. هذا الإجراء نهائي ولا يمكن التراجع عنه.') }}',
                                icon: 'warning',
                                isDanger: true,
                                confirmButtonText: '{{ __('تأكيد المسح النهائي') }}'
                            })"
                            class="w-12 h-12 bg-slate-50 dark:bg-slate-900 text-slate-500 hover:text-rose-500 hover:bg-rose-500/10 rounded-[1.2rem] transition-all flex items-center justify-center shadow-sm border border-slate-100 dark:border-white/5 font-Cairo text-start" title="{{ __('حذف البنك') }}">
                            <svg class="w-5 h-5 font-black uppercase" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-40 text-center flex flex-col items-center opacity-30 gap-8 font-Cairo">
                <div class="w-24 h-24 bg-slate-100 dark:bg-slate-900 rounded-[2rem] flex items-center justify-center text-6xl shadow-inner font-Cairo italic">🏦</div>
                <p class="text-xs font-black text-slate-500 uppercase tracking-[0.3em] font-Cairo text-start">{{ __('لا توجد بنوك مضافة حالياً.') }}</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
</div>
@endsection
