@extends('layouts.admin')

@section('title', __('مركز القيادة الرئيسي (Dashboard)'))

@section('content')
<div class="space-y-10 mt-6 animate-fade-in font-Cairo text-start">
    
    <!-- Header & Welcome -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 text-start">
        <div class="text-start">
            <h1 class="text-4xl font-black tracking-tight text-[var(--main-text)] mb-2 italic">
                {{ __('مرحباً بك،') }} {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-xs font-black text-[var(--text-muted)] uppercase tracking-[0.3em] font-Cairo">
                {{ __('نظرة شاملة على أداء المنصة والتحليلات الحية لليوم') }} - {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
        
        <!-- Dashboard Filters -->
        <div class="flex items-center gap-2 p-1.5 bg-[var(--glass-bg)]/50 backdrop-blur-xl rounded-[1.5rem] border border-[var(--glass-border)] shadow-sm">
            @foreach(['all' => __('الكل'), 'today' => __('اليوم'), 'week' => __('الأسبوع'), 'month' => __('الشهر')] as $key => $label)
                <a href="?filter={{ $key }}" class="px-6 py-2.5 rounded-[1.1rem] text-[13px] font-black uppercase tracking-widest transition-all {{ $filter == $key ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-[var(--text-muted)] hover:text-brand-primary opacity-60 hover:opacity-100' }}">
                    {{ __($label) }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Metric High-Performance Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Revenue Card -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group border-0 bg-gradient-to-br from-brand-primary/10 to-transparent">
             <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-primary/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-brand-primary text-white rounded-2xl flex items-center justify-center text-2xl shadow-xl shadow-brand-primary/20">💰</div>
                    <span class="text-[12px] font-black bg-[var(--glass-bg)]/40 px-3 py-1 rounded-full border border-[var(--glass-border)] shadow-sm whitespace-nowrap inline-flex items-center justify-center">{{ __('تراكمي') }}</span>
                </div>
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-2">{{ __('إجمالي العمولات') }}</span>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black font-mono italic">{{ number_format($commissionsTotal, 2) }}</h3>
                    <span class="text-xs font-black opacity-40">YER</span>
                </div>
                <div class="mt-auto pt-6 border-t border-[var(--glass-border)] flex items-center gap-2 {{ $revenueGrowth >= 0 ? 'text-emerald-500' : 'text-rose-500' }} text-[13px] font-black">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="{{ $revenueGrowth >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6' }}"></path></svg>
                    <span>{{ number_format($revenueGrowth, 1) }}% {{ __('نمو الإيرادات') }}</span>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-2xl shadow-xl shadow-indigo-600/20">👥</div>
                    <div class="flex -space-x-4 rtl:space-x-reverse">
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200 shadow-sm"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-300 shadow-sm"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-400 shadow-sm"></div>
                    </div>
                </div>
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-2">{{ __('توزع المستخدمين') }}</span>
                <div class="flex flex-col gap-1">
                    <h3 class="text-3xl font-black font-mono italic">{{ number_format($usersCount) }}</h3>
                    <div class="flex items-center justify-between text-[12px] font-bold opacity-60">
                        <div class="flex items-center gap-4">
                            <span class="flex items-center gap-1.5"><span class="w-2 h-2 bg-indigo-500 rounded-full"></span> {{ $providersCount }} {{ __('مزود') }}</span>
                            <span class="flex items-center gap-1.5"><span class="w-2 h-2 bg-slate-400 rounded-full"></span> {{ $seekersCount }} {{ __('عميل') }}</span>
                        </div>
                        <span class="{{ $userGrowth >= 0 ? 'text-emerald-500' : 'text-rose-500' }} font-black">{{ $userGrowth >= 0 ? '+' : '' }}{{ number_format($userGrowth, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Requests Card -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-xl shadow-amber-500/20">⚡</div>
                    <span class="text-[12px] font-black bg-amber-500/10 text-amber-600 px-3 py-1 rounded-full border border-amber-500/20 shadow-sm animate-pulse whitespace-nowrap inline-flex items-center justify-center">{{ __('نشط الآن') }}</span>
                </div>
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-2">{{ __('إجمالي الطلبات') }}</span>
                <h3 class="text-3xl font-black font-mono italic">{{ number_format($requestsCount) }}</h3>
                <p class="mt-4 text-[13px] font-bold opacity-60 italic">{{ __('العدد الكلي لطلبات الخدمات والمشاريع المسجلة') }}</p>
            </div>
        </div>

        <!-- System Task Alert Card -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group bg-slate-900 border-0">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/[0.1] to-transparent pointer-events-none"></div>
            <div class="relative z-10 flex flex-col h-full text-white">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-[var(--glass-bg)]/10 backdrop-blur-xl rounded-2xl flex items-center justify-center text-white text-2xl border border-white/20">🚨</div>
                    <span class="bg-rose-600 text-white text-[12px] font-black px-3 py-1 rounded-full animate-bounce whitespace-nowrap inline-flex items-center justify-center">{{ __('مهام عاجلة') }}</span>
                </div>
                <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mb-3">{{ __('تنبيهات التدقيق') }}</span>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-[14px] font-black group/item cursor-pointer" onclick="window.location='{{ route('admin.withdrawals.index') }}'">
                        <span class="opacity-60 group-hover/item:opacity-100 transition-opacity">🏦 {{ __('طلبات سحب') }}</span>
                        <span class="text-rose-500 font-mono">{{ $pendingWithdrawalsCount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[14px] font-black group/item cursor-pointer" onclick="window.location='{{ route('request-complaints.index') }}'">
                        <span class="opacity-60 group-hover/item:opacity-100 transition-opacity">⚖️ {{ __('نزاعات عالقة') }}</span>
                        <span class="text-amber-500 font-mono">{{ $pendingComplaintsCount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[14px] font-black group/item cursor-pointer" onclick="window.location='{{ route('user-verification-packages.index') }}'">
                        <span class="opacity-60 group-hover/item:opacity-100 transition-opacity">🛡️ {{ __('توثيق خطط') }}</span>
                        <span class="text-indigo-400 font-mono">{{ $pendingWebVerifications }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Central Analytics & Control Hub -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Revenue Analytics -->
        <div class="lg:col-span-8 card-premium glass-panel p-8 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] flex flex-col">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-8">
                <div class="text-start">
                    <h4 class="font-black text-xl flex items-center gap-4 italic">
                        <span class="w-2.5 h-8 bg-brand-primary rounded-full"></span>
                        {{ __('تحليل التدفقات المالية (العمولات)') }}
                    </h4>
                    <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest mt-2">{{ __('نمو الإيرادات خلال الأشهر الستة الماضية') }}</p>
                </div>
            </div>
            <div class="relative h-72 w-full font-mono">
                <canvas id="mainRevenueChart"></canvas>
            </div>
        </div>

        <!-- Side Control Palette (Mission Control) -->
        <div class="lg:col-span-4 translate-y-2 flex flex-col gap-8">
            <div class="card-premium glass-panel p-6 rounded-[3.5rem] shadow-2xl bg-gradient-to-br from-indigo-900 to-slate-950 border-0 text-white relative overflow-hidden flex flex-col">
                <!-- Ambient Glow Background -->
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-brand-primary/10 rounded-full blur-[100px] animate-pulse"></div>
                
                <!-- Card Header -->
                <div class="flex items-center justify-between mb-8 px-2 relative z-10">
                    <h4 class="font-black text-[13px] uppercase tracking-[0.3em] flex items-center gap-4 opacity-80">
                        <span class="w-1.5 h-6 bg-brand-primary rounded-full shadow-[0_0_15px_rgba(79,70,229,0.5)]"></span>
                        {{ __('مركز القيادة والتحكم') }}
                    </h4>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-white/5 rounded-full border border-white/10">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-60">{{ __('مباشر') }}</span>
                    </div>
                </div>

                <!-- Urgent Operations Section (Primary Response) -->
                <div class="flex flex-col gap-4 mb-10 relative z-10">
                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] px-2">{{ __('الاستجابة الفورية') }}</span>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Request Complaints -->
                        <a href="{{ route('request-complaints.index') }}" class="relative group p-6 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-[2.2rem] transition-all duration-500 flex flex-col items-center gap-3 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="text-3xl filter dropshadow-lg group-hover:scale-125 transition-transform duration-500">⚖️</span>
                            <span class="text-[12px] font-black text-rose-100/90 text-center leading-tight">{{ __('نزاعات الطلبات') }}</span>
                            @if($pendingComplaintsCount > 0)
                                <span class="absolute top-4 right-4 bg-rose-500 text-white text-[10px] font-black w-6 h-6 rounded-full flex items-center justify-center shadow-lg shadow-rose-900/50 animate-pulse border border-white/20">{{ $pendingComplaintsCount }}</span>
                            @endif
                        </a>

                        <!-- System Complaints -->
                        <a href="{{ route('system-complaints.index') }}" class="relative group p-6 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 rounded-[2.2rem] transition-all duration-500 flex flex-col items-center gap-3 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="text-3xl filter dropshadow-lg group-hover:scale-125 transition-transform duration-500">📢</span>
                            <span class="text-[12px] font-black text-amber-100/90 text-center leading-tight">{{ __('شكاوى النظام') }}</span>
                            @if($pendingSystemComplaintsCount > 0)
                                <span class="absolute top-4 right-4 bg-amber-500 text-white text-[10px] font-black w-6 h-6 rounded-full flex items-center justify-center shadow-lg shadow-amber-900/50 animate-pulse border border-white/20">{{ $pendingSystemComplaintsCount }}</span>
                            @endif
                        </a>

                        <!-- Withdrawals -->
                        <a href="{{ route('admin.withdrawals.index') }}" class="relative group p-6 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 rounded-[2.2rem] transition-all duration-500 flex flex-col items-center gap-3 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="text-3xl filter dropshadow-lg group-hover:scale-125 transition-transform duration-500">🏦</span>
                            <span class="text-[12px] font-black text-emerald-100/90 text-center leading-tight">{{ __('عمليات السحب') }}</span>
                            @if($pendingWithdrawalsCount > 0)
                                <span class="absolute top-4 right-4 bg-emerald-500 text-white text-[10px] font-black w-6 h-6 rounded-full flex items-center justify-center shadow-lg shadow-emerald-900/50 animate-pulse border border-white/20">{{ $pendingWithdrawalsCount }}</span>
                            @endif
                        </a>

                        <!-- Verifications -->
                        <a href="{{ route('user-verification-packages.index') }}" class="relative group p-6 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 rounded-[2.2rem] transition-all duration-500 flex flex-col items-center gap-3 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="text-3xl filter dropshadow-lg group-hover:scale-125 transition-transform duration-500">🛡️</span>
                            <span class="text-[12px] font-black text-indigo-100/90 text-center leading-tight">{{ __('توثيق الحسابات') }}</span>
                            @if($pendingWebVerifications > 0)
                                <span class="absolute top-4 right-4 bg-indigo-500 text-white text-[10px] font-black w-6 h-6 rounded-full flex items-center justify-center shadow-lg shadow-indigo-900/50 animate-pulse border border-white/20">{{ $pendingWebVerifications }}</span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Management Tools Row (Balanced Secondary) -->
                <div class="relative z-10 border-t border-white/5 pt-8">
                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] px-2 mb-4 block">{{ __('إدارة النظام') }}</span>
                    <div class="grid grid-cols-3 gap-3">
                        <a href="{{ route('settings.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white/5 hover:bg-white/10 rounded-3xl border border-white/5 transition-all text-center group">
                            <span class="text-xl group-hover:rotate-45 transition-transform duration-500">⚙️</span>
                            <span class="text-[10px] font-black uppercase opacity-60 tracking-wider">{{ __('الإعدادات') }}</span>
                        </a>
                        <a href="{{ route('admin.financial.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white/5 hover:bg-white/10 rounded-3xl border border-white/5 transition-all text-center group">
                            <span class="text-xl group-hover:scale-110 transition-transform">📊</span>
                            <span class="text-[10px] font-black uppercase opacity-60 tracking-wider">{{ __('المالية') }}</span>
                        </a>
                        <a href="{{ route('users.index') }}" class="flex flex-col items-center gap-2 p-4 bg-white/5 hover:bg-white/10 rounded-3xl border border-white/5 transition-all text-center group">
                            <span class="text-xl group-hover:-translate-y-1 transition-transform">👥</span>
                            <span class="text-[10px] font-black uppercase opacity-60 tracking-wider">{{ __('المستخدمين') }}</span>
                        </a>
                    </div>
                </div>
                
                <p class="mt-8 text-[10px] font-black opacity-30 uppercase tracking-[0.4em] text-center font-mono relative z-10">QSS COMMAND PALETTE // v2.5</p>
            </div>

            <!-- Revenue Mix Pie Chart -->
            <div class="card-premium glass-panel p-6 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] h-[320px] flex flex-col">
                <h4 class="font-black text-[13px] mb-4 flex items-center gap-3 italic opacity-80">
                    <span class="w-1.5 h-6 bg-emerald-500 rounded-full"></span>
                    {{ __('توزيع مصادر الدخل') }}
                </h4>
                <div class="relative flex-1 font-mono">
                    <canvas id="revenueMixChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Geographic Heatmap -->
    <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] flex flex-col">
        <div class="flex justify-between items-center mb-10">
            <div class="text-start">
                <h4 class="font-black text-xl italic flex items-center gap-4">
                    <span class="w-2.5 h-8 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/20"></span>
                    {{ __('كثافة الطلبات الجغرافية (Heatmap)') }}
                </h4>
                <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-widest">{{ __('توزع الطلبات الحية في اليمن بناءً على المواقع الجغرافية') }}</span>
            </div>
        </div>
        <div id="heatmapContainer" class="h-[500px] w-full rounded-[2.5rem] overflow-hidden shadow-inner border border-[var(--glass-border)] z-0"></div>
        
        <!-- Map Legend & Logic Guide - Enhanced -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Heatmap Guide -->
            <div class="p-6 bg-[var(--glass-bg)]/40 rounded-[2rem] border border-[var(--glass-border)] flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-rose-500/10 rounded-xl flex items-center justify-center text-rose-500">🔥</div>
                    <h5 class="text-xs font-black italic">{{ __('توزيع كثافة الطلبات') }}</h5>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-[12px] font-black">
                        <span class="opacity-50 italic">{{ __('مناطق ساخنة (نشاط مرتفع)') }}</span>
                        <div class="w-12 h-2 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></div>
                    </div>
                    <div class="flex items-center justify-between text-[12px] font-black">
                        <span class="opacity-50 italic">{{ __('مناطق باردة (نشاط منخفض)') }}</span>
                        <div class="w-12 h-2 rounded-full bg-indigo-400 opacity-40"></div>
                    </div>
                </div>
                <p class="text-[12px] leading-relaxed font-black opacity-60 mt-2">
                    {{ __('تظهر هذه الألوان أماكن تواجد العملاء اللحظي. الألوان القوية تعني طلباً مكثفاً يتطلب تغطية فورية من المزودين.') }}
                </p>
            </div>

            <!-- Provider Guide -->
            <div class="p-6 bg-[var(--glass-bg)]/40 rounded-[2rem] border border-[var(--glass-border)] flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-primary/10 rounded-xl flex items-center justify-center text-brand-primary">📍</div>
                    <h5 class="text-xs font-black italic">{{ __('توزع مزودي الخدمة') }}</h5>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-5 h-5 rounded-full bg-brand-primary border-2 border-white shadow-lg shrink-0"></div>
                    <p class="text-[12px] leading-relaxed font-black opacity-60">
                        {{ __('كل علامة زرقاء تمثل مزود خدمة نشط. يمكنك الضغط على العلامة لمعرفة اسم المزود والتأكد من تواجده في مناطق الطلب.') }}
                    </p>
                </div>
                <div class="mt-auto pt-4 border-t border-[var(--glass-border)]">
                    <span class="text-[14px] font-black uppercase tracking-widest text-brand-primary opacity-60">{{ __('إجمالي المسجلين في الخريطة:') }} {{ $providersCount }} {{ __('مزود') }}</span>
                </div>
            </div>

            <!-- Strategic Guide -->
            <div class="p-6 bg-brand-primary/5 rounded-[2rem] border border-brand-primary/20 border-dashed flex flex-col gap-4 relative overflow-hidden group">
                <div class="absolute -top-4 -right-4 text-4xl opacity-5 group-hover:scale-110 transition-transform">💡</div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-primary/20 rounded-xl flex items-center justify-center text-brand-primary">🚀</div>
                    <h5 class="text-xs font-black italic text-brand-primary">{{ __('التحليل الاستراتيجي (Decision Support)') }}</h5>
                </div>
                <p class="text-[13px] leading-relaxed font-black italic opacity-80">
                    {{ __('كـ مسؤول (Admin)، هدفك هو مطابقة اللون"الوردي" مع"النقاط الزرقاء". إذا وجدت منطقة وردية بدون نقاط زرقاء، فهذا يعني وجود عملاء بلا خدمات؛ ابدأ بحملة تسويقية لاستقطاب مزودين في تلك المنطقة فوراً.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Data Tables & Performance Monitor -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Recent Activity Feed -->
        <div class="lg:col-span-8 card-premium glass-panel rounded-[3.5rem] overflow-hidden shadow-2xl border border-[var(--glass-border)] flex flex-col">
            <div class="px-8 py-6 border-b border-[var(--glass-border)] bg-[var(--main-bg)] flex justify-between items-center relative z-10">
                <div class="text-start">
                    <h4 class="font-black text-lg italic flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-brand-primary rounded-full"></span>
                        {{ __('سجل العمليات الأخير حياً') }}
                    </h4>
                    <span class="text-[11px] font-black text-[var(--text-muted)] uppercase tracking-widest opacity-60">{{ __('مراقبة فورية لأحدث 5 طلبات في النظام') }}</span>
                </div>
                <div class="flex items-center gap-6">
                    <button onclick="exportTableToCSV('requests-table', 'qss-requests-report.csv')" class="text-[11px] font-black text-indigo-500 uppercase tracking-widest hover:text-indigo-600 transition-colors flex items-center gap-2 group/export">
                        <span class="group-hover/export:-translate-y-1 transition-transform">📥</span> {{ __('تصدير البيانات') }}
                    </button>
                    <a href="{{ route('requests.index') }}" class="text-[11px] font-black text-brand-primary uppercase tracking-widest hover:underline">{{ __('عرض الكل') }}</a>
                </div>
            </div>
            <div class="overflow-x-auto flex-1">
                @if($recentRequests->isEmpty())
                    <div class="p-20 flex flex-col items-center justify-center text-center opacity-30">
                        <span class="text-5xl mb-4">📂</span>
                        <p class="font-black text-sm uppercase tracking-widest">{{ __('لا توجد طلبات حديثة حالياً') }}</p>
                    </div>
                @else
                    <table id="requests-table" class="w-full text-start border-collapse">
                        <thead class="bg-[var(--glass-bg)]/30 text-[11px] font-black uppercase tracking-widest opacity-40 border-b border-[var(--glass-border)]">
                            <tr>
                                <th class="px-8 py-5 text-start">{{ __('صاحب الطلب') }}</th>
                                <th class="px-8 py-5 text-start">{{ __('الحالة') }}</th>
                                <th class="px-8 py-5 text-start">{{ __('المبلغ') }}</th>
                                <th class="px-8 py-5 text-end">{{ __('الوقت') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--glass-border)]">
                            @foreach($recentRequests as $r)
                            <tr class="hover:bg-brand-primary/[0.02] hover:shadow-[inset_4px_0_0_#4f46e5] transition-all group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-[var(--glass-border)] rounded-xl flex items-center justify-center font-black text-xs group-hover:bg-brand-primary group-hover:text-white transition-all shadow-inner">
                                            {{ mb_substr($r->user?->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-[13px] font-black italic">{{ $r->user?->name ?? __('مستخدم محذوف') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-4 py-1 rounded-full text-[11px] font-black border uppercase tracking-tighter @if($r->status == 'completed') bg-emerald-500/10 text-emerald-600 border-emerald-500/20 @elseif($r->status == 'pending') bg-amber-500/10 text-amber-600 border-amber-500/20 @else bg-slate-500/10 text-[var(--text-muted)] border-slate-500/20 @endif whitespace-nowrap inline-flex items-center justify-center">
                                        {{ __($r->status) }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="text-xs font-black font-mono tracking-tighter">{{ number_format($r->total_price, 0) }} YER</span>
                                </td>
                                <td class="px-8 py-5 text-end">
                                    <span class="text-[12px] font-black opacity-40 italic whitespace-nowrap">{{ $r->created_at->diffForHumans() }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Top Performing Partners -->
        <div class="lg:col-span-4 card-premium glass-panel p-8 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)] flex flex-col">
            <h4 class="font-black text-base italic mb-8 flex items-center gap-4">
                <span class="w-1.5 h-6 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/20"></span>
                {{ __('أفضل مزودي الخدمة أداءً') }}
            </h4>
            
            <div class="space-y-4 flex-1">
                @foreach($topProviders as $tp)
                <div class="flex items-center justify-between p-4 bg-[var(--glass-bg)]/40 hover:bg-[var(--glass-bg)]/60 rounded-[2.2rem] border border-[var(--glass-border)] transition-all hover:-translate-y-1 cursor-default group">
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl flex items-center justify-center text-white font-black shadow-lg group-hover:scale-110 transition-transform">
                            {{ mb_substr($tp->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-black italic text-start truncate max-w-[120px]">{{ $tp->name }}</span>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[11px] font-black bg-brand-primary/10 text-brand-primary px-2 py-0.5 rounded-full">{{ $tp->orders_count }} {{ __('طلبات') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="text-xs font-black font-mono text-brand-primary">{{ number_format($tp->total_commission ?? 0, 0) }}</span>
                        <span class="block text-[11px] font-black opacity-40 uppercase">YER</span>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-8 p-6 bg-white/5 rounded-[2.2rem] border border-white/5">
                <div class="flex justify-between items-center text-[12px] font-black">
                    <span class="opacity-40 uppercase tracking-widest">{{ __('معدل رضا المستخدمين') }}</span>
                    <span class="text-brand-primary">98.4%</span>
                </div>
                <div class="w-full h-1.5 bg-slate-200/5 rounded-full mt-3 overflow-hidden shadow-inner">
                    <div class="h-full bg-brand-primary w-[98.4%] shadow-[0_0_10px_#4f46e5]"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Feedback & Moderation -->
    <div class="card-premium glass-panel p-8 rounded-[3.5rem] shadow-2xl border border-[var(--glass-border)]">
        <div class="flex justify-between items-center mb-10">
            <div class="text-start">
                <h4 class="font-black text-xl italic flex items-center gap-4">
                    <span class="w-2.5 h-8 bg-rose-500 rounded-full shadow-lg shadow-rose-500/20"></span>
                    {{ __('أحدث تقييمات العملاء (مركز الرقابة)') }}
                </h4>
                <span class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-widest opacity-60">{{ __('إدارة ظهور التقييمات العامة ومعاينتها فورياً') }}</span>
            </div>
        </div>
        
        @if($recentReviews->isEmpty())
            <div class="p-20 flex flex-col items-center justify-center text-center opacity-30">
                <span class="text-5xl mb-4">⭐</span>
                <p class="font-black text-sm uppercase tracking-widest">{{ __('لا توجد تقييمات جديدة حالياً') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($recentReviews as $rev)
                <div class="p-8 bg-[var(--glass-bg)]/40 rounded-[2.5rem] border border-[var(--glass-border)] flex flex-col gap-6 relative group overflow-hidden transition-all hover:bg-[var(--glass-bg)]/60">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-brand-primary text-white rounded-xl flex items-center justify-center font-black text-xs shadow-lg">
                                {{ mb_substr($rev->request?->user?->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-black">{{ $rev->request?->user?->name ?? __('مستخدم') }}</span>
                                <div class="flex items-center text-amber-500 gap-0.5">
                                    @for($i=1; $i<=5; $i++)
                                        <span class="text-[13px]">{{ $i <= ($rev->rating ?? 0) ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <span class="text-[12px] font-black opacity-30 uppercase italic">{{ $rev->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <p class="text-[14px] font-bold italic opacity-70 line-clamp-3">"{{ $rev->comment ?? __('بدون تعليق') }}"</p>
                    
                    <div class="mt-auto flex items-center gap-3">
                        <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST" class="w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full py-3 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all {{ $rev->is_hidden ? 'bg-emerald-500/10 text-emerald-600 hover:bg-emerald-600 hover:text-white border border-emerald-500/20' : 'bg-rose-500/10 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-500/20 shadow-lg shadow-rose-900/10' }}">
                                {{ $rev->is_hidden ? __('إلغاء الإخفاء') : __('إخفاء التقييم') }}
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-container { background: transparent !important; }
    .dark .leaflet-tile { filter: invert(100%) hue-rotate(180deg) brightness(85%) contrast(85%); }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        /* ===== Main Revenue Trend Chart ===== */
        try {
            const mainCtx = document.getElementById('mainRevenueChart');
            if (mainCtx) {
                const ctx = mainCtx.getContext('2d');
                const mainGradient = ctx.createLinearGradient(0, 0, 0, 400);
                mainGradient.addColorStop(0, 'rgba(79, 70, 229, 0.45)');
                mainGradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($revenueLabels),
                        datasets: [{
                            label: '{{ __("إيرادات العمولات (ريال يمني)") }}',
                            data: @json($revenueData),
                            borderColor: '#4f46e5',
                            backgroundColor: mainGradient,
                            borderWidth: 6,
                            tension: 0.5,
                            fill: true,
                            pointRadius: 0,
                            pointHoverRadius: 10,
                            pointHoverBackgroundColor: '#4f46e5',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { family: 'Cairo', weight: 'bold', size: 14 },
                                bodyFont: { family: 'Cairo', size: 13 },
                                padding: 18,
                                cornerRadius: 20
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(148, 163, 184, 0.1)' },
                                ticks: { font: { family: 'Cairo', weight: 'bold', size: 10 } }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: 'Cairo', weight: 'bold', size: 10 } }
                            }
                        }
                    }
                });
            }
        } catch (e) { console.error('Main Chart Failed:', e); }

        /* ===== Revenue Mix Doughnut Chart ===== */
        try {
            const mixCtx = document.getElementById('revenueMixChart');
            if (mixCtx) {
                const ctx = mixCtx.getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($revenueMix->pluck('type')),
                        datasets: [{
                            data: @json($revenueMix->pluck('total')),
                            backgroundColor: ['#4f46e5', '#ec4899', '#10b981', '#f59e0b'],
                            borderWidth: 0,
                            hoverOffset: 25,
                            borderRadius: 15
                        }]
                    },
                    options: {
                        cutout: '75%',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                rtl: {{ app()->getLocale() == 'ar' ? 'true' : 'false' }},
                                labels: {
                                    usePointStyle: true,
                                    padding: 25,
                                    font: { family: 'Cairo', size: 9, weight: '900' }
                                }
                            }
                        }
                    }
                });
            }
        } catch (e) { console.error('Mix Chart Failed:', e); }

        /* ===== Geographic Heatmap & Provider Markers ===== */
        try {
            const heatmapContainer = document.getElementById('heatmapContainer');
            if (heatmapContainer) {
                const heatmapData = @json($heatmapData);
                const providers = @json($providerLocations);
                
                // Center of Yemen (fallback or dynamic)
                const center = heatmapData.length > 0 ? heatmapData[0] : [15.3694, 44.1910]; 
                const map = L.map('heatmapContainer', {
                    zoomControl: true,
                    attributionControl: false,
                    scrollWheelZoom: true,
                    doubleClickZoom: true
                }).setView(center, 7);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                // Heatmap for Requests
                if (heatmapData.length > 0 && typeof L.heatLayer === 'function') {
                    L.heatLayer(heatmapData, {
                        radius: 25,
                        blur: 15,
                        maxZoom: 17,
                        gradient: {0.4: 'rgba(79, 70, 229, 0.4)', 0.65: '#4f46e5', 1: '#ec4899'}
                    }).addTo(map);
                }

                // Markers for Providers
                const providerIcon = L.divIcon({
                    html: '<div class="w-4 h-4 bg-brand-primary border-2 border-white rounded-full shadow-lg"></div>',
                    className: 'custom-div-icon',
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                });

                providers.forEach(p => {
                    if (p.lat && p.lng) {
                        L.marker([p.lat, p.lng], { icon: providerIcon })
                            .addTo(map)
                            .bindPopup(`<div class="font-Cairo text-xs font-black p-1 text-[var(--main-text)]">${p.name}</div>`);
                    }
                });
            }
        } catch (e) { console.error('Heatmap Failed:', e); }
    });

    /**
     * Export HTML Table to CSV
     * Supports Arabic (BOM)
     */
    function exportTableToCSV(tableID, filename = '') {
        const table = document.getElementById(tableID);
        if (!table) return;

        let csv = [];
        const rows = table.querySelectorAll("tr");
        
        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");
            
            for (let j = 0; j < cols.length; j++) {
                // Clean text content: remove newlines, multiple spaces, and trim
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/\s+/g, ' ').trim();
                // Escape quotes
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }

        // Create CSV file with UTF-8 BOM for Arabic support
        const csv_string = "\uFEFF" + csv.join("\n");
        const blob = new Blob([csv_string], { type: "text/csv;charset=utf-8;" });
        const link = document.createElement("a");
        
        if (link.download !== undefined) {
            const url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", filename || 'export.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
</script>
@endpush
