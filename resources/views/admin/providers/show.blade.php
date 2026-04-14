@extends('layouts.admin')

@section('title', __('تفاصيل المزود | ') . $provider->name)

@section('content')
<div class="max-w-7xl mx-auto space-y-8 mt-4 animate-fade-in text-start font-Cairo" x-data="{ tab: 'overview' }">
    <!-- Header Section -->
    <div class="glass-panel p-10 rounded-[3.5rem] relative overflow-hidden group shadow-2xl flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 text-start">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-brand-primary/5 rounded-full blur-3xl group-hover:scale-125 transition-all duration-1000"></div>
        
        <div class="flex items-center gap-8 relative z-10 text-start">
            <div class="w-24 h-24 bg-brand-primary/10 rounded-3xl flex items-center justify-center text-4xl font-black text-brand-primary shadow-xl shadow-brand-primary/10 transition-all group-hover:rotate-6">
                @if($provider->profile && $provider->profile->image_path)
                    <img src="{{ asset('storage/' . $provider->profile->image_path) }}" class="w-full h-full object-cover rounded-3xl">
                @else
                    {{ mb_substr($provider->name, 0, 1) }}
                @endif
            </div>
            <div class="flex flex-col text-start">
                <div class="flex items-center gap-3">
                    <h3 class="text-3xl font-black font-Cairo">{{ $provider->name }}</h3>
                    @if($provider->provider_verified_until && \Carbon\Carbon::parse($provider->provider_verified_until)->isFuture())
                        <span class="w-6 h-6 bg-emerald-500 text-white rounded-full flex items-center justify-center text-[13px] shadow-lg shadow-emerald-500/20" title="{{ __('موثق') }}">✓</span>
                    @endif
                </div>
                <p class="text-sm font-black text-[var(--text-muted)] mt-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ $provider->email }}
                </p>
                <div class="flex items-center gap-4 mt-6">
                    <span class="px-5 py-2 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 text-[var(--text-muted)] text-[13px] font-black rounded-2xl flex items-center gap-2 whitespace-nowrap inline-flex items-center justify-center">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        {{ __('متصل الآن') }}
                    </span>
                    <span class="px-5 py-2 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 text-[var(--text-muted)] text-[13px] font-black rounded-2xl flex items-center gap-2 whitespace-nowrap inline-flex items-center justify-center">
                        <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                        {{ __('عضو منذ: ') }} {{ $provider->created_at->format('Y-m-d') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-end gap-3 w-full lg:w-fit relative z-10 text-start">
             <div class="flex items-center gap-3 w-full">
                <a href="{{ route('users.edit', $provider->id) }}" class="flex-1 lg:flex-none px-8 py-3 bg-brand-primary text-white text-[14px] font-black rounded-2xl hover:scale-105 transition-all shadow-xl shadow-brand-primary/20 flex items-center gap-2 justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    {{ __('تعديل الحساب') }}
                </a>
                <button class="p-3 bg-rose-500/10 text-rose-500 rounded-2xl hover:bg-rose-500 hover:text-white transition-all shadow-lg" title="{{ __('حظر المزود') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                </button>
             </div>
            @if(!($provider->provider_verified_until && \Carbon\Carbon::parse($provider->provider_verified_until)->isFuture()))
            <span class="text-[13px] font-black text-amber-600 bg-amber-500/5 px-4 py-2 rounded-xl border border-amber-500/10 italic flex items-center gap-2 whitespace-nowrap inline-flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ __('المزود غير موثق حالياً') }}
            </span>
            @endif
        </div>
    </div>

    <!-- Quick Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-start">
        <div class="card-premium glass-panel p-8 text-start">
            <div class="flex justify-between items-start">
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest font-Cairo">{{ __('إجمالي الطلبات') }}</span>
                <div class="p-2 bg-indigo-500/10 rounded-xl"><svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div>
            </div>
            <div class="flex items-baseline gap-2 mt-4">
                <span class="text-3xl font-black font-mono">{{ $stats['total_requests'] }}</span>
                <span class="text-[13px] font-black text-indigo-500">{{ __('طلب مستلم') }}</span>
            </div>
        </div>
        <div class="card-premium glass-panel p-8 text-start">
            <div class="flex justify-between items-start">
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest font-Cairo">{{ __('العمولات المحققة للمنصة') }}</span>
                <div class="p-2 bg-amber-500/10 rounded-xl"><svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V15"></path></svg></div>
            </div>
            <div class="flex items-baseline gap-2 mt-4">
                <span class="text-3xl font-black font-mono text-amber-500">{{ number_format($stats['total_commissions'], 0) }}</span>
                <span class="text-[13px] font-black text-amber-500 opacity-60">YER</span>
            </div>
        </div>
        <div class="card-premium glass-panel p-8 text-start">
            <div class="flex justify-between items-start">
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest font-Cairo">{{ __('متوسط التقييم') }}</span>
                <div class="p-2 bg-emerald-500/10 rounded-xl"><svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg></div>
            </div>
            <div class="flex items-baseline gap-2 mt-4">
                <span class="text-3xl font-black font-mono text-emerald-500">{{ number_format($stats['avg_rating'], 1) }}</span>
                <span class="text-[13px] font-black text-emerald-500 opacity-60 uppercase">{{ __('نجمة') }}</span>
            </div>
        </div>
        <div class="card-premium glass-panel p-8 text-start">
            <div class="flex justify-between items-start">
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest font-Cairo">{{ __('إجمالي إيرادات المزود') }}</span>
                <div class="p-2 bg-brand-primary/10 rounded-xl"><svg class="w-4 h-4 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
            </div>
            <div class="flex items-baseline gap-2 mt-4">
                <span class="text-3xl font-black font-mono text-brand-primary">{{ number_format($stats['total_revenue'] - $stats['total_commissions'], 0) }}</span>
                <span class="text-[13px] font-black text-brand-primary opacity-60">YER</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Tabs -->
    <div class="glass-panel rounded-[3.5rem] shadow-2xl overflow-hidden font-Cairo text-start min-h-[700px] flex flex-col">
        <div class="flex items-center gap-10 px-10 border-b border-[var(--glass-border)] bg-[var(--main-bg)] overflow-x-auto no-scrollbar">
            <button @click="tab = 'overview'" :class="tab === 'overview' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-[var(--text-muted)] border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all whitespace-nowrap">{{ __('نظرة عامة') }}</button>
            <button @click="tab = 'services'" :class="tab === 'services' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-[var(--text-muted)] border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all whitespace-nowrap">{{ __('دليل الخدمات') }}</button>
            <button @click="tab = 'portfolio'" :class="tab === 'portfolio' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-[var(--text-muted)] border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all whitespace-nowrap">{{ __('معرض الأعمال') }}</button>
            <button @click="tab = 'requests'" :class="tab === 'requests' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-[var(--text-muted)] border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all whitespace-nowrap">{{ __('سجل الطلبات') }}</button>
            <button @click="tab = 'financials'" :class="tab === 'financials' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-[var(--text-muted)] border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all whitespace-nowrap">{{ __('البيانات المالية') }}</button>
            <button @click="tab = 'reviews'" :class="tab === 'reviews' ? 'text-brand-primary border-b-4 border-brand-primary' : 'text-[var(--text-muted)] border-b-4 border-transparent'" class="py-8 text-xs font-black transition-all whitespace-nowrap">{{ __('التقييمات') }}</button>
        </div>

        <div class="p-10 flex-1 h-full">
            <!-- Overview & Profile Tab -->
            <div x-show="tab === 'overview'" class="animate-fade-in space-y-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="space-y-8">
                        <h4 class="text-sm font-black text-[var(--text-muted)] uppercase tracking-widest flex items-center gap-2">
                             <span class="w-8 h-px bg-slate-200"></span>
                             {{ __('المعلومات الأساسية') }}
                        </h4>
                        <div class="grid grid-cols-2 gap-8">
                            <div class="flex flex-col gap-2 p-6 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-3xl">
                                <span class="text-[12px] font-black text-[var(--text-muted)] uppercase">{{ __('المسمى الوظيفي') }}</span>
                                <span class="text-[12px] font-black">{{ $provider->profile->job_title ?? '---' }}</span>
                            </div>
                            <div class="flex flex-col gap-2 p-6 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-3xl">
                                <span class="text-[12px] font-black text-[var(--text-muted)] uppercase">{{ __('رقم الهاتف') }}</span>
                                <span class="text-[12px] font-black font-mono tabular-nums leading-none">
                                    {{ $provider->profile->profilePhones->first()->phone ?? '---' }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 p-6 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-3xl">
                             <span class="text-[12px] font-black text-[var(--text-muted)] uppercase">{{ __('نبذة عن المزود (Bio)') }}</span>
                             <p class="text-[14px] font-black leading-relaxed text-[var(--text-secondary)]">
                                {{ $provider->profile->bio ?? __('لا توجد نبذة تعريفية متاحة.') }}
                             </p>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <h4 class="text-sm font-black text-[var(--text-muted)] uppercase tracking-widest flex items-center gap-2">
                             <span class="w-8 h-px bg-slate-200"></span>
                             {{ __('حالة الحساب والتوثيق') }}
                        </h4>
                        <div class="space-y-4">
                            @forelse($provider->verificationPackages as $pkg)
                            <div class="flex items-center justify-between p-6 border border-[var(--glass-border)] rounded-3xl hover:bg-[var(--glass-bg)] transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[14px] font-black">{{ $pkg->name }}</span>
                                        <span class="text-[12px] font-black text-[var(--text-muted)] uppercase">{{ __('تاريخ الاشتراك: ') }} {{ $pkg->pivot->created_at->format('Y-m-d') }}</span>
                                    </div>
                                </div>
                                <span class="px-5 py-2 rounded-xl text-[12px] font-black uppercase tracking-wider {{ $pkg->pivot->status === 'approved' ? 'bg-emerald-500/10 text-emerald-600' : 'bg-[var(--glass-bg)] text-[var(--text-muted)]' }} whitespace-nowrap inline-flex items-center justify-center">
                                    {{ $pkg->pivot->status }}
                                </span>
                            </div>
                            @empty
                            <div class="p-10 text-center border-2 border-dashed border-[var(--glass-border)] rounded-[2.5rem] flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-full flex items-center justify-center text-slate-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <span class="text-[13px] font-black text-[var(--text-muted)] italic">{{ __('المزود لم يشترك في حزم توثيق بعد.') }}</span>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Tab -->
            <div x-show="tab === 'services'" class="animate-fade-in space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($provider->services as $service)
                    <div class="card-premium glass-panel p-8 text-start group hover:border-brand-primary/50 transition-all relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-primary/5 rounded-bl-[4rem] group-hover:scale-150 transition-all duration-700"></div>
                        
                        <div class="flex justify-between items-start relative z-10 w-full">
                            <div class="w-14 h-14 bg-brand-primary/10 dark:bg-brand-primary/20 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:rotate-12 transition-all">✨</div>
                            <span class="px-4 py-2 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-xl text-[12px] font-black text-[var(--text-muted)] uppercase tracking-widest whitespace-nowrap inline-flex items-center justify-center">{{ $service->category->name ?? __('عام') }}</span>
                        </div>
                        
                        <h5 class="text-[13px] font-black mt-8 group-hover:text-brand-primary transition-colors leading-tight min-h-[40px]">{{ $service->name }}</h5>
                        
                        <div class="mt-8 flex items-baseline gap-2">
                             <span class="text-2xl font-black font-mono text-emerald-600 tabular-nums">
                                {{ number_format($service->price, 0) }}
                             </span>
                             <span class="text-[13px] font-black opacity-30 tracking-tighter">YER</span>
                        </div>
                        
                        <div class="mt-8 pt-8 border-t border-[var(--glass-border)] flex flex-col gap-2">
                            <div class="flex justify-between items-center">
                                <span class="text-[13px] font-black text-[var(--text-muted)]">{{ __('عمولة النظام:') }}</span>
                                <span class="text-[12px] font-black text-[var(--text-muted)]">{{ $provider->commission ?? '10' }}%</span>
                            </div>
                            <a href="{{ route('services.show', $service->id) }}" class="mt-2 text-brand-primary text-[13px] font-black hover:translate-x-2 transition-transform flex items-center gap-2">
                                {{ __('عرض كامل التفاصيل') }} 
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </a>
                        </div>
                    </div>
                    @empty
                        <div class="col-span-3 py-40 text-center flex flex-col items-center gap-6">
                            <div class="w-24 h-24 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-full flex items-center justify-center text-slate-200">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <p class="text-[var(--text-muted)] font-black italic text-sm">{{ __('لا توجد خدمات مضافة لهذا الشريك حالياً.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Portfolio Tab -->
            <div x-show="tab === 'portfolio'" class="animate-fade-in space-y-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    @forelse($provider->profile->previousWorks ?? [] as $work)
                    <div class="card-premium glass-panel p-6 flex flex-col gap-6 text-start group hover:scale-[1.02] transition-all">
                        <div class="relative overflow-hidden rounded-[2.5rem] shadow-inner aspect-[4/3] bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5">
                            @if($work->image)
                                <img src="{{ asset('storage/'.$work->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-1000">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 bg-[var(--glass-bg)]">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2">
                             <h6 class="text-[12px] font-black group-hover:text-brand-primary transition-colors">{{ $work->title ?? __('عمل غير معنون') }}</h6>
                             <p class="text-[13px] font-black text-[var(--text-muted)] line-clamp-2 leading-relaxed">{{ $work->description ?? __('لا يوجد وصف مضاف...') }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 py-40 text-center flex flex-col items-center gap-6">
                        <div class="w-24 h-24 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-full flex items-center justify-center text-slate-200">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <p class="text-[var(--text-muted)] font-black italic text-sm">{{ __('لم يقم هذا المزود برفع أي أعمال سابقة حتى الآن.') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Requests History Tab -->
            <div x-show="tab === 'requests'" class="animate-fade-in -m-10">
                <div class="overflow-x-auto">
                    <table class="w-full text-start">
                        <thead>
                            <tr class="bg-[var(--main-bg)] border-b border-[var(--glass-border)]">
                                <th class="table-header-cell px-10 py-8 text-[13px] uppercase tracking-widest">{{ __('العميل والطلب') }}</th>
                                <th class="table-header-cell px-10 py-8 text-[13px] uppercase tracking-widest">{{ __('الخدمة الرئيسية') }}</th>
                                <th class="table-header-cell px-10 py-8 text-[13px] uppercase tracking-widest text-center">{{ __('الحالة') }}</th>
                                <th class="table-header-cell px-10 py-8 text-[13px] uppercase tracking-widest">{{ __('التكلفة الإجمالية') }}</th>
                                <th class="table-header-cell px-10 py-8 text-[13px] uppercase tracking-widest">{{ __('العمولة (المنصة)') }}</th>
                                <th class="table-header-cell px-10 py-8 text-[13px] uppercase tracking-widest text-center">{{ __('الإجراء') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--glass-border)] dark:divide-white/3">
                            @forelse($requests as $req)
                            <tr class="hover:bg-brand-primary/[0.01] transition-all group">
                                <td class="px-10 py-8">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[14px] font-black group-hover:text-brand-primary transition-colors">{{ $req->user->name ?? '---' }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-[12px] font-black text-[var(--text-muted)] font-mono tracking-tighter uppercase tabular-nums">ID: #{{ $req->id }}</span>
                                            <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                            <span class="text-[12px] font-black text-[var(--text-muted)] font-mono uppercase">{{ $req->created_at->format('Y/m/d') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <span class="text-[14px] font-black text-[var(--text-secondary)] leading-tight block max-w-[150px] truncate">
                                        {{ $req->main_service->first()->name ?? '---' }}
                                    </span>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-600'],
                                            'completed' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-600'],
                                            'cancelled' => ['bg' => 'bg-rose-500/10', 'text' => 'text-rose-600'],
                                        ];
                                        $config = $statusConfig[$req->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-[var(--text-muted)]'];
                                    @endphp
                                    <span class="px-5 py-2 {{ $config['bg'] }} {{ $config['text'] }} rounded-2xl text-[12px] font-black uppercase tracking-wider inline-block whitespace-nowrap inline-flex items-center justify-center">
                                        {{ $req->status }}
                                    </span>
                                </td>
                                <td class="px-10 py-8 text-[12px] font-black font-mono tabular-nums leading-none">
                                    {{ number_format($req->total_price, 0) }} <span class="text-[12px] opacity-30 italic">YER</span>
                                </td>
                                <td class="px-10 py-8 text-[12px] font-black text-amber-500 font-mono italic tabular-nums leading-none">
                                    {{ number_format($req->commission_amount, 0) }} <span class="text-[12px] opacity-40">YER</span>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    <a href="{{ route('requests.show', $req->id) }}" class="p-3 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 text-[var(--text-muted)] rounded-2xl hover:bg-brand-primary hover:text-white transition-all inline-flex items-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="py-40 text-center flex flex-col items-center gap-6">
                                <p class="text-[var(--text-muted)] font-black italic text-sm">{{ __('لم يتم تنفيذ أي طلبات بعد.') }}</p>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-8 px-10 pb-10">
                    {{ $requests->links() }}
                </div>
            </div>

            <!-- Financials Tab -->
            <div x-show="tab === 'financials'" class="animate-fade-in text-start space-y-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="card-premium glass-panel p-12 flex flex-col gap-8 text-start relative overflow-hidden">
                        <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl"></div>
                        <h4 class="text-sm font-black text-[var(--text-muted)] uppercase tracking-widest flex items-center gap-2 relative z-10">
                            <span class="w-5 h-5 bg-indigo-500/10 text-indigo-500 rounded-lg flex items-center justify-center">💳</span>
                            {{ __('إعدادات العمولات') }}
                        </h4>
                        <div class="space-y-6 relative z-10">
                            <div class="flex items-center justify-between p-6 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-3xl border border-[var(--glass-border)]">
                                <span class="text-[14px] font-black">{{ __('هل العميل مستثنى من العمولات؟') }}</span>
                                <span class="px-5 py-2 {{ $provider->no_commission ? 'bg-rose-500/10 text-rose-600' : 'bg-emerald-500/10 text-emerald-600' }} text-[12px] font-black rounded-xl border border-transparent shadow-sm whitespace-nowrap inline-flex items-center justify-center">
                                    {{ $provider->no_commission ? __('نعم (مستثنى)') : __('لا (يتم الخصم)') }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-6 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-3xl border border-[var(--glass-border)]">
                                <span class="text-[14px] font-black">{{ __('نسبة العمولة الخاصة بهذا المزود') }}</span>
                                <div class="flex items-baseline gap-2">
                                     <span class="text-3xl font-black font-mono text-indigo-600 leading-none tabular-nums">{{ $provider->commission ?? '10' }}</span>
                                     <span class="text-sm font-black text-indigo-400">%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-premium glass-panel p-12 flex flex-col gap-8 text-start">
                        <h4 class="text-sm font-black text-[var(--text-muted)] uppercase tracking-widest flex items-center gap-2">
                            <span class="w-5 h-5 bg-amber-500/10 text-amber-500 rounded-lg flex items-center justify-center">🏦</span>
                            {{ __('الحسابات البنكية المعتمدة') }}
                        </h4>
                        <div class="grid grid-cols-1 gap-6">
                            @forelse($provider->banks as $bank)
                            <div class="p-8 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-3xl flex flex-col gap-4 text-start border border-[var(--glass-border)] relative group hover:border-brand-primary/20 transition-all">
                                 <div class="flex justify-between items-center text-start">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-[var(--glass-bg)] rounded-xl shadow-sm flex items-center justify-center text-xl">🏛️</div>
                                        <span class="text-[12px] font-black text-brand-primary leading-none">{{ $bank->name }}</span>
                                    </div>
                                    <span class="text-[12px] font-black opacity-40 uppercase tracking-tighter">{{ __('رصيد نشط') }}</span>
                                 </div>
                                 <div class="mt-2 flex items-center justify-between">
                                     <span class="text-[14px] font-black font-mono tracking-widest tabular-nums text-[var(--text-secondary)]">
                                         {{ chunk_split($bank->pivot->bank_account, 4, ' ') }}
                                     </span>
                                     <button class="p-2 text-slate-300 hover:text-brand-primary transition-colors">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                     </button>
                                 </div>
                            </div>
                            @empty
                                <div class="py-16 text-center border border-dashed border-[var(--glass-border)] rounded-3xl">
                                    <span class="text-[14px] font-black text-[var(--text-muted)] italic">{{ __('لم يقم المزود بإضافة أي حسابات بنكية حتى الآن.') }}</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div x-show="tab === 'reviews'" class="animate-fade-in text-start space-y-12">
                <div class="flex items-center justify-between mb-8">
                     <h4 class="text-sm font-black text-[var(--text-muted)] uppercase tracking-widest flex items-center gap-2">
                        <span class="w-8 h-px bg-slate-200"></span>
                        {{ __('ما يقوله العملاء') }}
                     </h4>
                     <div class="flex items-center gap-2 px-6 py-3 bg-emerald-500/5 text-emerald-600 rounded-2xl border border-emerald-500/10">
                         <span class="text-[14px] font-black">{{ __('التقييم الإجمالي:') }}</span>
                         <span class="text-xl font-black font-mono">{{ number_format($stats['avg_rating'], 1) }} / 5</span>
                     </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    @forelse($requests->where('review', '!=', null) as $reqReviewed)
                    <div class="card-premium glass-panel p-10 flex flex-col gap-6 text-start relative group">
                        <div class="flex justify-between items-start">
                             <div class="flex items-center gap-4">
                                 <div class="w-12 h-12 bg-[var(--glass-bg)] rounded-2xl flex items-center justify-center text-xl font-black text-[var(--text-muted)]">{{ mb_substr($reqReviewed->user->name ?? '?', 0, 1) }}</div>
                                 <div class="flex flex-col">
                                     <span class="text-[14px] font-black">{{ $reqReviewed->user->name ?? '---' }}</span>
                                     <span class="text-[12px] font-black text-[var(--text-muted)] uppercase">{{ __('طلب رقم #') }}{{ $reqReviewed->id }}</span>
                                 </div>
                             </div>
                             <div class="flex text-amber-400 gap-0.5">
                                 @for($i = 1; $i <= 5; $i++)
                                 <svg class="w-3.5 h-3.5 {{ $i <= $reqReviewed->review->rating ? 'fill-current' : 'fill-slate-200 dark:fill-slate-700' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                 @endfor
                             </div>
                        </div>
                        <p class="text-[14px] font-black leading-relaxed text-[var(--text-secondary)] italic">"{{ $reqReviewed->review->comment ?? __('لا يوجد تعليق نصي...') }}"
                        </p>
                        <span class="text-[12px] font-black text-[var(--text-muted)] uppercase text-start opacity-40 group-hover:opacity-100 transition-opacity">
                            {{ $reqReviewed->review->created_at->diffForHumans() }}
                        </span>
                    </div>
                    @empty
                    <div class="col-span-2 py-32 text-center flex flex-col items-center gap-6">
                        <div class="w-20 h-20 bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5 rounded-full flex items-center justify-center text-slate-200">
                             <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <p class="text-[var(--text-muted)] font-black italic text-sm">{{ __('لا توجد تقييمات مسجلة لهذا المزود حتى الآن.') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    .card-premium {
        @apply transition-all duration-500 border border-[var(--glass-border)] hover:shadow-2xl hover:shadow-brand-primary/10;
    }
    
    .table-header-cell {
        @apply text-slate-400 font-black text-start;
    }
    
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fade-in 0.6s ease-out forwards; }
</style>
@endsection
