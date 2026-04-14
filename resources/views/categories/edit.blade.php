@extends('layouts.admin')

@section('title', __('تعديل التصنيف'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-2xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-14 h-14 bg-brand-primary/10 rounded-2xl flex items-center justify-center text-brand-primary text-2xl font-Cairo shadow-lg shadow-brand-primary/5 whitespace-nowrap inline-flex items-center justify-center">📂</span>
                {{ __('تعديل التصنيف') }}: {{ $category->name }}
            </h3>
            <div class="flex items-center gap-3 text-[13px] font-black mt-3 mr-20 uppercase tracking-[0.2em] font-Cairo text-start opacity-60">
                <span>{{ __('إدارة الأقسام') }}</span>
                <svg class="w-2 h-2 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-brand-primary opacity-100">{{ __('تعديل البيانات') }}</span>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-4 text-start">
            <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="text-start">
                @csrf
                @method('DELETE')
                <button type="button" 
                    onclick="confirmAction('delete-category-{{ $category->id }}', {
                        title: '{{ __('حذف التصنيف نهائياً') }}',
                        text: '{{ __('تحذير كلي: أنت على وشك مسح هذا التصنيف بجميع بياناته وارتباطاته. لن تتمكن من استعادة البيانات أبداً.') }}',
                        icon: 'warning',
                        isDanger: true,
                        confirmButtonText: '{{ __('تأكيد المسح النهائي') }}'
                    })" class="group px-8 py-4 bg-rose-500/10 text-rose-600 border border-rose-500/20 rounded-2xl text-[13px] font-black hover:bg-rose-600 hover:text-white transition-all font-Cairo shadow-sm flex items-center gap-3 text-start">
                    <span class="opacity-0 group-hover:opacity-100 transition-opacity italic">🗑️</span>
                    {{ __('حذف القسم نهائياً') }}
                </button>
            </form>
            <a href="{{ route('categories.index') }}" class="px-6 py-4 bg-[var(--glass-border)] text-[var(--text-muted)] rounded-2xl text-[13px] font-black hover:bg-brand-primary hover:text-white transition-all font-Cairo">
                {{ __('العودة للقائمة') }}
            </a>
        </div>
    </div>

    <!-- Edit Category Form -->
    <div class="card-premium glass-panel p-10 md:p-16 rounded-[4.5rem] shadow-[0_60px_120px_-30px_rgba(0,0,0,0.15)] relative border border-[var(--glass-border)] overflow-hidden text-start font-Cairo">
        <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-14 text-start">
            @csrf
            @method('PUT')

            <!-- Section 1: Taxonomy & Identity Re-config -->
            <div class="space-y-10 text-start">
                <div class="flex items-center gap-4 mb-2 text-start">
                    <span class="w-2.5 h-10 bg-brand-primary rounded-full shadow-lg shadow-brand-primary/40"></span>
                    <h4 class="font-black text-2xl font-Cairo text-start">{{ __('تعديل بيانات القسم') }}</h4>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 text-start">
                    <!-- Name -->
                    <div class="space-y-4 text-start">
                        <label for="name" class="text-[12px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">{{ __('اسم القسم') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required class="w-full px-8 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-12 focus:ring-brand-primary/5 transition-all text-[var(--main-text)] font-Cairo text-start">
                        @error('name')
                            <span class="text-[12px] font-black text-rose-500 px-4 mt-2 block font-Cairo whitespace-nowrap inline-flex items-center justify-center">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Parent Choice -->
                    <div class="space-y-4 text-start">
                        <label for="category_id" class="text-[12px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">{{ __('القسم الرئيسي (اختياري)') }}</label>
                        <div class="relative text-start">
                            <select name="category_id" id="category_id" class="w-full px-8 py-6 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[2.5rem] text-sm font-black outline-none focus:border-brand-primary focus:ring-12 focus:ring-brand-primary/5 appearance-none transition-all text-[var(--main-text)] font-Cairo text-start">
                                <option value="">— {{ __('قسم رئيسي') }} —</option>
                                @include('categories.partials.category-options-update', [
                                    'categories' => $categories,
                                    'prefix' => '',
                                    'cat' => $category,
                                ])
                            </select>
                            <div class="absolute left-8 top-1/2 -translate-y-1/2 pointer-events-none text-[var(--text-muted)]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Narrative Description -->
            <div class="space-y-10 pt-12 border-t border-[var(--glass-border)] text-start">
                <div class="flex items-center gap-4 mb-2 text-start">
                    <span class="w-2.5 h-10 bg-amber-500 rounded-full shadow-lg shadow-amber-500/40"></span>
                    <h4 class="font-black text-2xl font-Cairo text-start">{{ __('تعديل وصف القسم') }}</h4>
                </div>
                
                <div class="space-y-4 text-start">
                    <label for="description" class="text-[12px] font-black uppercase tracking-[0.3em] px-3 font-Cairo text-start opacity-60">{{ __('وصف القسم') }}</label>
                    <textarea name="description" id="description" rows="5" class="w-full px-8 py-8 bg-[var(--main-bg)] border-2 border-[var(--glass-border)] rounded-[3rem] text-sm font-black outline-none focus:border-amber-500 focus:ring-12 focus:ring-amber-500/5 transition-all text-[var(--main-text)] resize-none h-48 font-Cairo text-start">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <!-- Section 3: Visual Identity Refinement -->
            <div class="space-y-10 pt-12 border-t border-[var(--glass-border)] text-start">
                <div class="flex items-center gap-4 mb-2 text-start">
                    <span class="w-2.5 h-10 bg-purple-500 rounded-full shadow-lg shadow-purple-500/40"></span>
                    <h4 class="font-black text-2xl font-Cairo text-start">{{ __('تغيير صورة القسم') }}</h4>
                </div>

                <div class="flex flex-col xl:flex-row gap-12 items-center text-start">
                    <div class="flex-1 w-full text-start">
                        <label class="group relative flex flex-col items-center justify-center w-full h-72 border-4 border-dashed border-[var(--glass-border)] rounded-[4rem] bg-[var(--main-bg)] hover:border-brand-primary/40 hover:bg-[var(--glass-bg)] dark:hover:bg-[var(--glass-border)] text-white transition-all cursor-pointer overflow-hidden text-center">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10 text-center">
                                <div class="w-16 h-16 bg-[var(--glass-bg)] rounded-2xl flex items-center justify-center shadow-2xl mb-6 group-hover:scale-110 group-hover:-rotate-6 transition-transform">
                                    <svg class="w-8 h-8 text-[var(--text-muted)] group-hover:text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="mb-2 text-xs font-black font-Cairo opacity-70">{{ __('اختر صورة جديدة') }}</p>
                                <p class="text-[12px] font-black uppercase tracking-widest px-8 opacity-60">{{ __('سيتم استبدال الصورة الحالية عند اختيار ملف جديد.') }}</p>
                            </div>
                            <input type="file" id="imageInput" name="image" class="hidden" accept="image/*" onchange="previewImage(event)">
                        </label>
                    </div>

                    <!-- Enhanced Real-time Preview Node -->
                    <div class="w-full xl:w-80 h-72 rounded-[4rem] border-2 border-[var(--glass-border)] bg-[var(--glass-border)] flex items-center justify-center overflow-hidden relative group shadow-2xl text-center">
                        <img id="preview" src="{{ $category->image_path ? asset('storage/' . $category->image_path) : '' }}" class="w-full h-full object-cover scale-100 group-hover:scale-110 transition-transform duration-1000 {{ $category->image_path ? '' : 'hidden' }}">
                        <div id="preview-placeholder" class="text-center space-y-4 opacity-30 group-hover:scale-110 transition-transform {{ $category->image_path ? 'hidden' : '' }} text-center">
                             <div class="w-20 h-20 bg-slate-200 rounded-full flex items-center justify-center mx-auto">
                                 <svg class="w-10 h-10 text-[var(--text-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                            <span class="text-[14px] font-black uppercase tracking-[0.3em] block font-Cairo opacity-60">{{ __('معاينة الصورة') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Action Terminal -->
            <div class="pt-12 flex flex-col sm:flex-row items-center gap-6 text-start">
                <button type="submit" class="w-full sm:w-auto px-16 py-6 bg-brand-primary text-white rounded-[2rem] text-[13px] font-black uppercase tracking-[0.2em] shadow-2xl shadow-brand-primary/30 hover:scale-[1.05] transition-all font-Cairo flex items-center justify-center gap-4">
                    {{ __('حفظ التغييرات 💾') }}
                </button>
                <a href="{{ route('categories.index') }}" class="w-full sm:w-auto px-16 py-6 border-2 border-[var(--glass-border)] text-[var(--text-muted)] rounded-[2rem] text-[13px] font-black uppercase tracking-[0.2em] hover:bg-[var(--glass-bg)] dark:hover:bg-[var(--glass-border)] text-white transition-all text-center font-Cairo">
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
