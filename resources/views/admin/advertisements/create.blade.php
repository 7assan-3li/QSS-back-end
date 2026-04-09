@extends('layouts.admin')

@section('title', __('إضافة إعلان جديد'))

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 font-Cairo animate-in fade-in slide-in-from-bottom-8 duration-700" x-data="{ targetType: 'none', imagePreview: null }">
    
    <!-- Top Nav/Back Link -->
    <div class="mb-10 flex items-center justify-between">
        <a href="{{ route('advertisements.index') }}" class="group flex items-center gap-3 text-slate-500 hover:text-brand-primary transition-colors duration-300">
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-white/5 flex items-center justify-center group-hover:bg-brand-primary/10 transition-colors">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </div>
            <span class="font-black text-sm uppercase tracking-widest italic">{{ __('العودة لمركز الإعلانات') }}</span>
        </a>
        <div class="flex items-center gap-3">
            <div class="w-3 h-3 rounded-full bg-brand-primary animate-pulse"></div>
            <span class="text-[10px] font-black uppercase tracking-[0.3em] opacity-40">{{ __('بناء حملة جديدة') }}</span>
        </div>
    </div>

    <form action="{{ route('advertisements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Image & Preview -->
            <div class="lg:col-span-1 space-y-8">
                <div class="card-premium p-8 transition-colors duration-500">
                    <h3 class="text-lg font-black text-slate-800 dark:text-white mb-6 flex items-center gap-3 italic">
                        <span class="w-1.5 h-6 bg-brand-primary rounded-full"></span>
                        {{ __('هوية الإعلان Visual') }}
                    </h3>
                    
                    <!-- Image Upload -->
                    <div class="relative group">
                        <div class="aspect-[16/9] rounded-3xl bg-slate-50 dark:bg-white/5 border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center overflow-hidden transition-all duration-500 group-hover:border-brand-primary/50 relative">
                            <template x-if="!imagePreview">
                                <div class="flex flex-col items-center text-center p-6">
                                    <div class="w-16 h-16 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-500">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-black text-slate-500 italic block mb-1">{{ __('اختر صورة الإعلان') }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 opacity-60 italic">{{ __('المقياس المفضل 16:9') }}</span>
                                </div>
                            </template>
                            
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="w-full h-full object-cover">
                            </template>

                            <input type="file" name="image_path" class="absolute inset-0 opacity-0 cursor-pointer" 
                                   @change="const file = $event.target.files[0]; if(file) { const reader = new FileReader(); reader.onload = (e) => { imagePreview = e.target.result; }; reader.readAsDataURL(file); }">
                        </div>
                    </div>
                    @error('image_path')
                        <p class="mt-4 text-xs font-bold text-rose-500 italic flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Display Settings -->
                <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-white/5 p-8 transition-colors duration-500">
                    <h3 class="text-lg font-black text-slate-800 dark:text-white mb-6 italic">{{ __('إرشادات النشر') }}</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex flex-shrink-0 items-center justify-center">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 italic">{{ __('سيظهر الإعلان فوراً بمجرد تفعيل حالة النشاط وبلوغ تاريخ البداية.') }}</p>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-6 h-6 rounded-lg bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 flex flex-shrink-0 items-center justify-center">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            </div>
                            <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 italic">{{ __('تأكد من دقة الرابط الخارجي أو اختيار الخدمة الصحيحة للتوجيه.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form Data -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Main Configuration Card -->
                <div class="card-premium p-10 transition-colors duration-500">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('عنوان الإعلان (داخلي)') }}</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="{{ __('مثال: عرض اليوم الوطني') }}"
                                   class="input-premium placeholder:opacity-30">
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('نوع العرض') }}</label>
                            <select name="type" class="input-premium appearance-none italic">
                                <option value="carousel">{{ __('بنر منزلق (Carousel)') }}</option>
                                <option value="popup">{{ __('نافذة منبثقة (Pop-up)') }}</option>
                                <option value="section">{{ __('إعلان قسم (Section)') }}</option>
                            </select>
                        </div>

                        <!-- Targeted Users -->
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('الفئة المستهدفة') }}</label>
                            <select name="user_type" class="input-premium appearance-none italic">
                                <option value="all">{{ __('الجميع (All Users)') }}</option>
                                <option value="client">{{ __('العملاء فقط (Clients)') }}</option>
                                <option value="provider">{{ __('المزودين فقط (Providers)') }}</option>
                            </select>
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('ترتيب الظهور') }}</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                   class="input-premium italic">
                        </div>

                        <!-- Active Toggle -->
                        <div class="flex items-center gap-6 px-1">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                <div class="w-14 h-8 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-brand-primary"></div>
                                <span class="ms-4 text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider italic">{{ __('تفعيل الإعلان') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                        <!-- Deep Linking & Redirection Card -->
                <div class="card-premium p-10 transition-colors duration-500">
                    <h3 class="text-xl font-black text-slate-800 dark:text-white mb-8 flex items-center gap-4 italic uppercase">
                        <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        {{ __('التوجيه والارتباط الذكي') }} (Deep Linking)
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Target Type -->
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('نوع الرابط') }}</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach(['none' => 'لا يوجد', 'service' => 'خدمة', 'category' => 'قسم', 'external' => 'رابط خارجي'] as $val => $label)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="target_type" value="{{ $val }}" class="peer hidden" 
                                               x-model="targetType" {{ $val === 'none' ? 'checked' : '' }}>
                                        <div class="px-4 py-4 rounded-2xl bg-slate-50 dark:bg-white/5 border border-transparent peer-checked:border-brand-primary peer-checked:bg-brand-primary/5 transition-all text-center">
                                            <span class="text-xs font-black italic" :class="targetType === '{{ $val }}' ? 'text-brand-primary' : 'text-slate-500 opacity-60'">{{ $label }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Dynamic Inputs based on type -->
                        <div class="md:col-span-2 animate-in fade-in duration-500" x-show="targetType === 'service'">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('اختر الخدمة المستهدفة') }}</label>
                            <select name="target_id" class="input-premium appearance-none italic">
                                <option value="">{{ __('اختر من قائمة الخدمات...') }}</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->provider->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2 animate-in fade-in duration-500" x-show="targetType === 'category'">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('اختر القسم المستهدف') }}</label>
                            <select name="target_id" class="input-premium appearance-none italic">
                                <option value="">{{ __('اختر من قائمة الأقسام...') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2 animate-in fade-in duration-500" x-show="targetType === 'external'">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('الرابط الخارجي الكامل') }}</label>
                            <input type="url" name="external_link" placeholder="https://example.com/promotion"
                                   class="input-premium placeholder:opacity-30">
                        </div>
                    </div>
                </div>

                <!-- Scheduling Card -->
                <div class="card-premium p-10 transition-colors duration-500">
                    <h3 class="text-xl font-black text-slate-800 dark:text-white mb-8 flex items-center gap-4 italic uppercase">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        {{ __('الجددولة الزمنية للحملة') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('تاريخ البداية') }}</label>
                            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', now()->format('Y-m-d\TH:i')) }}"
                                   class="input-premium italic tracking-tight">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 italic px-1">{{ __('تاريخ الانتهاء (اختياري)') }}</label>
                            <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}"
                                   class="input-premium italic tracking-tight">
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="flex items-center justify-end gap-4 pt-4">
                    <button type="submit" class="group relative px-12 py-5 bg-brand-primary text-white rounded-[2rem] font-black text-sm transition-all duration-500 hover:scale-105 active:scale-95 shadow-2xl shadow-brand-primary/30 overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 shadow-inner"></div>
                        <div class="relative flex items-center gap-3">
                            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('إطلاق الحملة الإعلانية') }}</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
