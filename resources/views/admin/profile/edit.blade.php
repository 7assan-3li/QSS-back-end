@extends('layouts.admin')

@section('title', __('تعديل الملف الشخصي'))

@section('content')
<div class="min-h-screen pb-20 font-Cairo relative overflow-hidden">
    <!-- Animated Background Mesh -->
    <div class="absolute top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-brand-primary/5 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-emerald-500/5 rounded-full blur-[150px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <!-- Page Header -->
    <div class="relative mb-16 pt-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 relative z-10">
            <div class="space-y-4">
                <div class="flex items-center gap-4 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-brand-primary to-brand-primary/60 rounded-2xl flex items-center justify-center shadow-2xl shadow-brand-primary/20 group-hover:rotate-6 transition-transform duration-500">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-brand-primary text-xs font-black uppercase tracking-widest bg-brand-primary/10 px-3 py-1 rounded-full mb-2 inline-block italic">SECURITY CENTER</span>
                        <h1 class="text-5xl font-black text-brand-primary italic tracking-tight leading-tight">
                            {{ __('إدارة الهوية الرقمية') }}
                        </h1>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats Card -->
            <div class="bg-[var(--glass-bg)] border border-[var(--glass-border)] rounded-3xl p-6 backdrop-blur-md shadow-xl flex items-center gap-6 group hover:border-brand-primary/30 transition-all duration-500">
                <div class="text-right">
                    <p class="text-[10px] font-black text-brand-primary/40 uppercase italic mb-1">{{ __('آخر تسجيل دخول') }}</p>
                    <p class="text-sm font-black text-brand-primary italic">{{ now()->translatedFormat('d F Y') }}</p>
                </div>
                <div class="w-[1px] h-10 bg-[var(--glass-border)]"></div>
                <div class="flex -space-x-3 rtl:space-x-reverse">
                    <div class="w-10 h-10 rounded-full border-2 border-[var(--glass-bg)] bg-brand-primary/10 flex items-center justify-center text-brand-primary text-xs font-black italic shadow-lg">
                        {{ mb_substr($user->role, 0, 1) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-10">
            <!-- Left Panel: Profile Visual -->
            <div class="xl:col-span-4 space-y-8">
                <div class="bg-[var(--glass-bg)] border border-[var(--glass-border)] rounded-[40px] p-10 backdrop-blur-2xl shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-full h-32 bg-gradient-to-b from-brand-primary/5 to-transparent"></div>
                    
                    <div class="relative flex flex-col items-center">
                        <div class="relative mb-8">
                            <div class="w-40 h-40 bg-gradient-to-br from-brand-primary/20 to-brand-primary/5 rounded-[32px] flex items-center justify-center border border-brand-primary/30 shadow-2xl relative overflow-hidden group/avatar">
                                <span class="text-7xl font-black text-brand-primary italic select-none group-hover/avatar:scale-110 transition-transform duration-700">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </span>
                                <!-- Decorative rings -->
                                <div class="absolute inset-0 border-2 border-brand-primary/10 rounded-[32px] scale-90 group-hover/avatar:scale-100 transition-transform duration-700"></div>
                            </div>
                            <div class="absolute -bottom-3 -right-3 w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-500/30 border-4 border-[var(--glass-bg)]">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.64.304 1.24.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="text-center space-y-2">
                            <h3 class="text-3xl font-black text-brand-primary italic">{{ $user->name }}</h3>
                            <p class="text-brand-primary/50 font-bold italic tracking-wide">{{ $user->email }}</p>
                        </div>

                        <div class="w-full mt-12 grid grid-cols-2 gap-4">
                            <div class="p-4 bg-brand-primary/5 rounded-3xl border border-brand-primary/10 text-center">
                                <p class="text-[10px] font-black text-brand-primary/40 uppercase mb-1 italic">{{ __('الرتبة') }}</p>
                                <p class="text-sm font-black text-brand-primary italic">{{ $user->role === 'admin' ? __('مدير') : __('موظف') }}</p>
                            </div>
                            <div class="p-4 bg-brand-primary/5 rounded-3xl border border-brand-primary/10 text-center">
                                <p class="text-[10px] font-black text-brand-primary/40 uppercase mb-1 italic">{{ __('الحالة') }}</p>
                                <p class="text-sm font-black text-emerald-500 italic">{{ __('موثق') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Badge -->
                <div class="bg-gradient-to-br from-brand-primary to-brand-primary/80 rounded-[40px] p-8 text-white relative overflow-hidden shadow-2xl shadow-brand-primary/30">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10 flex items-center gap-6">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-inner">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-black italic">{{ __('حماية متقدمة') }}</h4>
                            <p class="text-xs font-bold opacity-80 italic">{{ __('حسابك مؤمن بنظام التشفير الثنائي') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Form Content -->
            <div class="xl:col-span-8 space-y-10">
                <!-- Core Identity Card -->
                <div class="bg-[var(--glass-bg)] border border-[var(--glass-border)] rounded-[40px] p-12 backdrop-blur-2xl shadow-2xl relative group">
                    <div class="flex items-center gap-4 mb-12 border-b border-[var(--glass-border)] pb-8">
                        <div class="w-12 h-12 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-black text-brand-primary italic">{{ __('البيانات التعريفية') }}</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Full Name -->
                        <div class="space-y-4 group/field">
                            <label class="text-xs font-black text-brand-primary/40 uppercase tracking-widest ms-6 italic block group-hover/field:text-brand-primary transition-colors">
                                {{ __('الاسم بالكامل') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-brand-primary/20 group-hover/field:text-brand-primary transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full bg-brand-primary/5 border-2 border-brand-primary/10 rounded-[28px] px-8 py-5 pl-14 text-brand-primary font-black italic focus:ring-0 focus:border-brand-primary focus:bg-white transition-all duration-500 shadow-inner">
                            </div>
                            @error('name') <p class="text-rose-500 text-[10px] font-black italic mt-2 ms-6 animate-bounce">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-4 group/field">
                            <label class="text-xs font-black text-brand-primary/40 uppercase tracking-widest ms-6 italic block group-hover/field:text-brand-primary transition-colors">
                                {{ __('البريد الإلكتروني الذكي') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-brand-primary/20 group-hover/field:text-brand-primary transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                    {{ $user->role !== 'admin' ? 'disabled' : '' }}
                                    class="w-full bg-brand-primary/5 border-2 border-brand-primary/10 rounded-[28px] px-8 py-5 pl-14 text-brand-primary font-black italic focus:ring-0 focus:border-brand-primary focus:bg-white transition-all duration-500 shadow-inner disabled:opacity-40 disabled:cursor-not-allowed">
                                @if($user->role !== 'admin')
                                    <div class="absolute inset-y-0 right-6 flex items-center">
                                        <span class="bg-brand-primary/10 text-brand-primary text-[10px] font-black px-3 py-1 rounded-full italic">{{ __('للمدير فقط') }}</span>
                                    </div>
                                @endif
                            </div>
                            @error('email') <p class="text-rose-500 text-[10px] font-black italic mt-2 ms-6 animate-bounce">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Security & Password Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Password Update -->
                    <div class="bg-[var(--glass-bg)] border border-[var(--glass-border)] rounded-[40px] p-10 backdrop-blur-2xl shadow-2xl relative group">
                        <h4 class="text-xl font-black text-brand-primary mb-8 flex items-center gap-4 italic">
                            <div class="w-10 h-10 bg-brand-primary/10 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                            {{ __('تحديث الأمان') }}
                        </h4>
                        
                        <div class="space-y-6">
                            <div class="space-y-2 group/input">
                                <label class="text-[11px] font-black text-brand-primary/40 ms-4 italic block uppercase tracking-wider group-hover/input:text-brand-primary transition-colors">{{ __('كلمة مرور جديدة') }}</label>
                                <input type="password" name="password" autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="w-full bg-brand-primary/5 border border-brand-primary/10 rounded-2xl px-6 py-4 text-brand-primary font-black focus:ring-0 focus:border-brand-primary transition-all duration-300">
                                @error('password') <p class="text-rose-500 text-[10px] font-black italic mt-2 ms-4">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2 group/input">
                                <label class="text-[11px] font-black text-brand-primary/40 ms-4 italic block uppercase tracking-wider group-hover/input:text-brand-primary transition-colors">{{ __('تأكيد الكلمة') }}</label>
                                <input type="password" name="password_confirmation" autocomplete="new-password"
                                    placeholder="••••••••"
                                    class="w-full bg-brand-primary/5 border border-brand-primary/10 rounded-2xl px-6 py-4 text-brand-primary font-black focus:ring-0 focus:border-brand-primary transition-all duration-300">
                            </div>
                        </div>
                    </div>

                    <!-- Sensitive Protection / Verification -->
                    <div class="bg-[var(--glass-bg)] border-2 border-brand-primary/10 rounded-[40px] p-10 backdrop-blur-2xl shadow-2xl relative group bg-gradient-to-br from-white/5 to-transparent">
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-brand-primary text-white rounded-2xl flex items-center justify-center shadow-xl rotate-12 group-hover:rotate-0 transition-transform duration-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        
                        <h4 class="text-xl font-black text-brand-primary mb-6 italic">{{ __('مصادقة الهوية') }}</h4>
                        <p class="text-xs font-bold text-brand-primary/50 italic mb-8 leading-relaxed">
                            {{ __('يتطلب النظام تأكيد هويتك بكلمة المرور الحالية قبل تعديل البيانات الحساسة (مثل الإيميل أو كلمة المرور الجديدة).') }}
                        </p>

                        <div class="space-y-2 group/verify">
                            <label class="text-[11px] font-black text-brand-primary/40 ms-4 italic block uppercase tracking-wider group-hover/verify:text-brand-primary transition-colors">{{ __('كلمة المرور الحالية') }}</label>
                            <div class="relative">
                                <input type="password" name="current_password"
                                    placeholder="{{ __('إدخل الكلمة الحالية...') }}"
                                    class="w-full bg-brand-primary/10 border-2 border-brand-primary/20 rounded-2xl px-6 py-4 text-brand-primary font-black placeholder:text-brand-primary/30 focus:ring-4 focus:ring-brand-primary/10 focus:border-brand-primary transition-all duration-500">
                                <div class="absolute inset-y-0 right-4 flex items-center text-brand-primary/40">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('current_password') <p class="text-rose-500 text-[10px] font-black italic mt-2 ms-4">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex justify-end pt-10">
                    <button type="submit"
                        class="group relative px-16 py-6 bg-brand-primary text-white font-black rounded-[28px] shadow-2xl shadow-brand-primary/30 hover:scale-105 active:scale-95 transition-all duration-500 overflow-hidden flex items-center gap-4 italic tracking-widest uppercase text-lg">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <span>{{ __('تحديث الهوية الرقمية') }}</span>
                        <svg class="w-6 h-6 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
@keyframes bounce-x {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(5px); }
}
.animate-bounce-x {
    animation: bounce-x 1s infinite;
}
</style>
@endsection
