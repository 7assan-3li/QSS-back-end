@extends('layouts.admin')

@section('title', __('تحديث هوية الخدمة'))

@section('content')
<div class="max-w-5xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo pb-24">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 px-4 md:px-0 text-start group font-Cairo">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-6 text-start font-Cairo leading-tight">
                <div class="w-16 h-16 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-3xl font-Cairo shadow-lg shadow-brand-primary/5 group-hover:rotate-6 transition-transform">✍️</div>
                <div class="flex flex-col text-start">
                    <span class="italic text-[var(--main-text)]">{{ __('تعديل بيانات الخدمة') }}</span>
                    <span class="text-[13px] font-black text-[var(--text-muted)] mt-2 tracking-[0.4em] uppercase opacity-60 font-Cairo leading-tight">{{ $service->name }}</span>
                </div>
            </h3>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('services.show', $service->id) }}" class="h-14 px-8 bg-[var(--glass-border)] text-[var(--text-secondary)] rounded-2xl font-black text-[14px] uppercase tracking-widest flex items-center gap-3 transition-all hover:bg-slate-200 font-Cairo">
                {{ __('إلغاء التعديل') }}
            </a>
        </div>
    </div>

    <!-- Main Configuration Matrix -->
    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-12">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Side: Basic & Financial Config -->
            <div class="lg:col-span-8 space-y-10">
                <!-- Basic Info Segment -->
                <div class="card-premium glass-panel p-10 md:p-14 rounded-[4rem] shadow-2xl border border-white/10 text-start font-Cairo bg-[var(--glass-bg)]/60">
                    <div class="flex items-center gap-4 mb-10 text-start font-Cairo">
                         <span class="w-2.5 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/20"></span>
                         <h4 class="text-xl font-black italic font-Cairo text-start leading-tight">{{ __('المعطيات الأساسية') }}</h4>
                    </div>

                    <div class="space-y-8 text-start font-Cairo">
                        <div class="space-y-3 text-start font-Cairo">
                            <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2 font-Cairo italic opacity-70">{{ __('اسم الخدمة المعروض') }}</label>
                            <input type="text" name="name" value="{{ old('name', $service->name) }}" required class="w-full px-8 py-5 bg-[var(--glass-bg)]/50 rounded-[1.8rem] border border-[var(--glass-border)] focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-bold placeholder:opacity-30 italic font-Cairo text-start">
                        </div>

                        <div class="space-y-3 text-start font-Cairo">
                            <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2 font-Cairo opacity-70 italic">{{ __('وصف الخدمة التفصيلي') }}</label>
                            <textarea name="description" rows="5" class="w-full px-8 py-6 bg-[var(--glass-bg)]/50 rounded-[2rem] border border-[var(--glass-border)] focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-bold placeholder:opacity-30 leading-relaxed italic font-Cairo text-start">{{ old('description', $service->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-start font-Cairo">
                            <div class="space-y-3 text-start font-Cairo">
                                <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2 font-Cairo opacity-70 italic">{{ __('التصنيف الرئيسي') }}</label>
                                <select name="category_id" class="w-full px-8 py-5 bg-[var(--glass-bg)]/50 rounded-[1.8rem] border border-[var(--glass-border)] focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-bold italic font-Cairo text-start">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $service->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-3 text-start font-Cairo">
                                <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2 font-Cairo opacity-70 italic">{{ __('مزود الخدمة') }}</label>
                                <select name="provider_id" class="w-full px-8 py-5 bg-[var(--glass-bg)]/50 rounded-[1.8rem] border border-[var(--glass-border)] focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-bold italic font-Cairo text-start">
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}" {{ $service->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Architecture Segment -->
                <div class="card-premium glass-panel p-10 md:p-14 rounded-[4rem] shadow-2xl border border-white/10 text-start font-Cairo bg-[var(--glass-bg)]/60">
                    <div class="flex items-center gap-4 mb-10 text-start font-Cairo">
                         <span class="w-2.5 h-10 bg-emerald-500 rounded-full shadow-lg shadow-emerald-500/20"></span>
                         <h4 class="text-xl font-black italic font-Cairo text-start leading-tight">{{ __('هيكلية التسعير والعمولات') }}</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start font-Cairo">
                        <div class="space-y-3 text-start font-Cairo">
                            <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2 font-Cairo opacity-70 italic">{{ __('السعر الأساسي (بالريال)') }}</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $service->price) }}" required class="w-full px-8 py-5 bg-[var(--glass-bg)]/50 rounded-[1.8rem] border border-[var(--glass-border)] focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-black italic font-mono text-start">
                        </div>

                        <div class="space-y-3 text-start font-Cairo">
                            <label class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2 font-Cairo opacity-70 italic">{{ __('نسبة الدفعة المقدمة (%)') }}</label>
                            <input type="number" name="required_partial_percentage" value="{{ old('required_partial_percentage', $service->required_partial_percentage) }}" required min="0" max="100" class="w-full px-8 py-5 bg-[var(--glass-bg)]/50 rounded-[1.8rem] border border-[var(--glass-border)] focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-black italic font-mono text-start">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Status, Logistics & Media -->
            <div class="lg:col-span-4 space-y-10 text-start font-Cairo">
                <!-- Media Matrix -->
                <div class="card-premium glass-panel p-10 rounded-[3rem] shadow-xl border border-white/10 text-start font-Cairo bg-[var(--glass-bg)]/60" x-data="{ photoName: null, photoPreview: null }">
                    <h5 class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.4em] mb-8 opacity-70 italic font-Cairo text-start">{{ __('أيقونة/صورة الخدمة') }}</h5>
                    
                    <div class="relative group/photo flex flex-col items-center text-start font-Cairo">
                        <input type="file" name="image_path" class="hidden" x-ref="photo" 
                               @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);">
                        
                        <div class="relative w-40 h-40 rounded-[2.5rem] overflow-hidden border-4 border-[var(--glass-border)] shadow-2xl group-hover:scale-105 transition-all text-start font-Cairo bg-[var(--glass-bg)] dark:bg-[var(--glass-bg)]/5">
                            <div class="absolute inset-0 flex items-center justify-center bg-[var(--glass-border)]" x-show="!photoPreview">
                                @if($service->image_path)
                                    <img src="{{ asset('storage/' . $service->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-4xl opacity-20">🖼️</span>
                                @endif
                            </div>
                            <div class="absolute inset-0" x-show="photoPreview" style="display: none;">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </div>
                             <!-- Photo Hover Overlay -->
                            <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all cursor-pointer" @click="$refs.photo.click()">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>

                        <p class="text-[12px] font-black text-[var(--text-muted)] mt-6 uppercase tracking-widest opacity-60 font-Cairo italic">{{ __('اضغط لتغيير الصورة') }}</p>
                    </div>
                </div>

                <!-- Strategic Toggles -->
                <div class="card-premium glass-panel p-10 rounded-[3rem] shadow-xl border border-white/10 text-start font-Cairo bg-[var(--glass-bg)]/60">
                    <h5 class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.4em] mb-10 opacity-70 italic font-Cairo text-start">{{ __('إعدادات الحالة اللوجستية') }}</h5>
                    
                    <div class="space-y-10 text-start font-Cairo">
                        <!-- Switch 1: Active -->
                        <div class="flex items-center justify-between text-start font-Cairo">
                            <div class="flex flex-col text-start">
                                <span class="text-[12px] font-black italic lrading-tight">نشاط الخدمة</span>
                                <span class="text-[14px] font-bold text-[var(--text-muted)] font-Cairo uppercase mt-1">System Activation Status</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ $service->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] rtl:after:right-[4px] after:bg-[var(--glass-bg)] after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-brand-primary shadow-inner"></div>
                            </label>
                        </div>

                        <!-- Switch 2: Available -->
                        <div class="flex items-center justify-between text-start font-Cairo">
                            <div class="flex flex-col text-start">
                                <span class="text-[12px] font-black italic lrading-tight">التوافر الفوري</span>
                                <span class="text-[14px] font-bold text-[var(--text-muted)] font-Cairo uppercase mt-1">Real-time Availability Toggle</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_available" value="1" {{ $service->is_available ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] rtl:after:right-[4px] after:bg-[var(--glass-bg)] after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                            </label>
                        </div>

                        <!-- Switch 3: Distance Pricing -->
                        <div class="flex items-center justify-between text-start font-Cairo" x-data="{ dBased: {{ $service->distance_based_price ? 'true' : 'false' }} }">
                            <div class="flex flex-col text-start">
                                <span class="text-[12px] font-black italic lrading-tight">التسعير حسب المسافة</span>
                                <span class="text-[14px] font-bold text-[var(--text-muted)] font-Cairo uppercase mt-1">Dynamic Distance Pricing</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="distance_based_price" value="1" @change="dBased = $el.checked" {{ $service->distance_based_price ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-8 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] rtl:after:right-[4px] after:bg-[var(--glass-bg)] after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-500 shadow-inner"></div>
                            </label>
                        </div>

                         <!-- Conditional Input for Distance Price -->
                        <div x-show="dBased" x-transition class="pt-6 border-t border-[var(--glass-border)] space-y-3 font-Cairo text-start" style="display: none;">
                             <label class="text-[12px] font-black text-brand-primary uppercase tracking-widest px-2 italic font-Cairo opacity-70">{{ __('رسوم إضافية لكل كم') }}</label>
                             <input type="number" step="0.01" name="price_per_km" value="{{ old('price_per_km', $service->price_per_km) }}" class="w-full px-8 py-5 bg-[var(--glass-bg)]/50 rounded-[1.8rem] border border-[var(--glass-border)] focus:ring-4 focus:ring-indigo-500/10 transition-all text-sm font-black italic font-mono text-start">
                        </div>
                    </div>
                </div>

                <!-- Technical Classification -->
                <div class="card-premium glass-panel p-10 rounded-[3rem] shadow-xl border border-white/10 text-start font-Cairo bg-[var(--glass-bg)]/60">
                    <h5 class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.4em] mb-10 opacity-70 italic font-Cairo text-start">{{ __('بروتوكول النظام') }}</h5>
                    <div class="space-y-3 text-start font-Cairo">
                         <label class="text-[12px] font-black text-[var(--text-muted)] uppercase tracking-widest px-2 italic font-Cairo text-start opacity-70">{{ __('الحالة التقنية') }}</label>
                         <select name="status" class="w-full px-8 py-5 bg-[var(--glass-bg)]/50 rounded-[1.8rem] border border-[var(--glass-border)] focus:ring-4 focus:ring-brand-primary/10 transition-all text-sm font-black italic font-Cairo text-start">
                             <option value="available" {{ $service->status == 'available' ? 'selected' : '' }}>Available for Requests</option>
                             <option value="unavailable" {{ $service->status == 'unavailable' ? 'selected' : '' }}>Temporarily Locked</option>
                         </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Global Save Action -->
        <div class="flex justify-end pt-12 pb-24 border-t border-[var(--glass-border)] font-Cairo">
            <button type="submit" class="h-20 px-16 bg-slate-900 hover:bg-black text-white rounded-[2.5rem] font-black text-sm uppercase tracking-[0.3em] flex items-center gap-6 shadow-2xl transition-all hover:scale-[1.05] italic group font-Cairo">
                <svg class="w-6 h-6 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                {{ __('حفظ وتطبيق التغييرات') }}
            </button>
        </div>
    </form>
</div>

<style>
    .animate-fade-in { animation: fade-in 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fade-in { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
