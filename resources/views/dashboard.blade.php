@extends('layouts.admin')

@section('title', __('مركز القيادة الرئيسي (Dashboard)'))

@section('content')
<div class="space-y-10 mt-6 animate-fade-in font-Cairo text-start">
    
    <!-- Header & Welcome -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 text-start">
        <div class="text-start">
            <h1 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white mb-2 italic">
                {{ __('مرحباً بك،') }} {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] font-Cairo">
                {{ __('نظرة شاملة على أداء المنصة والتحليلات الحية لليوم') }} - {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
        
        <!-- Dashboard Filters -->
        <div class="flex items-center gap-2 p-1.5 bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl rounded-[1.5rem] border border-slate-200/50 dark:border-slate-800/50 shadow-sm">
            @foreach(['all' => 'الكل', 'today' => 'اليوم', 'week' => 'الأسبوع', 'month' => 'الشهر'] as $key => $label)
                <a href="?filter={{ $key }}" class="px-6 py-2.5 rounded-[1.1rem] text-[10px] font-black uppercase tracking-widest transition-all 
                    {{ $filter == $key ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-500 hover:text-brand-primary opacity-60 hover:opacity-100' }}">
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
                    <span class="text-[9px] font-black bg-white/40 dark:bg-slate-800/40 px-3 py-1 rounded-full border border-slate-200/20 shadow-sm">{{ __('تراكمي') }}</span>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">{{ __('إجمالي العمولات') }}</span>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-3xl font-black font-mono italic">{{ number_format($commissionsTotal, 2) }}</h3>
                    <span class="text-xs font-black opacity-40">YER</span>
                </div>
                <div class="mt-auto pt-6 border-t border-slate-200/10 flex items-center gap-2 {{ $revenueGrowth >= 0 ? 'text-emerald-500' : 'text-rose-500' }} text-[10px] font-black">
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
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">{{ __('توزع المستخدمين') }}</span>
                <div class="flex flex-col gap-1">
                    <h3 class="text-3xl font-black font-mono italic">{{ number_format($usersCount) }}</h3>
                    <div class="flex items-center justify-between text-[9px] font-bold opacity-60">
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
                    <span class="text-[9px] font-black bg-amber-500/10 text-amber-600 px-3 py-1 rounded-full border border-amber-500/20 shadow-sm animate-pulse">{{ __('نشط الآن') }}</span>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">{{ __('إجمالي المعاملات') }}</span>
                <h3 class="text-3xl font-black font-mono italic">{{ number_format($requestsCount) }}</h3>
                <p class="mt-4 text-[10px] font-bold opacity-60 italic">{{ __('المعاملات التي تمت معالجتها عبر نظام QSS') }}</p>
            </div>
        </div>

        <!-- System Task Alert Card -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group bg-slate-900 border-0">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/[0.1] to-transparent pointer-events-none"></div>
            <div class="relative z-10 flex flex-col h-full text-white">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-xl rounded-2xl flex items-center justify-center text-white text-2xl border border-white/20">🚨</div>
                    <span class="bg-rose-600 text-white text-[9px] font-black px-3 py-1 rounded-full animate-bounce">{{ __('مهام عاجلة') }}</span>
                </div>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">{{ __('تنبيهات التدقيق') }}</span>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-[11px] font-black group/item cursor-pointer" onclick="window.location='{{ route('admin.withdrawals.index') }}'">
                        <span class="opacity-60 group-hover/item:opacity-100 transition-opacity">🏦 {{ __('طلبات سحب') }}</span>
                        <span class="text-rose-500 font-mono">{{ $pendingWithdrawalsCount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] font-black group/item cursor-pointer" onclick="window.location='{{ route('request-complaints.index') }}'">
                        <span class="opacity-60 group-hover/item:opacity-100 transition-opacity">⚖️ {{ __('نزاعات عالقة') }}</span>
                        <span class="text-amber-500 font-mono">{{ $pendingComplaintsCount }}</span>
                    </div>
                    <div class="flex items-center justify-between text-[11px] font-black group/item cursor-pointer" onclick="window.location='{{ route('user-verification-packages.index') }}'">
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
        <div class="lg:col-span-8 card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50 flex flex-col">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-12">
                <div class="text-start">
                    <h4 class="font-black text-xl flex items-center gap-4 italic">
                        <span class="w-2.5 h-8 bg-brand-primary rounded-full"></span>
                        {{ __('تحليل التدفقات المالية (العمولات)') }}
                    </h4>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-2">{{ __('نمو الإيرادات خلال الأشهر الستة الماضية') }}</p>
                </div>
            </div>
            <div class="relative h-80 w-full font-mono">
                <canvas id="mainRevenueChart"></canvas>
            </div>
        </div>

        <!-- Side Control Palette (Quick Actions) -->
        <div class="lg:col-span-4 space-y-8">
            <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl bg-gradient-to-br from-indigo-600 to-indigo-900 border-0 text-white relative overflow-hidden">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                
                <h4 class="font-black text-sm uppercase tracking-widest mb-10 flex items-center gap-4">
                    <span class="w-2 h-6 bg-white/20 rounded-full"></span>
                    {{ __('مركز العمليات السريع') }}
                </h4>

                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('services.create') }}" class="flex flex-col items-center justify-center gap-3 p-6 bg-white/10 hover:bg-white/20 rounded-[2rem] border border-white/10 transition-all hover:scale-105 group">
                        <span class="text-2xl group-hover:rotate-12 transition-transform">➕</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">{{ __('خدمة جديدة') }}</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex flex-col items-center justify-center gap-3 p-6 bg-white/10 hover:bg-white/20 rounded-[2rem] border border-white/10 transition-all hover:scale-105 group">
                        <span class="text-2xl group-hover:rotate-12 transition-transform">⚙️</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">{{ __('الإعدادات') }}</span>
                    </a>
                    <a href="{{ route('admin.financial.index') }}" class="flex flex-col items-center justify-center gap-3 p-6 bg-white/10 hover:bg-white/20 rounded-[2rem] border border-white/10 transition-all hover:scale-105 group">
                        <span class="text-2xl group-hover:rotate-12 transition-transform">💾</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">{{ __('التقارير المالية') }}</span>
                    </a>
                    <a href="{{ route('users.index') }}" class="flex flex-col items-center justify-center gap-3 p-6 bg-white/10 hover:bg-white/20 rounded-[2rem] border border-white/10 transition-all hover:scale-105 group">
                        <span class="text-2xl group-hover:rotate-12 transition-transform">🛡️</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">{{ __('المسؤولين') }}</span>
                    </a>
                </div>
                
                <p class="mt-10 text-[8px] font-black opacity-40 uppercase tracking-[0.3em] text-center">{{ __('QSS ADMIN COMMAND PALETTE v2.0') }}</p>
            </div>

            <!-- Revenue Mix Pie Chart -->
            <div class="card-premium glass-panel p-8 rounded-[3rem] shadow-2xl border border-white dark:border-slate-800/50 h-[380px] flex flex-col">
                <h4 class="font-black text-sm mb-8 flex items-center gap-3 italic">
                    <span class="w-2 h-6 bg-emerald-500 rounded-full"></span>
                    {{ __('توزيع مصادر الدخل') }}
                </h4>
                <div class="relative flex-1 font-mono">
                    <canvas id="revenueMixChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Geographic Heatmap -->
    <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50 flex flex-col">
        <div class="flex justify-between items-center mb-10">
            <div class="text-start">
                <h4 class="font-black text-xl italic flex items-center gap-4">
                    <span class="w-2.5 h-8 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/20"></span>
                    {{ __('كثافة الطلبات الجغرافية (Heatmap)') }}
                </h4>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ __('توزع الطلبات الحية في اليمن بناءً على المواقع الجغرافية') }}</span>
            </div>
        </div>
        <div id="heatmapContainer" class="h-[500px] w-full rounded-[2.5rem] overflow-hidden shadow-inner border border-slate-100 dark:border-slate-800/50 z-0"></div>
        
        <!-- Map Legend & Logic Guide - Enhanced -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Heatmap Guide -->
            <div class="p-6 bg-white/40 dark:bg-slate-900/40 rounded-[2rem] border border-slate-100 dark:border-slate-800/40 flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-rose-500/10 rounded-xl flex items-center justify-center text-rose-500">🔥</div>
                    <h5 class="text-xs font-black italic">{{ __('توزيع كثافة الطلبات') }}</h5>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-[9px] font-black">
                        <span class="opacity-50 italic">{{ __('مناطق ساخنة (نشاط مرتفع)') }}</span>
                        <div class="w-12 h-2 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></div>
                    </div>
                    <div class="flex items-center justify-between text-[9px] font-black">
                        <span class="opacity-50 italic">{{ __('مناطق باردة (نشاط منخفض)') }}</span>
                        <div class="w-12 h-2 rounded-full bg-indigo-400 opacity-40"></div>
                    </div>
                </div>
                <p class="text-[9px] leading-relaxed font-black opacity-60 mt-2">
                    {{ __('تظهر هذه الألوان أماكن تواجد العملاء اللحظي. الألوان القوية تعني طلباً مكثفاً يتطلب تغطية فورية من المزودين.') }}
                </p>
            </div>

            <!-- Provider Guide -->
            <div class="p-6 bg-white/40 dark:bg-slate-900/40 rounded-[2rem] border border-slate-100 dark:border-slate-800/40 flex flex-col gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-primary/10 rounded-xl flex items-center justify-center text-brand-primary">📍</div>
                    <h5 class="text-xs font-black italic">{{ __('توزع مزودي الخدمة') }}</h5>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-5 h-5 rounded-full bg-brand-primary border-2 border-white shadow-lg shrink-0"></div>
                    <p class="text-[9px] leading-relaxed font-black opacity-60">
                        {{ __('كل علامة زرقاء تمثل مزود خدمة نشط. يمكنك الضغط على العلامة لمعرفة اسم المزود والتأكد من تواجده في مناطق الطلب.') }}
                    </p>
                </div>
                <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-800/50">
                    <span class="text-[8px] font-black uppercase tracking-widest text-brand-primary opacity-60">{{ __('إجمالي المسجلين في الخريطة:') }} {{ $providersCount }} {{ __('مزود') }}</span>
                </div>
            </div>

            <!-- Strategic Guide -->
            <div class="p-6 bg-brand-primary/5 rounded-[2rem] border border-brand-primary/20 border-dashed flex flex-col gap-4 relative overflow-hidden group">
                <div class="absolute -top-4 -right-4 text-4xl opacity-5 group-hover:scale-110 transition-transform">💡</div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-primary/20 rounded-xl flex items-center justify-center text-brand-primary">🚀</div>
                    <h5 class="text-xs font-black italic text-brand-primary">{{ __('التحليل الاستراتيجي (Decision Support)') }}</h5>
                </div>
                <p class="text-[10px] leading-relaxed font-black italic opacity-80">
                    {{ __('كـ مسؤول (Admin)، هدفك هو مطابقة اللون "الوردي" مع "النقاط الزرقاء". إذا وجدت منطقة وردية بدون نقاط زرقاء، فهذا يعني وجود عملاء بلا خدمات؛ ابدأ بحملة تسويقية لاستقطاب مزودين في تلك المنطقة فوراً.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Data Tables & Performance Monitor -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Recent Activity Feed -->
        <div class="lg:col-span-8 card-premium glass-panel rounded-[3.5rem] overflow-hidden shadow-2xl border border-white dark:border-slate-800/50">
            <div class="px-12 py-10 border-b border-slate-100 dark:border-slate-800/50 bg-slate-50/40 dark:bg-slate-950/20 flex justify-between items-center">
                <div class="text-start">
                    <h4 class="font-black text-xl italic">{{ __('سجل العمليات الأخير حياً') }}</h4>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ __('مراقبة فورية لأحدث 5 طلبات في النظام') }}</span>
                </div>
                <div class="flex items-center gap-6">
                    <button onclick="exportTableToCSV('requests-table', 'qss-requests-report.csv')" class="text-[9px] font-black text-indigo-500 uppercase tracking-widest hover:underline flex items-center gap-2">
                        <span>📥</span> {{ __('تصدير البيانات') }}
                    </button>
                    <a href="{{ route('requests.index') }}" class="text-[9px] font-black text-brand-primary uppercase tracking-widest hover:underline">{{ __('عرض الكل') }}</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="requests-table" class="w-full text-start">
                    <thead class="bg-slate-50/80 dark:bg-slate-900/40 text-[9px] font-black uppercase tracking-tighter opacity-40 border-b border-slate-100 dark:border-slate-800/50">
                        <tr>
                            <th class="px-10 py-6 text-start">{{ __('صاحب الطلب') }}</th>
                            <th class="px-10 py-6 text-start">{{ __('الحالة') }}</th>
                            <th class="px-10 py-6 text-start">{{ __('المبلغ الإجمالي') }}</th>
                            <th class="px-10 py-6 text-end">{{ __('الوقت') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800/30">
                        @foreach($recentRequests as $r)
                        <tr class="hover:bg-brand-primary/[0.01] transition-all group">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center font-black text-xs group-hover:bg-brand-primary group-hover:text-white transition-all shadow-inner">
                                        {{ mb_substr($r->user?->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-[13px] font-black italic">{{ $r->user?->name ?? __('مستخدم محذوف') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black border uppercase tracking-tighter
                                    @if($r->status == 'completed') bg-emerald-500/10 text-emerald-600 border-emerald-500/20
                                    @elseif($r->status == 'pending') bg-amber-500/10 text-amber-600 border-amber-500/20
                                    @else bg-slate-500/10 text-slate-500 border-slate-500/20 @endif">
                                    {{ __($r->status) }}
                                </span>
                            </td>
                            <td class="px-10 py-6">
                                <span class="text-xs font-black font-mono tracking-tighter">{{ number_format($r->total_price, 2) }} YER</span>
                            </td>
                            <td class="px-10 py-6 text-end">
                                <span class="text-[10px] font-black opacity-40 italic">{{ $r->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Performing Partners -->
        <div class="lg:col-span-4 card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50 flex flex-col">
            <h4 class="font-black text-base italic mb-10 flex items-center gap-4">
                <span class="w-2.5 h-6 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/20"></span>
                {{ __('أفضل مزودي الخدمة أداءً') }}
            </h4>
            
            <div class="space-y-6 flex-1">
                @foreach($topProviders as $tp)
                <div class="flex items-center justify-between p-5 bg-white/40 dark:bg-slate-900/40 rounded-[2rem] border border-slate-100 dark:border-slate-800/50 hover:scale-[1.03] transition-all cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl flex items-center justify-center text-white font-black shadow-lg">
                            {{ mb_substr($tp->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-black italic text-start">{{ $tp->name }}</span>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[8px] font-black bg-brand-primary/10 text-brand-primary px-2 py-0.5 rounded-full">{{ $tp->orders_count }} {{ __('طلبات') }}</span>
                                <span class="text-[8px] font-black text-slate-400 font-mono tracking-tighter">{{ __('إجمالي الربح') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="text-xs font-black font-mono text-brand-primary">{{ number_format($tp->total_commission ?? 0, 0) }}</span>
                        <span class="block text-[7px] font-black opacity-40 uppercase">YER</span>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-8 p-6 bg-slate-50 dark:bg-slate-900/60 rounded-[2rem] border border-slate-100 dark:border-slate-800/50">
                <div class="flex justify-between items-center text-[10px] font-black">
                    <span class="opacity-60">{{ __('معدل رضا المستخدمين العام') }}</span>
                    <span class="text-brand-primary">98.4%</span>
                </div>
                <div class="w-full h-1.5 bg-slate-200 dark:bg-slate-800 rounded-full mt-3 overflow-hidden">
                    <div class="h-full bg-brand-primary w-[98.4%]"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Feedback & Moderation -->
    <div class="card-premium glass-panel p-10 rounded-[3.5rem] shadow-2xl border border-white dark:border-slate-800/50">
        <div class="flex justify-between items-center mb-10">
            <div class="text-start">
                <h4 class="font-black text-xl italic flex items-center gap-4">
                    <span class="w-2.5 h-8 bg-rose-500 rounded-full shadow-lg shadow-rose-500/20"></span>
                    {{ __('أحدث تقييمات العملاء (مركز الرقابة)') }}
                </h4>
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ __('إدارة ظهور التقييمات العامة ومعاينتها فورياً') }}</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($recentReviews as $rev)
            <div class="p-8 bg-white/40 dark:bg-slate-900/40 rounded-[2.5rem] border border-slate-100 dark:border-slate-800/50 flex flex-col gap-6 relative group overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-brand-primary text-white rounded-xl flex items-center justify-center font-black text-xs shadow-lg">
                            {{ mb_substr($rev->request?->user?->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-black">{{ $rev->request?->user?->name ?? __('مستخدم') }}</span>
                            <div class="flex items-center text-amber-500 gap-0.5">
                                @for($i=1; $i<=5; $i++)
                                    <span class="text-[10px]">{{ $i <= ($rev->rating ?? 0) ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <span class="text-[8px] font-black opacity-40 uppercase">{{ $rev->created_at->diffForHumans() }}</span>
                </div>
                
                <p class="text-[11px] font-bold italic opacity-70 line-clamp-3">"{{ $rev->comment ?? __('بدون تعليق') }}"</p>
                
                <div class="mt-auto flex items-center gap-3">
                    <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full py-3 rounded-2xl font-black text-[9px] uppercase tracking-widest transition-all
                            {{ $rev->is_hidden ? 'bg-emerald-500/10 text-emerald-600 hover:bg-emerald-600 hover:text-white border border-emerald-500/20' : 'bg-rose-500/10 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-500/20' }}">
                            {{ $rev->is_hidden ? __('إلغاء الإخفاء') : __('إخفاء التقييم') }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
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
                            label: '{{ __("إيرادات العمولات (YER)") }}',
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
                            .bindPopup(`<div class="font-Cairo text-xs font-black p-1 text-slate-800">${p.name}</div>`);
                    }
                });
            }
        } catch (e) { console.error('Heatmap Failed:', e); }

    });
</script>
@endpush
