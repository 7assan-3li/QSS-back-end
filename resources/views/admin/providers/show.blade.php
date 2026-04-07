@extends('layouts.admin')

@section('title', __('تفاصيل المزود | ') . $provider->name)

@section('content')
<div class="max-w-7xl mx-auto space-y-8 mt-4 animate-fade-in text-start font-Cairo" x-data="{ tab: 'profile' }">
    <!-- Header Section -->
    <div class="glass-panel p-10 rounded-[3.5rem] relative overflow-hidden group shadow-2xl flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 text-start">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-brand-primary/5 rounded-full blur-3xl group-hover:scale-125 transition-all duration-1000"></div>
        
        <div class="flex items-center gap-8 relative z-10 text-start">
            <div class="w-24 h-24 bg-brand-primary/10 rounded-3xl flex items-center justify-center text-4xl font-black text-brand-primary shadow-xl shadow-brand-primary/10 transition-all group-hover:rotate-6">{{ mb_substr($provider->name, 0, 1) }}</div>
            <div class="flex flex-col text-start">
                <div class="flex items-center gap-3">
                    <h3 class="text-3xl font-black font-Cairo">{{ $provider->name }}</h3>
                    @if($provider->provider_verified_until && \Carbon\Carbon::parse($provider->provider_verified_until)->isFuture())
                        <span class="w-6 h-6 bg-emerald-500 text-white rounded-full flex items-center justify-center text-[10px] shadow-lg shadow-emerald-500/20" title="{{ __('موثق') }}">✓</span>
                    @endif
                </div>
                <p class="text-sm font-black text-slate-400 mt-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ $provider->email }}
                </p>
                <div class="flex items-center gap-4 mt-6">
                    <span class="px-5 py-2 bg-slate-100 dark:bg-white/5 text-slate-500 text-[10px] font-black rounded-2xl flex items-center gap-2">
                        <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                        {{ __('عضو منذ: ') }} {{ $provider->created_at->format('Y-m-d') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-end gap-3 w-full lg:w-fit relative z-10 text-start">
             <a href="{{ route('users.edit', $provider->id) }}" class="px-8 py-3 bg-brand-primary text-white text-[11px] font-black rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-xl shadow-brand-primary/20 flex items-center gap-2 w-full lg:w-fit justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                {{ __('تعديل الحساب') }}
            </a>
            @if(!($provider->provider_verified_until && \Carbon\Carbon::parse($provider->provider_verified_until)->isFuture()))
            <span class="text-[10px] font-black text-rose-500 bg-rose-500/5 px-4 py-2 rounded-xl border border-rose-500/10 italic text-start">
                {{ __('يرجى ملاحظة أن المزود لم يقم بتوثيق حسابه بعد.') }}
            </span>
            @endif
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-start">
        <div class="card-premium glass-panel p-8 text-start">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-Cairo">{{ __('إجمالي الطلبات المستلمة') }}</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black font-mono">{{ $stats['total_requests'] }}</span>
                <span class="text-[10px] font-black text-indigo-500">{{ __('طلب') }}</span>
            </div>
        </div>
        <div class="card-premium glass-panel p-8 text-start">
             <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-Cairo">{{ __('الطلبات المكتملة') }}</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black font-mono text-emerald-500">{{ $stats['completed_requests'] }}</span>
                <span class="text-[10px] font-black text-emerald-500 opacity-60">{{ __('من التنفيذ') }}</span>
            </div>
        </div>
        <div class="card-premium glass-panel p-8 text-start">
             <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-Cairo">{{ __('إجمالي العمولات') }}</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black font-mono text-amber-500">{{ number_format($stats['total_commissions'], 2) }}</span>
                <span class="text-[10px] font-black text-amber-500 opacity-60 italic">{{ __('ر.س') }}</span>
            </div>
        </div>
        <div class="card-premium glass-panel p-8 text-start">
             <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-Cairo">{{ __('الخدمات المتاحة') }}</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-black font-mono text-brand-primary">{{ $stats['services_count'] }}</span>
                <span class="text-[10px] font-black text-brand-primary opacity-60">{{ __('في المتجر') }}</span>
            </div>
        </div>
    </div>

    <!-- Information Tabs Content -->
    <div class="glass-panel rounded-[3.5rem] shadow-2xl overflow-hidden font-Cairo text-start min-h-[600px] flex flex-col">
        <!-- Navigation Tabs -->
        <div class="flex items-center gap-10 px-10 border-b border-slate-100 dark:border-white/5 bg-slate-50/20 dark:bg-slate-900/40">
            <button @click="tab = 'profile'" :class="tab === 'profile' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-slate-400 border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all">{{ __('الملف الشخصي والحساب') }}</button>
            <button @click="tab = 'services'" :class="tab === 'services' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-slate-400 border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all">{{ __('دليل الخدمات') }}</button>
            <button @click="tab = 'requests'" :class="tab === 'requests' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-slate-400 border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all">{{ __('طلبات العملاء') }}</button>
            <button @click="tab = 'financials'" :class="tab === 'financials' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-slate-400 border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all">{{ __('البيانات المالية') }}</button>
        </div>

        <div class="p-10 flex-1 h-full">
            <!-- Profile Tab -->
            <div x-show="tab === 'profile'" class="animate-fade-in space-y-12 text-start">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 text-start">
                    <div class="space-y-8 text-start">
                        <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">{{ __('المعلومات الشخصية') }}</h4>
                        <div class="grid grid-cols-2 gap-8 text-start">
                            <div class="flex flex-col gap-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase">{{ __('الاسم الكامل') }}</span>
                                <span class="text-[11px] font-black">{{ $provider->name }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase">{{ __('البريد الإلكتروني') }}</span>
                                <span class="text-[11px] font-black">{{ $provider->email }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-8 text-start">
                            <div class="flex flex-col gap-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase">{{ __('أرقام التواصل') }}</span>
                                <div class="flex flex-col gap-2">
                                    @forelse($provider->profile->profilePhones ?? [] as $phone)
                                        <span class="text-[11px] font-black font-mono">{{ $phone->phone }}</span>
                                    @empty
                                        <span class="text-[9px] font-black text-slate-400 italic">{{ __('لم يتم تحديد أرقام') }}</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8 text-start pt-12 border-t border-slate-100 dark:border-white/5">
                    <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">{{ __('الأعمال السابقة (النماذج)') }}</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($provider->profile->previousWorks ?? [] as $work)
                        <div class="card-premium glass-panel p-6 flex flex-col gap-4 text-start group">
                            @if($work->image)
                                <img src="{{ asset('storage/'.$work->image) }}" class="w-full h-40 object-cover rounded-2xl group-hover:scale-105 transition-all">
                            @endif
                            <span class="text-[11px] font-black">{{ $work->title ?? __('عمل غير معنون') }}</span>
                        </div>
                        @empty
                            <div class="text-[11px] font-black text-slate-400 italic py-10 text-start">{{ __('لا توجد أعمال سابقة مضافة لهذا الزود.') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Services Tab -->
            <div x-show="tab === 'services'" class="animate-fade-in space-y-8 text-start">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($provider->services as $service)
                    <div class="card-premium glass-panel p-8 text-start group hover:border-brand-primary/50 transition-all">
                        <div class="flex justify-between items-start">
                            <div class="w-12 h-12 bg-brand-primary/5 rounded-2xl flex items-center justify-center text-xl">✨</div>
                            <span class="px-4 py-1.5 bg-slate-100 dark:bg-white/5 rounded-lg text-[9px] font-black text-slate-400 uppercase">{{ $service->category->name ?? __('عام') }}</span>
                        </div>
                        <h5 class="text-[12px] font-black mt-6 group-hover:text-brand-primary transition-colors">{{ $service->name }}</h5>
                        <div class="mt-6 flex items-baseline gap-2">
                             <span class="text-xl font-black font-mono text-emerald-600">{{ number_format($service->price, 2) }}</span>
                             <span class="text-[9px] font-black opacity-40">{{ __('ر.س') }}</span>
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-100 dark:border-white/5 flex justify-between items-center">
                            <span class="text-[9px] font-black text-slate-400">{{ __('عمولة النظام:') }} {{ $service->commission_percentage ?? '10' }}%</span>
                            <a href="{{ route('services.show', $service->id) }}" class="text-brand-primary text-[10px] font-black hover:underline underline-offset-4">{{ __('عرض التفاصيل') }} →</a>
                        </div>
                    </div>
                    @empty
                        <div class="col-span-3 py-32 text-center text-slate-400 font-black italic">{{ __('هذا الشريك لم يقم بإضافة أي خدمات بعد.') }}</div>
                    @endforelse
                </div>
            </div>

            <!-- Requests Tab -->
            <div x-show="tab === 'requests'" class="animate-fade-in text-start">
                <div class="overflow-x-auto h-full">
                    <table class="w-full text-start">
                        <thead>
                            <tr class="bg-slate-50/40 dark:bg-slate-900/40 border-b border-slate-100 dark:border-white/5">
                                <th class="table-header-cell px-10 py-6">{{ __('طالب الخدمة') }}</th>
                                <th class="table-header-cell px-10 py-6">{{ __('الخدمة') }}</th>
                                <th class="table-header-cell px-10 py-6">{{ __('الحالة') }}</th>
                                <th class="table-header-cell px-10 py-6">{{ __('التكلفة') }}</th>
                                <th class="table-header-cell px-10 py-6">{{ __('العمولة') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/3">
                            @forelse($requests as $req)
                            <tr class="hover:bg-brand-primary/[0.02] transition-all group">
                                <td class="px-10 py-6 text-start">
                                    <div class="flex flex-col text-start">
                                        <span class="text-[11px] font-black">{{ $req->user->name ?? '---' }}</span>
                                        <span class="text-[9px] font-black font-mono text-slate-400">{{ $req->created_at->format('Y-m-d') }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-6 text-[11px] font-black text-slate-500">{{ $req->main_service->first()->name ?? '---' }}</td>
                                <td class="px-10 py-6 text-start">
                                    <span class="px-4 py-2 bg-slate-100 dark:bg-white/5 rounded-xl text-[9px] font-black uppercase tracking-wider text-slate-500">
                                        {{ $req->status }}
                                    </span>
                                </td>
                                <td class="px-10 py-6 text-[12px] font-black font-mono">{{ number_format($req->total_price, 2) }} ر.س</td>
                                <td class="px-10 py-6 text-[12px] font-black text-amber-500 font-mono italic">{{ number_format($req->commission_amount, 2) }} ر.س</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="py-32 text-center text-slate-400 font-black italic">{{ __('لم يتم تنفيذ أي طلبات بعد.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-8">
                    {{ $requests->links() }}
                </div>
            </div>

            <!-- Financials Tab -->
            <div x-show="tab === 'financials'" class="animate-fade-in text-start space-y-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 text-start">
                    <div class="card-premium glass-panel p-10 flex flex-col gap-6 text-start">
                        <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">{{ __('إعدادات العمولات والحساب') }}</h4>
                        <div class="flex items-center justify-between py-4 border-b border-slate-100 dark:border-white/5">
                            <span class="text-[11px] font-black">{{ __('هل العميل مستثنى من العمولات؟') }}</span>
                            <span class="px-4 py-2 {{ $provider->no_commission ? 'bg-rose-500/10 text-rose-600' : 'bg-emerald-500/10 text-emerald-600' }} text-[9px] font-black rounded-xl border border-transparent">
                                {{ $provider->no_commission ? __('نعم (مستثنى)') : __('لا (يتم الخصم)') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-4 border-b border-slate-100 dark:border-white/5">
                            <span class="text-[11px] font-black">{{ __('نسبة العمولة الخاصة') }}</span>
                            <span class="text-xl font-black font-mono text-indigo-600">{{ $provider->commission ?? '10' }}%</span>
                        </div>
                    </div>

                    <div class="card-premium glass-panel p-10 flex flex-col gap-6 text-start">
                        <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest">{{ __('الحسابات البنكية') }}</h4>
                        @forelse($provider->banks as $bank)
                        <div class="p-6 bg-slate-50 dark:bg-white/5 rounded-2xl flex flex-col gap-3 text-start border border-slate-100 dark:border-white/5">
                             <div class="flex justify-between items-center text-start">
                                <span class="text-[11px] font-black text-brand-primary">{{ $bank->name }}</span>
                                <span class="text-[9px] font-black opacity-40 uppercase">{{ __('رصيد فعلي') }}</span>
                             </div>
                             <span class="text-[12px] font-black font-mono tracking-widest">{{ $bank->pivot->bank_account }}</span>
                        </div>
                        @empty
                            <div class="text-[11px] font-black text-slate-400 italic py-10 text-start font-Cairo">{{ __('لم يقم المزود بإضافة أي حسابات بنكية حتى الآن.') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
