@extends('layouts.admin')

@section('title', __('تحليل الخدمة ومراقبة الجودة'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo pb-24 print:p-0 print:m-0">
    <!-- Executive Header & Metadata -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-10 px-4 md:px-0 text-start group print:flex-row print:justify-between font-Cairo">
        <div class="text-start">
            <h3 class="font-black text-4xl flex items-center gap-6 text-start font-Cairo leading-tight">
                <div class="relative group/icon print:hidden">
                    @if($service->image_path)
                        <img src="{{ asset('storage/' . $service->image_path) }}" class="w-20 h-20 rounded-[2.2rem] object-cover shadow-2xl border-4 border-white dark:border-slate-800 transition-all group-hover/icon:scale-110 group-hover/icon:-rotate-6" alt="{{ $service->name }}">
                    @else
                        <span class="w-20 h-20 bg-brand-primary text-white rounded-[2.2rem] flex items-center justify-center text-4xl font-Cairo shadow-2xl shadow-brand-primary/20 transition-all group-hover/icon:scale-110 group-hover/icon:-rotate-3">🛠️</span>
                    @endif
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-white dark:bg-slate-900 rounded-full flex items-center justify-center shadow-lg border-2 border-slate-50 dark:border-slate-800">
                        <div class="w-3.5 h-3.5 {{ $service->is_active ? 'bg-emerald-500' : 'bg-rose-500' }} rounded-full {{ $service->is_active ? 'animate-ping' : '' }}"></div>
                    </div>
                </div>
                <div class="flex flex-col text-start">
                    <span class="italic text-slate-900 dark:text-white">{{ $service->name }}</span>
                    <div class="flex items-center gap-3 text-[10px] font-black text-slate-400 mt-2 tracking-[0.3em] uppercase opacity-60 font-Cairo">
                        <span>{{ $service->category->name ?? 'Uncategorized' }}</span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span>UID #{{ str_pad($service->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </h3>
        </div>

        <div class="flex items-center gap-5 print:hidden">
            <a href="{{ route('services.index') }}" class="h-14 px-8 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-2xl font-black text-[11px] uppercase tracking-widest flex items-center gap-3 transition-all hover:bg-slate-200">
                <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ __('العودة للقائمة') }}
            </a>
            <a href="{{ route('services.edit', $service->id) }}" class="h-14 px-10 bg-brand-primary text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] flex items-center gap-4 transition-all shadow-2xl shadow-brand-primary/30 hover:scale-[1.05] active:scale-95 italic italic group">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                {{ __('تعديل البيانات') }}
            </a>
        </div>
    </div>

    <!-- Analytical Intelligence Tier -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-4 md:px-0">
        <!-- Requests KPI -->
        <div class="card-premium glass-panel p-10 border-l-8 border-indigo-500 relative overflow-hidden group shadow-xl bg-white/40 dark:bg-slate-900/40">
            <div class="relative z-10 text-start">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block opacity-70 group-hover:text-indigo-500 transition-colors">{{ __('إجمالي الطلبات') }}</span>
                <div class="flex items-baseline gap-4 text-start font-mono text-start">
                    <span class="text-5xl font-black italic text-indigo-600">{{ number_format($stats['total_requests'], 0) }}</span>
                    <span class="text-[10px] font-black opacity-30 uppercase">{{ __('طلب') }}</span>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 text-8xl opacity-[0.03] group-hover:scale-110 transition-transform grayscale select-none italic font-black">Σ</div>
        </div>

        <!-- Conversion/Success KPI -->
        <div class="card-premium glass-panel p-10 border-l-8 border-emerald-500 relative overflow-hidden group shadow-xl bg-white/40 dark:bg-slate-900/40 font-Cairo text-start">
            <div class="relative z-10 text-start">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block opacity-70 group-hover:text-emerald-500 transition-colors uppercase italic">{{ __('طلبات ناجزة') }}</span>
                <div class="flex items-baseline gap-4 text-start font-mono text-start">
                    <span class="text-5xl font-black italic text-emerald-600">{{ number_format($stats['completed_requests'], 0) }}</span>
                    <span class="text-[10px] font-black opacity-30 uppercase underline italic">{{ __('تم التسليم') }}</span>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 text-8xl opacity-[0.03] group-hover:scale-110 transition-transform select-none italic font-black">✓</div>
        </div>

        <!-- Revenue KPI -->
        <div class="card-premium glass-panel p-10 border-l-8 border-amber-500 relative overflow-hidden group shadow-xl bg-white/40 dark:bg-slate-900/40 text-start font-Cairo">
            <div class="relative z-10 text-start font-Cairo">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block opacity-70 group-hover:text-amber-500 transition-colors italic uppercase">{{ __('عوائد الخدمة للمزودين') }}</span>
                <div class="flex items-baseline gap-3 text-start font-mono font-Cairo">
                    <span class="text-4xl font-black italic text-amber-600">{{ number_format($stats['total_revenue'], 2) }}</span>
                    <span class="text-[10px] font-black opacity-30 uppercase font-Cairo underline italic">{{ __('ر.س') }}</span>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 text-8xl opacity-[0.03] group-hover:scale-110 transition-transform select-none italic font-black">💵</div>
        </div>

        <!-- Profit Contribution KPI -->
        <div class="card-premium glass-panel p-10 border-l-8 border-brand-primary relative overflow-hidden group shadow-xl bg-slate-900 text-white font-Cairo text-start">
            <div class="relative z-10 text-start font-Cairo">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block opacity-40 uppercase italic group-hover:text-brand-primary transition-colors">{{ __('صافي عمولة المنصة (المسددة)') }}</span>
                <div class="flex items-baseline gap-3 text-start font-mono font-Cairo">
                    <span class="text-4xl font-black italic text-brand-primary">{{ number_format($stats['total_commissions'], 2) }}</span>
                    <span class="text-[10px] font-black opacity-30 uppercase underline italic font-Cairo">{{ __('ر.س') }}</span>
                </div>
            </div>
            <div class="absolute -bottom-4 -right-4 text-8xl opacity-[0.05] group-hover:scale-110 transition-transform select-none italic font-black">📈</div>
        </div>
    </div>

    <!-- Technical Specs & Identity Matrix -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 px-4 md:px-0">
        <!-- Identity Sidebar -->
        <div class="lg:col-span-4 space-y-10">
            <!-- Professional Branding -->
            <div class="card-premium glass-panel p-10 rounded-[3rem] shadow-2xl relative overflow-hidden text-start font-Cairo bg-white dark:bg-slate-900 border border-white/10">
                <h5 class="text-xs font-black text-slate-400 uppercase tracking-[0.4em] mb-10 opacity-70 italic">{{ __('هوية ومسؤول الخدمة') }}</h5>
                
                <div class="space-y-10 text-start font-Cairo">
                    <div class="flex items-center gap-6 text-start">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-white/5 rounded-[1.5rem] flex items-center justify-center text-2xl shadow-inner font-Cairo opacity-70">
                             {{ mb_substr($service->provider->name ?? '?', 0, 1) }}
                        </div>
                        <div class="flex flex-col text-start ">
                            <span class="text-[9px] font-black text-brand-primary uppercase tracking-widest italic leading-tight">{{ __('مزود الخدمة المعتمد') }}</span>
                            <a href="{{ route('admin.providers.show', $service->provider_id) }}" class="text-lg font-black italic hover:text-brand-primary transition-colors mt-1 font-Cairo leading-tight">{{ $service->provider->name ?? '---' }}</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-start font-Cairo">
                        <div class="p-6 bg-slate-50 dark:bg-white/5 rounded-3xl border border-slate-100 dark:border-white/5 text-start font-Cairo ">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest italic block mb-2">{{ __('الحالة') }}</span>
                            <span class="inline-flex items-center gap-2 text-[10px] font-black {{ $service->is_available ? 'text-emerald-500' : 'text-rose-500' }} font-Cairo italic leading-tight uppercase">
                                <span class="w-2 h-2 rounded-full {{ $service->is_available ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                {{ $service->is_available ? __('متاح') : __('غير متاح') }}
                            </span>
                        </div>
                        <div class="p-6 bg-slate-50 dark:bg-white/5 rounded-3xl border border-slate-100 dark:border-white/5 text-start font-Cairo">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest italic block mb-2">{{ __('التسعير') }}</span>
                            <span class="text-[10px] font-black text-slate-700 dark:text-slate-300 font-Cairo italic leading-tight uppercase">{{ $service->distance_based_price ? __('حسب المسافة') : __('سعر ثابت') }}</span>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-100 dark:border-white/5 flex items-center justify-between text-start font-Cairo">
                        <div class="text-start">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest italic block mb-2">{{ __('تقييم الجودة العام') }}</span>
                            <div class="flex items-center gap-1.5 text-start">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $stats['average_rating'] ? 'text-amber-400' : 'text-slate-200 dark:text-slate-700' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                        </div>
                        <span class="text-2xl font-black italic text-slate-300">{{ number_format($stats['average_rating'], 1) }}</span>
                    </div>
                </div>
            </div>

            <!-- Pricing Anatomy -->
            <div class="card-premium glass-panel p-10 rounded-[3rem] shadow-xl border border-white/10 text-start font-Cairo">
                 <h5 class="text-xs font-black text-slate-400 uppercase tracking-[0.4em] mb-10 opacity-70 italic">{{ __('تفاصيل التسعير والعمولات') }}</h5>
                 <div class="space-y-6 text-start font-Cairo">
                    <div class="flex justify-between items-center text-start font-Cairo">
                        <span class="text-[11px] font-bold text-slate-500 opacity-60 font-Cairo italic">{{ __('السعر الأساسي') }}</span>
                        <span class="text-lg font-black italic">{{ number_format($service->price, 2) }} ر.س</span>
                    </div>
                    @if($service->distance_based_price)
                    <div class="flex justify-between items-center font-Cairo text-start">
                        <span class="text-[11px] font-bold text-slate-500 opacity-60 font-Cairo italic">{{ __('إضافة لكل كيلو/م') }}</span>
                        <span class="text-lg font-black italic text-indigo-500">+{{ number_format($service->price_per_km, 2) }} ر.س</span>
                    </div>
                    @endif
                    <div class="pt-6 border-t border-slate-100 dark:border-white/5 flex justify-between items-center text-start font-Cairo">
                        <span class="text-[11px] font-bold text-slate-500 opacity-60 font-Cairo italic">{{ __('نسبة الدفعة المقدمة') }}</span>
                        <span class="px-4 py-1.5 bg-brand-primary/10 text-brand-primary rounded-xl text-xs font-black font-mono italic">{{ $service->required_partial_percentage }}%</span>
                    </div>
                 </div>
            </div>
        </div>

        <!-- Main Content Matrix -->
        <div class="lg:col-span-8 space-y-10">
            <!-- Description Matrix -->
            <div class="card-premium glass-panel p-12 md:p-16 rounded-[4.5rem] shadow-2xl relative border border-white/10 text-start font-Cairo">
                <div class="flex items-center gap-6 mb-12 text-start font-Cairo">
                    <span class="w-3 h-12 bg-brand-primary rounded-full animate-pulse font-Cairo"></span>
                    <h4 class="text-2xl font-black italic font-Cairo text-start leading-tight">{{ __('وصف الخدمة ونطاق العمل') }}</h4>
                </div>
                <div class="relative text-start font-Cairo">
                    <div class="absolute right-0 top-0 bottom-0 w-1.5 bg-brand-primary/10 rounded-full"></div>
                    <p class="text-xl font-bold leading-[2.2] pr-12 text-slate-600 dark:text-slate-300 italic text-start font-Cairo opacity-80">
                         {{ $service->description ?? __('لا يوجد وصف فني متوفر حالياً لهذه الخدمة.') }}
                    </p>
                </div>
            </div>

            <!-- Quality Control (Reviews/Activity) -->
            <div class="card-premium glass-panel rounded-[4.5rem] overflow-hidden shadow-2xl border border-white/10 flex flex-col font-Cairo">
                <div class="p-12 border-b border-slate-100 dark:border-white/5 flex justify-between items-center text-start group font-Cairo">
                    <div class="text-start font-Cairo">
                        <h4 class="text-2xl font-black italic text-start font-Cairo">{{ __('سجل مراجعات الجودة') }}</h4>
                        <span class="text-[10px] font-black opacity-30 uppercase tracking-[0.3em] font-Cairo mt-2 italic block">Live Customer Feedback Loop</span>
                    </div>
                    <div class="w-14 h-14 bg-amber-500/10 text-amber-500 rounded-3xl flex items-center justify-center text-xl shadow-inner italic font-black">★</div>
                </div>
                <div class="flex-1 max-h-[600px] overflow-y-auto custom-scrollbar p-10 font-Cairo">
                    @if($recentReviews->isEmpty())
                        <div class="h-60 flex flex-col items-center justify-center opacity-30 text-start font-Cairo">
                            <span class="text-6xl mb-6">💬</span>
                            <p class="text-sm font-black uppercase tracking-widest font-Cairo">{{ __('لا توجد مراجعات حتى الآن') }}</p>
                        </div>
                    @else
                        <div class="space-y-10 text-start font-Cairo italic">
                            @foreach($recentReviews as $review)
                            <div class="flex gap-8 group/item font-Cairo text-start italic">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 dark:bg-white/5 flex items-center justify-center text-xl font-black shrink-0 shadow-lg font-Cairo italic text-start">
                                    {{ mb_substr($review->request->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="flex-1 space-y-4 text-start font-Cairo italic">
                                    <div class="flex justify-between items-center text-start font-Cairo">
                                        <div class="text-start font-Cairo">
                                            <h6 class="font-black italic text-base leading-tight">{{ $review->request->user->name ?? 'Master User' }}</h6>
                                            <span class="text-[9px] font-black text-slate-400 mt-1 block uppercase tracking-tighter opacity-70">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            @for($j=1; $j<=5; $j++)
                                                <svg class="w-3 {{ $j <= $review->rating ? 'text-amber-400' : 'text-slate-200' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-[13px] font-bold text-slate-500 leading-relaxed italic bg-slate-50 dark:bg-white/[0.02] p-6 rounded-[2rem] border border-slate-100 dark:border-white/5">
                                        {{ $review->comment ?? '---' }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sub-Services Ledger (Child Services) -->
            @if($service->children->isNotEmpty())
            <div class="card-premium glass-panel rounded-[4.5rem] overflow-hidden shadow-2xl border border-white/10 font-Cairo">
                 <div class="p-12 border-b border-slate-100 dark:border-white/5 flex justify-between items-center text-start font-Cairo">
                    <div class="text-start font-Cairo">
                        <h4 class="text-2xl font-black italic text-start font-Cairo">{{ __('الخدمات الفرعية التابعة') }}</h4>
                        <span class="text-[10px] font-black opacity-30 uppercase tracking-[0.3em] font-Cairo mt-2 italic block">{{ $service->children->count() }} Sub-services active</span>
                    </div>
                </div>
                <div class="overflow-x-auto text-start font-Cairo">
                    <table class="w-full text-start font-Cairo">
                        <tbody class="divide-y divide-slate-100 dark:divide-white/3 font-Cairo">
                            @foreach($service->children as $child)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition-all group/item font-Cairo">
                                <td class="px-12 py-10 text-start font-Cairo">
                                    <div class="flex flex-col text-start ">
                                        <span class="text-base font-black italic group-hover/item:text-brand-primary transition-colors font-Cairo leading-tight">{{ $child->name }}</span>
                                        <p class="text-[10px] font-black text-slate-400 mt-2 font-Cairo opacity-50">{{ Str::limit($child->description, 60) }}</p>
                                    </div>
                                </td>
                                <td class="px-12 py-10 text-start font-Cairo">
                                    <span class="text-lg font-black italic text-brand-primary font-mono leading-none font-Cairo">{{ number_format($child->price, 2) }} ر.س</span>
                                </td>
                                <td class="px-12 py-10 text-end font-Cairo">
                                    <div class="flex justify-end gap-3 font-Cairo italic ">
                                        <a href="{{ route('services.show', $child->id) }}" class="p-4 bg-slate-100 dark:bg-white/5 rounded-2xl text-slate-500 hover:text-brand-primary hover:bg-brand-primary/10 transition-all shadow-sm">
                                            <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { height: 10px; width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.1); border-radius: 10px; border: 3px solid transparent; background-clip: content-box; }
    .animate-fade-in { animation: fade-in 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fade-in { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    
    @media print {
        body { padding: 0 !important; margin: 0 !important; background: white !important; font-size: 10pt; }
        .glass-panel { border: 0.5pt solid #ddd !important; box-shadow: none !important; background: transparent !important; }
        .card-premium { border-radius: 1rem !important; }
        aside, header, nav, footer, .print-hide, .animate-pulse, [x-show] { display: none !important; }
        .max-w-7xl { max-width: 100% !important; border: none !important; margin: 0 !important; }
        .divide-y > * { border-color: #ddd !important; }
        canvas, .chart-container { display: none !important; }
        @page { size: A4; margin: 15mm; }
    }
</style>
@endsection
