<aside class="w-80 bg-[var(--sidebar-bg)] flex flex-col z-30 transition-all duration-700 {{ app()->getLocale() == 'ar' ? 'shadow-[-20px_0_60px_-15px_rgba(0,0,0,0.05)] border-r' : 'shadow-[20px_0_60px_-15px_rgba(0,0,0,0.05)] border-l' }} dark:shadow-none flex-shrink-0 border-[var(--glass-border)] h-screen sticky top-0 font-Cairo overflow-hidden">

    <!-- Sidebar Header -->
    <div class="h-28 flex items-center px-10 mb-6 relative z-10 transition-all hover:bg-brand-primary/[0.02]">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 bg-gradient-to-tr from-brand-primary to-indigo-600 rounded-[1.25rem] flex items-center justify-center text-white text-3xl font-black shadow-lg transform hover:rotate-12 transition-all duration-500 font-mono italic">
                Q</div>
            <div class="flex flex-col leading-tight">
                <span class="text-2xl font-black tracking-tighter italic">QSS <span class="text-brand-primary">Portal</span></span>
                <span class="text-[12px] uppercase font-black opacity-60 tracking-[0.4em] mt-1 font-Cairo italic">{{ __('لوحة الإدارة') }}</span>
            </div>
        </div>
    </div>

    <!-- Navigation Scroll Area -->
    <nav class="flex-1 space-y-3 overflow-y-auto px-6 pb-40 custom-scrollbar relative z-10 font-Cairo">
        <!-- Overview Section -->
        <div class="mb-8 font-Cairo">
            <p class="text-[13px] font-black uppercase tracking-[0.3em] px-4 mb-5 italic font-Cairo text-start subpixel-antialiased opacity-60">
                {{ __('نظرة عامة والتحليل') }}</p>
            <div class="space-y-2 font-Cairo">
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ Request::routeIs('dashboard') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('dashboard') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('الرئيسية') }}</span>
                </a>

                <a href="{{ route('admin.financial.index') }}" class="sidebar-item {{ Request::routeIs('admin.financial.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('admin.financial.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100 group-hover:rotate-12' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('التقارير المالية') }}</span>
                </a>

                <a href="{{ route('admin.withdrawals.index') }}" class="sidebar-item {{ Request::routeIs('admin.withdrawals.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('admin.withdrawals.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('طلبات السحب') }}</span>
                    @if(isset($pending_withdrawals_count) && $pending_withdrawals_count > 0)
                        <span class="ms-auto bg-emerald-500 text-white text-[12px] font-black px-2 py-0.5 rounded-full shadow-lg shadow-emerald-500/20 italic">{{ $pending_withdrawals_count }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Supervision Section -->
        <div class="mb-8 font-Cairo">
            <p class="text-[13px] font-black uppercase tracking-[0.3em] px-4 mb-5 italic font-Cairo text-start subpixel-antialiased opacity-60">
                {{ __('الإشراف والرقابة') }}</p>
            <div class="space-y-2 font-Cairo">
                <a href="{{ route('request-complaints.index') }}" class="sidebar-item {{ Request::routeIs('request-complaints.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('request-complaints.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100 group-hover:rotate-12' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('نزاعات الطلبات') }}</span>
                    @if(isset($pending_complaints_count) && $pending_complaints_count > 0)
                        <span class="ms-auto bg-amber-500 text-white text-[12px] font-black px-2 py-0.5 rounded-full shadow-lg shadow-amber-500/20 italic">{{ $pending_complaints_count }}</span>
                    @endif
                </a>

                <a href="{{ route('system-complaints.index') }}" class="sidebar-item {{ Request::routeIs('system-complaints.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('system-complaints.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('شكاوى النظام') }}</span>
                </a>

                <a href="{{ route('commission-bonds.index') }}" class="sidebar-item {{ Request::routeIs('commission-bonds.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('commission-bonds.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('سندات العمولات') }}</span>
                    @if(isset($pending_commission_bonds_count) && $pending_commission_bonds_count > 0)
                        <span class="ms-auto bg-indigo-500 text-white text-[12px] font-black px-2 py-0.5 rounded-full shadow-lg shadow-indigo-500/20 italic">{{ $pending_commission_bonds_count }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Partners & Verification Section -->
        <div class="mb-8 font-Cairo">
            <p class="text-[13px] font-black uppercase tracking-[0.3em] px-4 mb-5 italic font-Cairo text-start subpixel-antialiased opacity-60">
                {{ __('إدارة الشركاء والتوثيق') }}</p>
            <div class="space-y-2 font-Cairo">
                <a href="{{ route('provider-requests.index') }}" class="sidebar-item {{ Request::routeIs('provider-requests.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('provider-requests.*') ? 'bg-[var(--glass-bg)]/20 text-white' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('طلبات الشراكة') }}</span>
                    @if(isset($pending_provider_requests_count) && $pending_provider_requests_count > 0)
                        <span class="ms-auto bg-brand-primary text-white text-[12px] font-black px-2 py-0.5 rounded-full shadow-lg shadow-brand-primary/20 italic">{{ $pending_provider_requests_count }}</span>
                    @endif
                </a>

                <a href="{{ route('verification-requests.index') }}" class="sidebar-item {{ Request::routeIs('verification-requests.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('verification-requests.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('توثيق الهوية') }}</span>
                    @if(isset($pending_id_verifications_count) && $pending_id_verifications_count > 0)
                        <span class="ms-auto bg-amber-500 text-white text-[12px] font-black px-2 py-0.5 rounded-full shadow-lg shadow-amber-500/20 italic">{{ $pending_id_verifications_count }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.providers.index') }}" class="sidebar-item {{ Request::routeIs('admin.providers.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('admin.providers.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('قائمة المزودين') }}</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[14px] font-black uppercase tracking-[0.4em] opacity-40 italic">{{ __('الاشتراكات والمدفوعات') }}</p>
                </div>

                <a href="{{ route('user-verification-packages.index') }}" class="sidebar-item {{ Request::routeIs('user-verification-packages.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('user-verification-packages.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="text-[14px] font-black italic tracking-tight font-Cairo opacity-100">{{ __('اشتراكات التوثيق') }}</span>
                    @if(isset($pending_verifications_count) && $pending_verifications_count > 0)
                        <span class="ms-auto bg-brand-primary text-white text-[12px] font-black px-2 py-0.5 rounded-full shadow-lg shadow-brand-primary/20 italic">{{ $pending_verifications_count }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.user-points-packages.index') }}" class="sidebar-item {{ Request::routeIs('admin.user-points-packages.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('admin.user-points-packages.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-[14px] font-black italic tracking-tight font-Cairo opacity-100">{{ __('اشتراكات النقاط') }}</span>
                    @if(isset($pending_user_points_packages_count) && $pending_user_points_packages_count > 0)
                        <span class="ms-auto bg-amber-500 text-white text-[12px] font-black px-2 py-0.5 rounded-full shadow-lg shadow-amber-500/20 italic">{{ $pending_user_points_packages_count }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- Marketplace & Users Section -->
        <div class="mb-8 font-Cairo">
            <p class="text-[13px] font-black uppercase tracking-[0.3em] px-4 mb-5 italic font-Cairo text-start subpixel-antialiased opacity-60">
                {{ __('إدارة السوق والمستخدمين') }}</p>
            <div class="space-y-2 font-Cairo">
                <a href="{{ route('users.index') }}" class="sidebar-item {{ Request::routeIs('users.index') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('users.index') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.732 4c-.77.234-1.476.614-2.066 1.114M6.718 4c.77.234 1.476.614 2.066 1.114M12 7h.01">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('إدارة المستخدمين') }}</span>
                </a>

                <a href="{{ route('requests.index') }}" class="sidebar-item {{ Request::routeIs('requests.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('requests.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100 group-hover:rotate-12' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('سجل طلبات الخدمات') }}</span>
                </a>

                <a href="{{ route('categories.index') }}" class="sidebar-item {{ Request::routeIs('categories.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('categories.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100 group-hover:rotate-12' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('أقسام السوق') }}</span>
                </a>

                <a href="{{ route('services.index') }}" class="sidebar-item {{ Request::routeIs('services.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('services.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100 group-hover:rotate-12' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('إدارة الخدمات') }}</span>
                </a>

                <a href="{{ route('advertisements.index') }}" class="sidebar-item {{ Request::routeIs('advertisements.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('advertisements.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100 group-hover:rotate-12' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('إدارة الإعلانات') }}</span>
                </a>
            </div>
        </div>

        <!-- System Configuration Section -->
        <div class="mb-8 font-Cairo">
            <p class="text-[13px] font-black uppercase tracking-[0.3em] px-4 mb-5 italic font-Cairo text-start subpixel-antialiased opacity-60">
                {{ __('إعدادات المنصة والتهيئة') }}</p>
            <div class="space-y-2 font-Cairo">
                <a href="{{ route('admin.points-packages.index') }}" class="sidebar-item {{ Request::routeIs('admin.points-packages.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('admin.points-packages.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('باقات النقاط') }}</span>
                </a>

                <a href="{{ route('verification-packages.index') }}" class="sidebar-item {{ Request::routeIs('verification-packages.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('verification-packages.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('حزم التوثيق') }}</span>
                </a>

                <a href="{{ route('banks.index') }}" class="sidebar-item {{ Request::routeIs('banks.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('banks.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('الحسابات البنكية') }}</span>
                </a>

                <a href="{{ route('settings.index') }}" class="sidebar-item {{ Request::routeIs('settings.*') ? 'active' : '' }} group w-full flex items-center gap-4 p-4 rounded-2xl transition-all duration-500">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 {{ Request::routeIs('settings.*') ? 'bg-[var(--glass-bg)]/20 text-white shadow-lg' : 'bg-brand-primary/5 group-hover:bg-[var(--glass-bg)] dark:group-hover:bg-brand-primary opacity-60 group-hover:opacity-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-black italic tracking-tight font-Cairo opacity-100">{{ __('إعدادات النظام') }}</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Logout & Profile Footer -->
    <div class="p-6 border-t border-[var(--glass-border)] bg-[var(--sidebar-bg)] relative z-10 transition-all hover:bg-brand-primary/[0.02]">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-[var(--glass-bg)] rounded-xl flex items-center justify-center text-brand-primary font-black shadow-inner">
                    {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-black text-brand-primary truncate max-w-[120px]">{{ auth()->user()->name ?? __('مشرف النظام') }}</span>
                    <span class="text-[12px] font-black uppercase tracking-widest opacity-60">{{ __('مشرف النظام') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-11 h-11 bg-rose-500/10 text-rose-600 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all duration-500 shadow-sm group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>