@extends('layouts.admin')

@section('title', 'إضافة تصنيف جديد')

@section('content')
<div class="max-w-5xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <div class="flex items-center gap-4 mb-3 text-start">
                <a href="{{ route('categories.index') }}" class="w-10 h-10 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-xl flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-sm">
                    <svg class="w-5 h-5 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h3 class="font-black text-2xl flex items-center gap-3 text-start font-Cairo">
                    <span class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-600 text-xl font-Cairo whitespace-nowrap inline-flex items-center justify-center">➕</span>
                    {{ __('إضافة تصنيف جديد') }}
                </h3>
            </div>
            <p class="text-[13px] font-black uppercase tracking-[0.2em] mr-14 text-start font-Cairo opacity-60">
                {{ __('أدخل بيانات التصنيف الجديد ليتم تنظيمه وعرضه في المنصة.') }}
            </p>
        </div>
        <div class="flex items-center gap-4">
             <a href="{{ route('categories.index') }}" class="px-6 py-3 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-xl text-[13px] font-black uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all font-Cairo opacity-80 hover:opacity-100">
                {{ __('العودة للقائمة') }}
             </a>
        </div>
    </div>

    <!-- Strategic Asset Blueprint Form -->
    <div class="card-premium glass-panel p-10 md:p-16 rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12 text-start">
            @csrf

            <!-- Section 1: Identity & Taxonomy -->
            <div class="space-y-10 text-start">
                <div class="flex items-center gap-4 mb-2 text-start">
                    <span class="w-2 h-8 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/40"></span>
                    <h4 class="font-black text-xl font-Cairo text-start">{{ __('بيانات القسم والنوع') }}</h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 text-start">
                    <!-- Title -->
                    <div class="space-y-3 text-start">
                        <label for="name" class="text-[12px] font-black uppercase tracking-[0.3em] px-2 font-Cairo text-start opacity-60">{{ __('اسم القسم') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="{{ __('مثال: التصميم المعماري...') }}" class="w-full px-8 py-5 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-8 focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-Cairo text-start">
                        @error('name')
                            <span class="text-[12px] font-black text-rose-500 px-4 tracking-tight font-Cairo block mt-2 whitespace-nowrap inline-flex items-center justify-center">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Taxonomy Node -->
                    <div class="space-y-3 text-start">
                        <label for="category_id" class="text-[12px] font-black uppercase tracking-[0.3em] px-2 font-Cairo text-start opacity-60">{{ __('القسم الرئيسي (اختياري)') }}</label>
                        <div class="relative text-start">
                            <select name="category_id" id="category_id" class="w-full px-8 py-5 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-8 focus:ring-brand-primary/5 appearance-none transition-all text-[var(--main-text)] font-Cairo text-start">
                                <option value="">— {{ __('قسم رئيسي') }} —</option>
                                @include('categories.partials.category-options', [
                                    'categories' => $categories,
                                    'prefix' => '',
                                ])
                            </select>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 pointer-events-none text-[var(--text-muted)]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Narrative Description -->
            <div class="space-y-10 pt-10 border-t border-[var(--glass-border)] text-start">
                <div class="flex items-center gap-4 mb-2 text-start">
                    <span class="w-2 h-8 bg-amber-500 rounded-full shadow-lg shadow-amber-500/40"></span>
                    <h4 class="font-black text-xl font-Cairo text-start">{{ __('وصف القسم') }}</h4>
                </div>
                
                <div class="space-y-3 text-start">
                    <label for="description" class="text-[12px] font-black uppercase tracking-[0.3em] px-2 font-Cairo text-start opacity-60">{{ __('وصف موجز للقسم') }}</label>
                    <textarea name="description" id="description" rows="4" placeholder="{{ __('اكتب وصفاً للقسم ليظهر للمستخدمين...') }}" class="w-full px-8 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-amber-500 focus:ring-8 focus:ring-amber-500/5 transition-all text-[var(--main-text)] resize-none h-40 font-Cairo text-start">{{ old('description') }}</textarea>
                    <p class="text-[12px] font-black px-4 italic font-Cairo text-start opacity-60">* {{ __('يظهر هذا الوصف في واجهة المستخدم النهائية تحت اسم القسم.') }}</p>
                </div>
            </div>

            <!-- Section 3: Visual Identity Assets -->
            <div class="space-y-10 pt-10 border-t border-[var(--glass-border)] text-start">
                <div class="flex items-center gap-4 mb-2 text-start">
                    <span class="w-2 h-8 bg-purple-500 rounded-full shadow-lg shadow-purple-500/40"></span>
                    <h4 class="font-black text-xl font-Cairo text-start">{{ __('صورة القسم') }}</h4>
                </div>

                <div class="flex flex-col xl:flex-row gap-12 items-start text-start">
                    <div class="flex-1 w-full text-start">
                        <label class="group relative flex flex-col items-center justify-center w-full h-64 border-4 border-dashed border-[var(--glass-border)] rounded-[3rem] bg-[var(--main-bg)] hover:border-brand-primary/40 hover:bg-[var(--glass-bg)] dark:hover:bg-[var(--glass-border)] text-white transition-all cursor-pointer overflow-hidden text-center">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10 text-center">
                                <div class="w-16 h-16 bg-[var(--glass-bg)] rounded-2xl flex items-center justify-center shadow-2xl mb-5 group-hover:scale-110 group-hover:rotate-6 transition-transform">
                                    <svg class="w-8 h-8 text-[var(--text-muted)] group-hover:text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <p class="mb-2 text-xs font-black font-Cairo opacity-70">{{ __('اختر صورة القسم') }}</p>
                                <p class="text-[12px] font-black uppercase tracking-widest opacity-60">SVG, PNG, JPG (MAX. 5MB)</p>
                            </div>
                            <input type="file" name="image_path" class="hidden" accept="image/*" onchange="previewImage(event)">
                        </label>
                        @error('image_path')
                            <span class="text-[12px] font-black text-rose-500 px-4 mt-3 block tracking-tight font-Cairo whitespace-nowrap inline-flex items-center justify-center">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Enhanced Preview Node -->
                    <div class="w-full xl:w-72 h-64 rounded-[3rem] border-2 border-[var(--glass-border)] bg-[var(--glass-border)] flex items-center justify-center overflow-hidden relative group shadow-inner text-center">
                        <img id="preview" class="w-full h-full object-cover hidden scale-100 group-hover:scale-110 transition-transform duration-700">
                        <div id="preview-placeholder" class="text-center space-y-3 opacity-30 group-hover:scale-110 transition-transform text-center">
                             <div class="w-16 h-16 bg-slate-200 rounded-full flex items-center justify-center mx-auto shadow-inner">
                                <svg class="w-8 h-8 text-[var(--text-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="text-[14px] font-black uppercase tracking-[0.3em] block font-Cairo opacity-60">{{ __('معاينة الصورة') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Action Terminal -->
            <div class="pt-12 flex flex-col sm:flex-row items-center gap-6 text-start">
                <button type="submit" class="w-full sm:w-auto px-16 py-6 bg-brand-primary text-white rounded-[2rem] text-xs font-black uppercase tracking-[0.2em] shadow-2xl shadow-brand-primary/30 hover:scale-[1.05] transition-all font-Cairo flex items-center justify-center gap-3">
                    {{ __('حفظ القسم 💾') }}
                </button>
                <a href="{{ route('categories.index') }}" class="w-full sm:w-auto px-16 py-6 bg-[var(--main-bg)] text-[var(--text-muted)] border-2 border-[var(--glass-border)] rounded-[2rem] text-xs font-black uppercase tracking-[0.2em] hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all text-center font-Cairo">
                    {{ __('إلغاء') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('preview-placeholder');
    const file = event.target.files[0];
    
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    }
}
</script>
@endpush
